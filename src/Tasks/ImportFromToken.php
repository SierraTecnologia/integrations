<?php
/**
 * @todo
 */

namespace Integrations\Tasks;

use Integrations\Tools\Databases\Mysql\Mysql as MysqlTool;
use Integrations\Models\Token;
use Integrations\Connectors\Sentry\Sentry;
use Integrations\Connectors\Sentry\Import as SentryImport;
use Integrations\Connectors\Jira\Jira;
use Integrations\Connectors\Jira\Import as JiraImport;
use Integrations\Connectors\Gitlab\Gitlab;
use Integrations\Connectors\Gitlab\Import as GitlabImport;
use Log;
use Operador\Contracts\ActionInterface;

use Operador\Actions\Action as ActionBase;

class ImportFromToken extends ActionBase implements ActionInterface
{
    const CODE = 'importIntegrationToken';
    CONST MODEL = \Integrations\Models\Token::class;
    const TYPE = \Operador\Actions\Action::ROUTINE;

    protected $token = false;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    public function execute(): bool
    {
        if (!$this->token->account || !$this->token->account->status) {
            $this->notice('Token ignorado sem account .. '.print_r($this->token, true));
            return false;
        }
        $this->info('Tratando Token de Integração: '.$this->token->account->integration_id);

        if ($this->token->account->integration_id == Sentry::getCodeForPrimaryKey()) {
            SentryImport::makeWithOutput($this->output, $this->token)->handle();
        } else if ($this->token->account->integration_id == Jira::getCodeForPrimaryKey()) {
            JiraImport::makeWithOutput($this->output, $this->token)->handle();
        } else if ($this->token->account->integration_id == Gitlab::getCodeForPrimaryKey()) {
            GitlabImport::makeWithOutput($this->output, $this->token)->handle();
        }

        return true;
    }
}

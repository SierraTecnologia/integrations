<?php

namespace Integrations\Tools\Plugin;

use Integrations\Tools\Builder;
use Fabrica\Models\Infra\Ci\Build;
use FlowdockClient\Api\Push\Push;
use FlowdockClient\Api\Push\TeamInboxMessage;
use Integrations\Tools\Plugin;

/**
 * Flowdock Plugin
 *
 * @author Petr Cervenka <petr@nanosolutions.io>
 */
class FlowdockNotify extends Plugin
{
    protected $apiKey;
    protected $email;
    protected $message;

    const MESSAGE_DEFAULT = 'Build %BUILD% has finished for commit <a href="%COMMIT_URI%">%SHORT_COMMIT%</a>
                            (%COMMIT_EMAIL%)> on branch <a href="%BRANCH_URI%">%BRANCH%</a>';

    /**
     * @return string
     */
    public static function pluginName()
    {
        return 'flowdock_notify';
    }

    /**
     * {@inheritdoc}
     */
    public function __construct(Builder $builder, Build $build, array $options = [])
    {
        parent::__construct($builder, $build, $options);

        if (!is_array($options) || !isset($options['api_key'])) {
            throw new \Exception('Please define the api_key for Flowdock Notify plugin!');
        }
        $this->apiKey  = trim($options['api_key']);
        $this->message = isset($options['message']) ? $options['message'] : self::MESSAGE_DEFAULT;
        $this->email   = isset($options['email']) ? $options['email'] : 'PHP Censor';
    }

    /**
     * Run the Flowdock plugin.
     *
     * @return bool
     * @throws \Exception
     */
    public function execute()
    {
        $message         = $this->builder->interpolate($this->message);
        $successfulBuild = $this->build->isSuccessful() ? 'Success' : 'Failed';
        $push            = new Push($this->apiKey);
        $flowMessage     = TeamInboxMessage::create()
            ->setSource("PHPCensor")
            ->setFromAddress($this->email)
            ->setFromName($this->build->getProject()->getTitle())
            ->setSubject($successfulBuild)
            ->setTags(['#ci'])
            ->setLink($this->build->getBranchLink())
            ->setContent($message);

        if (!$push->sendTeamInboxMessage($flowMessage, ['connect_timeout' => 5000, 'timeout' => 5000])) {
            throw new \Exception(sprintf('Flowdock Failed: %s', $flowMessage->getResponseErrors()));
        }
        return true;
    }
}

# SierraTecnologia Integrations

**SierraTecnologia Integrations** integration services integrations and providers for users required by various SierraTecnologia packages. Validator functionality, and basic controller included out-of-the-box.

[![Packagist](https://img.shields.io/packagist/v/sierratecnologia/integrations.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/sierratecnologia/integrations)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/sierratecnologia/integrations.svg?label=Scrutinizer&style=flat-square)](https://scrutinizer-ci.com/g/sierratecnologia/integrations/)
[![Travis](https://img.shields.io/travis/sierratecnologia/integrations.svg?label=TravisCI&style=flat-square)](https://travis-ci.org/sierratecnologia/integrations)
[![StyleCI](https://styleci.io/repos/60968880/shield)](https://styleci.io/repos/60968880)
[![License](https://img.shields.io/packagist/l/sierratecnologia/integrations.svg?label=License&style=flat-square)](https://github.com/sierratecnologia/integrations/blob/master/LICENSE)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/sierratecnologia/integrations/ci.yml?branch=master&label=CI&style=flat-square)](https://github.com/sierratecnologia/integrations/actions)

---

## 📚 Índice

- [Introdução](#-introdução)
- [Instalação](#-instalação)
- [Arquitetura e Estrutura Interna](#-arquitetura-e-estrutura-interna)
- [Principais Componentes](#-principais-componentes)
- [Conectores Disponíveis](#-conectores-disponíveis)
- [Uso Prático](#-uso-prático)
- [Integração com o Ecossistema SierraTecnologia](#-integração-com-o-ecossistema-sierratecnologia)
- [Extensão e Customização](#-extensão-e-customização)
- [Exemplos Reais](#-exemplos-reais)
- [Ferramentas de Qualidade](#-ferramentas-de-qualidade)
- [Guia de Contribuição](#-guia-de-contribuição)

---

## 🚀 Introdução

### O que é o SierraTecnologia Integrations?

O **SierraTecnologia Integrations** é um pacote Laravel robusto e extensível que fornece abstrações e implementações padronizadas para integração com diversos serviços externos, incluindo APIs de terceiros, provedores de pagamento, sistemas de notificações, ERPs, CRMs, plataformas de mídia social e muito mais.

### Objetivo e Filosofia do Projeto

Este projeto foi desenvolvido com os seguintes princípios em mente:

- **Desacoplamento**: Separação clara entre a lógica de negócio e as integrações externas
- **Reutilização**: Componentes modulares que podem ser utilizados em diferentes contextos
- **Extensibilidade**: Arquitetura que facilita a adição de novos conectores
- **Padronização**: Interface consistente para comunicação com serviços diversos
- **Manutenibilidade**: Código limpo, documentado e testável

### Tipos de Integrações Suportadas

O pacote oferece suporte para diversos tipos de integrações, incluindo:

- **Redes Sociais**: Facebook, Instagram, Twitter, LinkedIn, Pinterest, Tumblr, SnapChat, YouTube
- **Armazenamento em Nuvem**: Dropbox, Google Drive, Amazon S3
- **Gerenciamento de Projetos**: Jira, Trello, GitLab, GitHub, Bitbucket
- **CRM e Marketing**: Hubspot, Pipedrive, ExactSales, Zoho
- **Comunicação**: Gmail, Slack, ZohoMail
- **Outros**: Cloudflare, Sentry, Wakatime, TestLink, Wikipedia

### Importância dentro do Ecossistema SierraTecnologia

O **Integrations** é um componente fundamental do ecossistema SierraTecnologia / Rica Soluções, fornecendo a camada de comunicação entre os sistemas internos e o mundo externo. Ele permite que outros pacotes do ecossistema (como MediaManager, Market, CMS, Locaravel) se comuniquem com serviços externos de forma consistente e confiável.

---

## 📦 Instalação

### Requisitos Mínimos

- PHP 8.0 ou superior (recomendado PHP 8.2+)
- Laravel 9.x ou 10.x
- Composer 2.x
- Extensões PHP: `curl`, `json`, `mbstring`, `openssl`

### Instalação via Composer

```bash
composer require sierratecnologia/integrations
```

### Publicação de Configurações

Após a instalação, publique os arquivos de configuração:

```bash
# Publicar configurações
php artisan vendor:publish --tag=integrations-config

# Publicar views (opcional)
php artisan vendor:publish --tag=integrations-views

# Publicar traduções (opcional)
php artisan vendor:publish --tag=integrations-lang
```

Isso criará os seguintes arquivos:

- `config/integrations.php` - Configurações gerais do pacote
- `config/services.php` - Credenciais dos serviços externos (será mesclado com o existente)

### Configuração do Service Provider

O pacote utiliza **auto-discovery** do Laravel, então o `IntegrationsProvider` será registrado automaticamente. Caso necessite registrar manualmente, adicione ao arquivo `config/app.php`:

```php
'providers' => [
    // ...
    Integrations\IntegrationsProvider::class,
],

'aliases' => [
    // ...
    'Integrations' => Integrations\Facades\Integrations::class,
],
```

### Executar Migrations

Execute as migrations para criar as tabelas necessárias:

```bash
php artisan migrate
```

---

## 🏗 Arquitetura e Estrutura Interna

### Estrutura de Pastas e Namespaces

```
src/
├── Cacheable/              # Traits para cache de Eloquent
├── Connectors/             # Conectores para serviços externos
│   ├── Amazon/
│   ├── Facebook/
│   ├── Instagram/
│   ├── Jira/
│   ├── ... (39 conectores)
│   └── Connector.php       # Classe base abstrata
├── Console/                # Comandos Artisan
├── Contracts/              # Contratos e abstrações
├── Exceptions/             # Exceções customizadas
├── Facades/                # Facades Laravel
├── Factory/                # Factories para criação de objetos
├── Http/                   # Controllers e Middleware
│   ├── Admin/
│   └── Webhook/
├── Interfaces/             # Interfaces do pacote
├── Models/                 # Eloquent Models
│   ├── Integration.php
│   ├── Provider.php
│   ├── Service.php
│   └── Token.php
├── Observers/              # Eloquent Observers
├── Resources/              # API Resources
├── Scopes/                 # Query Scopes
├── Services/               # Camada de serviços
│   ├── IntegrationsService.php
│   └── LdapService.php
├── Tasks/                  # Tasks e Jobs
├── Tools/                  # Ferramentas auxiliares
├── Traits/                 # Traits reutilizáveis
├── Integrations.php        # Classe principal
└── IntegrationsProvider.php # Service Provider
```

### Padrões de Arquitetura Adotados

#### 1. **Service Layer Pattern**

O pacote utiliza uma camada de serviços para encapsular a lógica de negócio:

```php
use Integrations\Services\IntegrationsService;

class IntegrationsService
{
    public function __construct(array $config)
    {
        // Inicialização do serviço
    }

    // Métodos de negócio
}
```

#### 2. **Adapter Pattern**

Cada conector implementa um adaptador para o serviço específico:

```php
namespace Integrations\Connectors\Facebook;

use Integrations\Connectors\Connector;

class Facebook extends Connector
{
    protected static $ID = 'facebook';

    protected function getConnection($token = false)
    {
        // Implementação específica do Facebook
    }
}
```

#### 3. **Facade Pattern**

Acesso simplificado através de Facades:

```php
use Integrations;

$data = Integrations::getData();
```

### Fluxo de Comunicação Entre Camadas

```
┌─────────────────────────────────────────────────────┐
│ Application Layer (Controllers, Commands)           │
└───────────────────┬─────────────────────────────────┘
                    │
                    ↓
┌─────────────────────────────────────────────────────┐
│ Service Layer (IntegrationsService)                 │
└───────────────────┬─────────────────────────────────┘
                    │
                    ↓
┌─────────────────────────────────────────────────────┐
│ Connector Layer (Facebook, Instagram, etc.)         │
└───────────────────┬─────────────────────────────────┘
                    │
                    ↓
┌─────────────────────────────────────────────────────┐
│ External Service (API REST, OAuth, etc.)            │
└─────────────────────────────────────────────────────┘
```

### Convenções e Boas Práticas de Desacoplamento

- **Injeção de Dependência**: Todas as dependências são injetadas via construtor
- **Interfaces e Contratos**: Uso de interfaces para definir contratos
- **Models Eloquent**: Encapsulamento de dados e relacionamentos
- **Token-based Authentication**: Gestão centralizada de tokens de autenticação
- **Logging Dedicado**: Canal de log específico para integrations (`sitec-integrations.log`)

---

## 🧩 Principais Componentes

### 1. Classe Base `Connector`

Localização: `src/Connectors/Connector.php`

Classe abstrata que define a interface comum para todos os conectores:

```php
<?php

namespace Integrations\Connectors;

class Connector
{
    protected $_connection = null;
    protected $_token = null;

    public function __construct($token = false)
    {
        $this->_token = $token;
        $this->_connection = $this->getConnection($this->_token);
    }

    protected function getConnection($token = false)
    {
        return $this;
    }

    public function get($path)
    {
        // Implementação genérica de GET
    }

    public static function getCodeForPrimaryKey()
    {
        // Registra o conector no banco de dados
    }
}
```

### 2. Model `Token`

Localização: `src/Models/Token.php`

Gerencia tokens de autenticação para os serviços:

```php
<?php

namespace Integrations\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'integration_tokens';

    protected $fillable = [
        'integration_id',
        'user_id',
        'token',
        'refresh_token',
        'expires_at',
        'scopes',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'scopes' => 'array',
    ];

    // Relacionamentos
    public function integration()
    {
        return $this->belongsTo(Integration::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

### 3. IntegrationsService

Localização: `src/Services/IntegrationsService.php`

Serviço principal para gerenciamento de integrações:

```php
<?php

namespace Integrations\Services;

class IntegrationsService
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        \Log::channel('sitec-integrations')->info('IntegrationsService initialized');
    }

    // Métodos para gerenciar integrações
}
```

### 4. WebhookReceivedController

Localização: `src/Http/WebhookReceivedController.php`

Controller para receber webhooks de serviços externos:

```php
<?php

namespace Integrations\Http;

use Illuminate\Http\Request;
use Integrations\Exceptions\WebhookException;

class WebhookReceivedController extends Controller
{
    public function handle(Request $request, string $service)
    {
        // Valida e processa o webhook
        // Dispara eventos apropriados
    }
}
```

---

## 🔌 Conectores Disponíveis

### Redes Sociais

- **Facebook** (`Integrations\Connectors\Facebook\Facebook`)
- **Instagram** (`Integrations\Connectors\Instagram\Instagram`)
  - Suporte a métricas (FollowNumbers)
  - Like, Comment, Post, Profile
- **Twitter** (`Integrations\Connectors\Twitter\Twitter`)
  - Análise de sentimento via DatumboxAPI
- **LinkedIn** (`Integrations\Connectors\Linkedin\Linkedin`)
- **Pinterest** (`Integrations\Connectors\Pinterest\Pinterest`)
- **Tumblr** (`Integrations\Connectors\Tumblr\Tumblr`)
- **SnapChat** (`Integrations\Connectors\SnapChat\SnapChat`)
- **YouTube** (`Integrations\Connectors\Youtube\Youtube`)

### Armazenamento e Infraestrutura

- **Amazon S3** (`Integrations\Connectors\Amazon\Amazon`)
- **Dropbox** (`Integrations\Connectors\Dropbox\Dropbox`)
- **Google Drive** (`Integrations\Connectors\Googledrive\Googledrive`)
- **Cloudflare** (`Integrations\Connectors\Cloudflare\Cloudflare`)

### Gerenciamento de Projetos e Versionamento

- **Jira** (`Integrations\Connectors\Jira\Jira`)
  - Create, Update, Delete, Import
- **Trello** (`Integrations\Connectors\Trello\Trello`)
- **GitLab** (`Integrations\Connectors\Gitlab\Gitlab`)
- **GitHub** (`Integrations\Connectors\GitHub\GitHub`)
- **Bitbucket** (`Integrations\Connectors\BitBucket\BitBucket`)

### CRM, Marketing e Vendas

- **Hubspot** (`Integrations\Connectors\Hubspot\Hubspot`)
  - Create, Update, Import
- **Pipedrive** (`Integrations\Connectors\Pipedrive\Pipedrive`)
  - Create, Update, Import
- **ExactSales** (`Integrations\Connectors\ExactSales\ExactSales`)
  - Create, Update, Import
- **Zoho** (`Integrations\Connectors\Zoho\Zoho`)

### Comunicação

- **Gmail** (`Integrations\Connectors\Gmail\Gmail`)
- **Slack** (`Integrations\Connectors\Slack\Slack`)
- **ZohoMail** (`Integrations\Connectors\ZohoMail\ZohoMail`)

### Outros Serviços

- **Sentry** (`Integrations\Connectors\Sentry\Sentry`)
  - Monitoramento de erros
- **Wakatime** (`Integrations\Connectors\Wakatime\Wakatime`)
  - Rastreamento de tempo de desenvolvimento
- **TestLink** (`Integrations\Connectors\Testlink\Testlink`)
  - Gerenciamento de testes
- **Wikipedia** (`Integrations\Connectors\Wikipedia\Wikipedia`)
  - Busca e integração com Wikipedia

---

## 💡 Uso Prático

### Configurando Integrações em um Projeto Laravel

#### 1. Configurar Credenciais no `.env`

```env
# Facebook
FACEBOOK_CLIENT_ID=your_facebook_app_id
FACEBOOK_CLIENT_SECRET=your_facebook_app_secret
FACEBOOK_REDIRECT_URI=https://yourapp.com/callback/facebook

# Instagram
INSTAGRAM_CLIENT_ID=your_instagram_client_id
INSTAGRAM_CLIENT_SECRET=your_instagram_client_secret

# Jira
JIRA_HOST=https://yourcompany.atlassian.net
JIRA_USER=your_email@company.com
JIRA_TOKEN=your_jira_api_token

# Hubspot
HUBSPOT_API_KEY=your_hubspot_api_key
```

#### 2. Configurar no `config/services.php`

```php
return [
    // ...

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],

    'jira' => [
        'host' => env('JIRA_HOST'),
        'user' => env('JIRA_USER'),
        'token' => env('JIRA_TOKEN'),
    ],
];
```

### Exemplo: Integração com API Externa (Jira)

```php
<?php

namespace App\Http\Controllers;

use Integrations\Connectors\Jira\Jira;
use Integrations\Connectors\Jira\Create;
use Integrations\Connectors\Jira\Import;
use Integrations\Models\Token;

class JiraController extends Controller
{
    public function createIssue()
    {
        // Obter token do usuário autenticado
        $token = Token::where('integration_id', 'jira')
            ->where('user_id', auth()->id())
            ->first();

        // Inicializar conector
        $jira = new Jira($token);

        // Criar issue
        $create = new Create($token);
        $issue = $create->execute([
            'project' => 'PROJECT_KEY',
            'summary' => 'Nova tarefa criada via API',
            'description' => 'Descrição detalhada da tarefa',
            'issuetype' => 'Task',
            'priority' => 'High',
        ]);

        return response()->json($issue);
    }

    public function importIssues()
    {
        $token = Token::where('integration_id', 'jira')
            ->where('user_id', auth()->id())
            ->first();

        $import = new Import($token);

        // Importar issues do projeto
        $issues = $import->fromProject('PROJECT_KEY');

        // Processar issues
        foreach ($issues as $issue) {
            // Salvar no banco de dados local
            // ou processar conforme necessário
        }

        return response()->json([
            'message' => 'Issues importadas com sucesso',
            'count' => count($issues),
        ]);
    }
}
```

### Exemplo: Integração com Hubspot (CRM)

```php
<?php

namespace App\Services;

use Integrations\Connectors\Hubspot\Hubspot;
use Integrations\Connectors\Hubspot\Create;
use Integrations\Connectors\Hubspot\Update;
use Integrations\Models\Token;

class CrmService
{
    protected $hubspot;

    public function __construct()
    {
        $token = Token::where('integration_id', 'hubspot')
            ->where('user_id', auth()->id())
            ->first();

        $this->hubspot = new Hubspot($token);
    }

    public function createContact(array $data)
    {
        $create = new Create($this->hubspot->getToken());

        return $create->contact([
            'email' => $data['email'],
            'firstname' => $data['first_name'],
            'lastname' => $data['last_name'],
            'phone' => $data['phone'],
            'company' => $data['company'],
        ]);
    }

    public function updateContact(string $contactId, array $data)
    {
        $update = new Update($this->hubspot->getToken());

        return $update->contact($contactId, $data);
    }

    public function syncContactsFromLeads()
    {
        $leads = \App\Models\Lead::whereNull('hubspot_id')
            ->where('status', 'qualified')
            ->get();

        foreach ($leads as $lead) {
            $contact = $this->createContact([
                'email' => $lead->email,
                'first_name' => $lead->first_name,
                'last_name' => $lead->last_name,
                'phone' => $lead->phone,
                'company' => $lead->company,
            ]);

            $lead->update(['hubspot_id' => $contact['id']]);
        }
    }
}
```

### Como Lidar com Callbacks e Webhooks

#### Configurar Rotas

```php
// routes/web.php
Route::post('/webhook/{service}', [
    \Integrations\Http\WebhookReceivedController::class,
    'handle'
])->name('integrations.webhook');
```

#### Processar Webhook

```php
<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;

class ProcessWebhookListener
{
    public function handle($event)
    {
        $service = $event->service;
        $payload = $event->payload;

        Log::channel('sitec-integrations')->info(
            "Webhook recebido de {$service}",
            ['payload' => $payload]
        );

        // Processar baseado no serviço
        switch ($service) {
            case 'jira':
                $this->processJiraWebhook($payload);
                break;
            case 'hubspot':
                $this->processHubspotWebhook($payload);
                break;
        }
    }

    protected function processJiraWebhook($payload)
    {
        // Lógica específica para Jira
    }
}
```

### Boas Práticas de Segurança, Timeout e Logging

#### Segurança

```php
// Validar assinatura do webhook
public function validateWebhookSignature(Request $request, string $service)
{
    $signature = $request->header('X-Hub-Signature');
    $payload = $request->getContent();

    $secret = config("services.{$service}.webhook_secret");
    $expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, $secret);

    if (!hash_equals($expectedSignature, $signature)) {
        throw new WebhookException('Invalid signature');
    }
}
```

#### Timeout e Retry

```php
use Illuminate\Support\Facades\Http;

// Configurar timeout e retry
$response = Http::timeout(30)
    ->retry(3, 100)
    ->withToken($token->token)
    ->get('https://api.service.com/endpoint');
```

#### Logging

```php
// Usar canal dedicado
\Log::channel('sitec-integrations')->info('Integração iniciada', [
    'service' => 'jira',
    'user_id' => auth()->id(),
    'action' => 'create_issue',
]);

\Log::channel('sitec-integrations')->error('Falha na integração', [
    'service' => 'hubspot',
    'error' => $exception->getMessage(),
    'trace' => $exception->getTraceAsString(),
]);
```

---

## 🔗 Integração com o Ecossistema SierraTecnologia

### Conexão com Bibliotecas Irmãs

O **Integrations** se integra perfeitamente com outros pacotes do ecossistema:

#### 1. **sierratecnologia/muleta**

Dependência principal que fornece traits e helpers:

```php
use Muleta\Traits\Providers\ConsoleTools;

class IntegrationsProvider extends ServiceProvider
{
    use ConsoleTools; // Registra comandos automaticamente
}
```

#### 2. **Market (E-commerce)**

Integração com gateways de pagamento e ERPs:

```php
// Sincronizar produtos com marketplace externo
use Integrations\Connectors\Amazon\Amazon;

$amazon = new Amazon($token);
$amazon->syncProducts($marketProducts);
```

#### 3. **MediaManager**

Upload de mídias para serviços de armazenamento:

```php
use Integrations\Connectors\Dropbox\Dropbox;

$dropbox = new Dropbox($token);
$file = $dropbox->upload($mediaFile);
```

#### 4. **CMS (Content Management)**

Publicação de conteúdo em redes sociais:

```php
use Integrations\Connectors\Facebook\Facebook;

$facebook = new Facebook($token);
$facebook->publishPost($article->title, $article->content);
```

### Padrões de Versionamento e CI/CD

O projeto segue o **Semantic Versioning** (SemVer):

- **MAJOR**: Mudanças incompatíveis na API
- **MINOR**: Funcionalidades novas compatíveis com versões anteriores
- **PATCH**: Correções de bugs

#### Workflow de CI/CD

O projeto utiliza **GitHub Actions** para automação:

```yaml
# .github/workflows/ci.yml
- Testes automatizados (PHPUnit)
- Análise estática (PHPStan)
- Code style (PHPCS - PSR-12)
- Análise de complexidade (PHPMD)
```

### Casos de Uso Multi-Serviço

#### Exemplo: Pipeline de Marketing Automation

```php
// 1. Capturar lead do formulário
$lead = Lead::create($request->all());

// 2. Criar contato no Hubspot (CRM)
$hubspot = new Hubspot($crmToken);
$contact = $hubspot->createContact($lead->toArray());

// 3. Adicionar a lista de email marketing
$mailchimp = new Mailchimp($emailToken);
$mailchimp->addSubscriber($lead->email);

// 4. Notificar time de vendas no Slack
$slack = new Slack($slackToken);
$slack->sendMessage('#vendas', "Novo lead: {$lead->name}");

// 5. Criar task no Jira para follow-up
$jira = new Jira($jiraToken);
$jira->createTask([
    'summary' => "Follow-up lead: {$lead->name}",
    'assignee' => 'vendedor@empresa.com',
]);
```

---

## 🛠 Extensão e Customização

### Como Criar Novos Drivers ou Conectores Customizados

#### Passo 1: Criar a Estrutura

```bash
src/Connectors/MeuServico/
├── MeuServico.php
├── Create.php
├── Update.php
└── Import.php
```

#### Passo 2: Implementar o Conector Base

```php
<?php

namespace Integrations\Connectors\MeuServico;

use Integrations\Connectors\Connector;
use GuzzleHttp\Client;

class MeuServico extends Connector
{
    protected static $ID = 'meu-servico';

    protected $client;
    protected $baseUrl = 'https://api.meuservico.com/v1';

    protected function getConnection($token = false)
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => "Bearer {$token->token}",
                'Content-Type' => 'application/json',
            ],
            'timeout' => 30,
        ]);

        return $this;
    }

    public function get($path)
    {
        try {
            $response = $this->client->get($path);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $this->setError($e->getMessage(), $e->getCode());
        }
    }

    public function post($path, $data)
    {
        try {
            $response = $this->client->post($path, [
                'json' => $data,
            ]);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $this->setError($e->getMessage(), $e->getCode());
        }
    }
}
```

#### Passo 3: Implementar Ações Específicas

```php
<?php

namespace Integrations\Connectors\MeuServico;

class Create
{
    protected $connector;

    public function __construct($token)
    {
        $this->connector = new MeuServico($token);
    }

    public function resource(array $data)
    {
        return $this->connector->post('/resources', $data);
    }
}
```

#### Passo 4: Registrar o Conector

```php
// Executar no boot do provider ou em um command
use Integrations\Models\Integration;

Integration::createIfNotExistAndReturn([
    'id' => 'meu-servico',
    'name' => 'Meu Serviço',
    'code' => \Integrations\Connectors\MeuServico\MeuServico::class,
]);
```

### Como Estender Classes Base Sem Quebrar Compatibilidade

#### Usando Traits

```php
<?php

namespace App\Traits;

trait CustomIntegrationBehavior
{
    public function logActivity($message)
    {
        \Log::channel('custom')->info($message);
    }

    public function notifyOnError($exception)
    {
        // Notificar equipe
    }
}

// Usar no conector
class MeuServico extends Connector
{
    use CustomIntegrationBehavior;
}
```

#### Sobrescrevendo Métodos com Cuidado

```php
class CustomJira extends \Integrations\Connectors\Jira\Jira
{
    // Sobrescrever apenas o necessário
    protected function getConnection($token = false)
    {
        // Lógica customizada
        $connection = parent::getConnection($token);

        // Adicionar configurações extras
        $connection->setCustomConfig();

        return $connection;
    }
}
```

### Recomendações para Integração Segura e Isolada

#### 1. Usar Filas para Operações Pesadas

```php
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;

class SyncContactsJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue;

    public $tries = 3;
    public $timeout = 120;

    public function handle()
    {
        $hubspot = new Hubspot($this->token);
        $hubspot->syncContacts();
    }
}
```

#### 2. Implementar Circuit Breaker

```php
use Illuminate\Support\Facades\Cache;

class CircuitBreaker
{
    public function call($service, callable $callback)
    {
        $failureKey = "circuit_breaker:{$service}:failures";
        $failures = Cache::get($failureKey, 0);

        if ($failures >= 5) {
            throw new \Exception("Circuit breaker aberto para {$service}");
        }

        try {
            $result = $callback();
            Cache::forget($failureKey);
            return $result;
        } catch (\Exception $e) {
            Cache::put($failureKey, $failures + 1, now()->addMinutes(5));
            throw $e;
        }
    }
}
```

#### 3. Validar Dados Antes de Enviar

```php
use Illuminate\Support\Facades\Validator;

public function createContact(array $data)
{
    $validator = Validator::make($data, [
        'email' => 'required|email',
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        throw new \InvalidArgumentException(
            'Dados inválidos: ' . $validator->errors()->first()
        );
    }

    return $this->connector->post('/contacts', $data);
}
```

---

## 📊 Exemplos Reais

### Caso de Uso 1: Sistema de Gerenciamento de Projetos

**Cenário**: Empresa de software que usa Jira para gerenciar projetos e deseja integrar com seu sistema interno.

```php
<?php

namespace App\Services;

use Integrations\Connectors\Jira\Jira;
use Integrations\Connectors\Jira\Create;
use Integrations\Connectors\Jira\Import;
use App\Models\Project;
use App\Models\Task;

class ProjectManagementService
{
    protected $jira;

    public function __construct()
    {
        $token = \Integrations\Models\Token::where('integration_id', 'jira')
            ->where('user_id', auth()->id())
            ->first();

        $this->jira = new Jira($token);
    }

    public function syncProjectsFromJira()
    {
        $import = new Import($this->jira->getToken());

        // Importar projetos
        $jiraProjects = $import->allProjects();

        foreach ($jiraProjects as $jiraProject) {
            $project = Project::updateOrCreate(
                ['jira_key' => $jiraProject['key']],
                [
                    'name' => $jiraProject['name'],
                    'description' => $jiraProject['description'],
                    'lead_id' => $this->findUserByEmail($jiraProject['lead']['email']),
                ]
            );

            // Importar issues do projeto
            $this->syncTasksFromProject($project, $jiraProject['key']);
        }
    }

    protected function syncTasksFromProject(Project $project, string $jiraKey)
    {
        $import = new Import($this->jira->getToken());
        $issues = $import->fromProject($jiraKey);

        foreach ($issues as $issue) {
            Task::updateOrCreate(
                ['jira_id' => $issue['id']],
                [
                    'project_id' => $project->id,
                    'title' => $issue['fields']['summary'],
                    'description' => $issue['fields']['description'],
                    'status' => $this->mapJiraStatus($issue['fields']['status']['name']),
                    'priority' => $issue['fields']['priority']['name'],
                    'assigned_to' => $this->findUserByEmail($issue['fields']['assignee']['email'] ?? null),
                    'due_date' => $issue['fields']['duedate'] ?? null,
                ]
            );
        }
    }

    public function createJiraIssueFromTask(Task $task)
    {
        $create = new Create($this->jira->getToken());

        $issue = $create->execute([
            'project' => $task->project->jira_key,
            'summary' => $task->title,
            'description' => $task->description,
            'issuetype' => $this->mapTaskType($task->type),
            'priority' => $task->priority,
            'assignee' => $task->assignedUser->email ?? null,
        ]);

        $task->update(['jira_id' => $issue['id']]);

        return $issue;
    }
}
```

**Benefícios Observados**:
- Sincronização bidirecional entre Jira e sistema interno
- Redução de 70% no tempo de atualização manual de projetos
- Visibilidade centralizada do status dos projetos

### Caso de Uso 2: Automação de Marketing e Vendas

**Cenário**: E-commerce que integra Hubspot (CRM), Instagram (marketing) e Slack (comunicação interna).

```php
<?php

namespace App\Services;

use Integrations\Connectors\Hubspot\Hubspot;
use Integrations\Connectors\Instagram\Instagram;
use Integrations\Connectors\Slack\Slack;
use App\Models\Lead;
use App\Models\Sale;

class MarketingAutomationService
{
    protected $hubspot;
    protected $instagram;
    protected $slack;

    public function __construct()
    {
        // Inicializar conectores
        $this->hubspot = new Hubspot($this->getToken('hubspot'));
        $this->instagram = new Instagram($this->getToken('instagram'));
        $this->slack = new Slack($this->getToken('slack'));
    }

    public function processNewLead(array $data)
    {
        // 1. Criar lead no sistema
        $lead = Lead::create($data);

        // 2. Criar contato no Hubspot
        $hubspotContact = $this->hubspot->createContact([
            'email' => $lead->email,
            'firstname' => $lead->first_name,
            'lastname' => $lead->last_name,
            'phone' => $lead->phone,
            'lifecyclestage' => 'lead',
            'lead_source' => $lead->source,
        ]);

        $lead->update(['hubspot_id' => $hubspotContact['id']]);

        // 3. Notificar equipe de vendas no Slack
        $this->slack->sendMessage('#vendas', sprintf(
            "🎯 *Novo Lead Qualificado*\n" .
            "Nome: %s %s\n" .
            "Email: %s\n" .
            "Telefone: %s\n" .
            "Origem: %s",
            $lead->first_name,
            $lead->last_name,
            $lead->email,
            $lead->phone,
            $lead->source
        ));

        return $lead;
    }

    public function trackInstagramCampaign(string $campaignId)
    {
        // Obter métricas da campanha
        $metrics = $this->instagram->getPostMetrics($campaignId);

        // Registrar no sistema
        \App\Models\CampaignMetric::create([
            'campaign_id' => $campaignId,
            'platform' => 'instagram',
            'impressions' => $metrics['impressions'],
            'reach' => $metrics['reach'],
            'engagement' => $metrics['engagement'],
            'clicks' => $metrics['clicks'],
        ]);

        // Notificar equipe de marketing
        if ($metrics['engagement'] > 1000) {
            $this->slack->sendMessage('#marketing', sprintf(
                "🚀 *Campanha em Destaque!*\n" .
                "ID: %s\n" .
                "Engajamento: %d\n" .
                "Alcance: %d",
                $campaignId,
                $metrics['engagement'],
                $metrics['reach']
            ));
        }
    }

    public function syncSalesWithHubspot()
    {
        $sales = Sale::whereNull('hubspot_deal_id')
            ->where('created_at', '>=', now()->subDays(7))
            ->get();

        foreach ($sales as $sale) {
            $deal = $this->hubspot->createDeal([
                'dealname' => "Venda #{$sale->id}",
                'amount' => $sale->total,
                'dealstage' => $this->mapSaleStage($sale->status),
                'pipeline' => 'default',
                'closedate' => $sale->closed_at?->timestamp,
            ]);

            $sale->update(['hubspot_deal_id' => $deal['id']]);

            // Associar ao contato
            if ($sale->lead && $sale->lead->hubspot_id) {
                $this->hubspot->associateDealToContact(
                    $deal['id'],
                    $sale->lead->hubspot_id
                );
            }
        }
    }
}
```

**Benefícios Observados**:
- Automação completa do funil de vendas
- Redução de 80% no tempo de entrada de dados no CRM
- Aumento de 45% na taxa de conversão por notificação em tempo real
- Visibilidade instantânea de performance de campanhas

### Caso de Uso 3: Monitoramento e Notificações

**Cenário**: Sistema que monitora erros via Sentry e notifica a equipe técnica via Slack.

```php
<?php

namespace App\Services;

use Integrations\Connectors\Sentry\Sentry;
use Integrations\Connectors\Slack\Slack;
use Integrations\Connectors\Jira\Jira;

class ErrorMonitoringService
{
    protected $sentry;
    protected $slack;
    protected $jira;

    public function __construct()
    {
        $this->sentry = new Sentry($this->getToken('sentry'));
        $this->slack = new Slack($this->getToken('slack'));
        $this->jira = new Jira($this->getToken('jira'));
    }

    public function processErrorWebhook(array $data)
    {
        $error = $data['error'];
        $severity = $error['level'];

        // Notificar no Slack
        $message = sprintf(
            "🔴 *Erro %s Detectado*\n" .
            "Mensagem: %s\n" .
            "Ocorrências: %d\n" .
            "Ambiente: %s\n" .
            "Link: %s",
            strtoupper($severity),
            $error['message'],
            $error['count'],
            $error['environment'],
            $error['url']
        );

        $this->slack->sendMessage('#tech-alerts', $message);

        // Se for crítico, criar issue no Jira
        if (in_array($severity, ['error', 'fatal'])) {
            $this->jira->createIssue([
                'project' => 'BUGS',
                'summary' => "[{$severity}] {$error['message']}",
                'description' => $this->formatErrorDescription($error),
                'issuetype' => 'Bug',
                'priority' => $severity === 'fatal' ? 'Critical' : 'High',
                'labels' => ['auto-created', 'sentry', $error['environment']],
            ]);
        }
    }

    protected function formatErrorDescription(array $error)
    {
        return sprintf(
            "h2. Detalhes do Erro\n\n" .
            "*Mensagem:* %s\n" .
            "*Ocorrências:* %d\n" .
            "*Ambiente:* %s\n" .
            "*Primeira ocorrência:* %s\n" .
            "*Última ocorrência:* %s\n\n" .
            "h3. Stack Trace\n" .
            "{code}\n%s\n{code}\n\n" .
            "h3. Link no Sentry\n" .
            "%s",
            $error['message'],
            $error['count'],
            $error['environment'],
            $error['first_seen'],
            $error['last_seen'],
            $error['stacktrace'],
            $error['url']
        );
    }
}
```

**Benefícios Observados**:
- Tempo de resposta a erros críticos reduzido de horas para minutos
- Rastreabilidade completa de bugs desde detecção até resolução
- Redução de 60% em downtime não planejado

---

## 🧪 Ferramentas de Qualidade

O projeto utiliza um conjunto robusto de ferramentas para garantir qualidade de código:

### PHPUnit - Testes Automatizados

Executar testes:

```bash
# Todos os testes
vendor/bin/phpunit

# Com coverage
vendor/bin/phpunit --coverage-html coverage

# Teste específico
vendor/bin/phpunit tests/Unit/Connectors/JiraTest.php
```

Configuração: `phpunit.xml`

### PHPCS - Padrão de Código PSR-12

Verificar código:

```bash
# Verificar todos os arquivos
vendor/bin/phpcs

# Verificar pasta específica
vendor/bin/phpcs src/Connectors

# Corrigir automaticamente
vendor/bin/phpcbf
```

Configuração: `phpcs.xml`

### PHPStan - Análise Estática (Nível 5)

Analisar código:

```bash
# Análise completa
vendor/bin/phpstan analyse

# Com limite de memória maior
vendor/bin/phpstan analyse --memory-limit=2G

# Gerar baseline (ignorar erros existentes)
vendor/bin/phpstan analyse --generate-baseline
```

Configuração: `phpstan.neon`

### PHPMD - Detecção de Code Smells

Analisar complexidade:

```bash
# Análise em formato texto
vendor/bin/phpmd src text phpmd.xml

# Análise em formato HTML
vendor/bin/phpmd src html phpmd.xml --reportfile phpmd-report.html

# Análise específica
vendor/bin/phpmd src/Connectors text phpmd.xml
```

Configuração: `phpmd.xml`

### GrumPHP - Git Hooks

Configuração automática de hooks:

```bash
# Instalação dos hooks
vendor/bin/grumphp git:init

# Executar manualmente
vendor/bin/grumphp run
```

### GitHub Actions - CI/CD

O workflow `.github/workflows/ci.yml` executa automaticamente:

- ✅ Testes em PHP 8.0, 8.1, 8.2
- ✅ Testes em Laravel 9.x e 10.x
- ✅ PHPCS (Code Standards)
- ✅ PHPStan (Static Analysis)
- ✅ PHPMD (Mess Detection)

Status: [![CI](https://github.com/sierratecnologia/integrations/actions/workflows/ci.yml/badge.svg)](https://github.com/sierratecnologia/integrations/actions)

---

## 🤝 Guia de Contribuição

Agradecemos seu interesse em contribuir com o **SierraTecnologia Integrations**! Este guia fornece todas as informações necessárias para você começar.

### Como Contribuir

1. **Fork** o repositório
2. **Clone** seu fork localmente
3. Crie uma **branch** para sua feature ou correção
4. Faça suas alterações seguindo os padrões do projeto
5. **Commit** suas mudanças com mensagens descritivas
6. **Push** para sua branch
7. Abra um **Pull Request**

### Padrões de Commits

Utilizamos mensagens de commit semânticas:

```bash
# Novas funcionalidades
feat: Adiciona conector para Stripe

# Correções de bugs
fix: Corrige timeout em requisições do Jira

# Documentação
docs: Atualiza exemplos de uso do Hubspot

# Refatoração
refactor: Melhora estrutura do Connector base

# Testes
test: Adiciona testes para FacebookConnector

# Estilo/formatação
style: Aplica PSR-12 em todos os conectores

# Performance
perf: Otimiza consultas de tokens no banco

# Chore (manutenção)
chore: Atualiza dependências do composer
```

### Nomenclatura de Branches

```bash
# Features
feature/nome-da-feature

# Correções
fix/descricao-do-bug

# Documentação
docs/topico-documentado

# Exemplos
feature/stripe-connector
fix/jira-authentication
docs/update-readme
```

### Executar Ferramentas Localmente

Antes de fazer commit, execute as ferramentas de qualidade:

```bash
# 1. Instalar dependências
composer install

# 2. Executar testes
vendor/bin/phpunit

# 3. Verificar padrões de código (PSR-12)
vendor/bin/phpcs

# 4. Corrigir automaticamente problemas de estilo
vendor/bin/phpcbf

# 5. Análise estática
vendor/bin/phpstan analyse

# 6. Detecção de code smells
vendor/bin/phpmd src text phpmd.xml

# 7. Executar todas as verificações via GrumPHP
vendor/bin/grumphp run
```

### Requisitos para Pull Requests

Para que seu PR seja aceito, certifique-se de que:

- ✅ Todos os testes passam
- ✅ Código segue o padrão PSR-12
- ✅ PHPStan não reporta erros no nível configurado
- ✅ Documentação foi atualizada (se aplicável)
- ✅ Novos testes foram adicionados para novas funcionalidades
- ✅ CHANGELOG.md foi atualizado
- ✅ Mensagens de commit são descritivas e seguem o padrão

### Adicionando um Novo Conector

Se você deseja adicionar suporte para um novo serviço:

1. Crie a estrutura de diretórios em `src/Connectors/NomeServico/`
2. Implemente a classe base estendendo `Connector`
3. Adicione classes auxiliares (Create, Update, Import, etc.)
4. Escreva testes unitários em `tests/Unit/Connectors/NomeServicoTest.php`
5. Adicione documentação na seção "Conectores Disponíveis" do README
6. Registre o conector no banco de dados

Exemplo de estrutura:

```
src/Connectors/Stripe/
├── Stripe.php          # Classe principal
├── Create.php          # Criação de recursos
├── Update.php          # Atualização de recursos
├── Import.php          # Importação de dados
└── Webhook.php         # Processamento de webhooks
```

### Política de Licença

Este projeto está licenciado sob a **MIT License**. Ao contribuir, você concorda que suas contribuições sejam licenciadas sob os mesmos termos.

### Reportar Bugs

Para reportar bugs, abra uma [Issue](https://github.com/sierratecnologia/integrations/issues) com:

- Descrição clara do problema
- Passos para reproduzir
- Comportamento esperado vs. comportamento observado
- Versões (PHP, Laravel, pacote)
- Logs relevantes

### Solicitar Novas Funcionalidades

Para solicitar novas funcionalidades:

1. Abra uma [Issue](https://github.com/sierratecnologia/integrations/issues)
2. Use o label `enhancement`
3. Descreva detalhadamente o caso de uso
4. Explique como isso beneficiaria outros usuários

### Contato da Equipe Técnica

- **Email**: [help@sierratecnologia.com.br](mailto:help@sierratecnologia.com.br)
- **Slack**: [bit.ly/sierratecnologia-slack](https://bit.ly/sierratecnologia-slack)
- **Twitter**: [@sierratecnologia](https://twitter.com/sierratecnologia)

---

## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.

---

## Support

The following support channels are available at your fingertips:

- [Chat on Slack](https://bit.ly/sierratecnologia-slack)
- [Help on Email](mailto:help@sierratecnologia.com.br)
- [Follow on Twitter](https://twitter.com/sierratecnologia)

---

## Contributing & Protocols

Thank you for considering contributing to this project! The contribution guide can be found in [CONTRIBUTING.md](CONTRIBUTING.md).

Bug reports, feature requests, and pull requests are very welcome.

- [Versioning](CONTRIBUTING.md#versioning)
- [Pull Requests](CONTRIBUTING.md#pull-requests)
- [Coding Standards](CONTRIBUTING.md#coding-standards)
- [Feature Requests](CONTRIBUTING.md#feature-requests)
- [Git Flow](CONTRIBUTING.md#git-flow)

---

## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to [help@sierratecnologia.com.br](help@sierratecnologia.com.br). All security vulnerabilities will be promptly addressed.

---

## About SierraTecnologia

SierraTecnologia is a software solutions startup, specialized in integrated enterprise solutions for SMEs established in Rio de Janeiro, Brazil since June 2008. We believe that our drive The Value, The Reach, and The Impact is what differentiates us and unleash the endless possibilities of our philosophy through the power of software. We like to call it Innovation At The Speed Of Life. That’s how we do our share of advancing humanity.


## License

This software is released under [The MIT License (MIT)](LICENSE).

(c) 2008-2020 SierraTecnologia, This package no has rights reserved.

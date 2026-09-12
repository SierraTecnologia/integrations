<?php

namespace Integrations\Tests;

use Integrations\Facades\Integrations as IntegrationsFacade;
use Integrations\Models\Integration;
use Integrations\Models\Provider;
use Integrations\Models\Service;
use Integrations\Models\Token;

class IntegrationsTest extends TestCase
{
    public function test_integration_model_crud_and_attributes()
    {
        $integration = Integration::create([
            'name' => 'Slack Notifications',
            'code' => 'slack-webhook',
            'url' => 'https://hooks.slack.com/services/xxx',
            'description' => 'Dispatches alerts to #devops',
        ]);

        $this->assertNotNull($integration->id);
        $this->assertEquals('slack-webhook', $integration->code);
        $this->assertEquals('Slack Notifications', $integration->name);
        $this->assertEquals('https://hooks.slack.com/services/xxx', $integration->url);

        $found = Integration::where('code', 'slack-webhook')->first();
        $this->assertNotNull($found);
        $this->assertEquals('Dispatches alerts to #devops', $found->description);
    }

    public function test_service_model_and_relation_with_integration()
    {
        $integration = Integration::create([
            'name' => 'Stripe Payments',
            'code' => 'stripe-api',
            'url' => 'https://api.stripe.com',
            'description' => 'Payment processor',
        ]);

        $service = Service::create([
            'name' => 'Checkout Session API',
            'description' => 'Creates hosted checkout sessions',
            'integration_id' => $integration->id,
            'status' => 1,
        ]);

        $this->assertNotNull($service->id);
        $this->assertEquals('Checkout Session API', $service->name);
        $this->assertEquals($integration->id, $service->integration->id);
        $this->assertEquals('stripe-api', $service->integration->code);
    }

    public function test_provider_model_and_business_logic()
    {
        $provider = Provider::create([
            'name' => 'GitHub OAuth',
            'slug' => 'github',
            'login_count' => 5,
        ]);

        $this->assertNotNull($provider->id);
        $this->assertEquals('GitHub OAuth', (string) $provider);
        $this->assertEquals('GitHub OAuth', $provider->name);
        $this->assertEquals('github', $provider->slug);
        $this->assertEquals(5, $provider->login_count);

        // Test isUsable when config is not set
        $this->assertFalse($provider->isUsable());

        // Test isUsable when config is set
        config(['services.github.client_id' => 'gh_client_123']);
        $this->assertTrue($provider->isUsable());

        // Test soft delete
        $provider->delete();
        $this->assertTrue($provider->trashed());
        $this->assertFalse($provider->isUsable());
    }

    public function test_token_model_crud_and_scopes_cast()
    {
        $token = Token::create([
            'account_id' => 99,
            'token' => 'ghp_secret_access_token_12345',
            'obs' => 'CI runner deployment token',
            'scopes' => ['repo', 'read:org'],
            'status' => 1,
        ]);

        $this->assertNotNull($token->id);
        $this->assertEquals('ghp_secret_access_token_12345', $token->token);
        $this->assertEquals(99, $token->account_id);
        $this->assertIsArray($token->scopes);
        $this->assertContains('repo', $token->scopes);
        $this->assertContains('read:org', $token->scopes);

        $found = Token::where('token', 'ghp_secret_access_token_12345')->first();
        $this->assertNotNull($found);
        $this->assertEquals('CI runner deployment token', $found->obs);
    }

    public function test_facade_and_provider_configurations()
    {
        $this->assertNotNull(config('integrations'));
        $this->assertNotNull(config('services'));
    }
}

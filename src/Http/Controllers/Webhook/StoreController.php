<?php


namespace Integrations\Http\Controllers\Webhook;


use Integrations\Http\Controllers\Controller;
use BotMan\BotMan\BotMan;

class StoreController extends Controller
{

    public function __invoke(BotMan $bot, string $secret)
    {
        auth()->user()->webhook = encrypt($secret);
        auth()->user()->save();

        $bot->reply(
            trans('integrations.webhook.stored', ['url' => auth()->user()->getWebhookUrl()]),
            ['parse_mode' => 'Markdown']
        );
    }
}
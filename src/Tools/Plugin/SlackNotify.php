<?php

namespace Integrations\Tools\Plugin;

use Integrations\Tools\Builder;
use Fabrica\Models\Infra\Ci\Build;
use Integrations\Tools\Plugin;
use Maknz\Slack\Client;
use Maknz\Slack\Attachment;
use Maknz\Slack\AttachmentField;

/**
 * Slack Plugin
 *
 * @author Stephen Ball <phpci@stephen.rebelinblue.com>
 */
class SlackNotify extends Plugin
{
    private $webHook;
    private $room;
    private $username;
    private $message;
    private $icon;
    private $showStatus;

    /**
     * @return string
     */
    public static function pluginName()
    {
        return 'slack_notify';
    }

    /**
     * {@inheritdoc}
     */
    public function __construct(Builder $builder, Build $build, array $options = [])
    {
        parent::__construct($builder, $build, $options);

        if (is_array($options) && isset($options['webhook_url'])) {
            $this->webHook = trim($options['webhook_url']);

            if (isset($options['message'])) {
                $this->message = $options['message'];
            } else {
                $this->message = '<%PROJECT_URI%|%PROJECT_TITLE%> - <%BUILD_URI%|Build #%BUILD%> has finished ';
                $this->message .= 'for commit <%COMMIT_URI%|%SHORT_COMMIT% (%COMMIT_EMAIL%)> ';
                $this->message .= 'on branch <%BRANCH_URI%|%BRANCH%>';
            }

            if (isset($options['room'])) {
                $this->room = $options['room'];
            } else {
                $this->room = '#php-censor';
            }

            if (isset($options['username'])) {
                $this->username = $options['username'];
            } else {
                $this->username = 'PHP Censor';
            }

            if (isset($options['show_status'])) {
                $this->showStatus = (bool) $options['show_status'];
            } else {
                $this->showStatus = true;
            }

            if (isset($options['icon'])) {
                $this->icon = $options['icon'];
            }
        } else {
            throw new \Exception('Please define the webhook_url for slack_notify plugin!');
        }
    }

    /**
     * Run the Slack plugin.
     *
     * @return bool
     */
    public function execute()
    {
        $body = $this->builder->interpolate($this->message);

        $client = new Client($this->webHook);

        $message = $client->createMessage();

        if (!empty($this->room)) {
            $message->setChannel($this->room);
        }

        if (!empty($this->username)) {
            $message->setUsername($this->username);
        }

        if (!empty($this->icon)) {
            $message->setIcon($this->icon);
        }

        // Include an attachment which shows the status and hide the message
        if ($this->showStatus) {
            $successfulBuild = $this->build->isSuccessful();

            if ($successfulBuild) {
                $status = 'Success';
                $color = 'good';
            } else {
                $status = 'Failed';
                $color = 'danger';
            }

            // Build up the attachment data
            $attachment = new Attachment(
                [
                'fallback' => $body,
                'pretext'  => $body,
                'color'    => $color,
                'fields'   => [
                    new AttachmentField(
                        [
                        'title' => 'Status',
                        'value' => $status,
                        'short' => false
                        ]
                    )
                ]
                ]
            );

            $message->attach($attachment);

            $body = '';
        }

        $message->send($body);

        return true;
    }
}

<?php

namespace Integrations\Exceptions;

use Exception;
use Illuminate\Http\Request;

class WebhookException extends Exception
{
    public static function missingSignature()
    {
        return new static('The request did not contain a header named `Integrations-Signature`.');
    }

    public static function invalidSignature($signature)
    {
        return new static("The signature `{$signature}` found in the header named `Integrations-Signature` is invalid. Make sure that the use has configured the webhook field to the value you on the Socrates dashboard.");
    }

    public static function signingSecretNotSet()
    {
        return new static('The Integrations webhook signing secret is not set. Make sure that the user has configured the webhook field to the value on the Socrates dashboard.');
    }

    public static function missingType()
    {
        return new static('The webhook call did not contain a type. Valid Integrations webhook calls should always contain a type.');
    }

    public static function unrecognizedType($type)
    {
        return new static("The type {$type} is not currently supported.");
    }

    public function render($request)
    {
        return response(['error' => $this->getMessage()], 400);
    }
}

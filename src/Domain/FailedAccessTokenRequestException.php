<?php


namespace AivoChallenge\Domain;


class FailedAccessTokenRequestException extends \Exception
{
    public function __construct()
    {
        parent::__construct();

        $this->message = "Music service failed on access token request";
    }
}
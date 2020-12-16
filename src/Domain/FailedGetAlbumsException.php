<?php


namespace AivoChallenge\Domain;

class FailedGetAlbumsException extends \Exception
{
    public function __construct()
    {
        parent::__construct();

        $this->message = "Music service failed on get albums request";
    }
}
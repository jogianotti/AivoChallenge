<?php


namespace AivoChallenge\Domain;


class FailedSearchException extends \Exception
{
    public function __construct()
    {
        parent::__construct();

        $this->message = "Music service failed on search request";
    }
}
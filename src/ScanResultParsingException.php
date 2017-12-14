<?php


namespace cwreden\php7ccAnalyser;


class ScanResultParsingException extends \Exception
{
    public function __construct(string $message = "")
    {
        parent::__construct(sprintf(
            'Parsing exception. %s',
            $message
        ));
    }

}
<?php


namespace cwreden\php7ccAnalyser;


use Throwable;

class ResultFileNotFoundException extends \Exception
{
    public function __construct($message = 'php7cc result file not found.', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
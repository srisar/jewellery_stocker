<?php


namespace Jman\Exceptions;


use Exception;
use Throwable;

class KeyNotFoundException extends Exception
{
    public function __construct($message = "Key not found.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
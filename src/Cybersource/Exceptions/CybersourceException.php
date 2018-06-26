<?php 
namespace Cybersource\Exceptions;
use Exception;

class CybersourceException extends Exception
{
    public function __construct($message,$code)
    {
        parent::__construct($message,$code);
    }
}
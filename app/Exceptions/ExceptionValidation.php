<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 25/03/2023
 * Time: 15:13
 */

namespace App\Exceptions;

use Exception;

class ExceptionValidation extends Exception
{
    public function __construct($message = null, $code = 0)
    {
        parent::__construct($message, $code);
    }
}
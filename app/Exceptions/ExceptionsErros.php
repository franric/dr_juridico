<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Exception;
use Pettrus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\MassAssignmentException;

class ExceptionsErros
{
    public function errosExceptions($e)
    {
        switch(get_class($e))
            {
                case QueryException::class          : return ['success' => false, 'messages' => $e->getMessage()];
                case ValidatorException::class      : return ['success' => false, 'messages' => $e->getMessage()];
                case Exception::class               : return ['success' => false, 'messages' => $e->getMessage()];
                case MassAssignmentException::class : return ['success' => false, 'messages' => $e->getMessage()];
                default                             : return ['success' => false, 'messages' => $e->getMessage()];
            }
    }

}
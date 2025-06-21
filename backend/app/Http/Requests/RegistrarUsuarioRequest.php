<?php

namespace App\Http\Requests;

class RegistrarUsuarioRequest
{
    public static function validate(array $input)
    {
        if((!isset($input['nome']) || !$input['nome']) || (!isset($input['email']) || !$input['email']) || (!isset($input['senha']) || !$input['senha'])) {
            return false;
        }

        if((strlen($input['nome']) > 250 || strlen($input['email']) > 250 || strlen($input['senha']) < 8)) {
            return false;
        }

        $email_valido = filter_var($input['email'], FILTER_VALIDATE_EMAIL);

        if (!$email_valido) {
            return false;
        }

        if(isset($input['admin']) && gettype($input['admin']) !== 'boolean') {
            return false;
        }

        return true;
    }
}

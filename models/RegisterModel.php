<?php

namespace app\models;

use app\core\ActiveRecord;
use app\core\Validator;
use app\models\observers\RegisterModelObserver;

/**
 * Class RegisterModel
 * 
 * @package app\models
 */

class RegisterModel extends ActiveRecord
{
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $password;
    public string $confirmPassword;

    public function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return [
            'firstname',
            'lastname',
            'email',
            'password'
        ];
    }
    
    public function rules(): array
    {
        return [
            'firstname' => [Validator::RULE_REQUIRED],
            'lastname' => [Validator::RULE_REQUIRED],
            'email' => [Validator::RULE_REQUIRED, Validator::RULE_EMAIL],
            'password' => [
                Validator::RULE_REQUIRED,
                [
                    Validator::RULE_MIN,
                    'min' => 8
                ],
                [
                    Validator::RULE_MAX,
                    'max' => 24
                ]
            ],
            'confirmPassword' => [
                Validator::RULE_REQUIRED, 
                [
                    Validator::RULE_MATCH,
                    'match' => 'password'
                ]
            ],
        ];
    }

    public function observers(): array
    {
        return [
            RegisterModelObserver::class
        ];
    }
}
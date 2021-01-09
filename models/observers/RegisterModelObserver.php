<?php

namespace app\models\observers;

use app\models\RegisterModel;

/**
 * Class RegisterModelObserver
 * 
 * @package app\models\observers
 */

class RegisterModelObserver
{
    public function creating(RegisterModel $registerModel)
    {
        $registerModel->password = password_hash($registerModel->password, PASSWORD_DEFAULT);
    }

    public function created(RegisterModel $registerModel)
    {
        //
    }
}
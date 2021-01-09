<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\RegisterModel;

/**
 * Class AuthController
 * 
 * @package app\core
 */

class AuthController extends Controller
{
    public string $layout = 'auth';

    public array $middlewares = [
        'logout' => AuthMiddleware::class
    ];

    public function login()
    {
        return $this->render('login');
    }

    public function register(Request $request)
    {
        $registerModel = new RegisterModel();
        if ($request->getMethod() === 'post') {
            $registerModel->loadData($request->getBody());
            if ($registerModel->validate() && $registerModel->save()) {
                Application::$app->session->set('success', 'Successfully saved!');
                Application::$app->response->redirect();
            }

            return $this->render('register', [
                'model' => $registerModel
            ]);
        }

        return $this->render('register', [
            'model' => $registerModel
        ]);
    }
}

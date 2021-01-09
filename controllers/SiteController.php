<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

/**
 * Class SiteController
 * 
 * @package app\controllers
 */

 class SiteController extends Controller
 {
     public function home(Request $request)
     {
         $params = [
             'name' => 'Test Param'
         ];
         
         return $this->render('home', $params);
     }
 }
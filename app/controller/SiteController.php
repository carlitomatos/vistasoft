<?php


namespace App\controller;

use Src\Controller;

class SiteController extends Controller{

    public function index(){
        return view('index.php',["teste"=>"123"]);
    }

}
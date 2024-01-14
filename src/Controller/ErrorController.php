<?php

namespace App\controller;

use App\Controller\AbstractController;

class ErrorController extends AbstractController
{
    public function error()
    {
        return $this->twig->render("Errorlayout.html.twig");
    }
}

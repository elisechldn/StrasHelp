<?php

namespace App\controller;

use App\Controller\AbstractController;

class RepondreannonceController extends AbstractController
{
    public function repondreannonce()
    {
        if (!$this->user) {
            header('Location:/error');
        }
        return $this->twig->render("repondreannonce/repondreannonce.html.twig");
    }
}

<?php

namespace App\controller;

use App\Controller\AbstractController;
use App\Model\AnnonceManager;
use App\Model\UserManager;

class DashboardController extends AbstractController
{
    public function dashboard()
    {
        if (!$this->user) {
            header('Location:/error');
        }

        return $this->twig->render("Admin/dashboard.html.twig");
    }

    public function moderationAnnonces()
    {
        if (!$this->user) {
            header('Location:/error');
        }

        return $this->twig->render("Admin/moderation-des-annonces.html.twig");
    }

    public function moderationAnnoncesDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);

            $annoncesManagerDel = new AnnonceManager();
            $annoncesManagerDel->deleteAd((int)$id);

            header('Location:/Admin/moderation-des-annonces');
        }
    }

    public function gestionUser()
    {
        if (!$this->user) {
            header('Location:/error');
        }

        return $this->twig->render("Admin/gestion-des-utilisateurs.html.twig");
    }

    public function editUser(int $id)
    {
        if (!$this->user) {
            header('Location:/error');
        }

        $userManager = new userManager();
        $updatedUser = $userManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updateFields = array_map('trim', $_POST);

            $userManager->updateUsers($updateFields);

            header('Location: /Admin/gestion-des-utilisateurs');
        }

        return $this->twig->render("Admin/edition-utilisateur.html.twig", [
            'updates' => $updatedUser,
        ]);
    }

    public function informationsUser()
    {
        if (!$this->user) {
            header('Location:/error');
        }

        return $this->twig->render("Admin/informations-personnelles.html.twig");
    }

    public function deleteUser($id): void
    {
        $userManager = new UserManager();
        $userManager->deleteUser((int)$id);

        header('Location:/Admin/gestion-des-utilisateurs');
    }
}

<?php

namespace App\Controller;

use App\Model\AnnonceManager;
use App\Model\CategoryManager;

/**
 * @SuppressWarnings(PHPMD)
 **/

class AnnonceController extends AbstractController
{
    public function annonce($categorie = 0, $searchbar = ''): string
    {

        $annoncesList = new AnnonceManager();
        $annonces = $annoncesList->selectAllAd();

        if ($searchbar) {
            $annoncelist = new CategoryManager();
            $annonces = $annoncelist->search($searchbar);
        }
        if ($categorie) {
            $annoncelist = new CategoryManager();
            $annonces = $annoncelist->searchCat($categorie);
        }

        return $this->twig->render('Annonce/annonces.html.twig', ['annonces' => $annonces]);
    }

    public function annonceSearch($page = 0, $category = 0, $type = 0)
    {
        $searchAnnonces = new AnnonceManager();
        $searchAnnonce = $searchAnnonces->selectByPage($page, $category, $type);
        $countAd = $searchAnnonces->countAnnonce();

        return json_encode(['search' => $searchAnnonce, 'count' => $countAd]);
    }

    // Pour récupérer le détail de l'annonce par son id
    public function annoncesDetail(int $id)
    {
        $annonceManager = new AnnonceManager();
        $annonceID = $annonceManager->selectOneByIdAd($id);

        return $this->twig->render("Annonce/detail-annonce.html.twig", ['annonceID' => $annonceID]);
    }

    public function newAnnonces()
    {
        if (!$this->user) {
            header('Location:/error');
        }
        // On défini les erreurs dans un array vide
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadDir = './assets/images/';
            $uniqueName = uniqid('', true) . basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $uniqueName;
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $authorizedExtensions = ['jpg', 'jpeg', 'png', 'PNG', 'JPEG', 'JPG'];
            $maxFileSize = 2000000;

            $ads = array_map('trim', $_POST);
            $ads['image'] = $uploadFile;

            if (!isset($ads['radio']) || empty($ads['radio'])) {
                $errors['radio'] = "Veuillez choisir un type d'annonce";
            }

            if (!isset($ads['category']) || empty($ads['category'])) {
                $errors['category'] = "Veuillez choisir une catégorie";
            }

            if (!isset($ads['title']) || empty($ads['title'])) {
                $errors['title'] = "Donnez un titre";
            }

            if (!isset($ads['description']) || empty($ads['description'])) {
                $errors['description'] = "Donnez une description";
            }

            if (strlen($ads['description']) > 800) {
                $errors['description'] = "Rentrez une description de moins de 800 caractères";
            }

            if (strlen($ads['description']) < 35) {
                $errors['description'] = "Rentrez une description d'au moins 35 caractères";
            }

            if ((!in_array($extension, $authorizedExtensions))) {
                $errors['image'] = 'Veuillez sélectionner une image de type Jpg ou Png !';
            }

            if (
                file_exists($_FILES['image']['tmp_name']) && filesize($_FILES['image']['tmp_name']) > $maxFileSize
                || filesize($_FILES['image']['tmp_name']) == 0
            ) {
                $errors['image'] = "Votre fichier doit faire moins de 1M !";
            }

            if (empty($errors)) {
                $userId = $_SESSION['user_id'];
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);
                $createAnnonces = new AnnonceManager();
                if ($createAnnonces->createAnnonce($ads, $userId)) {
                    header('Location:/annonces');
                }
            }
        }
        return $this->twig->render('Annonce/deposer-une-annonce.html.twig', ['erreurs' => $errors]);
    }
    public function delete($id)
    {
        $annonceManager = new AnnonceManager();
        $annonceManager->delete($id);

        header('location:/annonces');
    }

    public function repondre()
    {
        if (!$this->user) {
            header('Location:/error');
        }
        //$errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = array_map('trim', $_POST);

            $userUserName = $_SESSION['user_username'];
            $userMail = $_SESSION['user_email'];
            $annonceManager = new AnnonceManager();
            $annonceManager->responseAd($response, $userUserName, $userMail);
        }

        return $this->twig->render('Annonce/repondreannonce.html.twig');
    }
}

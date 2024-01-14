<?php

namespace App\Controller;

use App\Model\CategoryManager;

class CategoryController extends AbstractController
{
    public function gestionCategory()
    {
        return $this->twig->render("Admin/gestion-des-categories.html.twig");
    }

    public function addCategory(): ?string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newCategory = array_map('trim', $_POST);

            if (!isset($newCategory['ajout']) || empty($newCategory['ajout'])) {
                $errors['ajout'] = "Veuillez remplir le champ.";
            }

            if (empty($errors)) {
                $newCategoryManager = new CategoryManager();
                $newCategoryManager->insertCategory($newCategory);
                header('Location: /Admin/gestion-des-categories');
            }
        }

        return $this->twig->render('Admin/gestion-des-categories.html.twig', ['errors' => $errors]);
    }

    public function deleteCat($id)
    {
        $categoryManager = new CategoryManager();
        $categoryManager->deleteCategory($id);

        header('location: /Admin/gestion-des-categories');
    }

    public function searchAd()
    {
        $resultSearch = [];
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $categorieName = $_GET['categorie'];
            $searchBar = $_GET['searchbar'];
            if ($categorieName) {
                $categoryManager = new CategoryManager();
                $resultSearch = $categoryManager->searchCat($categorieName);
            }
            if ($searchBar) {
                $categoryManager = new CategoryManager();
                $resultSearch = $categoryManager->search($searchBar);
            }
        }
        return $this->twig->render("Annonce/annonces.html.twig", ['resultSearch' => $resultSearch]);
    }
}

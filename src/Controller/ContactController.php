<?php

namespace App\controller;

use App\Model\ContactManager;
use App\Controller\AbstractController;

class ContactController extends AbstractController
{
    public function contact(): string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentialsContact = array_map('trim', $_POST);

            if (!isset($credentialsContact['email']) || empty($credentialsContact['email'])) {
                $errors['email'] = 'champ obligatoire';
            }

            if (!isset($credentialsContact['firstname']) || empty($credentialsContact['firstname'])) {
                $errors['firstname'] = 'champ obligatoire';
            }

            if (!isset($credentialsContact['lastname']) || empty($credentialsContact['lastname'])) {
                $errors['lastname'] = 'champ obligatoire';
            }

            if (!isset($credentialsContact['message']) || empty($credentialsContact['message'])) {
                $errors['message'] = 'champ obligatoire';
            }

            if (empty($errors)) {
                $userId = $_SESSION['user_id'];
                $contactManager = new ContactManager();
                $contactManager->insert($credentialsContact, $userId);
            }
        }
        return $this->twig->render('Contact/contact.html.twig', ['errors' => $errors]);
    }
}

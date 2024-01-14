<?php

namespace App\Controller;

use Twig\Environment;
use App\Model\UserManager;
use App\Model\AnnonceManager;
use App\Model\CategoryManager;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;
    protected array|false $user;


    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
            'cache' => false,
            'debug' => true,
            ]
        );
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('categories', $this->showCategory());
        $this->twig->addGlobal('adtypes', $this->showAdType());
        $this->twig->addGlobal('ads', $this->moderateAds());
        $userManager = new UserManager();
        $this->user = isset($_SESSION['user_id']) ? $userManager->selectOneById($_SESSION['user_id']) : false;
        $this->twig->addGlobal('user', $this->user);
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addGlobal('users', $this->allUsers());
    }

    private function showCategory()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();

        return $categories;
    }

    public function showAdType()
    {
        $showAdTypes = new AnnonceManager();
        $adtypes = $showAdTypes->adType();

        return $adtypes;
    }

    public function moderateAds()
    {
        $moderateAds = new AnnonceManager();
        $ads = $moderateAds->selectAd();

        return $ads;
    }

    public function allUsers()
    {
        $moderateUsers = new UserManager();
        $users = $moderateUsers->selectAllUsers();

        return $users;
    }
}

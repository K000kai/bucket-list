<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_home')]
    public function home(Request $request, EntityManagerInterface $entityManager,UserPasswordHasherInterface $hasher):Response
    {
        return $this->render('main/home.html.twig');
    }

    #[Route('/about-us', name:'main_about_us')]
    public function aboutUs() :Response{
        $contenu_json = file_get_contents('../src/data/team.json');
        // je décode le json pour le mettre en tableau d'objet
        $teamMembers = json_decode($contenu_json);

        return $this->render("main/about_us.html.twig", [
            'teamMembers' => $teamMembers
            ]);
    }

}
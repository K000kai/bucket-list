<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WishController extends AbstractController
{
    #[Route('/wishes', name: 'wish_list')]
    public function list(): Response{
        //todo : aller chercher les souhaits

        return $this->render('wish/list_wish.html.twig');
    }
    #[Route('/wishes/details/{id}',name:'wish_details')]
    public function details(int $id): Response {
        //todo: allez chercher le wish en BDD
        return $this->render('wish/details.html.twig');
    }

}

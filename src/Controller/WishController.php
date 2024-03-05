<?php

namespace App\Controller;


use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class WishController extends AbstractController
{
    #[Route('/wishes', name: 'wish_list')]
    public function list(WishRepository $repository): Response{

        //On stock les wishes dans une variable
        $wishes= $repository->findPublishesWishesWithCategory();

        return $this->render('wish/list_wish.html.twig',[
            'wishes'=>$wishes
        ]);
    }
    #[Route('/wishes/details/{id}',name:'wish_details')]
    public function details(int $id,WishRepository $repository): Response {
        $wish=$repository->find($id);
        //on créer une erreur 404 si ça n'existe pas en BDD
        if(!$wish){
            throw $this->createNotFoundException('This wish does not exist!! Sorry!!');
        }
        return $this->render('wish/details.html.twig',[
            'wish'=>$wish ]);
    }

    #[Route('/wishes/create',name:'wish_create')]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response{




        $wish = new Wish();
        $form = $this->createForm(WishType::class,$wish);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success','Idea successfully added !');

            return $this->render('wish/details.html.twig', [
                'wish'=>$wish
            ]);
        }
        //si le formulaire est soumis mais pas valid
        else if($form->isSubmitted()){
            $this->addFlash('danger', 'Impossible to create this wish');
        }


        return $this->render('wish/create_wish.html.twig',[
                'form' => $form
            ]);
    }
}

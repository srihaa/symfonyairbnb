<?php

namespace App\Controller;

use DateTime;
use App\Entity\House;
use App\Entity\Comment;
use App\Entity\Location;
use App\Form\HouseType;
use App\Form\CommentType;
use App\Form\SearchType;
use App\Repository\HouseRepository;
use App\Repository\LocationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AirbnbController extends AbstractController
{

    private $security;
    public function __construct(Security $security )
    {
        $this->security= $security;
    }


    #[Route('/', name: 'airbnb')]
    public function index(){
        return $this->render('airbnb/index.html.twig', [
        
        ]);
    }

    


    #[Route('/myhouses', name: 'myhouses')]
    public function properties(HouseRepository $houseRepository)
    {
        $houses = $houseRepository->findAll();
        return $this->render('airbnb/myhouse.html.twig', [
            'houses' => $houses
        ]);
    }

    #[Route('/properties', name: 'houses')]
    public function houses(HouseRepository $houseRepository)
    {
        $houses = $houseRepository->findAll();
        return $this->render('airbnb/properties.html.twig', [
            'houses' => $houses
        ]);
    }



    #[Route('/propertie/new', name: 'newHouse')]
    public function new (Request $request )
    {
        $house = new House();
        $form= $this->createForm(HouseType::class,$house);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $house->setUser($this->security->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager -> persist($house);
            $entityManager ->flush();

            return $this->redirectToRoute("propertieShow",['id'=>$house->getId()]);
        }
        return $this->render('airbnb/new.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    #[Route('/properties/{id}', name: 'propertieShow')]
    public function detail(House $house, Request $request)
    {
        $comment = new Comment;
    

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            $comment->setCeatedAt(new DateTime());
            $comment->setHouse($house);
            $entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute("propertieShow",['id' => $house->getId()]);
        }
        return $this->render('airbnb/detail.html.twig', [
            'house' => $house,
            'commentForm' => $form->createView()
        ]);
    }

    #[Route('/propertie/{id}/edit', name: 'editHouse', methods:['GET','POST'])]
    public function edit( Request $request , House $house): Response
    {
        $form= $this->createForm(HouseType::class, $house);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager -> persist($house);
            $entityManager->flush();

            return $this->redirectToRoute("propertieShow", ['id' =>$house->getId()]);
        }

        return $this->render('airbnb/edit.html.twig', [
            'editForm'=>$form->createView()
        ]);
    }

    #[Route('/search', name: 'housesearch')]
    public function search(Request $request)
    {
        $searchForm=$this->createForm(SearchType::class);
        return $this->render('airbnb/search.html.twig', [
            'search_form'=> $searchForm->createView()
        ]);
    }

}

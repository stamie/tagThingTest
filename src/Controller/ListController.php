<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Product;
use App\Entity\Reservation;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class ListController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function index(): Response
    {
        return $this->render('list/index.html.twig', [
            'controller_name' => 'ListController',
        ]);
    }

    /**
     * @Route("/list/products", name="products")
     */
    public function products(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();

        
        return $this->render('list/products.html.twig', ['products' => $products]);
    }
    /**
     * @Route("/list/reservations", name="reservations")
     */
    public function reservations(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Reservation::class);
        $reservations = $repository->findAll();

        
        return $this->render('list/reservations.html.twig', ['reservations' => $reservations]);
    }
}

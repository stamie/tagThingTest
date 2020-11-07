<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Reservation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;

class CreateController extends AbstractController
{
    /**
     * @Route("/create", name="create")
     */
    public function index(): Response
    {
        return $this->render('create/index.html.twig', [
            'controller_name' => 'CreateController',
        ]);
    }
     /**
     * @Route("/create/createproduct", name="createproduct")
     */
    public function createproduct(Request $request): Response
    {
        $product = new Product;

        $form = $this->createFormBuilder($product)
            ->add('name', TextType::class)
            ->add('basePrice', IntegerType::class)
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);            
        $form = $form->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $product->saveAs($entityManager);
            return $this->redirect('/edit/editproduct/'. $product->getId(), 301);
            
        }
           

        return $this->render('create/product.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/create/createreservation", name="createreservation")
     */
    public function createreservation(Request $request = null): Response
    {

        $reservation = new Reservation;

        $form = $this->createFormBuilder($reservation)
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                },
                'choice_label' => 'name',
            
            ])
            ->add('finalPrice', IntegerType::class)
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);            
        $form = $form->getForm();
        if ($request)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $reservation->saveAs($entityManager);
            return $this->redirect('/edit/editreservation/'. $reservation->getId(), 301);
            
        }
           

        return $this->render('create/reservation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

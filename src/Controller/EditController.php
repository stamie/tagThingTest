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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;

class EditController extends AbstractController
{
    /**
     * @Route("/edit", name="edit")
     */
    public function index(): Response
    {
        return $this->render('edit/index.html.twig', [
            'controller_name' => 'EditController',
        ]);
    }

     /**
     * @Route("/edit/editproduct", name="editproduct")
     */
    public function editproduct(int $id, Request $request = null): Response
    {
        $product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->find($id);

        if (!$product)
            exit('Nincs ilyen Product');
        
            
        $form = $this->createFormBuilder($product)
            ->add('name', TextType::class, ['attr' => ['value' => $product->getName()]])
            ->add('basePrice', IntegerType::class, ['attr' => ['value' => $product->getBasePrice()]])
            ->add('save', SubmitType::class, [
                'attr' => ['value' => 'Save'],
            ]);            
        $form = $form->getForm();
        if ($request)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $product->saveAs($entityManager);
            return $this->redirect('/edit/editproduct/'. $product->getId(), 301);
            
        }
           

        return $this->render('edit/product.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/edit/editreservation", name="editreservation")
     */
    public function editreservation(int $id, Request $request = null): Response
    {

        $reservation = $this->getDoctrine()
        ->getRepository(Reservation::class)
        ->find($id);

        if (!$reservation)
            exit('Nincs ilyen reservation');
        
            
        $form = $this->createFormBuilder($reservation)
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                },
                'choice_label' => 'name',
            
            ])
            ->add('finalPrice', IntegerType::class, ['attr' => ['value' => $reservation->getFinalPrice()]])
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
           

        return $this->render('edit/reservation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/edit/deletereservation", name="deletereservation")
     */
    public function deletereservation(int $id, Request $request = null): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reservation = $this->getDoctrine()
        ->getRepository(Reservation::class)
        ->find($id);

        $reservation->delete($entityManager);

        return $this->redirect('/list/reservations', 301);

    }

}

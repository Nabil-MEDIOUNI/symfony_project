<?php

namespace App\Controller;

use App\Entity\Contrat;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContratController extends AbstractController
{

  /**
   * @Route("/agent/contrats", name="client_contrats")
   * @Method({"GET"})
   */
  public function index()
  {

    $contrats = $this->getDoctrine()->getRepository(Contrat::class)->findAll();

    return $this->render('contrats/index.html.twig', ['contrats' => $contrats]);
  }

  /**
   * @Route("/agent/contrat/new", name="new_contrat")
   * Method({"GET", "POST"})
   */
  public function new(Request $request)
  {
    $car = new Contrat();

    $form = $this->createFormBuilder($car)
      ->add('type', TextType::class, array('attr' => array('class' => 'form-control')))
      ->add('date_retour', DateType::class, array('attr' => array('class' => 'form-control')))
      ->add('date_depart', DateType::class, array('attr' => array('class' => 'form-control')))
      ->add('id_client', ChoiceType::class, [
        'choices'  => [
          'agence 1' => 1,
          'agence 2' => 2,
        ],
        'attr' => array('class' => 'form-control')
      ])
      ->add('id_voiture', ChoiceType::class, [
        'choices'  => [
          'agence 1' => 1,
          'agence 2' => 2,
        ],
        'attr' => array('class' => 'form-control')
      ])
      ->add('save', SubmitType::class, array(
        'label' => 'Create',
        'attr' => array('class' => 'btn btn-primary mt-3')
      ))
      ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $car = $form->getData();

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($car);
      $entityManager->flush();

      return $this->redirectToRoute('car_list');
    }

    return $this->render('voitures/new.html.twig', array(
      'form' => $form->createView()
    ));
  }
}

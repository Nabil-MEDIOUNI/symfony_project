<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Contrat;
use App\Entity\Voiture;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;

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
   * @Route("/agent/contrat/{id}", name="contrat_show")
   */
  public function show($id)
  {
    $contrat = $this->getDoctrine()->getRepository(Contrat::class)->find($id);

    return $this->render('contrats/show.html.twig', array('contrat' => $contrat));
  }

  /**
   * @Route("/agent/contrat/new", name="new_contrat")
   * Method({"GET", "POST"})
   */
  public function new(Request $request)
  {
    $contrat = new Contrat();

    $form = $this->createFormBuilder($contrat)
      ->add('type', TextType::class, array('attr' => array('class' => 'form-control')))
      ->add('dateRetour', DateType::class, array('attr' => array('class' => 'form-control')))
      ->add('dateDepart', DateType::class, array('attr' => array('class' => 'form-control')))
      ->add('id_client', EntityType::class, [
        'placeholder' => 'Choose a client',
        'required' => true,
        'class' => Client::class,
        'choice_attr' => function (Client $client) {
          return [
            'class' => 'custom_class_' . $client->getId(),
            'data-post-title' => $client->getId()
          ];
        },
        'attr' => array('class' => 'form-control'),
      ])
      ->add('id_voiture', EntityType::class, [
        'placeholder' => 'Choose a car',
        'required' => true,
        'class' => Voiture::class,
        'choice_attr' => function (Voiture $car) {
          return [
            'class' => 'custom_class_' . $car->getId(),
            'data-post-title' => $car->getId()
          ];
        },
        'attr' => array('class' => 'form-control'),
      ])
      ->add('save', SubmitType::class, array(
        'label' => 'Create',
        'attr' => array('class' => 'btn btn-primary mt-3')
      ))
      ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $contrat = $form->getData();

      $car = $this->getDoctrine()->getRepository(Voiture::class)->findOneBy([
        'id' => $form->get('id_voiture')->getData(),
      ]);
      if($car->getDisponibilite() == false){
        return $this->render('errors/index.html.twig', ['error' => 'car selected is not available!', 'href' => '/agent/contrats']);
      }
      else{
        $car->setDisponibilite(false);
  
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($contrat);
        $entityManager->flush();
  
        return $this->redirectToRoute('client_contrats');
      }
    }

    return $this->render('contrats/new.html.twig', array(
      'form' => $form->createView()
    ));
  }

  /**
   * @Route("/agent/contrat/delete/{id}")
   * @Method({"DELETE"})
   */
  public function delete(Request $request, $id)
  {
    $contrat = $this->getDoctrine()->getRepository(Contrat::class)->find($id);
    $car = $this->getDoctrine()->getRepository(Voiture::class)->findOneBy([
      'Matricule' => $contrat->getIdVoiture(),
    ]);
    $car->setDisponibite(true);
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($contrat);
    $entityManager->flush();

    $response = new Response();
    $response->send();

    return $this->redirectToRoute('client_contrats');
  }
}

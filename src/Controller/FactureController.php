<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Contrat;
use App\Entity\Facture;
use App\Entity\Voiture;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;

class FactureController extends AbstractController
{

  /**
   * @Route("/agent/factures", name="client_factures")
   * @Method({"GET"})
   */
  public function index()
  {
    $factures = $this->getDoctrine()->getRepository(Facture::class)->findAll();
    return $this->render('factures/index.html.twig', ['factures' => $factures]);
  }

  /**
   * @Route("/agent/facture/new", name="new_facture")
   * Method({"GET", "POST"})
   */
  public function new(Request $request)
  {
    $facture = new Facture();

    $form = $this->createFormBuilder($facture)
      ->add('montant', IntegerType::class, array('attr' => array('class' => 'form-control')))
      ->add('dateFacture', DateType::class, array('attr' => array('class' => 'form-control')))
      ->add('payee', ChoiceType::class, [
        'choices'  => [
          'Yes' => true,
          'No' => false,
        ],
        'attr' => array('class' => 'form-control')
      ])
      ->add('id_client', EntityType::class, [
        'placeholder' => 'Choose a client',
        'required' => true,
        'class' => Client::class,
        'choice_attr' => function (Client $client) {
          return [
            'class' => 'custom_class_' . $client->getNom(),
            'data-post-title' => $client->getNom()
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

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($contrat);
      $entityManager->flush();

      return $this->redirectToRoute('client_factures');
    }

    return $this->render('factures/new.html.twig', array(
      'form' => $form->createView()
    ));
  }

  /**
   * @Route("/agent/facture/pay/{id}")
   * @Method({"POST"})
   */
  public function delete(Request $request, $id)
  {
    $facture = $this->getDoctrine()->getRepository(Facture::class)->find($id);

    $facture->setPayee(true);
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->flush();

    $response = new Response();
    $response->send();

    return $this->redirectToRoute('client_factures');
  }
}

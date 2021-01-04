<?php
  namespace App\Controller;

  use App\Entity\Voiture;
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

  class ContratController extends AbstractController {
    /**
     * @Route("/contract/new", name="create_contrat")
     * Method({"GET", "POST"})
     */
    public function createContrat(Request $request, string $mat): Response {
      $contrat = new Contrat();
      $contrat->setdate_depart(new\DateTime('now'));

      $form = $this->createFormBuilder($contrat)
        ->add('type', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('date_retour', DateType::class, array('attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array(
          'label' => 'Update',
          'attr' => array('class' => 'btn btn-primary mt-3')
        ))
        ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('car_list');
      }

      return $this->render('voitures/edit.html.twig', array(
        'form' => $form->createView()
      ));
    }
  }
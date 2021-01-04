<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Entity\Agence;

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

class VoitureController extends AbstractController
{
  /**
   * @Route("/admin/cars", name="admin_car_list")
   * @Method({"GET"})
   */
  public function admin_index()
  {

    $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();

    return $this->render('voitures/index.html.twig', ['voitures' => $voitures]);
  }

  /**
   * @Route("/agent/cars", name="car_list")
   * @Method({"GET"})
   */
  public function index()
  {

    $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();

    return $this->render('voitures/index.html.twig', ['voitures' => $voitures]);
  }

  /**
   * @Route("/admin/car/new", name="new_car")
   * Method({"GET", "POST"})
   */
  public function new(Request $request)
  {
    $car = new Voiture();
    $agences = $this->getDoctrine()->getRepository(Agence::class)->findAll();

    $form = $this->createFormBuilder($car)
      ->add('marque', TextType::class, array('attr' => array('class' => 'form-control')))
      ->add('couleur', TextType::class, array('attr' => array('class' => 'form-control')))
      ->add('matricule', IntegerType::class, array('required' => true, 'attr' => array('class' => 'form-control')))
      ->add('carburant', TextType::class, array('attr' => array('class' => 'form-control')))
      ->add('places', IntegerType::class, array('attr' => array('class' => 'form-control')))
      ->add('datemiseencirculation', DateType::class, array('attr' => array('class' => 'form-control')))
      ->add('disponibite', ChoiceType::class, [
        'choices'  => [
          'Yes' => true,
          'No' => false,
        ],
        'attr' => array('class' => 'form-control')
      ])
      ->add('id_agence', ChoiceType::class, [
        'choices'  => [
          'agence 1' => 1,
          'agence 2' => 2,
        ],
        'attr' => array('class' => 'form-control')
      ])
      ->add('description', TextareaType::class, array(
        'required' => true,
        'attr' => array('class' => 'form-control')
      ))
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

  /**
   * @Route("/admin/car/edit/{id}", name="edit_car")
   * Method({"GET", "POST"})
   */
  public function edit(Request $request, $id)
  {
    $car = new Voiture();
    $car = $this->getDoctrine()->getRepository(Voiture::class)->find($id);

    $form = $this->createFormBuilder($car)
      ->add('marque', TextType::class, array('attr' => array('class' => 'form-control')))
      ->add('couleur', TextType::class, array('attr' => array('class' => 'form-control')))
      ->add('matricule', IntegerType::class, array('required' => true, 'attr' => array('class' => 'form-control')))
      ->add('carburant', TextType::class, array('attr' => array('class' => 'form-control')))
      ->add('places', IntegerType::class, array('attr' => array('class' => 'form-control')))
      ->add('datemiseencirculation', DateType::class, array('attr' => array('class' => 'form-control')))
      ->add('disponibite', ChoiceType::class, [
        'choices'  => [
          'Yes' => true,
          'No' => false,
        ],
        'attr' => array('class' => 'form-control')
      ])
      ->add('id_agence', ChoiceType::class, [
        'choices'  => [
          'agence 1' => 1,
          'agence 2' => 2,
        ],
        'attr' => array('class' => 'form-control')
      ])
      ->add('description', TextareaType::class, array(
        'required' => true,
        'attr' => array('class' => 'form-control')
      ))
      ->add('save', SubmitType::class, array(
        'label' => 'Update',
        'attr' => array('class' => 'btn btn-primary mt-3')
      ))
      ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->flush();

      return $this->redirectToRoute('car_list');
    }

    return $this->render('voitures/edit.html.twig', array(
      'form' => $form->createView()
    ));
  }

  /**
   * @Route("/admin/car/{id}", name="car_show")
   */
  public function show($id)
  {
    $car = $this->getDoctrine()->getRepository(Voiture::class)->find($id);

    return $this->render('voitures/show.html.twig', array('car' => $car));
  }

  /**
   * @Route("/agent/cars/louer/{id}")
   * @Method({"GET", "POST"})
   */
  public function louer(Request $request, $id)
  {
    $car = $this->getDoctrine()->getRepository(Voiture::class)->find($id);
    $car->setDisponibite(false);
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->flush();

    $response = new Response();
    $response->send();

    return $this->redirectToRoute('car_list');
  }

  /**
   * @Route("/agent/cars/rendre/{id}")
   * @Method({"GET", "POST"})
   */
  public function rendre(Request $request, $id)
  {
    $car = $this->getDoctrine()->getRepository(Voiture::class)->find($id);
    $car->setDisponibite(true);
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->flush();

    $response = new Response();
    $response->send();

    return $this->redirectToRoute('car_list');
  }

  /**
   * @Route("/admin/car/delete/{id}")
   * @Method({"DELETE"})
   */
  public function delete(Request $request, $id)
  {
    $car = $this->getDoctrine()->getRepository(Voiture::class)->find($id);

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($car);
    $entityManager->flush();

    $response = new Response();
    $response->send();

    return $this->redirectToRoute('car_list');
  }
}

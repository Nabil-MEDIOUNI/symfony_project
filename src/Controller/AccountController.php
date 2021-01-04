<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends AbstractController
{
  /**
   * @Route("/admin/users", name="users_list")
   * @Method({"GET"})
   */
  public function index()
  {

    $accounts = $this->getDoctrine()->getRepository(User::class)->findAll();
    return $this->render('accounts/index.html.twig', ['accounts' => $accounts]);
  }

  /**
   * @Route("/admin/account/new", name="new_user")
   * Method({"GET", "POST"})
   */
  public function new(Request $request)
  {
    $user = new User();

    $form = $this->createFormBuilder($user)
      ->add('email', TextType::class, array('attr' => array('class' => 'form-control')))
      ->add('password', PasswordType::class, array('attr' => array('class' => 'form-control')))
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

    return $this->render('accounts/new.html.twig', array(
      'form' => $form->createView()
    ));
  }

    /**
   * @Route("/admin/account/edit/{id}", name="edit_account")
   * Method({"GET", "POST"})
   */
  public function edit(Request $request, $id)
  {
    $user = new User();
    $user = $this->getDoctrine()->getRepository(User::class)->find($id);

    $form = $this->createFormBuilder($user)
      ->add('email', TextType::class, array('attr' => array('class' => 'form-control')))
      ->add('save', SubmitType::class, array(
        'label' => 'Update',
        'attr' => array('class' => 'btn btn-primary mt-3')
      ))
      ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->flush();

      return $this->redirectToRoute('users_list');
    }

    return $this->render('accounts/edit.html.twig', array(
      'form' => $form->createView()
    ));
  }

  /**
   * @Route("/admin/account/{id}", name="user_show")
   */
  public function show($id)
  {
    $user = $this->getDoctrine()->getRepository(User::class)->find($id);

    return $this->render('accounts/show.html.twig', array('user' => $user));
  }

  /**
   * @Route("/admin/account/delete/{id}")
   * @Method({"DELETE"})
   */
  public function delete(Request $request, $id)
  {
    $car = $this->getDoctrine()->getRepository(User::class)->find($id);

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($car);
    $entityManager->flush();

    $response = new Response();
    $response->send();

    return $this->redirectToRoute('users_list');
  }
}

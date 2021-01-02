<?php
  namespace App\Controller;

  use App\Entity\Voiture;
  use App\Entity\User;

  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\Routing\Annotation\Route;
  use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
  use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

  use Symfony\Component\Form\Extension\Core\Type\TextType;
  use Symfony\Component\Form\Extension\Core\Type\TextareaType;
  use Symfony\Component\Form\Extension\Core\Type\SubmitType;

  class VoitureController extends AbstractController {
    /**
     * @Route("/", name="car_list")
     * @Method({"GET"})
     */
    public function index() {

      $voitures= $this->getDoctrine()->getRepository(Voiture::class)->findAll();
      $users= $this->getDoctrine()->getRepository(User::class)->findAll();

      return $this->render('voitures/index.html.twig', ['voitures' => $voitures, 'users' => $users]);
    }

    /**
     * @Route("/car/new", name="new_car")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
      $car = new Voiture();

      $form = $this->createFormBuilder($car)
        ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('body', TextareaType::class, array(
          'required' => false,
          'attr' => array('class' => 'form-control')
        ))
        ->add('save', SubmitType::class, array(
          'label' => 'Create',
          'attr' => array('class' => 'btn btn-primary mt-3')
        ))
        ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {
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
     * @Route("/car/edit/{id}", name="edit_car")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
      $car = new Voiture();
      $car = $this->getDoctrine()->getRepository(Voiture::class)->find($id);

      $form = $this->createFormBuilder($car)
        ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('body', TextareaType::class, array(
          'required' => false,
          'attr' => array('class' => 'form-control')
        ))
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

    /**
     * @Route("/car/{id}", name="car_show")
     */
    public function show($id) {
      $car = $this->getDoctrine()->getRepository(Voiture::class)->find($id);

      return $this->render('voitures/show.html.twig', array('car' => $car));
    }

    /**
     * @Route("/car/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
      $car = $this->getDoctrine()->getRepository(Voiture::class)->find($id);

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($car);
      $entityManager->flush();

      $response = new Response();
      $response->send();

      return $this->redirectToRoute('car_list');
    }

    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
     * @Method({"GET"})
     */
    public function admin() {
      $this->denyAccessUnlessGranted('ROLE_ADMIN');
      $voitures= $this->getDoctrine()->getRepository(Voiture::class)->findAll();
      $users= $this->getDoctrine()->getRepository(User::class)->findAll();

      return $this->render('admin/index.html.twig', ['voitures' => $voitures, 'users' => $users]);
    }
  }
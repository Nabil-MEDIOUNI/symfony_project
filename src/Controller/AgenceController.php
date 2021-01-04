<?php
  namespace App\Controller;

  use App\Entity\Agence;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\Routing\Annotation\Route;
  use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

  use Symfony\Component\Form\Extension\Core\Type\TextType;
  use Symfony\Component\Form\Extension\Core\Type\IntegerType;
  use Symfony\Component\Form\Extension\Core\Type\SubmitType;

  class AgenceController extends AbstractController {
    /**
     * @Route("/admin/agences", name="agence_list")
     * @Method({"GET"})
     */
    public function index() {

      $agences= $this->getDoctrine()->getRepository(Agence::class)->findAll();
      return $this->render('agences/index.html.twig', ['agences' => $agences]);
    }

    /**
     * @Route("/admin/agence/new", name="new_agence")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
      $agence = new Agence();

      $form = $this->createFormBuilder($agence)
        ->add('nom', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('phone', IntegerType::class, array('attr' => array('class' => 'form-control')))
        ->add('adresse', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('ville', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array(
          'label' => 'Create',
          'attr' => array('class' => 'btn btn-primary mt-3')
        ))
        ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {
        $agence = $form->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($agence);
        $entityManager->flush();

        return $this->redirectToRoute('agence_list');
      }

      return $this->render('agences/new.html.twig', array(
        'form' => $form->createView()
      ));
    }

    /**
     * @Route("/admin/agence/edit/{id}", name="edit_agence")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
      $agence = new Agence();
      $agence = $this->getDoctrine()->getRepository(Agence::class)->find($id);
      
      $form = $this->createFormBuilder($agence)
        ->add('nom', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('phone', IntegerType::class, array('attr' => array('class' => 'form-control')))
        ->add('adresse', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('ville', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array(
          'label' => 'Update',
          'attr' => array('class' => 'btn btn-primary mt-3')
        ))
        ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('agence_list');
      }

      return $this->render('agences/edit.html.twig', array(
        'form' => $form->createView()
      ));
    }

    /**
     * @Route("/admin/agence/{id}", name="agency_show")
     */
    public function show($id) {
      $agence = $this->getDoctrine()->getRepository(Agence::class)->find($id);

      return $this->render('agences/show.html.twig', array('agence' => $agence));
    }

    /**
     * @Route("/admin/agence/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
      $agence = $this->getDoctrine()->getRepository(Agence::class)->find($id);

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($agence);
      $entityManager->flush();

      $response = new Response();
      $response->send();

      return $this->redirectToRoute('agence_list');
    }
  }
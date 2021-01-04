<?php

namespace App\Controller;

use App\Entity\Client;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClientController extends AbstractController
{

    /**
     * @Route("/agent/clients", name="client_list")
     * @Method({"GET"})
     */
    public function index()
    {

        $clients = $this->getDoctrine()->getRepository(Client::class)->findAll();

        return $this->render('clients/index.html.twig', ['clients' => $clients]);
    }

    /**
     * @Route("/agent/client/new", name="new_client")
     * Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $client = new Client();

        $form = $this->createFormBuilder($client)
            ->add('nom', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('npermis', IntegerType::class, array('required' => true, 'attr' => array('class' => 'form-control')))
            ->add('ville', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('tel', IntegerType::class, array('attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_list');
        }

        return $this->render('clients/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/agent/client/edit/{id}", name="edit_client")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {
        $client = new Client();
        $client = $this->getDoctrine()->getRepository(Client::class)->find($id);

        $form = $this->createFormBuilder($client)
            ->add('nom', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('npermis', IntegerType::class, array('required' => true, 'attr' => array('class' => 'form-control')))
            ->add('ville', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('tel', IntegerType::class, array('attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
                'label' => 'Update',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('client_list');
        }

        return $this->render('clients/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/agent/client/{id}", name="client_show")
     */
    public function show($id)
    {
        $client = $this->getDoctrine()->getRepository(Client::class)->find($id);

        return $this->render('clients/show.html.twig', array('client' => $client));
    }

    /**
     * @Route("/agent/client/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $client = $this->getDoctrine()->getRepository(Client::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($client);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('client_list');
    }
}

<?php
  namespace App\Controller;

  use App\Entity\User;
  use App\Entity\Voiture;
  use App\Entity\Agence;
  use Symfony\Component\Routing\Annotation\Route;
  use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController {
    /**
     * @Route("/dashboard", name="dashboard")
     * @Method({"GET"})
     */
    public function index() {
    $accounts= $this->getDoctrine()->getRepository(User::class)->findAll();
    $voitures= $this->getDoctrine()->getRepository(Voiture::class)->findAll();
    $agences= $this->getDoctrine()->getRepository(Agence::class)->findAll();

      return $this->render('dashboard/index.html.twig', ['accounts' => $accounts, 'voitures' => $voitures, 'agences' => $agences]);
    }
  }
<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Voiture;
use App\Entity\Facture;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
  /**
   * @Route("/dashboard", name="dashboard")
   * @Method({"GET"})
   */
  public function index()
  {
    $accounts = $this->getDoctrine()->getRepository(User::class)->findAll();
    $availableCars = $this->getDoctrine()->getRepository(Voiture::class)->findBy([
      'Disponibilite' => true,
    ]);
    $notAvailableCars = $this->getDoctrine()->getRepository(Voiture::class)->findBy([
      'Disponibilite' => true,
    ]);
    $factures = $this->getDoctrine()->getRepository(Facture::class)->findBy([
      'payee' => false,
    ]);

    return $this->render('dashboard/index.html.twig', [
      'accounts' => $accounts,
      'availableCars' => $availableCars,
      'notAvailableCars' => $notAvailableCars,
      'factures' => $factures
    ]);
  }
}

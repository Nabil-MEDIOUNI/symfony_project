<?php
  namespace App\Controller;

  use App\Entity\User;
  use Symfony\Component\Routing\Annotation\Route;
  use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;

class AccountController extends AbstractController {
    /**
     * @Route("/admin/users", name="users_list")
     * @Method({"GET"})
     */
    public function index() {

      $accounts= $this->getDoctrine()->getRepository(User::class)->findAll();
      return $this->render('accounts/index.html.twig', ['accounts' => $accounts]);
    }
    
    /**
     * @Route("/admin/account/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $car = $this->getDoctrine()->getRepository(User::class)->find($id);
  
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($car);
        $entityManager->flush();
  
        $response = new Response();
        $response->send();
  
        return $this->redirectToRoute('users_list');
      }
  }
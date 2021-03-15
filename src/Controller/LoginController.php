<?php


namespace App\Controller;


use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Exception;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/login_page", name="login_page")
     * @return Exception|Response|LoaderError|RuntimeError|SyntaxError
     */
    public function index()
    {
        try {
            return new Response($this->twig->render('login.html.twig', [
            ]));
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $e;
        }
    }

}
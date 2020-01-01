<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User as Usuario;

/**
 * @Route("/user", name="usuario_")
 */

class UsuarioController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/register", name="registrar")
     */

    public function register( Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        
        $username = $request->request->get('username');
        $password = $request->request->get('password');        

        $user = new Usuario();
        $user->setUsername($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $em->persist($user);
        $em->flush();

        return [ "response" => sprintf('Usuario %s creado con exito', $user->getUsername()) ];
    }
}

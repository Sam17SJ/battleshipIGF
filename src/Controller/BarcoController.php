<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\AnnotationsasRest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Barco;

/**
 * Barco controller
 * @Route("/api/barco", name="api_")
 */

class BarcoController extends FOSRestController
{
    /**
     * Lista de barcos
     * @Rest\Get("/barcos")
     * 
     * @return Response
     */

     public function getBarcos()
     {
         $repository = $this->getDoctrine()->getRepository(Barco::class);
         $barcos = $repository->findall();
         return $this->handleView($this->view($barcos));
     }


   /*  public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/BarcoController.php',
        ]); 
    }*/

    /**
     * @Rest\Post("/register", name="registrar")
     */

     public function registrar(Request $request)
     {
        $em = $this->getDoctrine()->getManager();
        
        $nombre = $request->request->get('nombre');
        $tamanio = $request->request->get('tamanio');

        $barco = new Barco();
        $barco->setNombre($nombre);
        $barco->setTamanio($tamanio);
        $em->persist($barco);
        $em->flush();

        return [ "response" => sprintf('Barco creaco con exito') ];
    
     }
}

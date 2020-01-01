<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\AnnotationsasRest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Barco;
use App\Entity\Juego;
use App\Entity\Tablero;
use App\Entity\User;

/**
 * @Route("/api/juego", name="juego")
 */

class JuegoController extends AbstractController
{

    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/JuegoController.php',
        ]);
    }
    /**
     * Crear Grip
     * @Rest\Post("/grip")
     * 
     */

    public function grip(Request $request)
    {
        $em = $this->getDoctrine()->getRepository(Barco::class);

        $barcos = $request->request->get("barcos");
        $grip=[];
        for($i=0;$i<10;$i++){
            for($j=0;$j<10;$j++){
                $grip[$i][$j]=0;
            }
        }
        foreach($barcos as $b)
        {
            $barco= $em->find($b['id']);
            //$respuesta= $b['id'];
            $tamanio= $barco->getTamanio();
            $c=$tamanio;
            $x=$b['x'];
            $y=$b['y'];
            for($i=0;$i<10;$i++){
                for($j=0;$j<10;$j++){
                    //$grip[$i][$j]=0;
                    if ($x==$i && $y==$j && $grip[$i][$j]==0)
                    {
                        $grip[$i][$j]=$barco->getId();
                        $c--;
                        if ($b['ho']=="V" && $c > 0)
                        {
                            $x++;
                        }
                        if ($b['ho']=="H" && $c > 0)
                        {
                            $y++;
                        }
                }
                
                    }
                    
            }

        }
        $us = $request->request->get("user");
        $em = $this->getDoctrine()->getManager();
        $tablero = new Tablero();
        $emU = $this->getDoctrine()->getRepository(User::class);
        $user = $emU->find($us['id']);
        $tablero->setUser($user);
        $tablero->setGrid($grip);
        $em->persist($tablero);
        $em->flush();
        return $grip;
    }

/**
 * Crear juego
 * @Rest\Post("/iniciar")
 * 
 */
    public function iniciarJuego(Request $request)
    {
        $us = $request->request->get("user");
        $emU = $this->getDoctrine()->getRepository(User::class);
        $user = $emU->find($us['id']);
        $juego = new Juego();
        $juego->setJugador1($user);
        $juego->setTurnos(0);
        //$juego->
        $em = $this->getDoctrine()->getManager();
        $em->persist($juego);
        $em->flush();

        return [ "response" => sprintf('Juego iniciado con exito') ];
    }
/**
 * Disparar
 * @Rest\Post("/disparar")
 * 
 */
    public function disparar(Request $request)
    {
        $game = $request->request->get("juego");
        $emJ = $this->getDoctrine()->getRepository(Juego::class);
        $juego = $emJ->find($game['id']);
        $jugador1 = $juego->getJugador1();
        $emT = $this->getDoctrine()->getRepository(Tablero::class);
        $idU= $jugador1->getId();
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $tableros = $qb->select(array('t'))
            ->from('App\Entity\Tablero', 't')
            ->where('t.user = ?1')
            ->orderBy('t.id','DESC')
            ->setParameter(1,1)
            ->getQuery()
            ->getResult();
        $tablero=$tableros[0];
        $grid = $tablero->getGrid();
        $x =$request->request->get("X");
        $y =$request->request->get("Y");
        $responde = 0;
        if ($grid[$x][$y]==0)
        {
            $responde = 0;
            $grid[$x][$y]=-5;
        }else
        {
            if($grid[$x][$y]>0)
            {
                $responde = 1;
                $grid[$x][$y]=-10;
            }
            else $responde = -1;
        }
        $b=true;
        for($i=0;$i<10;$i++){
            for($j=0;$j<10;$j++)
            {
                if($grid[$i][$j]>0)
                {
                    $b=false;
                }
            }      
        }
        $turno= $juego->getTurnos();
        $turno++;
        $juego->setTurnos($turno);
        if($b)
        {
            $responde = 100;
        }
        $tablero->setGrid($grid);
        $em->persist($juego);
        $em->persist($tablero);
        $em->flush();
        return $responde;
    }
}

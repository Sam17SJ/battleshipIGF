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
 * @Route("/api/juego", name="juego_")
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
     * Obtener Grip
     * @Rest\Get("/obtener_grid/{id}")
     * 
     */

    public function getGrip($id,Request $request)
    {
        $em = $this->getDoctrine()->getRepository(Tablero::class);
        $grid = $em->find($id);
        return $grid;
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
        $user = $emU->findOneByUsername($us);
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
        $us2 = $request->request->get("user2");
        $emU = $this->getDoctrine()->getRepository(User::class);
        $user = $emU->findOneByUsername($us);
        $user2 = $emU->findOneByUsername($us2);
        error_log("AQUIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII");
        error_log($request);
        error_log($us);
        error_log($us2);
        $juego = new Juego();
        $juego->setJugador1($user);
        $juego->setJugador2($user2);
        $juego->setTurnos(0);
        //$juego->
        $em = $this->getDoctrine()->getManager();
        $em->persist($juego);
        $em->flush();
        $emT = $this->getDoctrine()->getRepository(Tablero::class);
        $t1=$emT->findOneBy(array('user' => $user),array('id' => 'DESC'));
        $t2=$emT->findOneBy(array('user' => $user2),array('id' => 'DESC'));      
        /*      
        foreach ($tableros as $t){
            error_log("TABLERO TAL".$t->getId());
            if($t->getUser()==$user){
                error_log("TABLERO DEL USUARIO");
            }
        } */
        error_log("111111111111111111AQUIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII");
       $respuesta=array( "response" => sprintf('Juego iniciado con exito'),
                 "idJuego" => $juego->getId(),
                  "tablero1" => $t1->getId(),
                  "tablero2" => $t2->getId());
        return  $respuesta;

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
        $juego = $emJ->find($game);
        $idTabla = $request->request->get("grid");
        $emT = $this->getDoctrine()->getRepository(Tablero::class);
        $tablero= $emT->find($idTabla);
        $em = $this->getDoctrine()->getManager();
        /* $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $tableros = $qb->select(array('t'))
            ->from('App\Entity\Tablero', 't')
            ->where('t.user = ?1')
            ->orderBy('t.id','DESC')
            ->setParameter(1,1)
            ->getQuery()
            ->getResult();
        $tablero=$tableros[0]; */
        $grid = $tablero->getGrid();
        $x =$request->request->get("X");
        $y =$request->request->get("Y");
        $responde = 0;
        $aux;
        if ($grid[$x][$y]==0)
        {
            $responde = 0;
            $grid[$x][$y]=-5;
        }else
        {
            if($grid[$x][$y]>0)
            {
                $responde = 1;
                $aux=$grid[$x][$y];
                $grid[$x][$y]=-10;
            }
            else $responde = -1;
        }
        $b=true;
        $c=false;
        for($i=0;$i<10;$i++){
            for($j=0;$j<10;$j++)
            {
                if($grid[$i][$j]>0)
                {
                    $b=false;
                }
                if($grid[$i][$j]==$aux)
                {
                    $c=true;
                }
            }      
        }
        $turno= $juego->getTurnos();
        $turno++;
        $juego->setTurnos($turno);
        if($c){
            $responde =5;
        }
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

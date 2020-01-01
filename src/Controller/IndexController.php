<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

/**
 * @Route("/")
 */
class IndexController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/")
     */
    public function index()
    {
        return [
            "service"   => "Mi API Rest",
            "version"   => "0.0.0",
            "status"    => "ok"
        ];
    }
        
    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction() {}
    
}
<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends Controller
{

    /**
     * @Route("/hello/{name}", name="app_hello")
     */
    public function hello($name="World")
    {

        return new Response(
            "<html><body>Hello " . $name . "</body></html>"
        );
    }

}
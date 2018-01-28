<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HelloWorldController extends Controller
{

    public function hello()
    {
        $name = "World";

        return new Response(
            "<html><body>Hello " . $name . "</body></html>"
        );
    }

}
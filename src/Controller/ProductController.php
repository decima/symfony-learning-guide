<?php
/**
 * Created by PhpStorm.
 * User: decima
 * Date: 25/02/18
 * Time: 01:01
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;


/**
 * @Route("/product")
 */
class ProductController extends Controller
{

    /**
     * @Route("/add", name="product.add")
     * @Template("product/add.html.twig")
     */
    public function add(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add("name", TextType::class)
            ->add("releaseOn", DateType::class, [
                "widget" => "single_text"
            ])
            ->add("save", SubmitType::class, ["label" => "create Product"])
            ->getForm();
        $result = [];
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $result = $form->getData();
        }

        return ["form" => $form->createView(), "result" => $result];

    }
}
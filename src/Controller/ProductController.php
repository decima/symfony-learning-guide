<?php
/**
 * Created by PhpStorm.
 * User: decima
 * Date: 25/02/18
 * Time: 01:01
 */

namespace App\Controller;

use App\Entity\Product;
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
     * @Route("/all", name="product.all")
     * @Template("product/all.html.twig")
     */
    public function all()
    {

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findAll();
        return ["products" => $products];
    }

    /**
     * @Route("/delete/{product}", name="product.delete")
     */
    public function delete(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute("product.all");
    }

    /**
     * @Route("/add", name="product.add")
     * @Template("product/add.html.twig")
     */
    public function add(Request $request)
    {
        $product = new Product();
        $form = $this->createFormBuilder($product)
            ->add("name", TextType::class)
            ->add("releaseOn", DateType::class, [
                "widget" => "single_text"
            ])
            ->add("save", SubmitType::class, ["label" => "create Product"])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute("product.all");

        }

        return ["form" => $form->createView()];

    }
}
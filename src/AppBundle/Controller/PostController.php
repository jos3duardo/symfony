<?php

namespace AppBundle\Controller;

use AppBundle\Form\Post;
use AppBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/posts")
 * Class PostController
 * @package AppBundle\Controller
 */
class PostController extends Controller
{
    /**
     * @Route("/")
     * @return Response
     */
    public function indexAction(){
        $posts = $this->getDoctrine()->getRepository("AppBundle:Post")
                        ->findAll();
        return $this->render('posts/posts.html.twig',['posts' => $posts]);

    }
    /**
     * @Route("/create")
     * @return Response
     */
    public function createAction(){
        $form = $this->createForm(PostType::class);
        return $this->render('posts/create.html.twig',['form' => $form->createView()]);

    }

    /**
     * @Route("/post/{slug}")
     * @return Response
     */
    public function singleAction($slug)
    {
        $data = ['slug' => $slug];

        return $this->render('posts/single.html.twig', $data);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
    public function createAction(Request $request){
        $form = $this->createForm(PostType::class);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()){
           $post = $form->getData();
           $post->setCreatedAt(new \DateTime("now", new \DateTimeZone("America/Campo_Grande")));
           $post->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Campo_Grande")));

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($post);
            $doctrine->flush();
            //mensagem
            $this->addFlash('success',"Post Criado com sucesso!");
           return $this->redirect('/posts');

        }

        return $this->render('posts/create.html.twig',['form' => $form->createView()]);

    }

    /**
     * @Route("/edit/{id}")
     * @return Response
     */
    public function editAction(Post $post, Request $request){
//        $post = $this->getDoctrine()->getRepository('AppBundle:Post')
//            ->find($post);

        $form = $this->createForm(PostType::class, $post );

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()){
            $post = $form->getData();
            $post->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Campo_Grande")));

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($post);
            $doctrine->flush();

            $this->addFlash('warning',"Post Editado com sucesso!");

            return $this->redirect('/posts');

        }

        return $this->render('posts/create.html.twig',['form' => $form->createView()]);

    }

    /**
     * @Route("/remove/{post}")
     * @param Post $post
     * @return Response
     */
    public function removeAction(Post $post){
        $this->getDoctrine()->getManager()->remove($post);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash("error","Post deletado com sucesso");
        return $this->redirect('/posts');

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

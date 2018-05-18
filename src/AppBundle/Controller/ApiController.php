<?php
namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\BlogPost;
use FOS\RestBundle\Context\Context;

class ApiController extends FOSRestController
{
    /**
     * @Route("/api")
     */
    public function indexAction()
    {
        $data = array("hello" => "world");
        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/blogs")
     */
    public function getBlogPostListAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:BlogPost')->findAll();
        if ($data === null) {
            return new View("there are no blog posts", Response::HTTP_NOT_FOUND);
        }

        $view = $this->view($data);

        $context = new Context();
        $context->setGroups(['list']);
        $view->setContext($context);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/blogs/{id}")
     */
    public function getBlogPostAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var $blogPost BlogPost */
        $blogPost = $entityManager->getRepository(BlogPost::class)->find($id);

        if (!$blogPost) {
            throw $this->createNotFoundException(
                'No blog post found for id '.$id
            );
        }
        $blogPost->setViewCount($blogPost->getViewCount() + 1);
        $this->getDoctrine()->getManager()->persist($blogPost);
        $this->getDoctrine()->getManager()->flush();

        $view = $this->view($blogPost);

        $context = new Context();
        $context->setGroups(['details']);
        $view->setContext($context);

        return $this->handleView($view);
    }
}
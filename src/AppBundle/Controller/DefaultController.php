<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\BlogPost;

class DefaultController extends Controller
{
    const POSTS_PER_PAGE = 2;

    /**
     * @param Request $request
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $limit   = $request->get('limit', self::POSTS_PER_PAGE);
        $page   = $request->get('page', 1);


        $entityManager = $this->getDoctrine()->getManager();
        $qb = $entityManager->createQueryBuilder()
            ->from('AppBundle:BlogPost', 'blog_post')
            ->select("blog_post")
            ->where('blog_post.visible = 1');

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $qb,
            $page,
            $limit,
            ['publishDate' => 'blog_post.publish_date', 'defaultSortDirection' => 'DESC']
        );

        // replace this example code with whatever you need
        return $this->render('AppBundle:default:index.html.twig', [
                'pagination' => $pagination
            ]);
    }

    /**
     * @param Request $request
     * @Route("/blog/{slug}", name="blog_post", defaults={"slug" = false}, requirements={"slug" = "[0-9a-zA-Z\/\-]*"})
     * @return Response
     */
    public function postAction(Request $request = null, $slug)
    {

        /** @var BlogPost $content */
        $blogPost = $this->getDoctrine()
            ->getRepository(BlogPost::class)
            ->findOneBy(['slug' => $slug]);

        if (!$blogPost) {
            return new Response('Not found!', 404);
        }

        $blogPost->setViewCount($blogPost->getViewCount() + 1);
        $this->getDoctrine()->getManager()->persist($blogPost);
        $this->getDoctrine()->getManager()->flush();

        // replace this example code with whatever you need
        return $this->render('AppBundle:default:post.html.twig', [
                'blogPost' => $blogPost,
            ]);
    }

}

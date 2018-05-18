<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Assert\CreateBlogPostRequest;
use AppBundle\Assert\UpdateBlogPostRequest;
use AppBundle\Form\BlogPostFormType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Form\FormError;

class AdminController extends Controller
{

    const POSTS_PER_PAGE = 10;

    /**
     * @Route("/admin", name="admin_blog_list")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {

        $limit   = $request->get('limit', self::POSTS_PER_PAGE);
        $page   = $request->get('page', 1);


        $entityManager = $this->getDoctrine()->getManager();
        $qb = $entityManager->createQueryBuilder()
            ->from('AppBundle:Post', 'blog_post')
            ->select("blog_post");

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $qb,
            $page,
            $limit
        );

        // replace this example code with whatever you need
        return $this->render('AppBundle:admin:index.html.twig', [
                'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/admin/create-post", name="admin_create_post")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newPostAction(Request $request)
    {

        // create an instance of an empty CreateArticleRequest
        $createBlogPostRequest = new CreateBlogPostRequest();

        // create a form but with a request object instead of entity
        $form = $this->createForm(BlogPostFormType::class, $createBlogPostRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $blogPost = new Post();
            $blogPost->setTitle($createBlogPostRequest->title);
            $blogPost->setText($createBlogPostRequest->text);
            $blogPost->setSlug($createBlogPostRequest->slug);
            $blogPost->setPublishDate($createBlogPostRequest->publishDate);
            $blogPost->setVisible($createBlogPostRequest->visible);

            $tags = explode(" ",$createBlogPostRequest->tags);
            $tags = array_unique($tags);
            if (isset($tags[0])){
                foreach($tags as $k=>$v){
                    $tag = $entityManager->getRepository(Tag::class)->findOneBy(['tag_name' => $v]);
                    if (!$tag){
                        $tag = new Tag();
                        $tag->setTagName($v);
                    }
                    $blogPost->addTag($tag);
                }
            }

            try {
                $entityManager->persist($blogPost);
                $entityManager->flush();
            } catch(UniqueConstraintViolationException $e) {
                $form->get('slug')->addError(new FormError('You already have that post url!'));

                return $this->render('AppBundle:admin:create.html.twig', ['form' => $form->createView()]);
            }


            return $this->redirectToRoute('admin_blog_list');
        }

        return $this->render('AppBundle:admin:create.html.twig', [
                'form' => $form->createView(),
            ]);

        return $this->render('AppBundle:admin:create.html.twig', [
                'pagination' => $pagination
            ]);
    }

    /**
     * @Route("/admin/edit-post/{id}", name="admin_edit_post")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editPostAction(Request $request, $id)
    {

        $entityManager = $this->getDoctrine()->getManager();
        /** @var $blogPost Post */
        $blogPost = $entityManager->getRepository(Post::class)->find($id);

        if (!$blogPost) {
            throw $this->createNotFoundException(
                'No blog post found for id '.$id
            );
        }

        $updateBlogPostRequest = new UpdateBlogPostRequest();
        $updateBlogPostRequest->title = $blogPost->getTitle();
        $updateBlogPostRequest->text = $blogPost->getText();
        $updateBlogPostRequest->slug = $blogPost->getSlug();
        $updateBlogPostRequest->publishDate = $blogPost->getPublishDate();
        $updateBlogPostRequest->visible = $blogPost->getVisible();
        $tags = $blogPost->getTags();
        $tagsArr = [];

        if (isset($tags[0])){
            foreach($tags as $k=>$v){
                $tagsArr[] = $v->getTagName();
            }
        }
        $updateBlogPostRequest->tags = implode(" ", $tagsArr);

        $form = $this->createForm(BlogPostFormType::class, $updateBlogPostRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $blogPost->setTitle($updateBlogPostRequest->title);
            $blogPost->setText($updateBlogPostRequest->text);
            $blogPost->setSlug($updateBlogPostRequest->slug);
            $blogPost->setPublishDate($updateBlogPostRequest->publishDate);
            $blogPost->setVisible($updateBlogPostRequest->visible);
            $blogPost->setTags([]);

            $tags = explode(" ",$updateBlogPostRequest->tags);

            $tags = array_unique($tags);
            if (isset($tags[0])){
                foreach($tags as $k=>$v){
                    $tag = $entityManager->getRepository(Tag::class)->findOneBy(['tag_name' => $v]);
                    if (!$tag){
                        $tag = new Tag();
                        $tag->setTagName($v);
                    }
                    $blogPost->addTag($tag);
                }
            }

            try {
                $entityManager->persist($blogPost);
                $entityManager->flush();
            } catch(UniqueConstraintViolationException $e) {
                $form->get('slug')->addError(new FormError('You already have that post url!'));

                return $this->render('AppBundle:admin:create.html.twig', ['form' => $form->createView()]);
            }

            return $this->redirectToRoute('admin_blog_list');
        }

        return $this->render('AppBundle:admin:create.html.twig', [
                'form' => $form->createView(),
            ]);

        return $this->render('AppBundle:admin:create.html.twig', [
                'pagination' => $pagination
            ]);
    }


}

<?php

namespace Blog\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Blog\ModelBundle\Form\CommentType;
use Blog\ModelBundle\Entity\Comment;

class PostController extends Controller
{
    /**
     * Show Post index
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
//         $this->get('translator')->setLocale('en'); // force locale

//         $posts = $this->getDoctrine()->getRepository('ModelBundle:Post')->findAll();
//         $latestPosts = $this->getDoctrine()->getRepository('ModelBundle:Post')->findLatest(5);
        
        $posts = $this->getPostManager()->findAll();
        $latestPosts = $this->getPostManager()->findLatest(5);

        return $this->render('CoreBundle:Post:index.html.twig', array(
            'posts' => $posts,
            'latestPosts' => $latestPosts
        ));
     }
     

     /**
      * Show a single post
      * 
      * @param int $slug
      * 
      * @throws NotFoundHttpException
      * 
      * @return \Symfony\Component\HttpFoundation\Response
      */
     public function showAction($slug)
     {
//          $post = $this->getDoctrine()->getRepository('ModelBundle:Post')->findOneBy(array(
//              'slug' => $slug
//          ));
         
//          if (null == $post) {
//              throw $this->createNotFoundException('Post was not found.');
//          }
         
         $post = $this->getPostManager()->findBySlug($slug);
         
         $form = $this->createForm(new CommentType());
         
         return $this->render('CoreBundle:Post:show.html.twig', array(
             'post' => $post,
             'form' => $form->createView()
         ));
     }
     
     /**
      * Create a comment
      * 
      * @param Request $request
      * @param string $slug
      * 
      * @throws NotFoundHttpException
      * @return array
      */
     public function createCommentAction(Request $request, $slug)
     {
//          $post = $this->getDoctrine()->getRepository('ModelBundle:Post')->findOneBy(array(
//              'slug' => $slug
//          ));
         
//          if (null === $post) {
//              throw $this->createNotFoundException('Post was not found');
//          }
         
//          $comment = new Comment();
//          $comment->setPost($post);
         
//          $form = $this->createForm(new CommentType(), $comment);
//          $form->handleRequest($request);
         
//          if ($form->isValid()) {
//              $this->getDoctrine()->getManager()->persist($comment);
//              $this->getDoctrine()->getManager()->flush();
             
//              $this->get('session')->getFlashBag()->add('success', 'Your comment was submitted successfully');
             
//              return $this->redirect($this->generateUrl('blog_core_post_show', array('slug' => $post->getSlug())));
//          }

//          return $this->render('CoreBundle:Post:show.html.twig', array(
//              'post' => $post,
//              'form' => $form->createView()
//          ));

         $post = $this->getPostManager()->findBySlug($slug);
         $form = $this->getPostManager()->createComment($post, $request);
         
         if (true === $form) {
             $this->get('session')->getFlashBag()->add('success', 'Your comment was submitted successfully');
         
             return $this->redirect($this->generateUrl('blog_core_post_show', array('slug' => $post->getSlug())));
         }
         
         return array(
             'post' => $post,
             'form' => $form->createView()
             );
     }
     
     // SERVICE
     private function getPostManager()
     {
         return $this->get('post_manager');
     }

}

<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        // Premesteno u repository
//         $blogs = $em->createQueryBuilder()
//                     ->select('b')
//                     ->from('BloggerBlogBundle:Blog', 'b')
//                     ->addOrderBy('b.created', 'DESC')
//                     ->getQuery()
//                     ->getResult();

        $blogs = $em->getRepository('BloggerBlogBundle:Blog')
                    ->getLatestBlogs();
        

        return $this->render('BloggerBlogBundle:Page:index.html.twig', array(
            'blogs' => $blogs
        ));
    }
    
    public function aboutAction()
    {
        return $this->render('BloggerBlogBundle:Page:about.html.twig');
    }
    
    public function contactAction() {
        $enquiry = new Enquiry(); // model
        $form = $this->createForm(new EnquiryType(), $enquiry); // form
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
//             $form->bindRequest($request); // spaja podatke
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                // Perform action
                $message = \Swift_Message::newInstance() // \Swift je global namespace
                    ->setSubject('Contact enquiry from symblog')
                    ->setFrom('support@symblog.com')
//                     ->setTo('test@email.com')
                    ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
                    ->setBody($this->renderView('BloggerBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
                $this->get('mailer')->send($message); // mailer service
                
//                 $this->get('session')->setFlash('blogger-notice', 'Your contact inquiry has been successfully sent. Thank you!');
//                 $this->addFlash('...', '......'); // jos krace
                $this->get('session')->getFlashBag()->add('blogger-notice', 'Your contact inquiry has been successfully sent. Thank you!');
                
                // redirect - prevents reposting
                return $this->redirect($this->generateUrl('blogger_blog_contact'));
            }
        }

        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function sidebarAction() {
        $em = $this->getDoctrine()
                   ->getEntityManager();

        $tags = $em->getRepository('BloggerBlogBundle:Blog')
                   ->getTags();

        $tagWeights = $em->getRepository('BloggerBlogBundle:Blog')
                         ->getTagWeights($tags);
        
        // container predefinisan value u config.yml
        $commentLimit   = $this->container
                               ->getParameter('blogger_blog.comments.latest_comment_limit');

        $latestComments = $em->getRepository('BloggerBlogBundle:Comment')
                             ->getLatestComments($commentLimit);

        return $this->render('BloggerBlogBundle:Page:sidebar.html.twig', array(
            'tags' => $tagWeights,
            'comments' => $latestComments
        )); 
    }
}
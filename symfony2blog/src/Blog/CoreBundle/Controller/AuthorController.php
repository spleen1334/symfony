<?php

namespace Blog\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthorController extends Controller
{
    public function showAction($slug)
    {
//         $author = $this->getDoctrine()->getRepository('ModelBundle:Author')->findOneBy(
//             array(
//                 'slug' => $slug
//             ));
        $author = $this->getAuthorManager()->findBySlug($slug);
        
//         if (null === $author) {
//             throw $this->createNotFoundException('Author is not found');
//         }
        
//         $posts = $this->getDoctrine()->getRepository('ModelBundle:Post')->findBy(array(
//             'author' => $author
//         ));
        $posts = $this->getAuthorManager()->findPosts($author);

        return $this->render('CoreBundle:Author:show.html.twig', array(
                'author' => $author,
                'posts'  => $posts
            ));   
    }
    
    // SERVICE
    private function getAuthorManager()
    {
        return $this->get('author_manager');
    }

}

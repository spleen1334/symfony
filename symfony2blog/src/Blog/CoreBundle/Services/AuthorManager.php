<?php

namespace Blog\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Blog\ModelBundle\Entity\Author;

class AuthorManager
{
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function findBySlug($slug)
    {
        $author = $this->em->getRepository('ModelBundle:Author')->findByOne(array(
            'slug' => $slug
        ));
        
        if (null === $author) {
            throw new NotFoundHttpException('Author was not found');
        }
        
        return $author;
    }

    public function findPosts(Author $author)
    {
        $posts = $this->em->getRepository('ModelBundle:Post')->findBy(array(
            'author' => $author
        ));
        
        return $posts;
    }
    
}
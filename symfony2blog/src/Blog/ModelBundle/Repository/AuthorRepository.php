<?php

namespace Blog\ModelBundle\Repository;

use Blog\ModelBundle\Entity\Author;
use Doctrine\ORM\EntityRepository;

class AuthorRepository extends EntityRepository
{
    /**
     * Find first author
     * 
     * @return Author
     */
    public function findFirst()
    {
        $qb = $this->getQueryBuilder()
                    ->orderBy('a.id', 'ASC')
                    ->setMaxResults(1);
        
        return $qb->getQuery()->getSingleResult();
    }

    /**
     * Helper method
     */
    private function getQueryBuilder()
    {
        $em = $this->getEntityManager();
    
        $qb = $em->getRepository('ModelBundle:Author')
                 ->createQueryBuilder('a');
    
        return $qb;
    }
}
<?php 

namespace Blog\ModelBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    /**
     * Find latest post
     * 
     * @param int $num How many posts to get?
     * @return array
     */
    public function findLatest($num)
    {
        $qb = $this->getQueryBuilder()
                   ->orderBy('p.createdAt', 'DESC')
                   ->setMaxResults($num);
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * Find first post
     * 
     * @return Post
     */
    public function findFirst()
    {
        $qb = $this->getQueryBuilder()
                   ->orderBy('p.id', 'ASC')
                   ->setMaxResults(1);
        
        return $qb->getQuery()->getSingleResult();
    }
    
    /**
     * Helper method
     */
    private function getQueryBuilder()
    {
        $em = $this->getEntityManager();
        
        $qb = $em->getRepository('ModelBundle:Post')
                 ->createQueryBuilder('p');
        
        return $qb;
    }
}
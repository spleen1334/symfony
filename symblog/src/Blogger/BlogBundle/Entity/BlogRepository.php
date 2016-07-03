<?php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BlogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BlogRepository extends EntityRepository
{
    /**
     * Uzmi blog postove, sortirane po created.
     * 
     * @param string $limit Broj postova
     */
    public function getLatestBlogs($limit = null)
    {
        $qb = $this->createQueryBuilder('b')
                   ->select('b', 'c')
                   ->leftJoin('b.comments', 'c') // ovo je zbog lazy loading, sad odjednom ucitava blog i sve njegove komentare
                   ->addOrderBy('b.created', 'DESC');
//                     ->from('BloggerBlogBundle:Blog', 'b') // ovde netreba jer je repository povezan sa blog, i auto poziva from()
    
        if (false === is_null($limit))
            $qb->setMaxResults($limit);
    
        return $qb->getQuery()
        ->getResult();
    }
    
    /**
     * Lista tagova, u bazi se cuvaju kao CSV ovo ih razdvaja u array
     * 
     * @return array $tags
     */
    public function getTags()
    {
        $blogTags = $this->createQueryBuilder('b')
        ->select('b.tags')
        ->getQuery()
        ->getResult();
    
        $tags = array();
        foreach ($blogTags as $blogTag)
        {
            $tags = array_merge(explode(",", $blogTag['tags']), $tags);
        }
    
        foreach ($tags as &$tag)
        {
            $tag = trim($tag);
        }
    
        return $tags;
    }
    
    /**
     * Racuna koji tag ima najvise clanova u array
     * 
     * @param array $tags
     * @return array $tagWeights
     */
    public function getTagWeights($tags)
    {
        $tagWeights = array();
        if (empty($tags))
            return $tagWeights;
    
        foreach ($tags as $tag)
        {
            $tagWeights[$tag] = (isset($tagWeights[$tag])) ? $tagWeights[$tag] + 1 : 1;
        }
        // Shuffle the tags, random display na strani
        uksort($tagWeights, function() {
            return rand() > rand();
        });
    
            $max = max($tagWeights);
    
            // Max of 5 weights
            $multiplier = ($max > 5) ? 5 / $max : 1;
            foreach ($tagWeights as &$tag)
            {
                $tag = ceil($tag * $multiplier);
            }
    
            return $tagWeights;
    }
}
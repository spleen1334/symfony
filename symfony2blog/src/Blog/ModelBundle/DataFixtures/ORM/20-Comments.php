<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Blog\ModelBundle\Entity\Comment;

class Comments extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
   public function getOrder() {
       return 20;
   } 
   
   /**
    * {@inheritDoc}
    */
   public function load(ObjectManager $manager)
   {
       $posts = $manager->getRepository('ModelBundle:Post')->findAll();
       
       $comments = array(
           0 => 'Mauris lacinia mauris a urna egestas, nec dignissim ex pulvinar. Maecenas consectetur enim eu sagittis pharetra. Nam elementum vitae justo.',
           1 => 'Duis dapibus dolor tellus. Morbi a placerat tortor. Maecenas non felis mattis, accumsan nunc sed, maximus erat. Nunc euismod elit.',
           2 => 'Suspendisse potenti. Quisque consequat, lacus nec fermentum luctus, sem mauris varius diam, a egestas ante mauris sed nulla. Nullam ac.',
       );
       
       $i = 0;
       
       foreach ($posts as $post) {
           $comment = new Comment();
           $comment->setAuthorName('Misko');
           $comment->setBody($comments[$i++]);
           $comment->setPost($post);
           
           $manager->persist($comment);
       }
       
       $manager->flush();
   }
}
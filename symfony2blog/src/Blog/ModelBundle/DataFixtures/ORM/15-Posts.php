<?php


namespace Blog\ModelBundle\DataFixtures\ORM;

use Blog\ModelBundle\Entity\Post;
use Blog\ModelBundle\Entity\Author;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixtures for Posts Entity
 * @author spleen
 *
 */
class Posts extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 15;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $p1 = new Post();
        $p1->setTitle('Lorem ipsum blog title');
        $p1->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec rhoncus lorem ac elit facilisis, nec placerat dui consectetur. Sed ipsum ante, euismod id nulla eget, ornare suscipit diam. Morbi id rutrum mauris. Nunc neque magna, tincidunt eget pulvinar et, auctor fermentum neque. Curabitur sed diam velit. Ut gravida, lorem ut rutrum eleifend, metus mi aliquam sem, non cursus odio diam a massa. Maecenas eu pellentesque libero. Suspendisse eu nibh ac nisi euismod vehicula vitae at nibh. Quisque mollis tortor dolor, et faucibus elit posuere vel. Pellentesque vitae lectus pharetra, varius tortor ut, vehicula velit. Praesent sapien eros, convallis eu porta non, pulvinar at elit.');
        $p1->setAuthor($this->getAuthor($manager, 'Beki'));

        $p2 = new Post();
        $p2->setTitle('Lorem ipsum blog title 22222');
        $p2->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec rhoncus lorem ac elit facilisis, nec placerat dui consectetur. Sed ipsum ante, euismod id nulla eget, ornare suscipit diam. Morbi id rutrum mauris. Nunc neque magna, tincidunt eget pulvinar et, auctor fermentum neque. Curabitur sed diam velit. Ut gravida, lorem ut rutrum eleifend, metus mi aliquam sem, non cursus odio diam a massa. Maecenas eu pellentesque libero. Suspendisse eu nibh ac nisi euismod vehicula vitae at nibh. Quisque mollis tortor dolor, et faucibus elit posuere vel. Pellentesque vitae lectus pharetra, varius tortor ut, vehicula velit. Praesent sapien eros, convallis eu porta non, pulvinar at elit.');
        $p2->setAuthor($this->getAuthor($manager, 'Acez'));

        $p3 = new Post();
        $p3->setTitle('Lorem ipsum blog title 33333');
        $p3->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec rhoncus lorem ac elit facilisis, nec placerat dui consectetur. Sed ipsum ante, euismod id nulla eget, ornare suscipit diam. Morbi id rutrum mauris. Nunc neque magna, tincidunt eget pulvinar et, auctor fermentum neque. Curabitur sed diam velit. Ut gravida, lorem ut rutrum eleifend, metus mi aliquam sem, non cursus odio diam a massa. Maecenas eu pellentesque libero. Suspendisse eu nibh ac nisi euismod vehicula vitae at nibh. Quisque mollis tortor dolor, et faucibus elit posuere vel. Pellentesque vitae lectus pharetra, varius tortor ut, vehicula velit. Praesent sapien eros, convallis eu porta non, pulvinar at elit.');
        $p3->setAuthor($this->getAuthor($manager, 'Beki'));

        $manager->persist($p1);
        $manager->persist($p2);
        $manager->persist($p3);

        $manager->flush();

    }
    
    /**
     * Get an author
     * 
     * @param ObjectManager $manager
     * @param string $name
     * 
     * @return Author
     */
    private function getAuthor(ObjectManager $manager, $name)
    {
        return $manager->getRepository('ModelBundle:Author')->findOneBy(
            array(
                'name' => $name
            )
        );
    }
}
<?php

namespace Koopa\Bundle\JobBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Koopa\Bundle\JobBundle\Entity\Category;
use Koopa\Bundle\JobBundle\Entity\SubCategory;

class LoadCategoryData implements FixtureInterface, OrderedFixtureInterface
{

    protected $categories = array(
        array('name' => 'Ressource humaine'),
        array('name' => 'Secretariat'),
        array('name' => 'IT et Informatique'),
        array('name' => 'Science et technique'),
    );

    protected $collections = array(
        array(
            array('name' => 'Directeur'),
            array('name' => 'Recruteur'),
        ),
        array(
            array('name' => 'Caissier'),
            array('name' => 'Tresorier'),
        ),
        array(
            array('name' => 'Admin Reseaux'),
            array('name' => 'Developpeur mobile'),
        ),
        array(
            array('name' => 'Electricien'),
            array('name' => 'Pedagogue'),
        ),
    );

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->categories as $cat) {
            $category = (new Category())->setName($cat['name']);

            $manager->persist($category);
        }

        $manager->flush();

        $categories = $manager->getRepository('KoopaJobBundle:Category')->findAll();



        foreach ($this->collections as $key => $collection) {
            $category = $categories[$key];

            foreach ($collection as $cat) {
                $subCategory = (new SubCategory())->setName($cat['name']);
                $category->addSubCategory($subCategory);

                $manager->persist($category);
            }
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}

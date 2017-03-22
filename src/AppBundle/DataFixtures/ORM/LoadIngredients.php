<?php
/**
 * Created by PhpStorm.
 * User: betho
 * Date: 22/03/2017
 * Time: 18:15
 */
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadIngredient extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ingredients = array(
            new \AppBundle\Entity\Ingredient("Eggs"),
            new \AppBundle\Entity\Ingredient("Flour"),
            new \AppBundle\Entity\Ingredient("Milk"),
            new \AppBundle\Entity\Ingredient("Sugar"),
            new \AppBundle\Entity\Ingredient("Vanilla extract"),
        );

        foreach ($ingredients as $i)
        {
            $manager->persist($i);
        }

        $manager->flush();

        foreach ($ingredients as $i) {
            $this->addReference("ingredient-".$i->getN)
        }
    }

    public function getOrder()
    {
        return 0;
    }
}
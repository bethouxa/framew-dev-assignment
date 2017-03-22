<?php
/**
 * Created by PhpStorm.
 * User: betho
 * Date: 22/03/2017
 * Time: 18:22
 */
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Recipe;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadSteps extends AbstractFixture implements OrderedFixtureInterface
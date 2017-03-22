<?php

/**
 * Created by PhpStorm.
 * User: betho
 * Date: 22/03/2017
 * Time: 17:03
 */

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements \Doctrine\Common\DataFixtures\FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setPassword('adminPwd');

        $manager->persist($userAdmin);
        $manager->flush();
    }
}
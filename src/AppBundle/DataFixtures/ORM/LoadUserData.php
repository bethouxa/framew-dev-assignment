<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user1 = $userManager->createUser();
        $user1->setUsername('admin');
        $user1->setEmail('admin@recipe-manager.com');
        $user1->setPlainPassword('admin');
        $user1->setEnabled(true);
        $user1->setRoles(array('ROLE_SUPER_ADMIN'));

        $userManager->updateUser($user1); // handles persist / flush

        echo "REMINDER: CHANGE ADMIN PASSWORD AS SOON AS POSSIBLE";

        return;
    }
}

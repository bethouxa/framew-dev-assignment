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
        $user1->setPlainPassword('plopplop');
        $user1->setEnabled(true);
        $user1->setRoles(array('ROLE_SUPER_ADMIN'));

        $userManager->updateUser($user1); // handles persist / flush

        $user2 = $userManager->createUser();
        $user2->setUsername('[deleted]');
        $user2->setEmail('admin@recipe-manager.com');
        $user2->setPlainPassword('plopplop');
        $user2->setEnabled(false);

        $userManager->updateUser($user2); // handles persist / flush

	    $user3 = $userManager->createUser();
	    $user3->setUsername('test');
	    $user3->setEmail('plop@plop.fr');
	    $user3->setPlainPassword('test');
	    $user3->setEnabled(true);

	    $userManager->updateUser($user3);
	    $this->addReference('test-user', $user3);



    }
}

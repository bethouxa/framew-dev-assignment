<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testUsermanagement()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

}

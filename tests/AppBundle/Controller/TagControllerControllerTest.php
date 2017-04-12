<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TagControllerControllerTest extends WebTestCase
{
    public function testUpvote()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/up');
    }

    public function testDownvote()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'down');
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: betho
 * Date: 12/04/2017
 * Time: 09:04
 */

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
	static $routes = [
		"/admin/",
		"/admin/users",
		"/collection/",
		"/collection/new",
		"/collection/{id}",
		"/collection/{id}/edit",
		"/collection/{id}",
		"/",
		"/home",
		"/userpanel",
		"/ptag/new",
		"/ptag/{id}",
		"/recipe/",
		"/recipe/new",
		"/recipe/{id}",
		"/recipe/{id}/edit",
		"/recipe/{id}",
		"/tag/vote/{action}/{id}",
		"/tag/new",
		"/tag/approve/{id}",
		"/login",
		"/login_check",
		"/logout",
		"/profile/",
		"/profile/edit",
		"/register/",
		"/register/check-email",
		"/register/confirm/{token}",
		"/register/confirmed",
		"/resetting/request",
		"/resetting/send-email",
		"/resetting/check-email",
		"/resetting/reset/{token}",
	];

	public function testPageIsSuccessful()
	{
		$client = self::createClient();
		foreach ($this::$routes as $route)
		$client->request('GET', $route);
		echo($client->getResponse()->getStatusCode());
		$this->assertTrue($client->getResponse()->isSuccessful());
	}
}
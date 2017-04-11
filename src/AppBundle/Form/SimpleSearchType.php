<?php
/**
 * Created by PhpStorm.
 * User: betho
 * Date: 03/04/2017
 * Time: 11:41
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;

//TODO: buildform()
class SimpleSearchType extends AbstractType
{
	protected $searchTerms;

	public function setSearchTerms(String $searchTerms)
	{
		$this->searchTerms = $searchTerms;
	}

	public function getSearchTerms()
	{
		return $this->searchTerms;
	}

	public function __toString()
	{
		return (String)$this->searchTerms;
	}
}
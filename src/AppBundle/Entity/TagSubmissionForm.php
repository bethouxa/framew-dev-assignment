<?php
/**
 * Created by PhpStorm.
 * User: betho
 * Date: 19/03/2017
 * Time: 15:40
 */

namespace AppBundle\Entity;


class TagSubmissionForm
{
    protected $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}
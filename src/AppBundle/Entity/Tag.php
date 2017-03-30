<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tags")
 */
class Tag extends BaseTag {

    public function __construct(BaseTag $tag)
    {
        parent::__construct($tag->getName());
    }
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tags")
 */
class Tag extends BaseTag {

    public static function castFromPending(BaseTag $tag)
    {
        return new Tag($tag->getName());
    }
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

/**
 * @ORM\Entity
 */
class PendingTag extends Tag {

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $score;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->setScore(0);
    }

    public function getRecipes()
    {
        return null;
    }

    public function addRecipe(\AppBundle\Entity\Recipe $recipe)
    {
        throw new \BadMethodCallException();
    }

    public function upvote($amt)
    {
        $this->setScore($this->getScore()+$amt);
    }

    public function downvote($amt)
    {
        $this->setScore($this->getScore()-$amt);
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return PendingTag
     */
    private function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }
}

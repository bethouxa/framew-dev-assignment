<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="ingredients")
 */
class Ingredient {

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\IngredientsUsed", mappedBy="ingredient")
     */
    protected $usedIn;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->usedIn = new ArrayCollection();
    }






    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Ingredient
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add recipe
     *
     * @param \AppBundle\Entity\IngredientsUsed $recipe
     *
     * @return Ingredient
     */
    public function addRecipe(\AppBundle\Entity\IngredientsUsed $recipe)
    {
        $this->usedIn[] = $recipe;

        return $this;
    }

    /**
     * Remove recipe
     *
     * @param \AppBundle\Entity\IngredientsUsed $recipe
     */
    public function removeRecipe(\AppBundle\Entity\IngredientsUsed $recipe)
    {
        $this->usedIn->removeElement($recipe);
    }

    /**
     * Get recipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsedIn()
    {
        return $this->usedIn;
    }

    /**
     * Add usedIn
     *
     * @param \AppBundle\Entity\IngredientsUsed $usedIn
     *
     * @return Ingredient
     */
    public function addUsedIn(\AppBundle\Entity\IngredientsUsed $usedIn)
    {
        $this->usedIn[] = $usedIn;

        return $this;
    }

    /**
     * Remove usedIn
     *
     * @param \AppBundle\Entity\IngredientsUsed $usedIn
     */
    public function removeUsedIn(\AppBundle\Entity\IngredientsUsed $usedIn)
    {
        $this->usedIn->removeElement($usedIn);
    }
}

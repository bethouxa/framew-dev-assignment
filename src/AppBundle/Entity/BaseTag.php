<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\MappedSuperClass
 */
abstract class BaseTag {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Recipe", mappedBy="tags")
     */
    protected $recipes;

    public function __construct($name)
    {
        $this->name = $name;

        $this->recipes = new ArrayCollection();
        $this->score = 0;
    }

    public function getRecipes() {return $this->recipes;}






    /**
     * Set name
     *
     * @param string $name
     *
     * @return BaseTag
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
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return BaseTag
     */
    public function addRecipe(\AppBundle\Entity\Recipe $recipe)
    {
        $this->recipes[] = $recipe;

        return $this;
    }

    /**
     * Remove recipe
     *
     * @param \AppBundle\Entity\Recipe $recipe
     */
    public function removeRecipe(\AppBundle\Entity\Recipe $recipe)
    {
        $this->recipes->removeElement($recipe);
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

    public function __toString()
    {
        return $this->name;
    }

}

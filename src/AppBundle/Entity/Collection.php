<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Collection
 *
 * @ORM\Table(name="collections")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CollectionRepository")
 */
class Collection
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="owner", referencedColumnName="id")
     */
    protected $owner;

    /**
     * @ORM\ManyToMany(targetEntity="Recipe", mappedBy="collections")
     */
    protected $recipes;


    /**
     * @ORM\Column(type="boolean")
     */
    protected $shared;

    public function __construct(User $owner)
    {
        $this->recipes = new ArrayCollection();
        $this->owner = $owner;
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
     * @return Collection
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
     * Set shared
     *
     * @param boolean $shared
     *
     * @return Collection
     */
    public function setShared($shared)
    {
        $this->shared = $shared;

        return $this;
    }

    /**
     * Get shared
     *
     * @return boolean
     */
    public function isShared()
    {
        return $this->shared;
    }

    /**
     * Set owner
     *
     * @param \AppBundle\Entity\User $owner
     *
     * @return Collection
     */
    public function setOwner(\AppBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \AppBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Get shared
     *
     * @return boolean
     */
    public function getShared()
    {
        return $this->shared;
    }

    /**
     * Add recipe
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return Collection
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
     * Get recipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipes()
    {
        return $this->recipes;
    }
}

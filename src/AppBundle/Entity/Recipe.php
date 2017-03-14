<?php
/**
 * Created by PhpStorm.
 * User: betho
 * Date: 05/03/2017
 * Time: 22:57
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipes")
 */
class Recipe {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", unique=TRUE)
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=TRUE)
     */
    protected $summary;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $public;
    /**
     * @ORM\Column(type="string", length=255, nullable=TRUE)
     */
    protected $author;
    /**
     * @ORM\Column(type="string", length=500, nullable=TRUE)
     */
    protected $photo;
    /**
     * @ORM\Column(type="time", name="creation")
     */
    protected $creationDate;
    /**
     * @ORM\Column(type="time", name="last_edit")
     */
    protected $lastEditDate;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rating;


    /**
     * One Recipe has many Steps.
     * @ORM\ManyToMany(targetEntity="Step")
     * @ORM\JoinTable(name="recipe_steps",
     *     joinColumns={@ORM\JoinColumn(name="recipe_id",referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="step_id", referencedColumnName="id", unique=true)}
     *     )
     */
    protected $steps;

    /**
     * Many recipes have many ingredients.
     * @ORM\ManyToMany(targetEntity="Ingredient", inversedBy="recipes")
     * @ORM\JoinTable(name="recipes_ingredients")
     */
    protected $ingredients;

    /**
     * Many recipes have many tags.
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="recipes")
     * @ORM\JoinTable(name="recipes_tags")
     */
    protected $tags;


    public function __construct()
    {
        $this->steps = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getTags() { return $this->tags; }
    public function getSteps() { return $this->steps; }
    public function getIngredients() { return $this->ingredients; }


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
     * Set title
     *
     * @param string $title
     *
     * @return Recipe
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set summary
     *
     * @param string $summary
     *
     * @return Recipe
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set public
     *
     * @param boolean $public
     *
     * @return Recipe
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Recipe
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Recipe
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set creationDate
     *
     * @param \datetype $creationDate
     *
     * @return Recipe
     */
    public function setCreationDate(\datetype $creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \datetype
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set lastEditDate
     *
     * @param \datetype $lastEditDate
     *
     * @return Recipe
     */
    public function setLastEditDate(\datetype $lastEditDate)
    {
        $this->lastEditDate = $lastEditDate;

        return $this;
    }

    /**
     * Get lastEditDate
     *
     * @return \datetype
     */
    public function getLastEditDate()
    {
        return $this->lastEditDate;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return Recipe
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Add step
     *
     * @param \AppBundle\Entity\Step $step
     *
     * @return Recipe
     */
    public function addStep(\AppBundle\Entity\Step $step)
    {
        $this->steps[] = $step;

        return $this;
    }

    /**
     * Remove step
     *
     * @param \AppBundle\Entity\Step $step
     */
    public function removeStep(\AppBundle\Entity\Step $step)
    {
        $this->steps->removeElement($step);
    }

    /**
     * Add ingredient
     *
     * @param \AppBundle\Entity\Ingredient $ingredient
     *
     * @return Recipe
     */
    public function addIngredient(\AppBundle\Entity\Ingredient $ingredient)
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * Remove ingredient
     *
     * @param \AppBundle\Entity\Ingredient $ingredient
     */
    public function removeIngredient(\AppBundle\Entity\Ingredient $ingredient)
    {
        $this->ingredients->removeElement($ingredient);
    }

    /**
     * Add tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return Recipe
     */
    public function addTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \AppBundle\Entity\Tag $tag
     */
    public function removeTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }
}

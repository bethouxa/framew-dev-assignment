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
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * @ORM\Entity(repositoryClass="RecipeRepository")
 * @ORM\Table(name="recipes")
 */
class Recipe
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $summary;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $public;
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="recipes")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $author;
    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    protected $photo;
    /**
     * @ORM\Column(type="datetime", nullable=true, name="creation")
     */
    protected $creationDate;
    /**
     * @ORM\Column(type="datetime", nullable=true, name="last_edit")
     */
    protected $lastEditDate;

    /**
     * @ORM\Column(name="content", type="text")
     */
    protected $steps;

    /**
     * Many recipes have many ingredients.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\IngredientsUsed", mappedBy="recipe")
     */
    protected $ingredients;

    /**
     * Many recipes have many tags.
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="recipes")
     * @ORM\JoinTable(
     *     name="recipes_tags",
     *     joinColumns={@ORM\JoinColumn(name="Recipe_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="Tag_id", referencedColumnName="id")}
     * )
     */
    protected $tags;

	/**
	 * Many recipes have many tags.
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PersonalTag", inversedBy="p_recipes")
	 * @ORM\JoinTable(
	 *     name="recipes_ptags",
	 *     joinColumns={@ORM\JoinColumn(name="Recipe_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="Tag_id", referencedColumnName="id")}
	 * )
	 */
	protected $personalTags;

    /**
     * @ORM\ManyToMany(targetEntity="Collection", inversedBy="recipes")
     * @ORM\JoinTable(name="recipes_collections")
     */
    protected $collections;


    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->collections = new ArrayCollection();
        $this->personalTags = new ArrayCollection();
        $this->setCreationDate(new \DateTime());
        $this->setLastEditDate(new \DateTime());
        $this->public = false;
    }

    public function __toString()
    {
        return $this->title;
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
     * Make the recipe public. _One way move._
     *
     * @return Recipe
     */
    public function setPublic(bool $public)
    {
    	if ($this->public == true)
    		throw new Exception("Cannot make a public recipe private."); // FIXME: handle this in form instead.
        $this->public = true;
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
     * @param \DateTime $creationDate
     *
     * @return Recipe
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set lastEditDate
     *
     * @param \DateTime $lastEditDate
     *
     * @return Recipe
     */
    public function setLastEditDate($lastEditDate)
    {
        $this->lastEditDate = $lastEditDate;

        return $this;
    }

    /**
     * Get lastEditDate
     *
     * @return \DateTime
     */
    public function getLastEditDate()
    {
        return $this->lastEditDate;
    }


    /**
     * Add ingredient
     *
     * @param \AppBundle\Entity\IngredientsUsed $ingredient
     *
     * @return Recipe
     */
    public function addIngredient(IngredientsUsed $ingredient)
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * Remove ingredient
     *
     * @param \AppBundle\Entity\IngredientsUsed $ingredient
     */
    public function removeIngredient(IngredientsUsed $ingredient)
    {
        $this->ingredients->removeElement($ingredient);
    }

    /**
     * Get ingredients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Add tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return Recipe
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \AppBundle\Entity\Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set author
     *
     * @param \AppBundle\Entity\User $author
     *
     * @return Recipe
     */
    public function setAuthor(User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }


    /**
     * Add collection
     *
     * @param \AppBundle\Entity\Collection $collection
     *
     * @return Recipe
     */
    public function addCollection(Collection $collection)
    {
        $this->collections[] = $collection;

        return $this;
    }

    /**
     * Remove collection
     *
     * @param \AppBundle\Entity\Collection $collection
     */
    public function removeCollection(Collection $collection)
    {
        $this->collections->removeElement($collection);
    }

    /**
     * Get collections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollections()
    {
        return $this->collections;
    }

    /**
     * Set steps
     *
     * @param string $steps
     *
     * @return Recipe
     */
    public function setSteps($steps)
    {
        $this->steps = $steps;

        return $this;
    }

    /**
     * Get steps
     *
     * @return string
     */
    public function getSteps()
    {
        return $this->steps;
    }

    public function getPersonalTags(User $u)
    {
    	$retval = [];
    	foreach ($this->personalTags as $personalTag)
    		if($personalTag->owner == $u)
    			$retval[] = $personalTag;
	    return $retval;
    }

    public function addPersonalTag(PersonalTag $tag)
    {
        $this->personalTags[] = $tag;
        return $this;
    }

    public function removePersonalTag(PersonalTag $tag)
    {
        $this->personalTags->removeElement($tag);
        return $this;
    }
}

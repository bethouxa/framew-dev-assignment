<?php
/**
 * Created by PhpStorm.
 * User: betho
 * Date: 10/04/2017
 * Time: 21:07
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PersonalTag
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 */
class PersonalTag extends BaseTag
{
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="personalTags")
     */
    protected $owner;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Recipe", mappedBy="personalTags")
     *
     */
    protected $p_recipes;

	public function __construct(String $name, User $owner)
	{
		parent::__construct($name);
		$this->owner = $owner;
		$this->p_recipes = new ArrayCollection();
	}

	/**
     * Set owner
     *
     * @param \AppBundle\Entity\User $owner
     *
     * @return PersonalTag
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
     * Add pRecipe
     *
     * @param \AppBundle\Entity\Recipe $pRecipe
     *
     * @return PersonalTag
     */
    public function addPRecipe(\AppBundle\Entity\Recipe $pRecipe)
    {
        $this->p_recipes[] = $pRecipe;

        return $this;
    }

    /**
     * Remove pRecipe
     *
     * @param \AppBundle\Entity\Recipe $pRecipe
     */
    public function removePRecipe(\AppBundle\Entity\Recipe $pRecipe)
    {
        $this->p_recipes->removeElement($pRecipe);
    }

    /**
     * Get pRecipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPRecipes()
    {
        return $this->p_recipes;
    }

    public function getRecipes()
    {
        return $this->getPRecipes();
    }

    public function addRecipe(\AppBundle\Entity\Recipe $recipe)
    {
        return $this->addPRecipe($recipe);
    }

    public function removeRecipe(\AppBundle\Entity\Recipe $recipe)
    {
        return $this->removePRecipe($recipe);
    }
}

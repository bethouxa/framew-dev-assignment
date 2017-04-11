<?php
/**
 * Created by PhpStorm.
 * User: betho
 * Date: 10/04/2017
 * Time: 21:07
 */

namespace AppBundle\Entity;

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
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="personalTags")
	 */
	protected $owner;


	public function __construct(String $name, User $owner)
	{
		parent::__construct($name);
		$this->setOwner($owner);
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
}

<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * OneToMany
     * @ORM\ManyToMany(targetEntity="PendingTag")
     * @ORM\JoinTable(name="users_tagsUp",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", unique=true)}
     *      )
     */
    protected $tagsUpvoted;

    /**
     * OneToMany
     * @ORM\ManyToMany(targetEntity="PendingTag")
     * @ORM\JoinTable(name="users_tagsDown",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", unique=true)}
     *      )
     */
    protected $tagsDownvoted;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->tagsVoted = new ArrayCollection();
    }

    /**
     * Convenience function for getUsername()
     */
    public function getName()
    {
        return parent::getUsername();
    }



    /**
     * Add tagsUpvoted
     *
     * @param \AppBundle\Entity\PendingTag $tagsUpvoted
     *
     * @return User
     */
    public function addTagsUpvoted(\AppBundle\Entity\PendingTag $tagsUpvoted)
    {
        $this->tagsUpvoted[] = $tagsUpvoted;

        return $this;
    }

    /**
     * Remove tagsUpvoted
     *
     * @param \AppBundle\Entity\PendingTag $tagsUpvoted
     */
    public function removeTagsUpvoted(\AppBundle\Entity\PendingTag $tagsUpvoted)
    {
        $this->tagsUpvoted->removeElement($tagsUpvoted);
    }

    /**
     * Get tagsUpvoted
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTagsUpvoted()
    {
        return $this->tagsUpvoted;
    }

    /**
     * Add tagsDownvoted
     *
     * @param \AppBundle\Entity\PendingTag $tagsDownvoted
     *
     * @return User
     */
    public function addTagsDownvoted(\AppBundle\Entity\PendingTag $tagsDownvoted)
    {
        $this->tagsDownvoted[] = $tagsDownvoted;

        return $this;
    }

    /**
     * Remove tagsDownvoted
     *
     * @param \AppBundle\Entity\PendingTag $tagsDownvoted
     */
    public function removeTagsDownvoted(\AppBundle\Entity\PendingTag $tagsDownvoted)
    {
        $this->tagsDownvoted->removeElement($tagsDownvoted);
    }

    /**
     * Get tagsDownvoted
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTagsDownvoted()
    {
        return $this->tagsDownvoted;
    }
}

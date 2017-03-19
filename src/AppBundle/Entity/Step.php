<?php
/**
 * Created by PhpStorm.
 * User: betho
 * Date: 06/03/2017
 * Time: 12:03
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="steps")
 */
class Step {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=true, name="step")
     */
    protected $step_num;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $content;







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
     * Set stepNum
     *
     * @param integer $stepNum
     *
     * @return Step
     */
    public function setStepNum($stepNum)
    {
        $this->step_num = $stepNum;

        return $this;
    }

    /**
     * Get stepNum
     *
     * @return integer
     */
    public function getStepNum()
    {
        return $this->step_num;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Step
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}

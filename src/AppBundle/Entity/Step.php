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
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", name="step")
     */
    protected $step_num;

    /**
     * @ORM\Column(type="string")
     */
    protected $content;






}

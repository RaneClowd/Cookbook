<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Ingredient
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="FoodItem")
     * @ORM\JoinColumn(name="fooditem_id", referencedColumnName="id")
     */
    private $fooditem;

    /**
     * @var string
     *
     * @ORM\Column(name="measure", type="string", length=255)
     */
    private $measure;
    
    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

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
     * Set measure
     *
     * @param string $measure
     *
     * @return Ingredient
     */
    public function setMeasure($measure)
    {
        $this->measure = $measure;

        return $this;
    }

    /**
     * Get measure
     *
     * @return string
     */
    public function getMeasure()
    {
        return $this->measure;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Ingredient
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set fooditem
     *
     * @param \AppBundle\Entity\FoodItem $fooditem
     *
     * @return Ingredient
     */
    public function setFooditem(\AppBundle\Entity\FoodItem $fooditem = null)
    {
        $this->fooditem = $fooditem;

        return $this;
    }

    /**
     * Get fooditem
     *
     * @return \AppBundle\Entity\FoodItem
     */
    public function getFooditem()
    {
        return $this->fooditem;
    }
}

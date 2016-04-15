<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\ViewEntity\Measure;

/**
 * @ORM\Entity
 */
class Ingredient
{
    public static function ingredient($amount, $unit, $food) {
        $instance = new Ingredient();
        $instance->setAmount($amount);
        $instance->setUnit($unit);
        $instance->setFoodItem(FoodItem::fooditem($food));
        
        return $instance;
    }
    
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
     * @ORM\Column(name="unit", type="string", length=255, nullable=true)
     */
    private $unit;
    
    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="decimal")
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255, nullable=true)
     */
    private $note;
    
    private $measure;

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
     * Set unit
     *
     * @param string $measure
     *
     * @return Ingredient
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
        
        return $this;
    }

    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
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
     * Set note
     *
     * @param string $note
     *
     * @return Ingredient
     */
    public function setNote($note)
    {
        $this->note = $note;
        
        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
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

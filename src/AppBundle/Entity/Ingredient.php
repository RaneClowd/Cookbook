<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\ViewEntity\Measure;

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
     * @ORM\Column(name="unit", type="string", length=255)
     */
    private $unit;
    
    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;
    
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
        $this->updateMeasure();

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
        $this->updateMeasure();

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
    
    private function updateMeasure()
    {
        if (empty($this->measure) && !empty($this->amount) && !empty($this->unit)) {
            $this->measure = Measure::measureTypeForUnit($this->unit);
        }
        
        if ( !empty($this->measure)) {
            $this->measure->setAmount($this->amount, $this->unit);
        }
    }
}

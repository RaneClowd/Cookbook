<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipeRepository")
 */
class Recipe
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\ManyToMany(targetEntity="Ingredient")
     * @ORM\JoinTable(name="recipes_ingredients",
     *      joinColumns={@ORM\JoinColumn(name="recipe_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="ingredient_id", referencedColumnName="id")}
     *      )
     */
    private $ingredients;
    
    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}


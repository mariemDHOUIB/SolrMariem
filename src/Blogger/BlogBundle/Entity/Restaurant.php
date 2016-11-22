<?php

namespace Blogger\BlogBundle\Entity;

/**
 * Restaurant
 */
class Restaurant
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $plats;

    /**
     * @var string
     */
    private $nomRestaurant;

    /**
     * @var string
     */
    private $ville;


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
     * Set plats
     *
     * @param string $plats
     *
     * @return Restaurant
     */
    public function setPlats($plats)
    {
        $this->plats = $plats;

        return $this;
    }

    /**
     * Get plats
     *
     * @return string
     */
    public function getPlats()
    {
        return $this->plats;
    }

    /**
     * Set nomRestaurant
     *
     * @param string $nomRestaurant
     *
     * @return Restaurant
     */
    public function setNomRestaurant($nomRestaurant)
    {
        $this->nomRestaurant = $nomRestaurant;

        return $this;
    }

    /**
     * Get nomRestaurant
     *
     * @return string
     */
    public function getNomRestaurant()
    {
        return $this->nomRestaurant;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Restaurant
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;

    }




}






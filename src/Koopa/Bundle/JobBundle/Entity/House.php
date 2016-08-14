<?php

namespace Koopa\Bundle\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * House
 *
 * @ORM\Table(name="house")
 * @ORM\Entity(repositoryClass="Koopa\Bundle\JobBundle\Repository\HouseRepository")
 */
class House
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
     * @var bool
     *
     * @ORM\Column(name="has_store", type="boolean")
     */
    private $hasStore;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_kitchen", type="boolean")
     */
    private $hasKitchen;

    /**
     * @var int
     *
     * @ORM\Column(name="rooms", type="integer")
     */
    private $rooms;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var bool
     *
     * @ORM\Column(name="for_sale", type="boolean")
     */
    private $forSale;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var Parcel
     *
     * @ORM\ManyToOne(targetEntity="Koopa\Bundle\JobBundle\Entity\Parcel", inversedBy="houses")
     */
    private $parcel;

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
     * Set hasStore
     *
     * @param boolean $hasStore
     *
     * @return House
     */
    public function setHasStore($hasStore)
    {
        $this->hasStore = $hasStore;

        return $this;
    }

    /**
     * Get hasStore
     *
     * @return boolean
     */
    public function getHasStore()
    {
        return $this->hasStore;
    }

    /**
     * Set hasKitchen
     *
     * @param boolean $hasKitchen
     *
     * @return House
     */
    public function setHasKitchen($hasKitchen)
    {
        $this->hasKitchen = $hasKitchen;

        return $this;
    }

    /**
     * Get hasKitchen
     *
     * @return boolean
     */
    public function getHasKitchen()
    {
        return $this->hasKitchen;
    }

    /**
     * Set rooms
     *
     * @param integer $rooms
     *
     * @return House
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * Get rooms
     *
     * @return integer
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return House
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set forSale
     *
     * @param boolean $forSale
     *
     * @return House
     */
    public function setForSale($forSale)
    {
        $this->forSale = $forSale;

        return $this;
    }

    /**
     * Get forSale
     *
     * @return boolean
     */
    public function getForSale()
    {
        return $this->forSale;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return House
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set parcel
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Parcel $parcel
     *
     * @return House
     */
    public function setParcel(\Koopa\Bundle\JobBundle\Entity\Parcel $parcel = null)
    {
        $this->parcel = $parcel;

        if (null !== $parcel) {
            $parcel->addHouse($this);
        }

        return $this;
    }

    /**
     * Get parcel
     *
     * @return \Koopa\Bundle\JobBundle\Entity\Parcel
     */
    public function getParcel()
    {
        return $this->parcel;
    }
}

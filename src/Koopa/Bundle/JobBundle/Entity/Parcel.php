<?php

namespace Koopa\Bundle\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Parcel
 *
 * @ORM\Table(name="app_parcel")
 * @ORM\Entity(repositoryClass="Koopa\Bundle\JobBundle\Repository\ParcelRepository")
 */
class Parcel
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
     * @var int
     *
     * @ORM\Column(name="house_number", type="integer")
     */
    private $houseNumber;

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
     * @var House[]
     *
     * @ORM\OneToMany(
     *     targetEntity="Koopa\Bundle\JobBundle\Entity\House",
     *     mappedBy="parcel",
     *     cascade={"persist"}
     * )
     */
    private $houses;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Koopa\Bundle\UserBundle\Entity\User", inversedBy="parcels")
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="commune", type="string", length=255)
     */
    private $commune;

    /**
     * @var string
     *
     * @ORM\Column(name="quarter", type="string", length=255)
     */
    private $quarter;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->houses = new ArrayCollection();
        $this->forSale = false;
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
     * Set houseNumber
     *
     * @param integer $houseNumber
     *
     * @return Parcel
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get houseNumber
     *
     * @return int
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * Set forSale
     *
     * @param boolean $forSale
     *
     * @return Parcel
     */
    public function setForSale($forSale)
    {
        $this->forSale = $forSale;

        return $this;
    }

    /**
     * Get forSale
     *
     * @return bool
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
     * @return Parcel
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
     * Add house
     *
     * @param \Koopa\Bundle\JobBundle\Entity\House $house
     *
     * @return Parcel
     */
    public function addHouse(\Koopa\Bundle\JobBundle\Entity\House $house)
    {
        $this->houses[] = $house;

        return $this;
    }

    /**
     * Remove house
     *
     * @param \Koopa\Bundle\JobBundle\Entity\House $house
     */
    public function removeHouse(\Koopa\Bundle\JobBundle\Entity\House $house)
    {
        $this->houses->removeElement($house);
    }

    /**
     * Get houses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHouses()
    {
        return $this->houses;
    }

    /**
     * Set author
     *
     * @param \Koopa\Bundle\UserBundle\Entity\User $author
     *
     * @return Parcel
     */
    public function setAuthor(\Koopa\Bundle\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;

        if (null !== $author) {
            $author->addParcel($this);
        }

        return $this;
    }

    /**
     * Get author
     *
     * @return \Koopa\Bundle\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set address
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Address $address
     *
     * @return Parcel
     */
    public function setAddress(\Koopa\Bundle\JobBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \Koopa\Bundle\JobBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Parcel
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Parcel
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set commune
     *
     * @param string $commune
     *
     * @return Parcel
     */
    public function setCommune($commune)
    {
        $this->commune = $commune;

        return $this;
    }

    /**
     * Get commune
     *
     * @return string
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * Set quarter
     *
     * @param string $quarter
     *
     * @return Parcel
     */
    public function setQuarter($quarter)
    {
        $this->quarter = $quarter;

        return $this;
    }

    /**
     * Get quarter
     *
     * @return string
     */
    public function getQuarter()
    {
        return $this->quarter;
    }

    public function convert()
    {
        $data = [];
        $data['houseNumber'] = $this->houseNumber;
        $data['forSale'] = $this->forSale;
        $data['description'] = $this->description;
        $data['city'] = $this->city;
        $data['street'] = $this->street;
        $data['commune'] = $this->commune;
        $data['quarter'] = $this->quarter;

        return $data;
    }

    public function __toString()
    {
        return sprintf(
            "Parcelle avec %s maisons, dans la ville de %s, commune %s/Q %s  avenue %s \n \n",
            $this->houseNumber,
            $this->city,
            $this->commune,
            $this->quarter,
            $this->street,
            $this->description
        );
    }

    public function url()
    {
        return 'p/'.$this->id;
    }
}

<?php

namespace Koopa\Bundle\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="Koopa\Bundle\JobBundle\Repository\AddressRepository")
 */
class Address
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Address
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
     * @return Address
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
     * @return Address
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
     * @return Address
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

    /**
     * Set parcel
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Parcel $parcel
     *
     * @return Address
     */
    public function setParcel(\Koopa\Bundle\JobBundle\Entity\Parcel $parcel = null)
    {
        $this->parcel = $parcel;

        if (null !== $parcel) {
            $parcel->setAddress($this);
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

<?php

namespace Koopa\Bundle\JobBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="job_categories")
 * @ORM\Entity(repositoryClass="Koopa\Bundle\JobBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=150)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", unique=true, length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @var Koopa\Bundle\JobBundle\Entity\SubCategory
     *
     * @ORM\OneToMany(
     * targetEntity="Koopa\Bundle\JobBundle\Entity\SubCategory",
     * mappedBy="category",
     * cascade={"persist"}
     * )
     */
    private $subCategories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subCategories = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return Category
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

    /**
     * Set slug
     *
     * @param string $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add subCategories
     *
     * @param \Koopa\Bundle\JobBundle\Entity\SubCategory $subCategories
     * @return Category
     */
    public function addSubCategory(\Koopa\Bundle\JobBundle\Entity\SubCategory $subCategories)
    {
        $this->subCategories[] = $subCategories;
        $subCategories->setCategory($this);

        return $this;
    }

    /**
     * Remove subCategories
     *
     * @param \Koopa\Bundle\JobBundle\Entity\SubCategory $subCategories
     */
    public function removeSubCategory(\Koopa\Bundle\JobBundle\Entity\SubCategory $subCategories)
    {
        $this->subCategories->removeElement($subCategories);
    }

    /**
     * Get subCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubCategories()
    {
        return $this->subCategories;
    }
}

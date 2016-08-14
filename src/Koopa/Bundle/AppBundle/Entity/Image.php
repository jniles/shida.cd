<?php

namespace Koopa\Bundle\AppBundle\Entity;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table(name="app_images")
 * @ORM\Entity(repositoryClass="Koopa\Bundle\AppBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
     * @ORM\Column(name="extension", type="string", length=10, nullable=true)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    private $file;

    private $tempFilename;



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
     * Set extension
     *
     * @param string $extension
     * @return Image
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set File
     *
     * @param UploadedFile $file
     * @return Image
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file)
    {
        $this->file = $file;

        if ($this->extension !== null) {
            $this->tempFilename = $this->extension;

            $this->extension = null;
            $this->alt = null;
        }

        return $this;
    }

    /**
     * Get File
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * get sources file
     */
    public function src()
    {
        return $this->getUploadDir() . '/' . $this->getId() . '.' . $this->extension;
    }

    /**
     * Get relative uploaded directory
     *
     * @return string
     */
    public function getUploadDir()
    {
        return 'img/upload';
    }

    /**
     * Get absolute uploaded directory
     *
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../../web/img/upload';
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if ($this->file === null) {
            return;
        }

        if ($this->tempFilename !== null) {
            $oldFile = $this->getUploadRootDir() . '/' . $this->id . '.' . $this->tempFilename;
            if(file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
        $this->file->move(
            $this->getUploadRootDir(),
            $this->id . '.' . $this->extension
        );
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if ($this->file === null) {
            return;
        }
        $this->extension = $this->file->guessExtension();
        $this->alt = $this->file->getClientOriginalName();
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        $this->tempFilename = $this->getUploadRootDir() . '/' . $this->id . '.' . $this->extension;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if(file_exists($this->tempFilename)) {
            unlink($this->tempFilename);
        }
    }
}

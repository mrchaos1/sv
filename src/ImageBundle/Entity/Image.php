<?php

namespace ImageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="ImageBundle\Repository\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="width", type="integer")
     */
    private $width;

    /**
     * @var int
     *
     * @ORM\Column(name="height", type="integer")
     */
    private $height;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime_added", type="datetime", nullable=true)
     */
    private $datetimeAdded;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime_modifed", type="datetime", nullable=true)
     */
    private $datetimeModifed;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=255)
     */
    private $fileName;

    /**
     * @var string
     *
     * @ORM\Column(name="file_extension", type="string", length=50, nullable=true)
     */
    private $fileExtension;

    /**
     * @var string
     *
     * @ORM\Column(name="public_dir", type="string", length=255)
     */
    private $publicDir;

    /**
     * @var string
     *
     * @ORM\Column(name="internal_dir", type="string", length=255)
     */
    private $internalDir;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_original", type="boolean", nullable=true)
     */
    private $isOriginal;

    /**
     * One Image has many thumbnains.
     * @ORM\OneToMany(targetEntity="Image", mappedBy="parent")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $thumbnails;

    /**
     * Many Thumbnails have one parent.
     * @ORM\ManyToOne(targetEntity="Image", inversedBy="thumbnails")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="sub_dir", type="string", length=255)
     */
    private $subDir;

    /**
     * @var string
     */
    private $publicSrc;

    /**
     * @var string
     * @ORM\Column(name="thumbnail_name", type="string", length=255, nullable=true)
     */
    private $thumbnailName;

    /**
    * @ORM\OneToOne(targetEntity="ImageProvider", mappedBy="image", cascade={"persist", "remove"}, orphanRemoval=true)
    */
    private $provider;



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
     * Set title
     *
     * @param string $title
     *
     * @return Image
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set width
     *
     * @param integer $width
     *
     * @return Image
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return Image
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set datetimeAdded
     *
     * @param \DateTime $datetimeAdded
     *
     * @return Image
     */
    public function setDatetimeAdded($datetimeAdded)
    {
        $this->datetimeAdded = $datetimeAdded;

        return $this;
    }

    /**
     * Get datetimeAdded
     *
     * @return \DateTime
     */
    public function getDatetimeAdded()
    {
        return $this->datetimeAdded;
    }

    /**
     * Set datetimeModifed
     *
     * @param \DateTime $datetimeModifed
     *
     * @return Image
     */
    public function setDatetimeModifed($datetimeModifed)
    {
        $this->datetimeModifed = $datetimeModifed;

        return $this;
    }

    /**
     * Get datetimeModifed
     *
     * @return \DateTime
     */
    public function getDatetimeModifed()
    {
        return $this->datetimeModifed;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Image
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set fileExtension
     *
     * @param string $fileExtension
     *
     * @return Image
     */
    public function setFileExtension($fileExtension)
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    /**
     * Get fileExtension
     *
     * @return string
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    /**
     * Set publicDir
     *
     * @param string $publicDir
     *
     * @return Image
     */
    public function setPublicDir($publicDir)
    {
        $this->publicDir = $publicDir;

        return $this;
    }

    /**
     * Get publicDir
     *
     * @return string
     */
    public function getPublicDir()
    {
        return $this->publicDir;
    }

    /**
     * Set internalDir
     *
     * @param string $internalDir
     *
     * @return Image
     */
    public function setInternalDir($internalDir)
    {
        $this->internalDir = $internalDir;

        return $this;
    }

    /**
     * Get internalDir
     *
     * @return string
     */
    public function getInternalDir()
    {
        return $this->internalDir;
    }

    /**
     * Set isOriginal
     *
     * @param boolean $isOriginal
     *
     * @return Image
     */
    public function setIsOriginal($isOriginal)
    {
        $this->isOriginal = $isOriginal;

        return $this;
    }

    /**
     * Get isOriginal
     *
     * @return bool
     */
    public function getIsOriginal()
    {
        return $this->isOriginal;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->thumbnails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add thumbnail
     *
     * @param \ImageBundle\Entity\Image $thumbnail
     *
     * @return Image
     */
    public function addThumbnail(\ImageBundle\Entity\Image $thumbnail)
    {
        $this->thumbnails[] = $thumbnail;

        return $this;
    }

    /**
     * Remove thumbnail
     *
     * @param \ImageBundle\Entity\Image $thumbnail
     */
    public function removeThumbnail(\ImageBundle\Entity\Image $thumbnail)
    {
        $this->thumbnails->removeElement($thumbnail);
    }

    /**
     * Get thumbnails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThumbnails()
    {
        return $this->thumbnails;
    }

    /**
     * Set parent
     *
     * @param \ImageBundle\Entity\Image $parent
     *
     * @return Image
     */
    public function setParent(\ImageBundle\Entity\Image $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \ImageBundle\Entity\Image
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set subDir
     *
     * @param string $subDir
     *
     * @return Image
     */
    public function setSubDir($subDir)
    {
        $this->subDir = $subDir;

        return $this;
    }

    /**
     * Get subDir
     *
     * @return string
     */
    public function getSubDir()
    {
        return $this->subDir;
    }


    /**
     * Set subDir
     *
     * @param string $publicSrc
     *
     * @return Image
     */
    public function setPublicSrc($publicSrc)
    {
        $this->publicSrc = $publicSrc;

        return $this;
    }

    /**
     * Get publicSrc
     *
     * @return string
     */
    public function getPublicSrc()
    {
        return '/' . (trim($this->publicDir, '/')) . '/' . (trim($this->subDir, '/')) . '/' . (trim($this->fileName, '/'));
    }






    /**
     * Set thumbnailName
     *
     * @param string $thumbnailName
     *
     * @return Image
     */
    public function setThumbnailName($thumbnailName)
    {
        $this->thumbnailName = $thumbnailName;

        return $this;
    }

    /**
     * Get thumbnailName
     *
     * @return string
     */
    public function getThumbnailName()
    {
        return $this->thumbnailName;
    }

    /**
     * Set provider
     *
     * @param \ImageBundle\Entity\ImageProvider $provider
     *
     * @return Image
     */
    public function setProvider(\ImageBundle\Entity\ImageProvider $provider = null)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return \ImageBundle\Entity\ImageProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Remove provider
     *
     * @return \ImageBundle\Entity\ImageProvider
     */
    public function removeProvider($provider)
    {
        $this->provider->remove($provider);
        $this->setProvider(null);
    }

}

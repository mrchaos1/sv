<?php

namespace HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use ImageBundle\Entity\ImageProvider;


/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="HotelBundle\Repository\PostRepository")
 */
class Post
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
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="short_text", type="text", nullable=true)
     */
    private $shortText;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", length=1000, nullable=true)
     */
    private $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_keywords", type="string", length=1000, nullable=true)
     */
    private $metaKeywords;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=true)
     */
    private $datetime;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_system", type="boolean", nullable=true)
     */
    private $isSystem;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_published", type="boolean", nullable=true)
     */
    private $isPublished;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_order", type="integer", nullable=true)
     */
    private $sortOrder;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="posts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    private $category;


   /**
    * @ORM\ManyToMany(targetEntity="ImageBundle\Entity\ImageProvider", mappedBy="posts", cascade={"persist"})
    */
    private $images;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime_modifed", type="datetime", nullable=true)
     */
    private $datetimeModifed;


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
     * @return Post
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
     * Set text
     *
     * @param string $text
     *
     * @return Post
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set shortText
     *
     * @param string $shortText
     *
     * @return Post
     */
    public function setShortText($shortText)
    {
        $this->shortText = $shortText;

        return $this;
    }

    /**
     * Get shortText
     *
     * @return string
     */
    public function getShortText()
    {
        return $this->shortText;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Post
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
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return Post
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return Post
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     *
     * @return Post
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return Post
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set modifed datetime
     *
     * @param \DateTime $datetime
     *
     * @return Post
     */
    public function setDatetimeModifed($datetimeModifed)
    {
        $this->datetimeModifed = $datetimeModifed;

        return $this;
    }

    /**
     * Get modifed datetime
     *
     * @return \DateTime
     */
    public function getDatetimeModifed()
    {
        return $this->datetimeModifed;
    }

    /**
     * Set isSystem
     *
     * @param boolean $isSystem
     *
     * @return Post
     */
    public function setIsSystem($isSystem)
    {
        $this->isSystem = $isSystem;

        return $this;
    }

    /**
     * Get isSystem
     *
     * @return bool
     */
    public function getIsSystem()
    {
        return $this->isSystem;
    }

    /**
     * Set sortOrder
     *
     * @param integer $sortOrder
     *
     * @return Post
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * Get sortOrder
     *
     * @return integer
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->category = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set isPublished
     *
     * @param boolean $isPublished
     *
     * @return Post
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * Get isPublished
     *
     * @return boolean
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * Add category
     *
     * @param \HotelBundle\Entity\Category $category
     *
     * @return Post
     */
    public function addCategory(\HotelBundle\Entity\Category $category)
    {
        $this->category[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \HotelBundle\Entity\Category $category
     */
    public function removeCategory(\HotelBundle\Entity\Category $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category
     *
     * @param \HotelBundle\Entity\Category $category
     *
     * @return Post
     */
    public function setCategory(\HotelBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set images
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }

    /**
     * Add image
     *
     * @param \ImageBundle\Entity\ImageProvider $image
     *
     * @return Post
     */
    public function addImage(\ImageBundle\Entity\ImageProvider $image)
    {
        $image->addPost($this);
    }

    /**
     * Remove image
     *
     * @param \ImageBundle\Entity\ImageProvider $image
     */
    public function removeImage(\ImageBundle\Entity\ImageProvider $image)
    {
        $image->removePost($this);
        $this->images->removeElement($image);
    }


}

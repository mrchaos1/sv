<?php

namespace HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
#use \Application\Sonata\MediaBundle\Entity\Media;
#use HotelBundle\Entity\RoomMedia;
use ImageBundle\Entity\ImageProvider;


/**
 * Room
 *
 * @ORM\Table(name="room")
 * @ORM\Entity(repositoryClass="HotelBundle\Repository\RoomRepository")
 */
class Room
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
     * @var int
     *
     * @ORM\Column(name="price_from", type="integer", nullable=true)
     */
    private $priceFrom;

    /**
     * @var int
     *
     * @ORM\Column(name="price_to", type="integer", nullable=true)
     */
    private $priceTo;

    /**
     * @var int
     *
     * @ORM\Column(name="floor", type="integer", nullable=true)
     */
    private $floor;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_order", type="integer", nullable=true)
     */
    private $sortOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="short_text", type="text", nullable=true)
     */
    private $shortText;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_published", type="boolean", nullable=true)
     */
    private $isPublished;

    /**
     * @var int
     *
     * @ORM\Column(name="area_size", type="integer", nullable=true)
     */
    private $areaSize;

    /**
     * @var int
     *
     * @ORM\Column(name="persons_number", type="integer", nullable=true)
     */
    private $personsNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=500, nullable=true)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_keywords", type="string", length=1000, nullable=true)
     */
    private $metaKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", length=2000, nullable=true)
     */
    private $metaDescription;

   /**
    * @ORM\ManyToMany(targetEntity="ImageBundle\Entity\ImageProvider", mappedBy="rooms", cascade={"persist"})
    */
    private $images;

    /**
     * @var string
     *
     * @ORM\Column(name="includes", type="string", length=255, nullable=true)
     */
    private $includes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime_modifed", type="datetime", nullable=true)
     */
    private $datetimeModifed;

    /**
    * @ORM\OneToMany(targetEntity="Feedback", mappedBy="room")
    */
    private $feedbacks;

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
     * @return Room
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
     * @return Room
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
     * Set priceFrom
     *
     * @param integer $priceFrom
     *
     * @return Room
     */
    public function setPriceFrom($priceFrom)
    {
        $this->priceFrom = $priceFrom;

        return $this;
    }

    /**
     * Get priceFrom
     *
     * @return int
     */
    public function getPriceFrom()
    {
        return $this->priceFrom;
    }

    /**
     * Set priceTo
     *
     * @param integer $priceTo
     *
     * @return Room
     */
    public function setPriceTo($priceTo)
    {
        $this->priceTo = $priceTo;

        return $this;
    }

    /**
     * Get priceTo
     *
     * @return int
     */
    public function getPriceTo()
    {
        return $this->priceTo;
    }

    /**
     * Set floor
     *
     * @param integer $floor
     *
     * @return Room
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * Get floor
     *
     * @return int
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Set sortOrder
     *
     * @param integer $sortOrder
     *
     * @return Room
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * Get sortOrder
     *
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * Set shortText
     *
     * @param string $shortText
     *
     * @return Room
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
     * Set isPublished
     *
     * @param boolean $isPublished
     *
     * @return Room
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * Get isPublished
     *
     * @return bool
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * Set areaSize
     *
     * @param integer $areaSize
     *
     * @return Room
     */
    public function setAreaSize($areaSize)
    {
        $this->areaSize = $areaSize;

        return $this;
    }

    /**
     * Get areaSize
     *
     * @return int
     */
    public function getAreaSize()
    {
        return $this->areaSize;
    }

    /**
     * Set personsNumber
     *
     * @param integer $personsNumber
     *
     * @return Room
     */
    public function setPersonsNumber($personsNumber)
    {
        $this->personsNumber = $personsNumber;

        return $this;
    }

    /**
     * Get personsNumber
     *
     * @return int
     */
    public function getPersonsNumber()
    {
        return $this->personsNumber;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return Room
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
     * Set metaKeywords
     *
     * @param string $metaKeywords
     *
     * @return Room
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
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return Room
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
     * @return Room
     */
    public function addImage(\ImageBundle\Entity\ImageProvider $image)
    {

        $image->addRoom($this);
      #  $this->images->addRoom($image);
    }

    /**
     * Remove image
     *
     * @param \ImageBundle\Entity\ImageProvider $image
     */
    public function removeImage(\ImageBundle\Entity\ImageProvider $image)
    {
        $image->removeRoom($this);
        $this->images->removeElement($image);
    }

    /**
     * Get includes
     *
     * @return string
     */
    public function getIncludes()
    {
        return $this->includes;
    }

    /**
     * Set includes
     *
     * @param string $includes
     *
     * @return Room
     */
    public function setIncludes($includes)
    {
        $this->includes = $includes;

        return $this;
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
     * Add feedback
     *
     * @param \HotelBundle\Entity\Feedback $feedback
     *
     * @return Room
     */
    public function addFeedback(\HotelBundle\Entity\Feedback $feedback)
    {
        $this->feedbacks[] = $feedback;

        return $this;
    }

    /**
     * Remove feedback
     *
     * @param \HotelBundle\Entity\Feedback $feedback
     */
    public function removeFeedback(\HotelBundle\Entity\Feedback $feedback)
    {
        $this->feedbacks->removeElement($feedback);
    }

    /**
     * Get feedbacks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFeedbacks()
    {
        return $this->feedbacks;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->feedbacks = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

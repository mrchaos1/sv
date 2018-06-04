<?php

namespace HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Setting
 *
 * @ORM\Table(name="setting")
 * @ORM\Entity(repositoryClass="HotelBundle\Repository\SettingRepository")
 */
class Setting
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
     * @ORM\Column(name="meta_title", type="string", length=500, nullable=true)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", length=2000, nullable=true)
     */
    private $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_keywords", type="string", length=2000, nullable=true)
     */
    private $metaKeywords;

    /**
     * @var array
     *
     * @ORM\Column(name="room_promotions", type="array", nullable=true)
     */
    private $roomPromotions;


    /**
     * @var string
     *
     * @ORM\Column(name="admin_email", type="string", length=255, nullable=true)
     */
    private $adminEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var integer
     *
     * @ORM\Column(name="discount_monday", type="integer", nullable=true)
     */
    private $discountMonday;


    /**
     * @var integer
     *
     * @ORM\Column(name="discount_tuesday", type="integer", nullable=true)
     */
    private $discountTuesday;


    /**
     * @var integer
     *
     * @ORM\Column(name="discount_wednesday", type="integer", nullable=true)
     */
    private $discountWednesday;


    /**
     * @var integer
     *
     * @ORM\Column(name="discount_thursday", type="integer", nullable=true)
     */
    private $discountThursday;


    /**
     * @var integer
     *
     * @ORM\Column(name="discount_friday", type="integer", nullable=true)
     */
    private $discountFriday;


    /**
     * @var integer
     *
     * @ORM\Column(name="discount_saturday", type="integer", nullable=true)
     */
    private $discountSaturday;


    /**
     * @var integer
     *
     * @ORM\Column(name="discount_sunday", type="integer", nullable=true)
     */
    private $discountSunday;


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
     * @return Setting
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
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return Setting
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
     * @return Setting
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
     * @return Setting
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
     * Set roomPromotions
     *
     * @param array $roomPromotions
     *
     * @return Setting
     */
    public function setRoomPromotions($roomPromotions)
    {
        $this->roomPromotions = $roomPromotions;

        return $this;
    }

    /**
     * Get roomPromotions
     *
     * @return array
     */
    public function getRoomPromotions()
    {
        return $this->roomPromotions;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Setting
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
     * Set admin email
     *
     * @param string $adminEmail
     *
     * @return Setting
     */
    public function setAdminEmail($adminEmail)
    {
        $this->adminEmail = $adminEmail;

        return $this;
    }

    /**
     * Get admin email
     *
     * @return string
     */
    public function getAdminEmail()
    {
        return $this->adminEmail;
    }



    /**
     * Set discountMonday
     *
     * @param integer $discountMonday
     *
     * @return Setting
     */
    public function setDiscountMonday($discountMonday)
    {
        $this->discountMonday = $discountMonday;

        return $this;
    }

    /**
     * Get discountMonday
     *
     * @return integer
     */
    public function getDiscountMonday()
    {
        return $this->discountMonday;
    }

    /**
     * Set discountTuesday
     *
     * @param integer $discountTuesday
     *
     * @return Setting
     */
    public function setDiscountTuesday($discountTuesday)
    {
        $this->discountTuesday = $discountTuesday;

        return $this;
    }

    /**
     * Get discountTuesday
     *
     * @return integer
     */
    public function getDiscountTuesday()
    {
        return $this->discountTuesday;
    }

    /**
     * Set discountWednesday
     *
     * @param integer $discountWednesday
     *
     * @return Setting
     */
    public function setDiscountWednesday($discountWednesday)
    {
        $this->discountWednesday = $discountWednesday;

        return $this;
    }

    /**
     * Get discountWednesday
     *
     * @return integer
     */
    public function getDiscountWednesday()
    {
        return $this->discountWednesday;
    }

    /**
     * Set discountThursday
     *
     * @param integer $discountThursday
     *
     * @return Setting
     */
    public function setDiscountThursday($discountThursday)
    {
        $this->discountThursday = $discountThursday;

        return $this;
    }

    /**
     * Get discountThursday
     *
     * @return integer
     */
    public function getDiscountThursday()
    {
        return $this->discountThursday;
    }

    /**
     * Set discountFriday
     *
     * @param integer $discountFriday
     *
     * @return Setting
     */
    public function setDiscountFriday($discountFriday)
    {
        $this->discountFriday = $discountFriday;

        return $this;
    }

    /**
     * Get discountFriday
     *
     * @return integer
     */
    public function getDiscountFriday()
    {
        return $this->discountFriday;
    }

    /**
     * Set discountSaturday
     *
     * @param integer $discountSaturday
     *
     * @return Setting
     */
    public function setDiscountSaturday($discountSaturday)
    {
        $this->discountSaturday = $discountSaturday;

        return $this;
    }

    /**
     * Get discountSaturday
     *
     * @return integer
     */
    public function getDiscountSaturday()
    {
        return $this->discountSaturday;
    }

    /**
     * Set discountSunday
     *
     * @param integer $discountSunday
     *
     * @return Setting
     */
    public function setDiscountSunday($discountSunday)
    {
        $this->discountSunday = $discountSunday;

        return $this;
    }

    /**
     * Get discountSunday
     *
     * @return integer
     */
    public function getDiscountSunday()
    {
        return $this->discountSunday;
    }

    /**
     * Get today discount
     *
     * @return integer
     */
    public function getDiscountToday()
    {
        $day = date('w');

        if($day == 1)
        {
            return $this->discountMonday;
        }
        else if($day == 2)
        {
            return $this->discountTuesday;
        }
        else if($day == 3)
        {
            return $this->discountWednesday;
        }
        else if($day == 4)
        {
            return $this->discountThursday;
        }
        else if($day == 5)
        {
            return $this->discountFriday;
        }
        else if($day == 6)
        {
            return $this->discountSaturday;
        }
        else if($day == 7)
        {
            return $this->discountSunday;
        }
    }
}

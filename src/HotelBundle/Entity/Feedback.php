<?php

namespace HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feedback
 *
 * @ORM\Table(name="feedback")
 * @ORM\Entity(repositoryClass="HotelBundle\Repository\FeedbackRepository")
 */
class Feedback
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_readed", type="boolean", nullable=true)
     */
    private $isReaded;

    /**
     * @var string
     *
     * @ORM\Column(name="date_come", type="string", length=255, nullable=true)
     */
    private $dateCome;

    /**
     * @var string
     *
     * @ORM\Column(name="date_left", type="string", length=255, nullable=true)
     */
    private $dateLeft;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=255, nullable=true)
     */
    private $ipAddress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=true)
     */
    private $datetime;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_reservation", type="boolean", nullable=true)
     */
    private $isReservation;

    /**
     * @var string
     *
     * @ORM\Column(name="form_name", type="string", length=255, nullable=true)
     */
    private $formName;

    /**
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="feedbacks")
     * @ORM\JoinColumn(name="room_id", referencedColumnName="id", nullable=true)
     */
    private $room;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;




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
     * Set name
     *
     * @param string $name
     *
     * @return Feedback
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
     * Set email
     *
     * @param string $email
     *
     * @return Feedback
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Feedback
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set dateCome
     *
     * @param string $dateCome
     *
     * @return Feedback
     */
    public function setDateCome($dateCome)
    {
        $this->dateCome = $dateCome;

        return $this;
    }

    /**
     * Get dateCome
     *
     * @return string
     */
    public function getDateCome()
    {
        return $this->dateCome;
    }

    /**
     * Set dateLeft
     *
     * @param string $dateLeft
     *
     * @return Feedback
     */
    public function setDateLeft($dateLeft)
    {
        $this->dateLeft = $dateLeft;

        return $this;
    }

    /**
     * Get dateLeft
     *
     * @return string
     */
    public function getDateLeft()
    {
        return $this->dateLeft;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return Feedback
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return Feedback
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
     * Set isReservation
     *
     * @param boolean $isReservation
     *
     * @return Feedback
     */
    public function setIsReservation($isReservation)
    {
        $this->isReservation = $isReservation;

        return $this;
    }

    /**
     * Get isReservation
     *
     * @return bool
     */
    public function getIsReservation()
    {
        return $this->isReservation;
    }

    /**
     * Set formName
     *
     * @param string $formName
     *
     * @return Feedback
     */
    public function setFormName($formName)
    {
        $this->formName = $formName;

        return $this;
    }

    /**
     * Get formName
     *
     * @return string
     */
    public function getFormName()
    {
        return $this->formName;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->room = new \Doctrine\Common\Collections\ArrayCollection();
    }



    /**
     * Set room
     *
     * @param \HotelBundle\Entity\Room $room
     *
     * @return Feedback
     */
    public function setRoom(\HotelBundle\Entity\Room $room = null)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return \HotelBundle\Entity\Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Room
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }


    /**
     * Set isReaded
     *
     * @param boolean $isReaded
     *
     * @return Feedback
     */
    public function setIsReaded($isReaded)
    {
        $this->isReaded = $isReaded;

        return $this;
    }

    /**
     * Get isReaded
     *
     * @return boolean
     */
    public function getIsReaded()
    {
        return $this->isReaded;
    }
}

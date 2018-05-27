<?php

namespace ImageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use RoomBundle\Entity\Room;


/**
 * ImageProvider
 *
 * @ORM\Table(name="image_provider")
 * @ORM\Entity(repositoryClass="ImageBundle\Repository\ImageProviderRepository")
 */
class ImageProvider
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
     * @ORM\OneToOne(targetEntity="Image", inversedBy="provider")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    private $image;

    /**
   * Many Users have Many Groups.
   * @ORM\ManyToMany(targetEntity="HotelBundle\Entity\Room", inversedBy="images", cascade={"persist"})
   * @ORM\JoinTable(name="rooms_images")
   */
    private $rooms;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255, nullable=true)
     */
    private $note;

    /**
     * @var int
     *
     * @ORM\Column(name="room_sort_order", type="integer", nullable=true)
     */
    private $roomSortOrder;



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
     * Set image
     *
     * @param \ImageBundle\Entity\Image $image
     *
     * @return ImageProvider
     */
    public function setImage(\ImageBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \ImageBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rooms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get rooms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Add room
     *
     * @param \HotelBundle\Entity\Room $room
     *
     * @return ImageProvider
     */
    public function addRoom(\HotelBundle\Entity\Room $room)
    {
        if (!$this->rooms->contains($room))
        {
            $this->rooms->add($room);
        }
    }

    /**
     * Remove room
     *
     * @param \HotelBundle\Entity\Room $room
     */
    public function removeRoom(\HotelBundle\Entity\Room $room)
    {
        $this->rooms->removeElement($room);
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return ImageProvider
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set room sort order
     *
     * @param int $roomSortOrder
     *
     * @return ImageProvider
     */
    public function setRoomSortOrder($roomSortOrder)
    {
        $this->roomSortOrder = $roomSortOrder;

        return $this;
    }

    /**
     * Get room sort order
     *
     * @return int
     */
    public function getRoomSortOrder()
    {
        return $this->roomSortOrder;
    }
}

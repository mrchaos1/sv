<?php

namespace ImageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use RoomBundle\Entity\Room;

use RoomBundle\Entity\Post;


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
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255, nullable=true)
     */
    private $note;

    /**
   * @ORM\ManyToMany(targetEntity="HotelBundle\Entity\Room", inversedBy="images", cascade={"persist"})
   * @ORM\JoinTable(name="rooms_images")
   */
    private $rooms;

    /**
     * @var int
     *
     * @ORM\Column(name="room_sort_order", type="integer", nullable=true)
     */
    private $roomSortOrder;

    /**
   * @ORM\ManyToMany(targetEntity="HotelBundle\Entity\Post", inversedBy="images", cascade={"persist"})
   * @ORM\JoinTable(name="posts_images")
   */
    private $posts;

    /**
     * @var int
     *
     * @ORM\Column(name="post_sort_order", type="integer", nullable=true)
     */
    private $postSortOrder;



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


    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Add post
     *
     * @param \HotelBundle\Entity\Post $post
     *
     * @return ImageProvider
     */
    public function addPost(\HotelBundle\Entity\Post $post)
    {
        if (!$this->posts->contains($post))
        {
            $this->posts->add($post);
        }
    }

    /**
     * Remove post
     *
     * @param \HotelBundle\Entity\Post $post
     */
    public function removePost(\HotelBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Set post sort order
     *
     * @param int $postSortOrder
     *
     * @return ImageProvider
     */
    public function setPostSortOrder($postSortOrder)
    {
        $this->postSortOrder = $postSortOrder;

        return $this;
    }

    /**
     * Get post sort order
     *
     * @return int
     */
    public function getPostSortOrder()
    {
        return $this->postSortOrder;
    }
}

<?php

namespace HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HotelBundle\Entity\Room;
use HotelBundle\Entity\Feedback;
use ImageBundle\Entity\Image;
use ImageBundle\Entity\ImageProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\RedirectResponse;


class HotelController extends Controller
{
    public function indexAction(Request $request)
    {
        $rooms  = $this->getRooms();
        $em     = $this->getDoctrine()->getManager();
        $images = $em->getRepository(Image::class)
          ->createQueryBuilder('i')
          ->addSelect('p')
          ->join('i.provider', 'p')
          ->join('p.rooms', 'r')
          ->setMaxResults(10)
          ->getQuery()
          ->getResult();


        return $this->render('@Hotel/Default/index.html.twig', [
          'rooms'     => $rooms,
          'images'    => $images,
        ]);
    }

    public function callBackAction(Request $request)
    {

    }

    public function bookRoomAction(Request $request)
    {
        $bookForm = $this->getBookRoomForm();
        $bookForm->handleRequest($request);

        if($bookForm->isSubmitted() && $bookForm->isValid())
        {
            $data = $bookForm->getData();
            $feedback = new Feedback;
            $feedback->setName($data['name']);
            $feedback->setEmail($data['email']);
            $feedback->setPhone($data['phone']);
            $feedback->setDateCome($data['dateCome']);
            $feedback->setDateLeft($data['dateLeft']);
            $feedback->setIpAddress($_SERVER['REMOTE_ADDR']);
            $feedback->setIsReservation(true);
            $feedback->setRoom($data['rooms']);
            $feedback->setComment($data['comment']);
            $feedback->setDatetime(new \DateTime);

            $em = $this->getDoctrine()->getManager();
            $em->persist($feedback);
            $em->flush();
            $this->addFlash('notice', 'Ваше сообщение отправлено!');

            return $this->redirectToRoute('hotel_homepage');
        }
    }

    protected function getBookRoomForm($rooms = false)
    {
        if(!$rooms)
        {
            $rooms = $this->getRooms();
        }

        $bookForm = $this->createFormBuilder()
          ->add('dateCome', TextType::class, [ 'required' => false  ])
          ->add('dateLeft', TextType::class, [ 'required' => false  ])
          ->add('name', TextType::class, [ 'required' => false  ])
          ->add('phone', TextType::class, [ 'required' => false  ])
          ->add('email', EmailType::class, [ 'required' => false  ])
          ->add('comment', TextareaType::class, [ 'required' => false  ])
          ->add('rooms', ChoiceType::class,
          [
              'required' => false,
              'choices' => $rooms,
              'placeholder' => 'Выберите номер',
              'choice_label' => function($room, $key, $index) { return $room->getTitle(); },
          ])
          ->setAction($this->generateUrl('hotel_room_book'))
          ->add('submit', SubmitType::class, ['label' => 'Отправить'])
          ->getForm();
        return $bookForm;
    }

    public function bookRoomModalRender($rooms)
    {
        $bookForm = $this->getBookRoomForm($rooms);

        return $this->render('@Hotel/Default/bookRoomModal.html.twig', ['bookForm' => $bookForm->createView() ]);
    }


    public function callBackModalRender(Request $request)
    {
        $form = $this->createFormBuilder()
          ->add('name', TextType::class, ['label' => 'Имя', 'required' => false  ])
          ->add('phone', TextType::class, ['label' => 'Телефон', 'required' => false  ])
          ->add('comment', TextareaType::class, ['label' => 'Комментарий' ])
        #  ->add('redirect', HiddenType::class, ['data' => $this->generateUrl('hotel_callback') ])
          ->add('submit', SubmitType::class, ['label' => 'Отправить'])
          ->setAction($this->generateUrl('hotel_callback'))
          ->getForm();



        return $this->render('@Hotel/Default/callBackModal.html.twig', [ 'form' => $form->createView() ]);
    }

    public function contactsAction(Request $request)
    {
        $form = $this->createFormBuilder()
          ->add('name', TextType::class, ['label' => 'Имя', 'required' => false  ])
          ->add('email', EmailType::class, ['label' => 'E-Mail*' ])
          ->add('phone', TextType::class, ['label' => 'Телефон', 'required' => false  ])
          ->add('comment', TextareaType::class, ['label' => 'Ваш вопрос*' ])
          ->add('submit', SubmitType::class, array('label' => 'Отправить'))

          ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $message = (new \Swift_Message('Hello Email'))
              ->setFrom('info@cl23681.tmweb.ru')
              ->setTo('mrchaos001@yandex.ru')
              ->setBody($this->renderView('@Hotel/Default/contacts.html.twig', [ 'form' => $form->createView() ]), 'text/html');

            $result = $this->get('mailer')->send($message);
            die;
        }

        return $this->render('@Hotel/Default/contacts.html.twig', [ 'form' => $form->createView() ]);
    }


    protected function getRooms($limit = false)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(Room::class)
          ->createQueryBuilder('r')
          ->addSelect('p')
          ->addSelect('i')
          ->leftJoin('r.images', 'p', 'WITH', 'p.roomSortOrder=0')
          ->leftJoin('p.image', 'i')
          ->leftJoin('i.thumbnails', 'th');
        #  ->groupBy('r.id');

        $limit > 0 ? $qb->setMaxResults($limit) : null;
        $rooms  =  $qb->getQuery()->getResult();


        foreach ($rooms as $room)
        {
            $iterator = $room->getImages()->getIterator();
            $iterator->uasort(function ($a, $b)
            {
                return ($a->getRoomSortOrder() < $b->getRoomSortOrder()) ? -1 : 1;
            });
            $collection = new ArrayCollection(iterator_to_array($iterator));
            $room->setImages($collection);
        }
        return $rooms;

    }
    public function roomsAction(Request $request)
    {
        return $this->render('@Hotel/Default/rooms.html.twig', [ 'rooms' => $this->getRooms() ]);
    }

    public function roomAction(Request $request, $roomId)
    {
        $em     = $this->getDoctrine()->getManager();
        $rooms  = $em->getRepository(Room::class)
          ->createQueryBuilder('r')
          ->addSelect('p')
          ->addSelect('i')
          ->addSelect('th')

          ->leftJoin('r.images', 'p')
          ->leftJoin('p.image', 'i')
          ->leftJoin('i.thumbnails', 'th')

          ->andWhere('r.id = :roomId')
          ->setParameter('roomId', $roomId)
          ->getQuery()
          ->getResult();

        if($rooms)
        {
            $room = $rooms[0];
            return $this->render('@Hotel/Default/room.html.twig', ['room' => $room]);
        }
        else
        {

        }

    }

    public function galleryAction(Request $request)
    {
        $em       = $this->getDoctrine()->getManager();
        $images   = $em->getRepository(Image::class)
          ->createQueryBuilder('i')
          ->addSelect('p')
          ->addSelect('th')
          ->addSelect('r')

          ->join('i.provider', 'p')
          ->join('p.rooms', 'r')
          ->leftJoin('i.thumbnails', 'th')
          ->getQuery()
          ->getResult();

        return $this->render('@Hotel/Default/gallery.html.twig', ['images' => $images]);

    }

    public function postAction(Request $request, $postSlug)
    {
        return $this->render('@Hotel/Default/post.html.twig');

    }





}

<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HotelBundle\Entity\Room;
use HotelBundle\Entity\Post;
use ImageBundle\Entity\Image;
use ImageBundle\Entity\ImageProvider;
use HotelBundle\Entity\Feedback;
use ImageBundle\Form\ImageProviderType;
use ImageBundle\Repository\ImageProviderRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AdminBundle\Form\Object\FileObject;
use Doctrine\Common\Collections\ArrayCollection;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;


class AdminController extends Controller
{
    protected $session;
    protected $login = false;

    public function __construct()
    {
        $this->session  = new Session();
        $this->login    = $this->session->get('login');
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('count(room.id)');
        $qb->from('HotelBundle:Room', 'room');
        $roomsCount = $qb->getQuery()->getSingleScalarResult();

        $rooms  =
          $em->getRepository(Room::class)
          ->createQueryBuilder('r')
          ->orderBy('r.datetimeModifed', 'DESC')
          ->getQuery()
          ->setMaxResults(3)
          ->getResult();


        $qb->select('count(image.id)');
        $qb->from('ImageBundle:Image', 'image');
        $qb->where('image.isOriginal=1');
        $imagesCount = $qb->getQuery()->getSingleScalarResult();

        $images  =
          $em->getRepository(Image::class)
          ->createQueryBuilder('i')
          ->join('i.provider', 'p')
          ->orderBy('i.id', 'DESC')
          ->getQuery()
          ->setMaxResults(3)
          ->getResult();


        $feedbacks  =
            $em->getRepository(Feedback::class)
            ->createQueryBuilder('f')
            ->orderBy('f.id', 'DESC')
            ->where('f.isReaded IS NULL OR f.isReaded = 0')
            ->getQuery()
            ->setMaxResults(500)
            ->getResult();

        $qb->select('distinct count(distinct feedback.id)');
        $qb->from('HotelBundle:Feedback', 'feedback');
        $qb->where('feedback.isReaded IS null OR feedback.isReaded = 0');
        $feedbacksCount = $qb->getQuery()->getSingleScalarResult();

        $qb = $em->createQueryBuilder();
        $qb->select('count(post.id)');
        $qb->from('HotelBundle:Post', 'post');
        $postsCount = $qb->getQuery()->getSingleScalarResult();

        $posts  =
          $em->getRepository(Post::class)
          ->createQueryBuilder('p')
          ->orderBy('p.datetimeModifed', 'DESC')
          ->getQuery()
          ->setMaxResults(10)
          ->getResult();

        return $this->render('@Admin/index.html.twig',
        [
          'roomsCount'      => $roomsCount,
          'rooms'           => $rooms,
          'imagesCount'     => $imagesCount,
          'images'          => $images,
          'feedbacks'       => $feedbacks,
          'feedbacksCount'  => $feedbacksCount,
          'postsCount'      => $postsCount,
          'posts'           => $posts,

        ]);
    }


    public function feedbackAction(Request $request, $feedbackId)
    {
        $em = $this->getDoctrine()->getManager();

        if($feedback = $em->getRepository(Feedback::class)->findOneBy(['id' => $feedbackId]))
        {
            $qb   = $em->createQueryBuilder();
            $q    = $qb->update('HotelBundle:Feedback', 'f')
              ->set('f.isReaded', '1')
              ->where('f.id = :id')
              ->setParameter(':id', $feedback->getId())
              ->getQuery()
              ->execute();

            return $this->render('@Admin/feedbackView.html.twig', ['feedback' => $feedback ]);
        }
    }


    public function feedbacksAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $feedbacksQuery  =
          $em->getRepository(Feedback::class)
          ->createQueryBuilder('f')
          ->orderBy('f.id', 'DESC')
          ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $feedbacksQuery, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            100
        );

        $qb   = $em->createQueryBuilder();
        $q    = $qb->update('HotelBundle:Feedback', 'f')
          ->set('f.isReaded', '1')
          ->getQuery()
          ->execute();

        return $this->render('@Admin/feedbacks.html.twig', [ 'pagination' => $pagination, 'feedbacks' => $pagination->getItems() ]);

    }


    public function loginAction(Request $request)
    {
        $form = $this->createFormBuilder()
          ->add('login', TextType::class, ['label' => 'Login', 'required' => false  ])
          ->add('password', TextType::class, ['label' => 'Password' ])
          ->add('submit', SubmitType::class, array('label' => 'Login'))
          ->getForm();

          $form->handleRequest($request);

          if($form->isSubmitted() && $form->isValid())
          {
              sleep(1);
              $login      = 'admin';
              $password   = 'pass';

              if($form->getData()['password'] == $password && $form->getData()['login'] == $login)
              {
                  $this->session->set('login', true);
                  return $this->redirectToRoute('admin_index');
              }
              else
              {
                  $this->addFlash("error", "Login or password incorrect");
              }
          }

        return $this->render('@Admin/login.html.twig', [ 'form' => $form->createView() ]);
    }

    public function imagesModalAction(Request $request)
    {
          $em             = $this->getDoctrine()->getManager();
          $providersIds   = $request->query->get('providersIds');
          $roomId         = $request->query->get('roomId');
          $type           = $request->query->get('type');

          $qb = $em->getRepository(ImageProvider::class)->createQueryBuilder('p');
          $qb->addSelect('i');
          $qb->addSelect('th');
          $qb->join('p.image', 'i');
          $qb->leftJoin('i.thumbnails', 'th');
          $qb->andWhere('i.isOriginal=1');

          $qb->addSelect('r');

          $qb->leftJoin('p.rooms', 'r');
          $qb->andWhere('r.id is NULL');

          $qb->leftJoin('p.posts', 'post');
          $qb->andWhere('post.id is NULL');

          if(!empty($providersIds))
          {
              $qb->andWhere("p.id NOT IN(:providers)");
              $qb->setParameter('providers', $providersIds);
          }

          $qb->orderBy('i.id', 'DESC');
          $providers = $qb->getQuery()->getResult();

          return $this->render('@Admin/imagesModal.html.twig', [ 'providers' => $providers ]);
    }

    public function imagesBoxAction(Request $request)
    {
        $em             = $this->getDoctrine()->getManager();
        $providersIds   = $request->query->get('providers');

        if(count($providersIds) > 0)
        {
            $providers = $em->getRepository(ImageProvider::class)
            ->createQueryBuilder('p')
            ->addSelect('i')
            ->addSelect('th')
            ->leftJoin('p.image', 'i')
            ->leftJoin('i.thumbnails', 'th')
            ->andWhere('i.isOriginal=1')
            ->andWhere("p.id IN(:providers)")
            ->setParameter('providers', $providersIds)
            ->orderBy('i.id', 'DESC')
            ->getQuery()
            ->getResult();
            return $this->render('@Admin/imagesBox.html.twig', [ 'providers' => $providers ]);
        }
        die('0');
    }

    /**
    * @param array $providers
    * @return Response
    */
    public function imagesBoxRender($providers)
    {
        return $this->render('@Admin/imagesBox.html.twig', [ 'providers' => $providers ]);
    }

    public function roomRemoveAction(Request $request, $roomId)
    {
        $em = $this->getDoctrine()->getManager();
        if($room = $em->getRepository(Room::class)->findOneBy(['id' => $roomId]))
        {
            $em->remove($room);
            $em->flush();
            return $this->redirectToRoute('admin_rooms');
        }
    }

    public function feedbackRemoveAction(Request $request, $feedbackId)
    {
        $em = $this->getDoctrine()->getManager();
        if($feedback = $em->getRepository(Feedback::class)->findOneBy(['id' => $feedbackId]))
        {
            $em->remove($feedback);
            $em->flush();
            return $this->redirectToRoute('admin_feedbacks');
        }
    }


    public function roomEditorAction(Request $request, $roomId = false)
    {
        $em = $this->getDoctrine()->getManager();

        # Exists room
        if($roomId > 0)
        {
            if(!$room = $em->getRepository(Room::class)->findOneBy(['id' => $roomId]))
            {
                $roomId >= 1?die('Room not found'):null;
            }

            # Sorting images
            if($room->getImages())
            {
                $iterator = $room->getImages()->getIterator();
                $iterator->uasort(function ($a, $b) {
                    return ($a->getRoomSortOrder() < $b->getRoomSortOrder()) ? -1 : 1;
                });
                $collection = new ArrayCollection(iterator_to_array($iterator));
                $room->setImages($collection);
            }
        }
        # New room
        else
        {
            $room = new Room;
            $room->setIsPublished(true);
        }

        $form = $this->createFormBuilder($room)
            ->add('title', TextType::class)
            ->add('text', TextAreaType::class, ['required' => false])
            ->add('shortText', TextAreaType::class, ['required' => false])
            ->add('priceFrom', TextType::class, ['required' => false])
            ->add('priceTo', TextType::class, ['required' => false])
            ->add('floor', TextType::class, ['required' => false])
            ->add('includes', TextType::class, ['required' => false])
            ->add('areaSize', TextType::class, ['required' => false])
            ->add('personsNumber', TextType::class, ['required' => false])
            ->add('sortOrder', TextType::class, ['required' => false])
            ->add('isPublished', CheckboxType::class, ['required' => false])
            ->add('metaTitle', TextType::class, ['required' => false])
            ->add('metaKeywords', TextAreaType::class, ['required' => false])
            ->add('metaDescription', TextAreaType::class, ['required' => false])
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $room = $form->getData();
            $room->setDatetimeModifed(new \DateTime());

            $em->persist($room);
            $em->flush();

            $imageService = $this->get('image_uploader');
            $imageService->updateImageProviders($request->request->get('providers'), $room);

            return $this->redirectToRoute('admin_room_editor', ['roomId' => $room->getId()]);
        }

        return $this->render('@Admin/roomEditor.html.twig',
        [
            'room' => $room,
            'form' => $form->createView()
        ]);
    }

    # Images
    public function imagesAction(Request $request)
    {
        $em       = $this->getDoctrine()->getManager();

        $file = new FileObject;
        $form = $this->createFormBuilder($file)
          ->add('file', FileType::class,  ['multiple' => true])
          ->getForm()
          ->handleRequest($request);


        if($form->isSubmitted() && $form->isValid())
        {
            $uploader = $this->get('image_uploader');
            foreach($form->getData()->getFile() as $k=>$file)
            {
                $uploader->uploadFile($file, 'default', date('Y-m-d-h-i-s').'-i-' . $k);
            }
            return $this->redirectToRoute('admin_images');

        }

        $images  =
          $em->getRepository(Image::class)
          ->createQueryBuilder('i')
          ->addSelect('th')
          ->addSelect('thp')
          ->addSelect('p')
          ->leftJoin('i.thumbnails', 'th')
          ->join('i.provider', 'p')
          ->leftJoin('th.provider', 'thp')
          ->where('i.isOriginal=1')
        #  ->orderBy('i.id', 'DESC')
          ->orderBy('p.sortOrder', 'ASC')

          ->getQuery()
          ->getResult();

        return $this->render('@Admin/images.html.twig', ['form' => $form->createView(), 'images' => $images]);
    }

    public function imageRemoveAction(Request $request, $imageId)
    {
        $em = $this->getDoctrine()->getManager();
        if($image = $em->getRepository(Image::class)->find($imageId))
        {
            $imageService   = $this->get('image_uploader');
            $imageService->removeImage($image);
            return $this->redirectToRoute('admin_images');
        }
    }


    public function roomsAction(Request $request)
    {
        $em     = $this->getDoctrine()->getManager();
        $rooms  =
          $em->getRepository(Room::class)
          ->createQueryBuilder('r')
          ->orderBy('r.sortOrder', 'ASC')
          ->getQuery()
          ->getResult();
        return $this->render('@Admin/rooms.html.twig', ['rooms' => $rooms]);
    }


    public function siteSettingsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        die('siteSettingsAction');
    }

    /**
    * @param Request $request
    * @param int $imageId
    * @return Response
    */
    public function imageEditorAction(Request $request, $imageId = false)
    {
        $em     = $this->getDoctrine()->getManager();
        $provider  =
          $em->getRepository(ImageProvider::class)
          ->createQueryBuilder('p')
          ->addSelect('th')
          ->addSelect('i')
          ->leftJoin('p.image', 'i')
          ->leftJoin('i.thumbnails', 'th')
          ->where("i.id={$imageId}")
          ->getQuery()
          ->getSingleResult();

        $roleChoices = [];

        if(!$provider)
        {
            die('Image not found');
        }

        foreach($provider->getRoleNames() as $role)
        {
              $roleChoices[$role] = $role;
        }

        $form = $this->createFormBuilder($provider)
          ->add('note',       TextType::class, [ 'required' => false ])
          ->add('sortOrder',  TextType::class, [ 'required' => false ])
          ->add('roles',      ChoiceType::class, array
          (
              'choices'               => $roleChoices,
              'multiple'              => true,
              'expanded'              => true,
              'choices_as_values'     => true,
              'translation_domain'    => 'admin',
          ))
          ->add('save', SubmitType::class)
          ->getForm()
          ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($provider);
            $em->flush();
            return $this->redirectToRoute('admin_image_editor', [ 'imageId' => $provider->getImage()->getId() ]);
        }



        return $this->render('@Admin/imageEditor.html.twig', [ 'form' => $form->createView(), 'provider' => $provider ]);
    }



}

<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HotelBundle\Entity\Room;
use ImageBundle\Entity\Image;
use HotelBundle\Entity\Post;
use HotelBundle\Entity\Review;
use HotelBundle\Entity\Category;
use ImageBundle\Entity\ImageProvider;
use HotelBundle\Entity\Feedback;
use ImageBundle\Form\ImageProviderType;
use ImageBundle\Repository\ImageProviderRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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


class ReviewAdminController extends Controller
{
    public function reviewEditorAction(Request $request, $reviewId = false)
    {
        $em = $this->getDoctrine()->getManager();

        if($reviewId > 0)
        {
            if($review = $em->getRepository(Review::class)->findOneBy(['id' => $reviewId]))
            {}
            else
            {
                die('Review not found');
            }
        }
        else
        {
            $review = new Review;
        }

        $form = $this->createFormBuilder($review)
            ->add('name',       TextType::class, [ 'required' => false ])
            ->add('country',       TextType::class, [ 'required' => false ])
            ->add('city',       TextType::class, [ 'required' => false ])
            ->add('sortOrder',  TextType::class, [ 'required' => false ])
            ->add('text',       TextAreaType::class)
            ->add('replyText',  TextAreaType::class, [ 'required' => false ])
            // ->add('datetime',   DateType::class, ['widget' => 'single_text', 'required' => 'false' ])
            ->add('save',       SubmitType::class, array('label' => ''))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($review);
            $em->flush();
            return $this->redirectToRoute('admin_review_editor', ['reviewId' => $review->getId()]);
        }

        return $this->render('@Admin/review/reviewEditor.html.twig', [ 'form' => $form->createView(), 'review' => $review ]);
    }

    /**
    * @param Request $request
    * @return Response
    */
    public function reviewsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $reviews  =
          $em->getRepository(Review::class)
          ->createQueryBuilder('r')
          ->orderBy('r.sortOrder', 'ASC')
          ->getQuery()
          ->getResult();
        return $this->render('@Admin/review/reviews.html.twig', ['reviews' => $reviews ]);
    }

    public function reviewRemoveAction(Request $request, $reviewId)
    {
        $em = $this->getDoctrine()->getManager();
        if($review = $em->getRepository(Review::class)->findOneBy(['id' => $reviewId]))
        {
            $em->remove($review);
            $em->flush();
            return $this->redirectToRoute('admin_reviews');
        }
    }












}

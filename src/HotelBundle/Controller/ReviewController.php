<?php

namespace HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HotelBundle\Entity\Room;
use HotelBundle\Entity\Post;
use HotelBundle\Entity\Review;
use HotelBundle\Entity\Category;
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


class ReviewController extends Controller
{
    public function reviewsAction(Request $request)
    {
        $em         = $this->getDoctrine()->getManager();
        $reviews  =
          $em->getRepository(Review::class)
          ->createQueryBuilder('i')
          ->getQuery()
          ->getResult();

        return $this->render('@Hotel/Default/reviews.html.twig', [ 'reviews' => $reviews ]);

    }






}

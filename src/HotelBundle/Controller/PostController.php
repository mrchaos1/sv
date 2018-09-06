<?php

namespace HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HotelBundle\Entity\Room;
use HotelBundle\Entity\Post;
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


class PostController extends Controller
{

    public function postAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        if(!$post = $em->getRepository(Post::class)->getPostBySlug($slug))
        {
            throw $this->createNotFoundException('Страница не найдена');
        }

        $iterator = $post->getImages()->getIterator();
        $iterator->uasort(function ($a, $b)
        {
            return ($a->getRoomSortOrder() < $b->getRoomSortOrder()) ? -1 : 1;
        });
        $collection = new ArrayCollection(iterator_to_array($iterator));
        $post->setImages($collection);


        return $this->render('@Hotel/Default/post.html.twig', [ 'post' => $post ]);

    }

    public function postsAction(Request $request, $slug = false)
    {
        $em         = $this->getDoctrine()->getManager();
        $category   = false;

        if($slug)
        {
            if($category = $em->getRepository(Category::class)->findOneBy(['slug' => $slug]))
            {

            }
            else
            {
                throw $this->createNotFoundException('Страница не найдена');
            }

        }

        $posts   = $em->getRepository(Post::class)->getPosts($slug);

        return $this->render('@Hotel/Default/posts.html.twig', [ 'posts' => $posts, 'category' => $category ]);

    }






}

<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HotelBundle\Entity\Room;
use ImageBundle\Entity\Image;
use HotelBundle\Entity\Post;
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


class PostAdminController extends Controller
{

    protected function slugConvert($formData)
    {
        $slug = str_replace([ ' ' ], [ '_' ], trim($formData->getSlug()));
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->findOneBy(['slug' => $formData->getSlug()]);
        if($post && $formData->getId() != $post->getId())
        {
            $slug = $post->getSlug().'_2';
        }
        return $slug;
    }


    public function postEditorAction(Request $request, $postId = false)
    {
        $em = $this->getDoctrine()->getManager();

        if($postId > 0)
        {
            if($post = $em->getRepository(Post::class)->findOneBy(['id' => $postId]))
            {
               # Sorting images
               if($post->getImages())
               {
                   $iterator = $post->getImages()->getIterator();
                   $iterator->uasort(function ($a, $b) {
                       return ($a->getPostSortOrder() < $b->getPostSortOrder()) ? -1 : 1;
                   });
                   $collection = new ArrayCollection(iterator_to_array($iterator));
                   $post->setImages($collection);
               }
            }
            else
            {
                die('Post not found');
            }
        }
        else
        {
            $post = new Post;
            $post->setIsPublished(true);
        }



        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('slug', TextType::class)
            ->add('sortOrder', TextType::class, ['required' => false])
            ->add('text', TextAreaType::class, ['required' => false])
            ->add('shortText', TextAreaType::class, ['required' => false])
            ->add('isPublished', CheckboxType::class, ['required' => false])
            ->add('category', EntityType::class, ['placeholder' => 'Без категории', 'choice_label' => 'title', 'class' => Category::class, 'required' => false])
            ->add('metaTitle', TextType::class, ['required' => false])
            ->add('metaKeywords', TextAreaType::class, ['required' => false])
            ->add('metaDescription', TextAreaType::class, ['required' => false])
            ->add('save', SubmitType::class, array('label' => ''))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $imageService = $this->get('image_uploader');
            $imageService->updateImageProviders($request->request->get('providers'), $post);

            $post = $form->getData();
            $post->setDatetimeModifed(new \DateTime());
            $post->setSlug($this->slugConvert($form->getData()));

            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('admin_post_editor', ['postId' => $post->getId()]);
        }

        return $this->render('@Admin/post/postEditor.html.twig', [ 'form' => $form->createView(), 'post' => $post ]);
    }

    public function postsAction(Request $request)
    {
        $em     = $this->getDoctrine()->getManager();
        $posts  =  $em->getRepository(Post::class)->getPosts(false, false);
        return $this->render('@Admin/post/posts.html.twig', ['posts' => $posts ]);
    }

    public function postRemoveAction(Request $request, $postId)
    {
        $em = $this->getDoctrine()->getManager();
        if($post = $em->getRepository(Post::class)->findOneBy(['id' => $postId]))
        {
            if($post->getIsSystem())
            {
                die('Статья защища от удаления');
            }
            $em->remove($post);
            $em->flush();
            return $this->redirectToRoute('admin_posts');
        }
    }











}

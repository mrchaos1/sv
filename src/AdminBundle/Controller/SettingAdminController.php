<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HotelBundle\Entity\Room;
use ImageBundle\Entity\Image;
use HotelBundle\Entity\Post;
use HotelBundle\Entity\Category;
use ImageBundle\Entity\ImageProvider;
use HotelBundle\Entity\Feedback;
use HotelBundle\Entity\Setting;
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
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AdminBundle\Form\Object\FileObject;
use Doctrine\Common\Collections\ArrayCollection;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;


class SettingAdminController extends Controller
{


    public function settingEditorAction(Request $request, $slug = 'default')
    {
        $em       = $this->getDoctrine()->getManager();
        $setting  = $em->getRepository(Setting::class)->findOneBy(['slug' => $slug]);

        if(!$setting)
        {
            $setting = new Setting;
            $setting->setSlug($slug);
            $em->persist($setting);
            $em->flush();
        }

        $form = $this->createFormBuilder($setting)
            ->add('title', TextType::class, [ 'label' => 'Название сайта', 'required' => false ])
            ->add('adminEmail', EmailType::class, [ 'label' => 'E-Mail администратора', 'required' => false ])

            ->add('discountMonday',     TextType::class, [ 'label' => 'Пн', 'required' => false ])
            ->add('discountTuesday',    TextType::class, [ 'label' => 'Вт', 'required' => false ])
            ->add('discountWednesday',  TextType::class, [ 'label' => 'Ср', 'required' => false ])
            ->add('discountThursday',   TextType::class, [ 'label' => 'Чт', 'required' => false ])
            ->add('discountFriday',     TextType::class, [ 'label' => 'Пт', 'required' => false ])
            ->add('discountSaturday',   TextType::class, [ 'label' => 'Сб', 'required' => false ])
            ->add('discountSunday',     TextType::class, [ 'label' => 'Вс', 'required' => false ])

            ->add('save', SubmitType::class, array('label' => ''))
            ->getForm();


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $setting = $form->getData();
            $em->persist($setting);
            $em->flush();
            return $this->redirectToRoute('admin_setting_editor');
        }

        return $this->render('@Admin/settingEditor.html.twig', [ 'form' => $form->createView(), 'setting' => $setting ]);




    }















}

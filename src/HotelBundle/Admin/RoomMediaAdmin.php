<?php

namespace HotelBundle\Admin;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


use Doctrine\Common\Collections\ArrayCollection;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;


use BlogBundle\Entity\Post;
use BlogBundle\Entity\PostTranslation;
use BlogBundle\Entity\Language;
use BlogBundle\Entity\Category;

use BlogBundle\Form\PostTranslationType;

class RoomMediaAdmin extends AbstractAdmin
{
  protected function configureFormFields(FormMapper $formMapper)
  {
      
  }

  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
      $datagridMapper->add('title');
  }

  protected function configureListFields(ListMapper $listMapper)
  {
      $listMapper->addIdentifier('id', 'text');
      $listMapper->addIdentifier('title', 'text');
      $listMapper->add('_action', 'actions', array
      (
          'header_style'  => 'width: 200px',
          'actions'       => array
          (
              'show'    => [],
              'edit'    => [],
              'delete'  => []
          )
      ));

  }





}

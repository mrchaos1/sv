<?php

namespace HotelBundle\Repository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    /**
    *
    * @param string   $categorySlug
    * @param bool     $onlyPublished
    * @param int      $limit
    *
    * @return Post[]
    */
    public function getPosts($categorySlug = false, $onlyPublished = true, $limit = false)
    {
      $qb =  $this->createQueryBuilder('post');

      $qb->leftJoin('post.category', 'c');
      $qb->addSelect('c');

      $qb->addSelect('p');
      $qb->addSelect('i');
      $qb->addSelect('th');

      $qb->leftJoin('post.images', 'p');
      $qb->leftJoin('p.image', 'i');
      $qb->leftJoin('i.thumbnails', 'th');

      if($onlyPublished)
      {
          $qb->andWhere('post.isPublished = 1');
      }


      if($categorySlug)
      {
          $qb->andWhere('c.slug = :categorySlug');
          $qb->setParameter('categorySlug', $categorySlug);
      }

      if($limit)
      {
          $qb->setMaxResults($limit);
      }

      $qb->orderBy('post.sortOrder', 'ASC');
      $posts = $qb->getQuery()->getResult();

      return $posts;

    }


    public function getPostBySlug($slug, $onlyPublished = true)
    {
        $qb = $this->createQueryBuilder('post')
          ->addSelect('p')
          ->addSelect('i')
          ->addSelect('th')

          ->leftJoin('post.images', 'p')
          ->leftJoin('p.image', 'i')
          ->leftJoin('i.thumbnails', 'th');

          if($onlyPublished)
          {
              $qb->andWhere('post.isPublished = 1');
          }

          $qb->andWhere('post.slug = :slug');
          $qb->setParameter('slug', $slug);
          $post = $qb->getQuery()->getResult();

        return $post ? $post[0] : false;
    }



}

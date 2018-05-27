<?php

namespace ImageBundle\Twig;

class ImageExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('thumbnail', [$this, 'getThumbnail']),
        );
    }
    /**
    * @param Image image
    *
    */
    public function getThumbnail($image, $thumbnailName)
    {
        foreach($image->getThumbnails() as $thumbnail)
        {
            if($thumbnail->getThumbnailName() == $thumbnailName)
            {
                return $thumbnail->getPublicSrc();
                break;
            }
        }

        return false;
    }
}

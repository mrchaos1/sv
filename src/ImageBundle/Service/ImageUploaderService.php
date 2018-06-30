<?php
namespace ImageBundle\Service;
use \ImageBundle\Entity\Image;
use \ImageBundle\Entity\ImageProvider;




class ImageUploaderService
{
    protected $publiDir;
    protected $internalDir;
    protected $root;
    protected $patterns;
    protected $container;
    protected $thumbnailPatterns;
    protected $mimes =
    [
      'image/jpeg'  => ['extension' => 'jpg'],
      'image/gif'   => ['extension' => 'gif'],
      'image/png'   => ['extension' => 'png'],
      'image/svg'   => ['extension' => 'svg']
    ];

    public function __construct($container, $root, $publicDir, $internalDir, $patterns, $thumbnailPatterns)
    {
        $this->container              = $container;
        $this->publicDir              = $publicDir;
        $this->internalDir            = $internalDir;
        $this->root                   = $root;
        $this->patterns               = $patterns;
        $this->thumbnailPatterns      = $thumbnailPatterns;
    }

    /**
    * @param string $mime
    * @return string
    */
    protected function getImageExtension($mime)
    {
        return $this->mimes[$mime]['extension'];
    }

    /**
    * @return string
    */
    protected function generateFilePath()
    {
        return ('/'.(trim($this->root, '/')) . '/' . (trim($this->internalDir, '/')) . '/');
    }

    /**
    * @return string
    */
    protected function generateFilePublicPath()
    {
        return '/' . (trim($this->publicDir, '/')) . '/';
    }

    /**
    * @return string|false
    */
    public function generateSubDir($subDirTemplate)
    {
        $subDirGenerated  = trim(date($subDirTemplate), '/');
        $pathToGenerate   = $this->generateFilePath().$subDirGenerated;
        if(is_dir($pathToGenerate))
        {
            return $subDirGenerated . '/';
        }
        else
        {
          if(mkdir($pathToGenerate, 0777, true))
          {
              return $subDirGenerated . '/';
          }
        }

        return false;
    }

    /**
    * Image resize
    *
    * @param string $fileRealpath
    * @param string $saveFileRealpath
    * @param string $width
    * @param string $height
    *
    * @return Image|false
    */
    protected function imageResize($fileRealpath, $saveFileRealpath, $width, $height)
    {
        $imagick = new \Imagick();
        $imagick->readimage($fileRealpath);

        $originalSize     = $imagick->getImageGeometry();
        $originalWidth    = $originalSize['width'];
        $originalHeight   = $originalSize['height'];

        $ratio = $originalWidth/$originalHeight;

        # Calculation new image width and height
        # If image is vertical
        if ($originalHeight > $originalWidth)
        {
            # If original height is less, than resizing height, then keep sizes
            if($height >= $originalHeight)
            {
                $newWidth     = $originalWidth;
                $newHeight    = $originalHeight;
            }
            else
            {
                $newWidth     = $height*$ratio;
                $newHeight    = $height;
            }
        }
        # If image is horizontal
        else
        {
            # If original width is less, than resizing width, then keep sizes
            if($width >= $originalHeight)
            {
                $newWidth     = $originalWidth;
                $newHeight    = $originalHeight;
            }
            else
            {
                $newWidth     = $width;
                $newHeight    = $width/$ratio;
            }

        }
        $thumbWidth       = intval($newWidth);
        $thumbHeight      = intval($newHeight);

        $imagick->scaleImage($thumbWidth, $thumbHeight);

        $image = new Image;
        $image->setWidth($thumbWidth);
        $image->setHeight($thumbHeight);

        if($imagick->writeImage($saveFileRealpath))
        {
            return $image;
        }

        return false;
    }

    /**
    * @param File $file
    * @param string $pattern
    * @return Image
    */
    public function uploadFile($file, $pattern = 'default', $fileName = false)
    {
        $pattren            = $this->patterns[$pattern];
        $subDir             = false;
        $subDirTemplate     = $this->patterns[$pattern]['sub_dir_template'];

        if($subDirTemplate)
        {
            $subDir = $this->generateSubDir($subDirTemplate);
        }

        $em = $this->container->get('doctrine.orm.entity_manager');

        # Image File parameters
        $imageSize        = getimagesize($file->getRealpath());
        $imageWidth       = $imageSize[0];
        $imageHeight      = $imageSize[1];
        $imageMime        = $imageSize['mime'];
        $imageExtension   = $this->getImageExtension($imageSize['mime']);
        $fileName         = $fileName.'.'.$imageExtension;

        # Save paths
        $filePath         = $this->generateFilePath();
        $filePublicPath   = $this->generateFilePublicPath();
        $fileNameOrigal   = $file->getClientOriginalName();

        # Prepare to database
        $image = new Image;
        $image->setTitle($fileName);
        $image->setDatetimeAdded(new \DateTime);
        $image->setDatetimeModifed(new \DateTime);
        $image->setWidth($imageWidth);
        $image->setHeight($imageHeight);
        $image->setIsOriginal(true);
        $image->setPublicDir($filePublicPath);
        $image->setInternalDir($this->internalDir);
        $image->setSubDir($subDir);
        $image->setFileName($fileName);
        $image->setFileExtension($imageExtension);
        $imageProvider = new ImageProvider;
        $imageProvider->setImage($image);
        $image->setProvider($imageProvider);

        $file->move($filePath.$subDir, $fileName);

        $em->persist($image);
        $em->flush();

        $originalFileRealpath = $filePath.$subDir.$fileName;

        // Make thumbnails
        if(isset($pattren['thumbnails']) && count($pattren['thumbnails']) > 0)
        {
            foreach($pattren['thumbnails'] as $thumbnailName)
            {
                $thumbnail        = $this->thumbnailPatterns[$thumbnailName];
                $thumbFileName    = $thumbnailName.'-'.$fileName;

                # Resizing and saving image
                if($thumbImage = $this->imageResize($originalFileRealpath, $filePath.$subDir.$thumbFileName, $thumbnail['width'], $thumbnail['height']))
                {
                    $thumbImage->setTitle(date('Y-m-d H:i:s'));
                    $thumbImage->setDatetimeAdded(new \DateTime);
                    $thumbImage->setDatetimeModifed(new \DateTime);
                    $thumbImage->setIsOriginal(false);
                    $thumbImage->setThumbnailName($thumbnailName);
                    $thumbImage->setParent($image);
                    $thumbImage->setPublicDir($filePublicPath);
                    $thumbImage->setInternalDir($this->internalDir);
                    $thumbImage->setSubDir($subDir);
                    $thumbImage->setFileExtension($imageExtension);
                    $thumbImage->setFileName($thumbFileName);
                    $thumbImage->setDatetimeAdded(new \DateTime);
                    $thumbImage->setDatetimeModifed(new \DateTime);
                    $em->persist($thumbImage);
                    $em->flush();
                }
            }
        }
        return $image;
    }

    /**
    * @param Image $image
    * @return string
    */
    protected function getFileRealpath($image)
    {
        return '/' . trim($this->root, '/') . '/' . trim($image->getInternalDir(), '/') . '/' . ($image->getSubDir() ? (trim($image->getSubDir(), '/') . '/') : '') . $image->getFileName() ;
    }

    /**
    * @param Image $image
    * @param bool $removeImageWithoutFile
    * @return bool
    */
    protected function removeImageFile($image, $removeImageWithoutFile = true)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        $imageRealpath = $this->getFileRealpath($image);

        if(file_exists($imageRealpath))
        {
            if(unlink($imageRealpath))
            {
                $em->remove($image);
                $em->flush();
            }
        }
        else if($removeImageWithoutFile)
        {
            $em->remove($image);
            $em->flush();
        }
    }

    /**
    * @param Image $image
    * @return bool
    */
    public function removeImage($image)
    {
        foreach($image->getThumbnails() as $thumbnail)
        {
            $this->removeImageFile($thumbnail);
        }
        return $this->removeImageFile($image);
    }


    protected function removeObjectFromImage($object)
    {
        $object = explode('\\', get_class($object));
        $objectName = end($object);
        return $objectName;
    }

    public function updateImageProviders($providersIds, $object)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        $newProviders   =
          $em->getRepository(ImageProvider::class)
          ->createQueryBuilder('p')
          ->andWhere('p.id IN (:providersIds)')
          ->setParameter('providersIds', $providersIds)
          ->getQuery()
          ->getResult();

        $objectName = $this->removeObjectFromImage($object);

        # Remove old images
        if($object->getImages())
        {
            foreach($object->getImages() as $image)
            {
                # Call remove method of object
                call_user_func_array([$image, 'remove'.$objectName], [$object]);
                $object->removeImage($image);
                $em->persist($object);
                $em->flush();
            }
        }

        if($newProviders)
        {
            $flipProvidersIds     = array_flip($providersIds);
            $providersToInsert    = [];

            foreach ($newProviders as $provider)
            {
                # Set sort order
                if(isset($flipProvidersIds[$provider->getId()]))
                {
                    call_user_func_array([$provider, 'set'.$objectName.'SortOrder'], [$flipProvidersIds[$provider->getId()]]);

                }
                $object->addImage($provider);
                $em->persist($object);
                $em->flush();

            }
        }
    }



}

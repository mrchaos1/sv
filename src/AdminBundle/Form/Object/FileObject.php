<?php

namespace AdminBundle\Form\Object;


class FileObject
{
    protected $file;


    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }




}

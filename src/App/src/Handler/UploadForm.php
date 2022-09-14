<?php

namespace App\Handler;

use Laminas\Form\Element;
use Laminas\Form\Form;

class UploadForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->addElements();
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('image');
        $file->setLabel('Example file input');
        $file->setAttribute('id', 'image');

        $this->add($file);
    }
}
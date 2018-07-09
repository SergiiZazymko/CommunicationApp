<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 09.07.18
 * Time: 16:26
 */

namespace Files\Form;


use Files\Form\Filter\UploadFilter;
use Zend\Form\Element\File;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class UploadForm
 * @package Files\Form
 */
class UploadForm extends Form
{
    /**
     * UploadForm constructor.
     * @param string $name
     */
    public function __construct($name='Upload')
    {
        parent::__construct($name);
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setInputFilter(new UploadFilter());

        /** @var Text $description */
        $description = new Text('description');
        $description->setLabel('File Description');
        $this->add($description);

        /** @var File $file */
        $file = new File('file');
        $file->setLabel('File Upload');
        $this->add($file);

        /** @var Submit $submit */
        $submit = new Submit('submit');
        $submit->setValue('Upload Now');
        $this->add($submit);
    }
}

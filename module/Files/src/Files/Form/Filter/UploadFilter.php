<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 09.07.18
 * Time: 16:34
 */

namespace Files\Form\Filter;


use Zend\Filter\File\RenameUpload;
use Zend\Filter\HtmlEntities;
use Zend\Filter\StringTrim;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

/**
 * Class UploadFilter
 * @package Files\Form\Filter
 */
class UploadFilter extends InputFilter
{
    /**
     * UploadFilter constructor.
     */
    public function __construct()
    {
        /** @var Input $description */
        $description = new Input('description');
        $description->getFilterChain()
            ->attach(new HtmlEntities())
            ->attach(new StringTrim());
        $description->setRequired(true)
            ->getValidatorChain()
            ->attach(new NotEmpty());
        $this->add($description);

        /** @var RenameUpload $renameUpload */
        $renameUpload = new RenameUpload('./data/uploads');
        $renameUpload->setUseUploadExtension(true);
        $renameUpload->setUseUploadName(true);
        $renameUpload->setRandomize(true);

        /** @var Input $file */
        $file = new Input('file');
        $file->getFilterChain()
            ->attach($renameUpload);
        $this->add($file);
    }
}

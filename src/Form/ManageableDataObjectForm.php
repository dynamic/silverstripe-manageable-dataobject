<?php

namespace Dynamic\ManageableDataObject\Form;

use SilverStripe\Control\Controller;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;

/**
 * Class ManageableDataObjectForm
 */
class ManageableDataObjectForm extends Form
{

    /**
     * ManageableDataObjectForm constructor.
     *
     * @param Controller $controller
     * @param string $name
     * @param \SilverStripe\ORM\DataObject|string $object
     */
    public function __construct(Controller $controller, $name, $object)
    {
        if (is_string($object) && class_exists($object)) {
            $object = Injector::inst()->get($object);
        }

		/** @var \SilverStripe\ORM\DataObject|\Dynamic\ManageableDataObject\Interfaces\ManageableDataObjectInterface $object */
        $fields = $object->getFrontEndFields();
        $actions = $object->getFrontEndActions();
        if (!$actions->dataFieldByName('action_doSaveObject')) {
            $actions->push(FormAction::create('doSaveObject')->setTitle('Save'));
        }
        $validator = $object->getFrontEndRequiredFields();

        parent::__construct($controller, $name, $fields, $actions, $validator);
    }

}

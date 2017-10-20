<?php

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
     * @param FieldList $object
     */
    public function __construct(Controller $controller, $name, $object)
    {
        if (is_string($object) && class_exists($object)) {
            $object = Injector::inst()->get($object);
        }
        $fields = $object->getFrontEndFields();
        $actions = $object->getFrontEndActions();
        if (!$actions->dataFieldByName('action_doSaveObject')) {
            $actions->push(FormAction::create('doSaveObject')->setTitle('Save'));
        }
        $validator = $object->getFrontEndRequiredFields();

        parent::__construct($controller, $name, $fields, $actions, $validator);
    }

}
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
     * @param FieldList $model
     */
    public function __construct(Controller $controller, $name, $model)
    {
        $object = Injector::inst()->get($model);

        $fields = $object->getFrontEndFields();
        $actions = $object->getFrontEndActions();
        if (!$actions->dataFieldByName('action_doSaveObject')) {
            $actions->push(FormAction::create('doSaveObject')->setTitle('Save'));
        }
        $validator = $object->getFrontEndRequiredFields();

        parent::__construct($controller, $name, $fields, $actions, $validator);
    }

}
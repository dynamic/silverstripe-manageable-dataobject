<?php

/**
 * Class ManageableDataObjectExtension
 */
class ManageableDataObjectExtension extends Extension
{

    /**
     * @var array
     */
    private static $allowed_actions = [
        'add',
        'edit',
        'delete',
        'ManageableDataObjectForm',
    ];

    /**
     * Add object
     *
     * @return SS_HTTPResponse|ViewableData_Customised
     */
    public function add()
    {
        $model = $this->owner->config()->get('managed_object');
        $object = Injector::inst()->get($model);
        if ($object->canCreate(Member::currentUser())) {

            $form = $this->ManageableDataObjectForm();
            $form->Actions()->push(new CancelFormAction($this->owner->Link(), 'Cancel'));

            return $this->owner->customise(array(
                'Title' => 'Add new ' . $object->singular_name(),
                'ManageableDataObjectForm' => $form
            ));
        }

        return Security::permissionFailure($this->owner, "You don't have permission to add records.");
    }

    /**
     * Edit object
     *
     * @return SS_HTTPResponse|ViewableData_Customised
     */
    public function edit()
    {
        if ($item = $this->getCurrentItem()) {
            if ($item->canEdit(Member::currentUser())) {

                // get Form
                $form = $this->ManageableDataObjectForm($item);

                return $this->owner->customise(array(
                    'Title' => 'Edit ' . $item->singular_name(),
                    'ManageableDataObjectForm' => $form,
                    'Item' => $item
                ));
            }

            return Security::permissionFailure($this->owner, "You don't have permission to edit this record.");
        }

        return $this->owner->httpError(404);
    }

    /**
     * Delete Object
     *
     * @return SS_HTTPResponse
     */
    public function delete()
    {
        if ($item = $this->getCurrentItem()) {
            if ($item->canDelete(Member::currentUser())) {
                $item->delete();

                return $this->owner->redirect($this->owner->Link());
            }

            return Security::permissionFailure($this->owner, "You don't have permission to delete this record.");
        }

        return $this->owner->httpError(404);
    }

    /**
     * Main GridObject Form. Fields loaded via getFrontEndFields method on each Object
     *
     * @param $object
     *
     * @return ManageableDataObjectForm
     */
    public function ManageableDataObjectForm($object = null)
    {
        $model = $this->owner->config()->get('managed_object');
        $object = ($object !== null && $object instanceof $model && $object->exists())
            ? $object
            : Injector::inst()->create($model);

        $form = ManageableDataObjectForm::create(
            $this->owner,
            'ManageableDataObjectForm',
            $model
        );

        if ($object->exists()) {
            $form->Fields()->push(HiddenField::create('ID'));
            $form->loadDataFrom($object);
        }

        return $form;
    }

    /**
     * Save object
     *
     * @param $data
     * @param $form
     *
     * @return SS_HTTPResponse
     */
    public function doSaveObject($data, $form)
    {

        $model = $this->owner->config()->get('managed_object');

        if (isset($data['ID']) && $data['ID']) {
            $object = $model::get()->byID($data['ID']);
        } else {
            $object = $model::create();
            // write on create to relations are saved on final write (needs ID)
            $object->write();
        }

        $form->saveInto($object);

        $object->write();

        return $this->owner->redirect($object->Link());
    }


    /**
     * @return bool|DataObject
     */
    protected function getCurrentItem()
    {
        if (!$id = $this->owner->request->param('ID')) {
            return false;
        }

        $class = $this->owner->config()->get('managed_object');
        if (!$record = $class::get()->byID($id)) {
            return false;
        }

        return $record;
    }

}
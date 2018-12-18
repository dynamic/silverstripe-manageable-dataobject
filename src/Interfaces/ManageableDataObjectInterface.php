<?php

namespace Dynamic\ManageableDataObject\Interfaces;

/**
 * interface ManageableDataObjectInterface
 */
interface ManageableDataObjectInterface
{

    /**
     * Return FieldList of form fields used to manage a DataObject's data
     *
     * @return \SilverStripe\Forms\FieldList
     */
    public function getFrontendFields();

    /**
     * Return FieldList of form actions used to manage a DataObject's data
     *
     * @return \SilverStripe\Forms\FieldList
     */
    public function getFrontEndActions();

    /**
     * Return set of required form fields used to manage a DataObject's data
     *
     * @return \SilverStripe\Forms\RequiredFields
     */
    public function getFrontEndRequiredFields();
}

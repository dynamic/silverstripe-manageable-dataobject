<?php

/**
 * Interface ManageableDataObjectInterface
 */
interface ManageableDataObjectInterface
{

    /**
     * Return FieldList of form fields used to manage a DataObject's data
     *
     * @return FieldList
     */
    public function getFrontendFields();

    /**
     * Return FieldList of form actions used to manage a DataObject's data
     *
     * @return FieldList
     */
    public function getFrontEndActions();

    /**
     * Return set of required form fields used to manage a DataObject's data
     *
     * @return RequiredFields
     */
    public function getFrontEndRequiredFields();

}
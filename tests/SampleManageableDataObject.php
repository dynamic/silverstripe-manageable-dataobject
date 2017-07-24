<?php

/**
 * Class SampleManageableDataObject
 */
class SampleManageableDataObject extends DataObject implements PermissionProvider, ManageableDataObjectInterface, TestOnly
{

    /**
     * @var string
     */
    private static $listing_page_class = 'SampleManageableObjectPage';

    /**
     * @var array
     */
    private static $extensions = [
        'Dynamic\\ViewableDataObject\\Extensions\\ViewableDataObject',
        'ManageableObjectDataExtension',
    ];

    /**
     * @return array
     */
    public function providePermissions()
    {
        return [
            'MDO_Create',
            'MDO_Edit',
            'MDO_Delete',
            'MDO_View',
        ];
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canCreate($member = null)
    {
        return Permission::check('MDO_Create', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canEdit($member = null)
    {
        return Permission::check('MDO_Edit', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canDelete($member = null)
    {
        return Permission::check('MDO_Delete', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canView($member = null)
    {
        return Permission::check('MDO_View', 'any', $member);
    }

    /**
     * @param null $params
     *
     * @return FieldList
     */
    public function getFrontEndFields($params = null)
    {
        return parent::getFrontEndFields();
    }

    /**
     * @return FieldList
     */
    public function getFrontEndActions()
    {
        return FieldList::create();
    }

    /**
     * @return RequiredFields
     */
    public function getFrontEndRequiredFields()
    {
        return RequiredFields::create();
    }

}
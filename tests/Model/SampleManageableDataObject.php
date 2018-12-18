<?php

namespace Dynamic\ManageableDataObject\Test\Model;

use Dynamic\ManageableDataObject\Extensions\ManageableObjectDataExtension;
use Dynamic\ManageableDataObject\Interfaces\ManageableDataObjectInterface;
use Dynamic\ViewableDataObject\Extensions\ViewableDataObject;
use SilverStripe\Dev\TestOnly;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;

/**
 * Class SampleManageableDataObject
 * @package Dynamic\ManageableDataObject\Test\Model
 *
 * @mixin ViewableDataObject
 * @mixin ManageableObjectDataExtension
 */
class SampleManageableDataObject extends DataObject implements PermissionProvider, ManageableDataObjectInterface, TestOnly
{

    /**
     * @var string
     */
    private static $listing_page_class = SampleManageableObjectPage::class;

    /**
     * @var array
     */
    private static $extensions = [
        ViewableDataObject::class,
        ManageableObjectDataExtension::class,
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
	 * @param array $context
	 *
	 * @return bool|int
	 */
    public function canCreate($member = null, $context = array())
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

<?php

namespace Dynamic\ManageableDataObject\Test\Extensions;

use Dynamic\ManageableDataObject\Test\Model\SampleManageableDataObject;
use Dynamic\ManageableDataObject\Test\Model\SampleManageableObjectPage;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Security\Security;

/**
 * Class ManageableObjectDataExtensionTest
 */
class ManageableObjectDataExtensionTest extends SapphireTest
{

    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     * @var array
     */
	protected static $extra_dataobjects = [
        SampleManageableDataObject::class,
        SampleManageableObjectPage::class,
    ];

	/**
	 * Ensure any current member is logged out
	 */
	public function logOut()
	{
		if ($member = Security::getCurrentUser()) {
			Security::setCurrentUser(null);
		}
	}

    /**
     *
     */
    public function testGetListingPage()
    {
        $this->assertEquals(SampleManageableObjectPage::class,
            Injector::inst()->get(SampleManageableDataObject::class)->getListingPage());
    }

    /**
     *
     */
    public function testGetAddLink()
    {
		/** @var SampleManageableObjectPage $page */
		$page = $this->objFromFixture(SampleManageableObjectPage::class, 'one');
		/** @var SampleManageableDataObject $object */
		$object = $this->objFromFixture(SampleManageableDataObject::class, 'one');

        $this->logOut();
        $this->assertFalse($object->getAddLink());

        $this->logInWithPermission('MDO_Create');

        $this->assertEquals($page->Link('add'), $object->getAddLink());

        $this->logOut();
    }

    /**
     *
     */
    public function testGetEditLink()
    {
		/** @var SampleManageableObjectPage $page */
		$page = $this->objFromFixture(SampleManageableObjectPage::class, 'one');
		/** @var SampleManageableDataObject $object */
		$object = $this->objFromFixture(SampleManageableDataObject::class, 'one');

        $this->logOut();
        $this->assertFalse($object->getEditLink());

        $this->logInWithPermission('MDO_Edit');

        $this->assertEquals(Controller::join_links($page->Link('edit'), $object->ID), $object->getEditLink());

        $this->logOut();
    }

    /**
     *
     */
    public function testGetDeleteLink()
    {
    	/** @var SampleManageableObjectPage $page */
        $page = $this->objFromFixture(SampleManageableObjectPage::class, 'one');
		/** @var SampleManageableDataObject $object */
        $object = $this->objFromFixture(SampleManageableDataObject::class, 'one');

        $this->logOut();
        $this->assertFalse($object->getDeleteLink());

        $this->logInWithPermission('MDO_Delete');

        $this->assertEquals(Controller::join_links($page->Link('delete'), $object->ID), $object->getDeleteLink());

        $this->logOut();
    }

}

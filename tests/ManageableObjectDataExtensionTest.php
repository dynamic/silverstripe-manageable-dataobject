<?php

/**
 * Class ManageableObjectDataExtensionTest
 */
class ManageableObjectDataExtensionTest extends SapphireTest
{

    /**
     * @var string
     */
    protected static $fixture_file = 'fixtures.yml';

    /**
     * @var array
     */
    protected $extraDataObjects = [
        SampleManageableDataObject::class,
        SampleManageableObjectPage::class,
    ];

    /**
     * Ensure any current member is logged out
     */
    public function logOut()
    {
        if ($member = Member::currentUser()) {
            $member->logOut();
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
        $page = $this->objFromFixture(SampleManageableObjectPage::class, 'one');
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
        $page = $this->objFromFixture(SampleManageableObjectPage::class, 'one');
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
        $page = $this->objFromFixture(SampleManageableObjectPage::class, 'one');
        $object = $this->objFromFixture(SampleManageableDataObject::class, 'one');

        $this->logOut();
        $this->assertFalse($object->getDeleteLink());

        $this->logInWithPermission('MDO_Delete');

        $this->assertEquals(Controller::join_links($page->Link('delete'), $object->ID), $object->getDeleteLink());

        $this->logOut();
    }

}
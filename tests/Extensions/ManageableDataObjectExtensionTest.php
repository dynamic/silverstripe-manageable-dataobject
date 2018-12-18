<?php

namespace Dynamic\ManageableDataObject\Test\Extensions;

use Dynamic\ManageableDataObject\Test\Model\SampleManageableDataObject;
use Dynamic\ManageableDataObject\Test\Model\SampleManageableObjectPage;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Security\Security;
use SilverStripe\View\SSViewer;

/**
 * Class ManageableDataObjectExtensionTest
 */
class ManageableDataObjectExtensionTest extends FunctionalTest
{

    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     * @var array
     */
    protected $extraDataObjects = [
        SampleManageableDataObject::class,
        SampleManageableObjectPage::class,
    ];

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        // Suppress themes
		SSViewer::config()->update('theme_enabled', false);
    }

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
    public function testAdd()
    {
        $this->logInWithPermission('MDO_Create');
        $response = $this->get('/SampleManageableObjectPage_Controller/add');
        $this->assertEquals(200, $response->getStatusCode());
        $this->logOut();
    }

    /**
     *
     */
    public function testEdit()
    {
        $this->logInWithPermission('MDO_Edit');
        $object = $this->objFromFixture(SampleManageableDataObject::class, 'one');
        $response = $this->get('/SampleManageableObjectPage_Controller/edit/' . $object->ID);
        $this->assertEquals(200, $response->getStatusCode());
        $this->logOut();

        $response2 = $this->get('/SampleManageableObjectPage_Controller/edit/' . 0);
        $this->assertEquals(404, $response2->getStatusCode());
    }

    /**
     *
     */
    public function testDelete()
    {
        $newObject = SampleManageableDataObject::create();
        $newObject->Title = 'Foo';
        $newObject->write();

        $id = $newObject->ID;

        $this->logInWithPermission('MDO_Delete');

        $response404 = $this->get('/SampleManageableObjectPage_Controller/delete/' . 0);
        $this->assertEquals(404, $response404->getStatusCode());

        $success = $this->get('/SampleManageableObjectPage_Controller/delete/' . $id);
        $this->assertEquals(200, $success->getStatusCode());
        $this->assertNull(SampleManageableDataObject::get()->byID($id));

        $this->logOut();
    }

    /**
     *
     */
    public function testDoSaveObject()
    {
        $this->logInWithPermission('MDO_Create');

        $controller = SamplemanageableObjectPage_Controller::create($this->objFromFixture(SampleManageableObjectPage::class, 'one'));
        $form = $controller->Form();

        $response = $this->get('/SampleManageableObjectPage_Controller/add');
        $this->assertEquals(200, $response->getStatusCode(), 'Submission successful');

        $data = ['Title' => 'Foobar'];
        $responseSubmission = $this->submitForm('ManageableDataObjectForm_Form', 'action_doSaveObject', $data);

        $record = SampleManageableDataObject::get()->filter($data)->first();
        $this->assertInstanceOf(SampleManageableDataObject::class, $record);
        $this->assertTrue($record->exists());//*/
    }

}

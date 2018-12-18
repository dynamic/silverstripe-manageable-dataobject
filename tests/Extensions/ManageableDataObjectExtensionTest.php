<?php

namespace Dynamic\ManageableDataObject\Test\Extensions;

use Dynamic\ManageableDataObject\Test\Model\SampleManageableDataObject;
use Dynamic\ManageableDataObject\Test\Model\SampleManageableObjectPage;
use Dynamic\ManageableDataObject\Test\Model\SampleManageableObjectPageController;
use SilverStripe\Control\Controller;
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
	protected static $extra_dataobjects = [
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
		$this->session()->set('readingMode', 'Stage.Stage');
		$this->session()->set('unsecuredDraftSite', true);
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
		/** @var SampleManageableObjectPage $page */
		$page = $this->objFromFixture(SampleManageableObjectPage::class, 'one');

		$this->logInWithPermission('MDO_Create');
		$response = $this->get($page->Link('add'));
		$this->assertEquals(200, $response->getStatusCode());
		$this->logOut();
	}

	/**
	 *
	 */
	public function testEdit()
	{
		/** @var SampleManageableDataObject $object */
		$object = $this->objFromFixture(SampleManageableDataObject::class, 'one');
		/** @var SampleManageableObjectPage $page */
		$page = $this->objFromFixture(SampleManageableObjectPage::class, 'one');

		$this->logInWithPermission('MDO_Edit');
		$response = $this->get(Controller::join_links(
			$page->Link(),
			'edit',
			$object->ID
		));
		$this->assertEquals(200, $response->getStatusCode());
		$this->logOut();

		$response2 = $this->get('/SampleManageableObjectPageController/edit/' . 0);
		$this->assertEquals(404, $response2->getStatusCode());
	}

	/**
	 *
	 */
	public function testDelete()
	{
		/** @var SampleManageableObjectPage $page */
		$page = $this->objFromFixture(SampleManageableObjectPage::class, 'one');

		$newObject = SampleManageableDataObject::create();
		$newObject->Title = 'Foo';
		$newObject->write();

		$id = $newObject->ID;

		$this->logInWithPermission('MDO_Delete');

		$response404 = $this->get(Controller::join_links(
			$page->Link(),
			'delete',
			0
		));
		$this->assertEquals(404, $response404->getStatusCode());

		$success = $this->get(Controller::join_links(
			$page->Link(),
			'delete',
			$id
		));
		$this->assertEquals(200, $success->getStatusCode());
		$this->assertNull(SampleManageableDataObject::get()->byID($id));

		$this->logOut();
	}

	/**
	 *
	 */
	public function testDoSaveObject()
	{
		/** @var SampleManageableObjectPage $page */
		$page = $this->objFromFixture(SampleManageableObjectPage::class, 'one');

		$this->logInWithPermission('MDO_Create');

		$controller = SampleManageableObjectPageController::create(
			$this->objFromFixture(SampleManageableObjectPage::class, 'one')
		);
		$form = $controller->Form();

		$response = $this->get($page->Link('add'));
		$this->assertEquals(200, $response->getStatusCode(), 'Submission successful');

		$data = ['Title' => 'Foobar'];
		$responseSubmission = $this->submitForm(
			'ManageableDataObjectForm_Form',
			'action_doSaveObject',
			$data
		);

		$record = SampleManageableDataObject::get()->filter($data)->first();
		$this->assertInstanceOf(SampleManageableDataObject::class, $record);
		$this->assertTrue($record->exists());
	}
}

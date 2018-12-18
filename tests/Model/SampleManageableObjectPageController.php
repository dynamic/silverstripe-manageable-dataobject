<?php

namespace Dynamic\ManageableDataObject\Test\Model;

use Dynamic\ManageableDataObject\Extensions\ManageableDataObjectExtension;
use Dynamic\ManageableDataObject\Form\ManageableDataObjectForm;
use SilverStripe\Dev\TestOnly;
use SilverStripe\View\Requirements;

/**
 * Class SampleManageableObjectPageController
 * @package Dynamic\ManageableDataObject\Test\Model
 *
 * @mixin ManageableDataObjectExtension
 */
class SampleManageableObjectPageController extends \PageController implements TestOnly
{

	/**
	 * @var array
	 */
	private static $allowed_actions = [
		'Form',
	];

	/**
	 * @var array
	 */
	private static $extensions = [
		ManageableDataObjectExtension::class
	];

	/**
	 * @var string
	 */
	private static $managed_object = SampleManageableDataObject::class;

	/**
	 *
	 */
	public function init()
	{
		parent::init();
		Requirements::clear();
	}

	public function Form()
	{
		return ManageableDataObjectForm::create($this, 'Form', $this->config()->get('managed_object'));
	}
}

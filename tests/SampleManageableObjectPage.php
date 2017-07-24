<?php

/**
 * Class SampleManageableObjectPage
 */
class SampleManageableObjectPage extends Page implements TestOnly
{

}

/**
 * Class SampleManageableObjectPage_Controller
 */
class SampleManageableObjectPage_Controller extends Page_Controller implements TestOnly
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
        'ManageableDataObjectExtension',
    ];

    /**
     * @var string
     */
    private static $managed_object = 'SampleManageableDataObject';

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
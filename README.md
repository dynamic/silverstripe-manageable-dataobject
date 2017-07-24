# dynamic/silverstripe-manageable-dataobject

[![Build Status](https://travis-ci.org/dynamic/silverstripe-manageable-dataobject.svg?branch=master)](https://travis-ci.org/dynamic/silverstripe-manageable-dataobject)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dynamic/silverstripe-manageable-dataobject/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-manageable-dataobject/?branch=master)
[![codecov](https://codecov.io/gh/dynamic/silverstripe-manageable-dataobject/branch/master/graph/badge.svg)](https://codecov.io/gh/dynamic/silverstripe-manageable-dataobject)

Allow front-end management of DataObjects.

## Requirements

- SilverStripe ^3.2
- Viewable Dataobject ^1.0
- Additional Form Fields ^1.0

## Installation

`composer require dynamic/silverstripe-manageable-dataobject`

## Configuration

```yml
MyPage_Controller:
  managed_object: MyManageableObject
  extensions:
    - ManageableDataObjectExtension
MyManageableObject:
  extensions:
    - Dynamic\\ViewableDataObject\\Extensions\\ViewableDataObject
    - ManageableObjectDataExtension
  listing_page_class: MyPage
```

## MyManageableObject

To utilize ManageableDataObject you must implement `PermissionProvider` and methods defined in `ManageableDataObjectInterface`. The example below is a very basic implementation of the `PermissionProvider` and `ManageableDataObjectInterface` methods.

```php
<?php

class MyManageableObject extends DataObject implements PermissionProvider, ManageableDataObjectInterface
{

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
```


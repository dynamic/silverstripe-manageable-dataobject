<?php

/**
 * Class GridObject
 */
class ManageableObjectDataExtension extends DataExtension
{

    /**
     * Get the listing page to view this Event on (used in Link functions below)
     *
     * @return mixed
     */
    public function getListingPage()
    {

        $listingClass = $this->owner->config()->get('listing_page_class');

        if ($listingPage = $listingClass::get()->first()) {
            return $listingPage;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function getAddLink()
    {
        if ($this->owner->getListingPage()->hasMethod('Link') && $this->owner->canCreate(Member::currentUser())) {
            return $this->owner->getListingPage()->Link('add');
        }

        return false;
    }

    /**
     * @return bool|String
     */
    public function getEditLink()
    {
        if ($this->owner->getListingPage()->hasMethod('Link') && $this->owner->canEdit(Member::currentUser())) {
            $field = ($this->owner->config()->get('query_field'))
                ? $this->owner->config()->get('query_field')
                : 'ID';

            return Controller::join_links($this->owner->getListingPage()->Link('edit'), $this->owner->$field);
        }

        return false;
    }

    /**
     * @return bool|String
     */
    public function getDeleteLink()
    {
        if ($this->owner->getListingPage()->hasMethod('Link') && $this->owner->canDelete(Member::currentUser())) {
            $field = ($this->owner->config()->get('query_field'))
                ? $this->owner->config()->get('query_field')
                : 'ID';

            return Controller::join_links($this->owner->getListingPage()->Link('delete'), $this->owner->$field);
        }

        return false;
    }

}
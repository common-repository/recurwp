<?php
/**
 * This file is automatically created by Recurly's OpenAPI generation process
 * and thus any edits you make by hand will be lost. If you wish to make a
 * change to this file, please create a Github issue explaining the changes you
 * need and we will usher them to the appropriate places.
 */
namespace Recurly\Resources;

use Recurly\RecurlyResource;

// phpcs:disable
class ExportDates extends RecurlyResource
{
    private $_dates;
    private $_object;

    protected static $array_hints = [
        'setDates' => 'string',
    ];

    
    /**
    * Getter method for the dates attribute.
    * An array of dates that have available exports.
    *
    * @return array
    */
    public function getDates(): array
    {
        return $this->_dates ?? [] ;
    }

    /**
    * Setter method for the dates attribute.
    *
    * @param array $dates
    *
    * @return void
    */
    public function setDates(array $dates): void
    {
        $this->_dates = $dates;
    }

    /**
    * Getter method for the object attribute.
    * Object type
    *
    * @return ?string
    */
    public function getObject(): ?string
    {
        return $this->_object;
    }

    /**
    * Setter method for the object attribute.
    *
    * @param string $object
    *
    * @return void
    */
    public function setObject(string $object): void
    {
        $this->_object = $object;
    }
}
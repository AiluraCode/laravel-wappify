<?php

namespace AiluraCode\Wappify\Concern;

use AiluraCode\Wappify\Exceptions\PropertyNoExists;

/**
 * Trait IsValidable.
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 */
trait IsValidable
{
    /**
     * Validate if exists a property in an object.
     *
     * @param object $object   Object to validate
     * @param string $property Property to validate
     *
     * @return string The property value
     *
     * @throws PropertyNoExists If the property does not exist
     *
     * @since 1.0.0
     *
     * @version 1.0.0
     *
     * @author SiddharthaGF <livesanty_@hotmail.com>
     */
    public function validateProperty(object $object, string $property): string
    {
        if (!property_exists($object, $property)) {
            throw new PropertyNoExists($object, $property);
        }

        return $object->$property;
    }
}

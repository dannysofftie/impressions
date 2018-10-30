<?php

namespace Libraries;

/**
 * Provide JSON interfaces similar to JavaScript's stringify and parse
 */
class JSON
{

    /**
     * Encode an object to a json object
     *
     * @param [object] $object
     * @return string
     */
    public static function stringify($object)
    {
        if (!isset ($object)) {
            throw new \Exception('Expected an object array but found none!');
        }
        return json_encode($object);
    }

    /**
     * Retrieve string content from a json object
     *
     * @param [string] $value
     * @return mixed
     */
    public static function parse($value)
    {
        if (!isset ($value)) {
            throw new \Exception('Expected a string but found none!');
        }
        return json_decode($value);
    }
}
<?php

namespace Libraries;

/**
 * Provide JSON interfaces similar to JavaScript's stringify and parse
 */
class JSON
{

    /**
     * Provide a similar interface to JavaScript's JSON.stringify()
     * @throws
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
     * Provide a similar interface to JavaScript's JSON.parse()
     * @throws
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
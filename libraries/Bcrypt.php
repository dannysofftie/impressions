<?php
namespace Libraries;

/**
 * A top level midlleware for string encryption using Bcrypt algorithm,
 * provides a two functionalities:
 *  - A hashing utility,
 *  - A comparison utility which a string to a hash value
 */
class Bcrypt
{

    /**
     * Creates a hash for a string value
     *
     * @param [string] $value
     * @return string
     */
    public static function encrypt($value)
    {
        if (!isset($value)) {
            throw new Exception('Expected a string to encrypt!');
            return false;
        }
        // make hash
        $options = [
            'cost' => 11
        ];
        return password_hash($value, PASSWORD_BCRYPT, $options);
    }

    /**
     * Compares hash to a string value
     *
     * @param [string] $hash hash value from database
     * @param [string] $stringValue string value from client
     * @return boolean
     */
    public static function verify($hash, $stringValue)
    {
        if (!isset($hash) && !isset($stringValue)) {
            throw new Exception('A hash value and a string to compare expected');
            return false;
        }
        // compare stringValue to the hashValue passed
        return password_verify($stringValue, $hash);
    }
}

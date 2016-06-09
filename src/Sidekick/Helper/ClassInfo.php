<?php
/**
 * Helper for getting useful class information like:
 *  • Constant arrays for (for lists, dropdowns, etc.)
 *  • Filtered class name
 *  • Public method and property checks
 *
 * @package     Rootwork\Sidekick\Helper
 * @copyright   Copyright (c) 2016 Rootwork InfoTech LLC (www.rootwork.it)
 * @license     BSD 3-clause
 * @author      Mike Soule <mike@rootwork.it>
 * @filesource
 */

namespace Rootwork\Sidekick\Helper;

/**
 * Class information helper
 *
 * @package     Rootwork\Sidekick\Helper
 */
class ClassInfo
{

    /**
     * Constants
     */
    const CONSTANTS_FORMAT_NAME_NAME    = 'name.name';
    const CONSTANTS_FORMAT_NAME_VALUE   = 'name.value';
    const CONSTANTS_FORMAT_VALUE_VALUE  = 'value.value';

    /**
     * Get an array of filtered class constants.
     *
     * @param string|object $class
     *
     * @param string        $pattern The pattern to match in the constant name.
     * @param bool|integer  $pos     The exact position where $pattern
     *                               should appear. false = anywhere
     * @param string        $format
     *
     * @return array <code>
     *
     * <code>
     * class User
     * {
     * const ROLE_GUEST    = 'Guest';
     * const ROLE_USER     = 'User';
     * const ROLE_ADMIN    = 'Admin';
     *
     * const FIRST_PLACE   = '1st Place';
     * const SECOND_PLACE  = '2nd Place';
     * const THIRD_PLACE   = '3rd Place';
     *
     * const CLASS_ARISTOCRACY = 'Aristocracy';
     * const CLASS_PROLETARIAT = 'Proletariat';
     * const CLASS_PEASANTRY   = 'Peasantry';
     * }
     *
     * var_dump(ClassInfo::getFilteredConstants(User::class, 'ROLE'));
     * var_dump(ClassInfo::getFilteredConstants(User::class, 'ROLE', 0));
     * var_dump(ClassInfo::getFilteredConstants(User::class, '_PLACE'));
     *
     * Results:
     * array(4) {
     * 'ROLE_GUEST'        => Guest
     * 'ROLE_USER'         => User
     * 'ROLE_ADMIN'        => Admin
     * 'CLASS_PROLETARIAT' => Proletariat
     * }
     *
     * array(3) {
     * 'ROLE_GUEST'    => Guest
     * 'ROLE_USER'     => User
     * 'ROLE_ADMIN'    => Admin
     * }
     *
     * array(3) {
     * 'FIRST_PLACE'   => 1st Place
     * 'SECOND_PLACE'  => 2nd Place
     * 'THIRD_PLACE'   => 3rd Place
     * }
     * </code>
     */
    public static function getFilteredConstants(
        $class, $pattern, $pos = false, $format = self::CONSTANTS_FORMAT_NAME_VALUE
    )
    {
        $reflection = new \ReflectionClass($class);
        $constants  = $reflection->getConstants();
        $filtered   = [];

        foreach ($constants as $name => $value) {
            // Must match at the exact position
            if ($pos !== false and strpos($name, $pattern) === $pos) {
                $formatted  = self::getFormattedConstantKeyValue($name, $value, $format);
                $filtered   = $filtered + $formatted;
            }

            // Must match anywhere in name
            if ($pos === false and strpos($name, $pattern) !== false) {
                $formatted  = self::getFormattedConstantKeyValue($name, $value, $format);
                $filtered   = $filtered + $formatted;
            }
        }

        return $filtered;
    }

    /**
     * Get a filtered class name.
     *
     * Acts as a mix of get_class() and str_replace().
     * @see http://php.net/get_class
     * @see http://php.net/str_replace
     *
     * @param string|object $class
     * @param bool          $namespace
     * @param mixed         $search
     * @param mixed         $replace
     *
     * @return mixed|string
     */
    public static function getFilteredClassName(
        $class, $namespace = false, $search = null, $replace = ''
    ) {
        $name = is_object($class) ? get_class($class) : $class;

        if (!$namespace) {
            $parts  = explode('\\', $name);
            $name   = array_pop($parts);
        }

        if ($search) {
            $name = str_replace($search, $replace, $name);
        }

        return $name;
    }

    /**
     * Determine if a method is public.
     *
     * @param string|object $class
     * @param string        $name
     *
     * @return bool
     */
    public static function isPublicMethod($class, $name)
    {
        $reflection = new \ReflectionMethod($class, $name);

        return $reflection->isPublic();
    }

    /**
     * Determine if a class property is public.
     *
     * @param string|object $class
     * @param string        $name
     *
     * @return bool
     */
    public static function isPublicProperty($class, $name)
    {
        $reflection = new \ReflectionProperty($class, $name);

        return $reflection->isPublic();
    }

    /**
     * Get a formatted constant key => value pair.
     *
     * @param string    $name
     * @param mixed     $value
     * @param string    $format
     *
     * @return array
     */
    private static function getFormattedConstantKeyValue(
        $name, $value, $format
    ) {
        switch ($format) {
            case self::CONSTANTS_FORMAT_NAME_NAME:
                return [$name => $name];
            case self::CONSTANTS_FORMAT_NAME_VALUE:
                return [$name => $value];
            case self::CONSTANTS_FORMAT_VALUE_VALUE:
                return [$value => $value];
        }

        throw new \InvalidArgumentException('Invalid constant format given');
    }
}

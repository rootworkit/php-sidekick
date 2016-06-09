<?php
/**
 * ClassInfo helper as a trait
 *
 * @package     Rootwork\Sidekick\Helper\HelperTrait
 * @copyright   Copyright (c) 2016 Rootwork InfoTech LLC (www.rootwork.it)
 * @license     BSD 3-clause
 * @author      Mike Soule <mike@rootwork.it>
 * @filesource
 */

namespace Rootwork\Sidekick\Helper\HelperTraits;

use Rootwork\Sidekick\Helper\ClassInfo as Helper;

/**
 * Class information trait
 *
 * @package     Rootwork\Sidekick\Helper\HelperTrait
 */
trait ClassInfo
{

    /**
     * Get an array of filtered class constants.
     *
     * @param string       $pattern The pattern to match in the constant name.
     * @param bool|integer $pos     The exact position where $pattern
     *                              should appear. false = anywhere
     *
     * @param string       $format
     *
     * @return array <code>
     *
     * <code>
     * class User
     * {
     * use Rootwork\Sidekick\Helper\HelperTrait\ClassInfo;
     *
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
     * $user = new User();
     * var_dump(User::getFilteredConstants('ROLE'));
     * var_dump(User::getFilteredConstants('ROLE', 0));
     * var_dump(User::getFilteredConstants('_PLACE'));
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
        $pattern, $pos = false, $format = Helper::CONSTANTS_FORMAT_NAME_VALUE
    ) {
        return Helper::getFilteredConstants(
            __CLASS__, $pattern, $pos, $format
        );
    }

    /**
     * Get a filtered class name.
     *
     * @param bool   $namespace
     * @param null   $search
     * @param string $replace
     *
     * @return mixed|string
     */
    public static function getFilteredClassName(
        $namespace = false, $search = null, $replace = ''
    ) {
        return Helper::getFilteredClassName(
            __CLASS__, $namespace, $search, $replace
        );
    }

    /**
     * Determine if a class method is public.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function isPublicMethod($name)
    {
        return Helper::isPublicMethod(__CLASS__, $name);
    }

    /**
     * Determine if a class property is public.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function isPublicProperty($name)
    {
        return Helper::isPublicProperty(__CLASS__, $name);
    }
}

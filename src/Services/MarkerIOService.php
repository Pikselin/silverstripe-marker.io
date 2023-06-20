<?php

namespace Pikselin\MarkerIO\Services;

use SilverStripe\Core\Config\Configurable;

/**
 * Tiny MarkerIO helper for configs
 */
class MarkerIOService
{
    use Configurable;

    /**
     * @config
     * @var string Destination for MarkerIO
     */
    protected static $destination;

    /**
     * @config
     * @var array Users that should see the widget
     */
    protected static $allowed_members;

    /**
     * @config
     * @var array Groups that can see the widget
     */
    protected static $allowed_groups;

    protected static $show_in_dev;

    /**
     * @return mixed
     */
    public static function getAllowedMembers()
    {
        if (!self::$allowed_members) {
            self::$allowed_members = self::config()->get('allowed_members') ?? [];
        }

        return self::$allowed_members;
    }

    /**
     * @return mixed
     */
    public static function getAllowedGroups()
    {
        if (!self::$allowed_groups) {
            self::$allowed_groups = self::config()->get('allowed_groups') ?? [];
        }

        return self::$allowed_groups;
    }

    /**
     * @return string
     */
    public static function getDestination(): string
    {
        if (self::$destination === null) {
            self::$destination = self::config()->get('destination') ?? '';
        }

        return self::$destination;
    }

    /**
     * @return mixed
     */
    public static function getShowInDev()
    {
        if (self::$show_in_dev === null) {
            self::$show_in_dev = self::config()->get('show_in_dev') ?? false;
        }

        return self::$show_in_dev;
    }
}

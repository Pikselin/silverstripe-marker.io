<?php

namespace Pikselin\MarkerIO\Services;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\Security\PermissionProvider;

/**
 * Tiny MarkerIO helper for configs
 */
class MarkerIOService implements PermissionProvider
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

    /**
     * @config
     * @var bool show the widget in dev
     */
    protected static $show_in_dev;

    /**
     * @config
     * @var bool Allow anonymous access?
     */
    protected static $allow_anonymous;

    /**
     * Get specific members that are allowed
     * @return array
     */
    public static function getAllowedMembers()
    {
        if (!self::$allowed_members) {
            self::$allowed_members = self::config()->get('allowed_members') ?? [];
        }

        return self::$allowed_members;
    }

    /**
     * Get the allowed groups
     * @return array
     */
    public static function getAllowedGroups()
    {
        if (!self::$allowed_groups) {
            self::$allowed_groups = self::config()->get('allowed_groups') ?? [];
        }

        return self::$allowed_groups;
    }

    /**
     * Marker.IO "destination" key
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
     * Should show always when in dev?
     * @return bool
     */
    public static function getShowInDev()
    {
        if (self::$show_in_dev === null) {
            self::$show_in_dev = self::config()->get('show_in_dev') ?? false;
        }

        return self::$show_in_dev;
    }

    /**
     * Allow anonymous access?
     * @return bool
     */
    public static function getAllowAnonymous(): bool
    {
        if (self::$allow_anonymous === null) {
            self::$allow_anonymous = self::config()->get('allow_anonymous') ?? false;
        }

        return self::$allow_anonymous;
    }

    public function providePermissions()
    {
        return [
            'MARKERIO_GRANT_ACCESS' => [
                'name'     => _t(__CLASS__ . '.PERMISSION_GRANTACCESS_DESCRIPTION', 'Use Marker.IO'),
                'help'     => _t(__CLASS__ . '.PERMISSION_GRANTACCESS_HELP', 'Allow submitting bug/feature requests via Marker.IO.'),
                'category' => _t(__CLASS__ . '.PERMISSIONS_CATEGORY', 'MarkerIO'),
                'sort'     => 10
            ],
        ];
    }
}

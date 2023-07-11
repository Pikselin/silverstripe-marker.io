<?php

namespace Pikselin\MarkerIO\Extensions;

use Pikselin\MarkerIO\Services\MarkerIOService;
use SilverStripe\Control\Director;
use SilverStripe\Core\Extension;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;

class MarkerIOControllerExtension extends Extension
{

    public function onAfterInit($controller = null)
    {
        $conf = MarkerIOService::config()->get('destination');
        if (!empty($conf) && $this->shouldShow()) {
            Requirements::javascript('pikselin/silverstripe-markerio:dist/js/main.js');
            Requirements::insertHeadTags(<<<MARKERIO
<script type='text/javascript' id="markerio-id">window.markerio = "$conf";</script>
MARKERIO
            );
        }


    }

    /**
     * Check whether the widget should show.
     * @return bool
     */
    private function shouldShow(): bool
    {
        if (Director::isDev() && MarkerIOService::getShowInDev()) {
            return true;
        }

        if (MarkerIOService::getAllowAnonymous()) {
            return true;
        }

        $currentUser = Security::getCurrentUser();

        if ($currentUser) {
            // Check permission via config allowed users
            $allowedUsers = MarkerIOService::getAllowedMembers() ?? [];
            if (in_array($currentUser->Email, $allowedUsers) || in_array('*', $allowedUsers)) {
                return true;
            }
            // Check permission via config allowed groups
            $groups = MarkerIOService::getAllowedGroups() ?? [];
            if ($currentUser->inGroups($groups) || in_array('*', $groups)) {
                return true;
            }
            // Check permission via the CMS
            $permission = Permission::check('MARKERIO_GRANT_ACCESS', [], $currentUser);
            if ($permission !== false) {
                return true;
            }
        }

        return false;
    }
}

<?php

namespace Pikselin\MarkerIO\Extensions;

use Pikselin\MarkerIO\Services\MarkerIOService;
use SilverStripe\Control\Director;
use SilverStripe\Core\Extension;
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
        if (Director::isDev()) {
            return MarkerIOService::getShowInDev();
        }

        $currentUser = Security::getCurrentUser();
        if (MarkerIOService::getAllowAnonymous()) {
            return true;
        }

        if ($currentUser) {
            $allowedUsers = MarkerIOService::getAllowedMembers();
            if ($allowedUsers && in_array($currentUser->Email, $allowedUsers)) {
                return true;
            }
            $groups = MarkerIOService::getAllowedGroups();
            if ($groups && $currentUser->inGroups($groups)) {
                return true;
            }
            if ($allowedUsers[0] === '*' || $groups[0] === '*') {
                return true;
            }
        }

        return false;
    }
}

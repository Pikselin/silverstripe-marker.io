# silverstripe-marker.io
basic integration for marker.io with silverstripe

## Installation

`composer require pikselin/silverstripe-markerio`

## Configuration

```yaml
---
after:
    - PikselinMarkerIO
---
Pikselin\MarkerIO\Services\MarkerIOService:
    destination: 'mymarkeriokey'
    allowed_groups:
        - administrators
    allowed_members:
        - admin
    show_in_dev: false
    allow_anonymous: false
```

Allowed groups and allowed members are optional.

If none are given, nobody can see the widget.

To allow all users, or all groups, give it a value of `'*'`:

```yaml
allowed_groups:
    - '*'
```

(note the `'` quotes!)

## Permissions

A user can also be granted access to the widget, via the CMS.

It is a specific permission which can be set per-user.

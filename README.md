Jigoshop-Plugin-Dependencies
============================

A useful library for checking against the Jigoshop plugin before activating your own.

Features
------------

### Is Jigoshop activated
```php
<?php
is_jigoshop_active();
```

### Require a Jigoshop version
```php
<?php
is_jigoshop_active( '1.4.2' );
```

Usage
------------

You must call `is_jigoshop_active()` in your main plugin directory on `init`.

```php
<?php

function require_jigoshop() {
	require_once 'jigoshop-functions.php';
	is_jigoshop_active( '1.4.2' );
}

add_action('init', 'require_jigoshop');
```

Bug tracker
-----------

Have a bug? Please create an issue here on GitHub!

https://github.com/Geczy/Jigoshop-Plugin-Dependencies/issues/
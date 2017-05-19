# Amir PHP

A Simple package that includes various systems to get started on a PHP project without a heavy framework.

This is not an advanced PHP framework but a simple one for beginners or small projects.

This package can be easily modified and upgraded, no special set of skills are required.

## Includes

- Routing engine
- Base template
- Database connection
- Authentication system
- Session code
- Common methods

## Routing engine

A Simple routing system that works via the `.htaccess` and `base.html`.

Each state has it's own file based on it's name/url.

### Route class

In Route class you can easily add an state to your website, here's an example:

```php
Route::add("home", "/");
Route::add("sample", "/sample", "Sample Page - ");
Route::add("alert", "/alert", "Alert Page - ");
```

First line adds the homepage (default) with the unique name `home` and url `/` (root).

Note that the unique name (first parameter) should also be the file name (`home.php`)!

Second line adds an additional state called `sample`, the third parameter is the page title.

In the `include/route.php` file, the current route is set to the `$base` variable.

## Base template

The base template is loaded from the `base.php` file which is the core of project (like the `index.php`).

### Top of base

At the very top of base, the required files are included, `<html>`, `<body>` and other tags.
The current page is determined via the `$base` object (from route system).

### Middle section

In the middle of the `<body>` tag you'll see `<?php include $base->include; ?>`,
we're loading the current template file of state.
For example if you visit `/sample`, the `sample.php` file will be included.

### Footer section

At the bottom, we have the footer section where scripts are loaded, the authentication variables are assign to JS variable `auth`, so that all the authentication variables are available to the scripts of the app.

To add extra content for a certail page, for example `sample.php` file you can do:

```html
<?php $base->extra = "<script>console.debug('</> Hello, I am an extra script from sample!')</script>"; ?>
```

This additional footer content, will render after all the scripts.

### Alert system

If you set a value for the `$_SESSION["alert"]` variable, an alert will show up when rendering `base.php`, for example:

```php
Amir::setAlert("<b>Hey</b>, I'm an alert", "danger");
```

You can also show an alert via JS:

```php
Amir.Alert.show("This is a warning alert!", "warning");
```

### Extra scripts

Each state can have its own extra footer content, like an additional script only for that state,
which will be loaded after the scripts of the app are loaded.

## Database connection

Database connection happens in `/include/db.php`, change the default variables and connect to database.

On database error, you can show a custom message or redirect to another page.

### Alpha ID

It's not a good idea to show the primary key `id` from the database to html that users can see, you need to turn that `id` into an Alpha ID and use it that way, example:

```php
$user["id"] = Amir::aId($row["id"]) // Turn 1 into a
```

If you want to use the Alpha ID later:

```php
$id = Amir::aId($_POST["id"], true); // Turn a into 1
```

Note that the second parameter is `true` which will reverse the situation.

### Authentication system

To work with authentication of Amir PHP, just set the keys you'd like to use in the `Amir` class, for example:

```php
class Amir {

    public static $authenticationKeys = [
        ["isAuthenticated", false], ["id", 0], ["username", null], ["email", null]
    ];

    ...
}
```

Note that the second value is the default value of that key.

To authenticate the user, you must set all the values into the `$_SESSION["auth"]` array, for example:

```php
$_SESSION["auth"] = [
    "isAuthenticated" => true,
    "id" => $row["id"],
    "username" => $row["username"],
    "email" => $row["email"]
]
```

And after a page reload, user will be authenticated, to check user's authentication:

```php
if ($auth["isAuthenticated"]) {
    // User is logged in do stuff here
} else {
    // User is not logged in, treat user as a guest here
}
```

If you want to log the user out, just empty the `$_SESSION["auth"]` variable or
set the `$_SESSION["isAuthenticated"]` to false (if you use it).

You can change the authentication implementation in the `include/authenticate.php`.

## Session code

You can use the session code just like a `CSRF` token, here's an example:

```html
<input type="hidden" name="token" value="<?=Amir::generateSessionCode('code_login')?>">
```

And when trying to log the user in, just include the `include/validatecode.php` to validate the session code.

## Common methods

Some useful and common functions can be found in the `Amir` class, some of them are used by Amir PHP.

You can see them all in the `include/amir.php` or `Amir` class, for example:

```php
Amir::h(); // Htmlify
Amir::c(); // Clean
Amir::s(); // Slugify
Amir::ds();  // Deslugify
Amir::secure(); // Escape string
Amir::getTimeSince(); // Turn date into time since. (ex: "5 min(s) ago")
Amir::isAjax(); // True if request is ajax-like
...
```

You can easily customize each function and method to work best with your project and requirement.

# Installation

## Copy

Copy these files into your root directory:

- `.htaccess`
- `.base.php`
- `home.php`

Create a folder named `include/` and copy the below files into that folder:

- `amir.php`
- `authenticate.php`
- `db.php`
- `requirements.php`
- `route.php`
- `validatecode.php`

It's recommended to put all your assets into a folder called `assets/` or `static/` and load them from `base.php`.

To use the alert system, you need to load the `amir.css` and `amir.js` files.

## Configure

Open and edit `/include/db.php` and input your database information.

### Get started

If you work with ajax too, create a folder for all your form files like `form/`.

For example, you want to login via ajax, create a file at `form/account/login.php`:

```php
// Load all requirements
require "../../include/requirements.php";

// Validate (optional)
require "../../include/validatecode.php";

// Proceed to login
$username = $_POST["username"];
...
```

Here's the `/include/requirements.php`:

```php
require "../../include/amir.php";
require "../../include/db.php";
require "../../include/authenticate.php";
require "../../include/route.php";
```

# Contribute

If you find any bug, any way to improve or a better ways of doing things in Amir PHP,
your contribution is highly appreciated.

<?php

/**
 * Route
 *
 * Route class for all routes and states
 */
class Route {

    // Unique route name
    public $name;

    // Unique route url
    public $url;

    // Page title
    public $title;

    // File name to include
    public $include;

    // User friendly label
    public $label;

    // Extra footer content
    public $extra;

    protected static $instances = array();

    private function __construct($name, $url, $title) {
        $this->name = $name;
        $this->url = $url;
        $this->title = $title;
        $this->include = $name . ".php";
        $this->label = ucwords($name);
    }

    public static function currentPath() {
        // Get routing path
        $path = explode("/", $_SERVER["REQUEST_URI"]);
        array_shift($path);
        return $path;
    }

    public static function find($name) {

        if ($name instanceof Route) {
            return $name;
        }

        if (isset(static::$instances[$name])) {
            return static::$instances[$name];
        }

        return null;
    }

    public static function all() {
        return static::$instances;
    }

    public static function add($name, $url, $title = null) {
        return static::$instances[$name] = new static($name, $url, $title);
    }
}

// Let's add some routes
Route::add("home", "/");
Route::add("sample", "/sample", "Sample Page - ");
Route::add("alert", "/alert", "Alert Page - ");

// Default route
$base = Route::find("home");

// Check current route to use in base and pages
foreach (Route::all() as $route) {
    if (Route::currentPath()[0] === $route->name) {
        $base = $route;
        break;
    }
}
<?php

// Starting session usage
session_start();

/**
 * Amir
 *
 * Static class for common functions
 */
class Amir {

    // All authentication keys
    public static $auth_keys = [
        ["isAuthenticated", false], ["id", 0], ["username", null], ["email", null],
    ];

    // Htmlify
    public static function h($string) {
        return trim(str_replace("\n", "<br>", $string));
    }

    // Slugify
    public static function s($string, $lowercase = false) {

        $string = preg_replace('~[^\\pL\d]+~u', '-', $string);
        $string = trim($string, '-');
        $string = preg_replace('~[^-\w]+~', '', $string);

        return $lowercase ? strtolower($string) : $string;
    }

    // Deslugify
    public static function ds($string) {
        return str_replace('-', ' ', $string);
    }

    // Clean
    public static function c($string) {
        return trim(preg_replace('/\s\s+/', '', $string));
    }

    // Generate session code to use for forms
    public static function generate_session_code($name) {
        $code = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        $_SESSION["code"][$name] = $code;
        return $code;
    }

    // Check if it's a valid session code
    public static function is_valid_session_code($name, $code) {
        return hash_equals($_SESSION["code"][$name], $code) ? true : false;
    }

    // Secure and escape string
    public static function secure($handle, $string) {
        return mysqli_real_escape_string($handle, $string);
    }

    // Get time since via date
    public static function get_time_since($time) {

        $dateTime = DateTime::CreateFromFormat("Y-m-d H:i:s", $time);

        $year = $dateTime->format('Y');
        $month = $dateTime->format('m');
        $monthName = $dateTime->format('M');
        $day = $dateTime->format('d');
        $hour = $dateTime->format('H');
        $minute = $dateTime->format('i');

        if ($year != date('Y')) {
            return $year . " " . $monthName . " " . $day;
        } else if ($month != date('m')) {
            return $monthName . " " . $day;
        } else if ($day != date('d')) {
            return date('d') - $day . " Day(s) ago";
        } else if ($hour != date('H')) {
            return date('H') - $hour . " Hour(s) ago";
        } else if ($minute != date('i')) {
            return date('i') - $minute . " Min(s) ago";
        } else {
            return "Just now...";
        }
    }

    // If request is ajax-like
    public static function is_ajax() {
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) OR
            !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return false;
        }
        return true;
    }

    // Turn id into alpha id or reverse
    public static function a_id($in, $to_num = false, $pad_up = false, $pass_key = null) {
        $out = '';
        $index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base = strlen($index);

        if ($pass_key !== null) {

            for ($n = 0; $n < $base; $n++) {
                $i[] = substr($index, $n, 1);
            }

            $pass_hash = hash('sha256', $pass_key);
            $pass_hash = (strlen($pass_hash) < $base ? hash('sha512', $pass_key) : $pass_hash);

            for ($n = 0; $n < $base; $n++) {
                $p[] = substr($pass_hash, $n, 1);
            }

            array_multisort($p, SORT_DESC, $i);
            $index = implode($i);
        }

        if ($to_num) {
            // Digital number  <<--  alphabet letter code
            $len = strlen($in) - 1;

            for ($t = $len; $t >= 0; $t--) {
                $bcp = bcpow($base, $len - $t);
                $out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
            }

            if (is_numeric($pad_up)) {
                $pad_up--;

                if ($pad_up > 0) {
                    $out -= pow($base, $pad_up);
                }
            }

        } else {
            // Digital number  -->>  alphabet letter code
            if (is_numeric($pad_up)) {
                $pad_up--;

                if ($pad_up > 0) {
                    $in += pow($base, $pad_up);
                }
            }

            for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
                $bcp = bcpow($base, $t);
                $a = floor($in / $bcp) % $base;
                $out = $out . substr($index, $a, 1);
                $in = $in - ($a * $bcp);
            }
        }

        return $out;
    }

    // Make a url post
    public static function post($url, $fields) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    // Set alert
    public static function set_alert($content, $type = "info") {
        $_SESSION["alert"] = [
            "content" => $content,
            "type" => $type,
        ];
    }

    // Get alert
    public static function alert() {
        if (isset($_SESSION["alert"]) AND $_SESSION["alert"]["content"]) {
            return $_SESSION["alert"];
        };
        return false;
    }

    // Reset alert
    public static function clear_alert() {
        $_SESSION["alert"] = null;
    }
}

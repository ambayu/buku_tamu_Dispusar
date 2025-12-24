<?php

/**
 * PHP 5.3+ Polyfills for modern functions
 * Provides compatibility for password_*, random_bytes, hash_equals
 */

// ============================================
// random_bytes() polyfill for PHP < 7.0
// ============================================
if (!function_exists('random_bytes')) {
    function random_bytes($length)
    {
        if ($length < 1) {
            throw new Exception('Length must be greater than 0');
        }

        $bytes = '';

        // Try openssl_random_pseudo_bytes first (PHP 5.3+)
        if (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes($length, $strong);
            if ($bytes !== false && $strong === true) {
                return $bytes;
            }
        }

        // Try mcrypt_create_iv (deprecated in PHP 7.1, but available in PHP 5.3+)
        if (function_exists('mcrypt_create_iv')) {
            $bytes = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
            if ($bytes !== false) {
                return $bytes;
            }
        }

        // Fallback to /dev/urandom on Unix-like systems
        if (is_readable('/dev/urandom')) {
            $fp = fopen('/dev/urandom', 'rb');
            if ($fp !== false) {
                $bytes = fread($fp, $length);
                fclose($fp);
                if (strlen($bytes) === $length) {
                    return $bytes;
                }
            }
        }

        // Last resort: Use mt_rand (NOT cryptographically secure!)
        // This is not ideal but better than nothing
        for ($i = 0; $i < $length; $i++) {
            $bytes .= chr(mt_rand(0, 255));
        }

        return $bytes;
    }
}

// ============================================
// hash_equals() polyfill for PHP < 5.6
// ============================================
if (!function_exists('hash_equals')) {
    function hash_equals($known_string, $user_string)
    {
        if (!is_string($known_string)) {
            trigger_error('Expected known_string to be a string', E_USER_WARNING);
            return false;
        }

        if (!is_string($user_string)) {
            trigger_error('Expected user_string to be a string', E_USER_WARNING);
            return false;
        }

        $known_len = strlen($known_string);
        $user_len = strlen($user_string);

        // Return false if lengths don't match
        if ($known_len !== $user_len) {
            return false;
        }

        // Timing-safe comparison
        $result = 0;
        for ($i = 0; $i < $known_len; $i++) {
            $result |= (ord($known_string[$i]) ^ ord($user_string[$i]));
        }

        return $result === 0;
    }
}

// ============================================
// password_* functions polyfill for PHP < 5.5
// ============================================
if (!defined('PASSWORD_BCRYPT')) {
    define('PASSWORD_BCRYPT', 1);
}

if (!defined('PASSWORD_DEFAULT')) {
    define('PASSWORD_DEFAULT', PASSWORD_BCRYPT);
}

if (!function_exists('password_hash')) {
    function password_hash($password, $algo, $options = array())
    {
        if (!is_string($password)) {
            trigger_error('password_hash(): Password must be a string', E_USER_WARNING);
            return false;
        }

        if (!is_int($algo)) {
            trigger_error('password_hash(): Algorithm must be an integer', E_USER_WARNING);
            return false;
        }

        // Default cost
        $cost = isset($options['cost']) ? $options['cost'] : 10;

        // Validate cost
        if ($cost < 4 || $cost > 31) {
            trigger_error('password_hash(): Invalid bcrypt cost parameter', E_USER_WARNING);
            return false;
        }

        // Generate salt if not provided
        if (isset($options['salt'])) {
            // Using custom salt (deprecated but supported)
            $salt = $options['salt'];
        } else {
            // Generate random salt
            $raw_salt = random_bytes(16);
            $salt = substr(str_replace('+', '.', base64_encode($raw_salt)), 0, 22);
        }

        // Format: $2y$[cost]$[22 character salt]
        $hash = crypt($password, sprintf('$2y$%02d$%s', $cost, $salt));

        if (!is_string($hash) || strlen($hash) < 60) {
            return false;
        }

        return $hash;
    }
}

if (!function_exists('password_verify')) {
    function password_verify($password, $hash)
    {
        if (!is_string($password) || !is_string($hash)) {
            return false;
        }

        $computed_hash = crypt($password, $hash);

        if (!is_string($computed_hash) || strlen($computed_hash) !== strlen($hash)) {
            return false;
        }

        return hash_equals($hash, $computed_hash);
    }
}

if (!function_exists('password_needs_rehash')) {
    function password_needs_rehash($hash, $algo, $options = array())
    {
        if (!is_string($hash)) {
            return false;
        }

        $cost = isset($options['cost']) ? $options['cost'] : 10;

        // Extract cost from hash
        $hash_parts = explode('$', $hash);
        if (count($hash_parts) < 4) {
            return true;
        }

        $current_cost = intval($hash_parts[2]);

        // Check if algorithm or cost has changed
        if ($algo !== PASSWORD_BCRYPT || $cost !== $current_cost) {
            return true;
        }

        return false;
    }
}

if (!function_exists('password_get_info')) {
    function password_get_info($hash)
    {
        if (!is_string($hash)) {
            return array(
                'algo' => 0,
                'algoName' => 'unknown',
                'options' => array()
            );
        }

        $hash_parts = explode('$', $hash);

        if (count($hash_parts) >= 4 && ($hash_parts[1] === '2y' || $hash_parts[1] === '2a' || $hash_parts[1] === '2x')) {
            return array(
                'algo' => PASSWORD_BCRYPT,
                'algoName' => 'bcrypt',
                'options' => array(
                    'cost' => intval($hash_parts[2])
                )
            );
        }

        return array(
            'algo' => 0,
            'algoName' => 'unknown',
            'options' => array()
        );
    }
}

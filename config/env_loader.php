<?php

/**
 * Simple .env file loader - PHP 5.3+ Compatible
 * Loads environment variables from .env file
 */

if (!function_exists('loadEnv')) {
    function loadEnv($path)
    {
        if (!file_exists($path)) {
            return false;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse line
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);

                // Remove quotes if present
                if (preg_match('/^(["\'])(.*)\\1$/', $value, $matches)) {
                    $value = $matches[2];
                }

                // Set as constant if not already defined
                if (!defined($name)) {
                    define($name, $value);
                }

                // Also set in $_ENV for compatibility
                $_ENV[$name] = $value;
            }
        }

        return true;
    }
}

if (!function_exists('env')) {
    /**
     * Get environment variable value
     * @param string $key Key name
     * @param mixed $default Default value if not found
     * @return mixed
     */
    function env($key, $default = null)
    {
        if (defined($key)) {
            return constant($key);
        }

        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }

        return $default;
    }
}

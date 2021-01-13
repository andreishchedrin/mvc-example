<?php

namespace app\core;

/**
 * Class Session
 *
 * @package app\core
 */

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function set(string $key, string $message): void
    {
        $_SESSION['flash'][$key] = $message;
    }

    public function get(string $key): string
    {
        $message = $_SESSION['flash'][$key] ?? null;
        if ($message) {
            unset($_SESSION['flash'][$key]);
        }
        return $message;
    }

    public function isSet(string $key)
    {
        return isset($_SESSION['flash'][$key]) ? true : false;
    }
}

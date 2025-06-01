<?php

return [
    "cookieName" => "dt_token",
    "cookieDomain" => env("CUSTOM_COOKIE_DOMAIN", "localhost"),
    "cookieExpires" => 480, // in minutes
    "cookiePath" => "/",
    "cookieSecure" => env("SESSION_SECURE_COOKIE", false),
    "cookieHttpOnly" => true,
];
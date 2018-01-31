<?php


return [
    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.gmail.com'),
    'port' => env('MAIL_PORT', 587),
    'from' => ['address' => 'blackjackdadexame@gmail.com', 'name' => 'blackjackdadexame'],
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    
    'username' => env('MAIL_USERNAME','blackjackdadexame@gmail.com'),
    'password' => env('MAIL_PASSWORD', 'secret123'),
    'sendmail' => '/usr/sbin/sendmail -bs',
];
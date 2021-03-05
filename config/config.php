<?php

return [
    'database'    => [
        'adapter'  => getenv('DB_ADAPTER'),
        'host'     => getenv('DB_HOST'),
        'port'     => getenv('DB_PORT'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'dbname'   => getenv('DB_NAME'),
    ],
    'application' => [
        'baseUri'         => PROJECT_PATH,
        'publicUrl'       => getenv('APP_PUBLIC_URL'),
        'cryptSalt'       => getenv('APP_CRYPT_SALT'),
        'viewsDir'        => APP_PATH . '/Views/default',
        'controllersDir'  => APP_PATH . '/Controllers/',
        'modelsDir'       => APP_PATH . '/Models/',
        'cacheDir'        => root_path('var/cache/'),
        'sessionSavePath' => root_path('var/cache/session/'),
    ],
    'mail'        => [
        'fromName'  => getenv('MAIL_FROM_NAME'),
        'fromEmail' => getenv('MAIL_FROM_EMAIL'),
        'smtp'      => [
            'server'   => getenv('MAIL_SMTP_SERVER'),
            'port'     => getenv('MAIL_SMTP_PORT'),
            'security' => getenv('MAIL_SMTP_SECURITY'),
            'username' => getenv('MAIL_SMTP_USERNAME'),
            'password' => getenv('MAIL_SMTP_PASSWORD'),
        ],
    ],
    'logger'      => [
        'path'     => root_path('var/logs/'),
        'format'   => '%date% [%type%] %message%',
        'date'     => 'D j H:i:s',
        'logLevel' => Logger::DEBUG,
        'filename' => 'application.log',
    ],
    // Set to false to disable sending emails (for use in tests environment)
    'useMail'     => true,
];
<?php

return array(
    'db' => array(
        'adapters' => array(
            'db_english_media' => array(
                'driver'         => 'Pdo',
                'dsn'            => 'mysql:dbname=staging.em.traveldreams.vn;host=localhost',
                'username' => 'developer',
                'password' => 'kiss259',
                'driver_options' => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                ),
            ),

            'db_dictionary' => array(
                'driver'         => 'Pdo',
                'dsn'            => 'mysql:dbname=dictionary.traveldreams.vn;host=localhost',
                'username' => 'developer',
                'password' => 'kiss259',
                'driver_options' => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                ),
            ),
        ),
    ),

    'application' => array(
        'path_upload' => '/home/web/data/test.em.traveldreams.vn',
    ),
);
<?php

return array(
    'db' => array(
        'adapters' => array(
            'db_english_media' => array(
                'driver'         => 'Pdo',
                'dsn'            => 'mysql:dbname=em.traveldreams.vn;host=localhost',
                'username' => 'live',
                'password' => 'kiss259',
                'driver_options' => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                ),
            ),

            'db_dictionary' => array(
                'driver'         => 'Pdo',
                'dsn'            => 'mysql:dbname=dictionary.traveldreams.vn;host=localhost',
                'username' => 'live',
                'password' => 'kiss259',
                'driver_options' => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                ),
            ),
        ),
    ),

    'application' => array(
        'path_upload' => '/home/web/data/live.em.traveldreams.vn/uploads',
    ),
);
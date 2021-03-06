<?php
// This is the main YiiCart configuration.
return array(
    'name' => 'Yii Cart',
    'language' => 'en',
    'theme' => 'classic',
    // application components
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=yiicart',
            'emulatePrepare' => true,
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
        ),
    ),
    // global params
    'params' => array(
        'imagePath' => '/var/www/YiiCart/image/',
    ),
);
?>
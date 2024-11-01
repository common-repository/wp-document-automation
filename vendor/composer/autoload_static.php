<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit09a4b6111c8ff12907fc3e6ffde6b336
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WP\\Plugin\\DocumentAutomation\\' => 29,
        ),
        'P' => 
        array (
            'Psr\\Container\\' => 14,
        ),
        'O' => 
        array (
            'OA_WP_Library\\' => 14,
            'OA\\OpenDocument\\FlatXML\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WP\\Plugin\\DocumentAutomation\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'OA_WP_Library\\' => 
        array (
            0 => __DIR__ . '/..' . '/outsourceappz/wp-library/src',
        ),
        'OA\\OpenDocument\\FlatXML\\' => 
        array (
            0 => __DIR__ . '/..' . '/outsourceappz/flat-xml-opendocument-reader-writer/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Pimple' => 
            array (
                0 => __DIR__ . '/..' . '/pimple/pimple/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit09a4b6111c8ff12907fc3e6ffde6b336::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit09a4b6111c8ff12907fc3e6ffde6b336::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit09a4b6111c8ff12907fc3e6ffde6b336::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}

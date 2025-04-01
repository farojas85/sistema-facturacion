<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit057431fa1d463b86235299ac44da1faa
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Picqer\\Barcode\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Picqer\\Barcode\\' => 
        array (
            0 => __DIR__ . '/..' . '/picqer/php-barcode-generator/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit057431fa1d463b86235299ac44da1faa::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit057431fa1d463b86235299ac44da1faa::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit057431fa1d463b86235299ac44da1faa::$classMap;

        }, null, ClassLoader::class);
    }
}

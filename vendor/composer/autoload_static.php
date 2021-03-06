<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7a593771796e69c6c3e1a73c814fa025
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Inc\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Inc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7a593771796e69c6c3e1a73c814fa025::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7a593771796e69c6c3e1a73c814fa025::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7a593771796e69c6c3e1a73c814fa025::$classMap;

        }, null, ClassLoader::class);
    }
}

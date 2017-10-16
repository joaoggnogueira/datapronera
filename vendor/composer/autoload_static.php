<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit29ef6e1e74bc7c18086c47b300936739
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'ReCaptcha\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ReCaptcha\\' => 
        array (
            0 => __DIR__ . '/..' . '/google/recaptcha/src/ReCaptcha',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit29ef6e1e74bc7c18086c47b300936739::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit29ef6e1e74bc7c18086c47b300936739::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

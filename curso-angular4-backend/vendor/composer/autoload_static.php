<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3d04b1a01fdeec0f614cde15f527ab71
{
    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
    );

    public static $classMap = array (
        'PiramideUploader' => __DIR__ . '/../..' . '/piramide-uploader/PiramideUploader.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit3d04b1a01fdeec0f614cde15f527ab71::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit3d04b1a01fdeec0f614cde15f527ab71::$classMap;

        }, null, ClassLoader::class);
    }
}
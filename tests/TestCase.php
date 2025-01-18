<?php

namespace CompressMyPhotos\Image\Tests;

use CompressMyPhotos\Image\CompressMyPhotosServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            CompressMyPhotosServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Load the views
        app('view')->addNamespace('compress-my-photos', __DIR__.'/../resources');
    }
}

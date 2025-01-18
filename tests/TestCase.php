<?php

namespace CompressMyPhotos\Image\Tests;

use CompressMyPhotos\Image\CompressMyPhotosServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            CompressMyPhotosServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Perform any environment setup
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Load the views
        $this->app['view']->addNamespace('compress-my-photos', __DIR__.'/../resources');
    }
}

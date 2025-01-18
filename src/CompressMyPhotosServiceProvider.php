<?php

namespace CompressMyPhotos\Image;

use Illuminate\Support\ServiceProvider;
use CompressMyPhotos\Image\View\Components\Image;

class CompressMyPhotosServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources', 'compress-my-photos');

        $this->publishes([
            __DIR__.'/../resources' => resource_path('views/vendor/compress-my-photos'),
        ], 'views');

        $this->loadViewComponentsAs('compress-my-photos', [
            Image::class,
        ]);
    }

    public function register()
    {
        //
    }
}

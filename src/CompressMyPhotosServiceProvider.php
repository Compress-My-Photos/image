<?php

namespace CompressMyPhotos\Image;

use CompressMyPhotos\Image\View\Components\Image;
use Illuminate\Support\ServiceProvider;

class CompressMyPhotosServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources', 'compress-my-photos');

        $this->publishes([
            __DIR__.'/../resources' => resource_path('views/vendor/compress-my-photos'),
        ], 'views');

        $this->loadViewComponentsAs('compress-my-photos', [
            Image::class,
        ]);
    }

    public function register(): void
    {
        //
    }
}

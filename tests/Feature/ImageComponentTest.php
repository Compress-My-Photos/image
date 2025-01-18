<?php

namespace CompressMyPhotos\Image\Tests\Feature;

use CompressMyPhotos\Image\View\Components\Image;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

beforeEach(function () {
    Config::set('compress-my-photos.api_url', 'https://example.com');
    Config::set('compress-my-photos.api_key', 'test_key');
});

it('can be instantiated', function () {
    $component = new Image(1);
    expect($component)->toBeInstanceOf(Image::class);
});

it('renders correctly', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['url' => 'https://example.com/image.jpg', 'alt' => 'Test Image']) ?: '')
    ]);

    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    $component = new Image(
        1,
        75,
        0,
        null,
        false,
        false,
        'webp',
        false,
        false,
        false,
        $client
    );
    $view = $component->render();
    expect($view)->toBeInstanceOf(View::class);

    if ($view instanceof View) {
        expect($view->getName())->toBe('compress-my-photos::image');
    }
});

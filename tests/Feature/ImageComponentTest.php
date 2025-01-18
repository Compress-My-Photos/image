<?php

use CompressMyPhotos\Image\View\Components\Image;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

beforeEach(function () {
    Config::set('compress-my-photos.api_url', 'https://example.com');
    Config::set('compress-my-photos.api_key', 'test_key');
});

it('can be instantiated', function () {
    $component = new Image(1);
    expect($component)->toBeInstanceOf(Image::class);
});

it('renders correctly', function () {
    // Create a mock response
    $mock = new MockHandler([
        new Response(200, [], json_encode(['url' => 'https://example.com/image.jpg', 'alt' => 'Test Image']))
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
    expect($view)->toBeInstanceOf(\Illuminate\View\View::class)
        ->and($view->getName())->toBe('compress-my-photos::image');
});

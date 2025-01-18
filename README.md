# CompressMyPhotos Image

CompressMyPhotos Image is a Laravel package that provides an easy-to-use Blade component for rendering optimized images using the CompressMyPhotos API.

## Installation

You can install the package via composer:

```bash
composer require compressmyphotos/image
```

## Configuration

After installation, publish the configuration file:

```bash
php artisan vendor:publish --provider="CompressMyPhotos\Image\CompressMyPhotosServiceProvider" --tag="config"
```

This will create a `compress-my-photos.php` configuration file in your `config` directory. Update it with your CompressMyPhotos API credentials:

```php
return [
    'api_url' => env('COMPRESS_MY_PHOTOS_API_URL', 'https://api.compressmyphotos.com'),
    'api_key' => env('COMPRESS_MY_PHOTOS_API_KEY'),
    'default_quality' => env('COMPRESS_MY_PHOTOS_DEFAULT_QUALITY', 75),
    'default_format' => env('COMPRESS_MY_PHOTOS_DEFAULT_FORMAT', 'webp'),
];
```

Make sure to add your API key to your **.env** file:

## Usage
You can use the `<x-compress-my-photos-image>` component in your Blade templates:

```bladehtml
<x-compress-my-photos-image 
    :id="123" 
    :quality="80" 
    :blur="0" 
    :sepia="false" 
    :grayscale="false" 
    format="webp" 
    :lazy="true"
/>
```

## Available Options
- id (required): The ID of the image in the CompressMyPhotos system.
- quality (optional, default: 75): The quality of the image (0-100).
- blur (optional, default: 0): The blur level of the image.
- sepia (optional, default: false): Apply sepia filter.
- grayscale (optional, default: false): Convert to grayscale.
- format (optional, default: 'webp'): The output format of the image.
- lazy (optional, default: false): Enable lazy loading.
- oilpaint (optional, default: false): Apply oil paint effect.
- flip (optional, default: null): Flip the image ('horizontal', 'vertical', or null).
- preload (optional, default: false): Preload the image.

## Testing

```bash
composer test
```

## Contributing
Please see CONTRIBUTING for details.

## Security Vulnerabilities
If you discover any security related issues, please email info@compressmy.photos instead of using the issue tracker.

## License
The MIT License (MIT). Please see License File for more information.

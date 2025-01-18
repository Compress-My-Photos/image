<?php

return [
    'api_url' => env('COMPRESS_MY_PHOTOS_API_URL', 'https://compressmyphotos.com/'),
    'api_key' => env('COMPRESS_MY_PHOTOS_API_KEY'),
    'default_quality' => env('COMPRESS_MY_PHOTOS_DEFAULT_QUALITY', 75),
    'default_format' => env('COMPRESS_MY_PHOTOS_DEFAULT_FORMAT', 'webp'),
];

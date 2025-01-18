<?php

namespace CompressMyPhotos\Image\View\Components;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Image extends Component
{
    public int|string $id;
    public int $quality;
    public int $blur;
    public bool $sepia;
    public bool $oilpaint;
    public bool $grayscale;
    public bool $lazy;
    public bool $preload;
    public ?string $imageUrl = null;
    public ?string $altText = null;
    public ?string $format = 'webp';
    public ?string $flip = null;
    public ?string $errorMessage = null;
    public bool $isLoading = true;
    public ?int $imageWidth = null;
    public ?int $imageHeight = null;

    /**
     * @var array<int, string>
     */
    public array $urls = [];

    protected Client $client;

    public function __construct(
        int|string $id,
        int $quality = 75,
        int $blur = 0,
        ?string $flip = null,
        bool $sepia = false,
        bool $grayscale = false,
        string $format = 'webp',
        bool $oilpaint = false,
        bool $lazy = false,
        bool $preload = false,
        ?Client $client = null
    ) {
        $this->id = $id;
        $this->quality = $quality;
        $this->blur = $blur;
        $this->oilpaint = $oilpaint;
        $this->format = $format;
        $this->sepia = $sepia;
        $this->flip = $flip;
        $this->grayscale = $grayscale;
        $this->lazy = $lazy;
        $this->preload = $preload;
        $this->isLoading = true;
        $this->client = $client ?? new Client();

        $this->fetchImageData();

        if ($this->imageUrl !== null) {
            $this->generateUrls();
        }
        $this->isLoading = false;
    }

    private function fetchImageData(): void
    {
        try {
            $baseUrl = Config::get('compress-my-photos.api_url');
            $endpoint = rtrim($baseUrl, '/') . "/api/image-data/{$this->id}";

            $response = $this->client->get($endpoint, [
                'query' => [
                    'quality' => $this->quality,
                    'blur' => $this->blur,
                    'oilpaint' => (bool) $this->oilpaint,
                    'sepia' => (bool) $this->sepia,
                    'format' => $this->format,
                    'flip' => $this->flip,
                    'grayscale' => (bool) $this->grayscale,
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . Config::get('compress-my-photos.api_key'),
                ],
            ]);

            $json = json_decode((string) $response->getBody(), true);

            if (isset($json['url'], $json['alt'])) {
                $this->imageUrl = $json['url'];
                $this->altText = $json['alt'];

                if (isset($json['width']) && is_numeric($json['width'])) {
                    $this->imageWidth = (int) $json['width'];
                }
                if (isset($json['height']) && is_numeric($json['height'])) {
                    $this->imageHeight = (int) $json['height'];
                }
            } else {
                $this->errorMessage = 'Missing url or alt in the API response.';
            }
        } catch (GuzzleException $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    private function generateUrls(): void
    {
        if ($this->imageUrl === null) {
            return;
        }

        $originalWidth = $this->imageWidth ?: 1920;
        $breakpoints = [320, 640, 768, 1024, 1280, 1536, 1920];
        $filtered = array_filter($breakpoints, fn ($bp) => $bp <= $originalWidth);

        if (!in_array($originalWidth, $filtered)) {
            $filtered[] = $originalWidth;
            sort($filtered);
        }

        foreach ($filtered as $bp) {
            $this->urls[$bp] = $this->imageUrl . (str_contains($this->imageUrl, '?') ? '&' : '?') . "width={$bp}";
        }
    }

    public function render(): View
    {
        return view('compress-my-photos::image');
    }
}

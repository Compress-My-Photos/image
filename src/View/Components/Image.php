<?php

namespace CompressMyPhotos\Image\View\Components;

use Illuminate\View\Component;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\View\View;
use Illuminate\Support\Facades\Config;

class Image extends Component
{
    /**
     * Same properties as before:
     */
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
    public array $urls = [];
    public bool $isLoading = true;

    // The API may provide dimensions
    public ?int $imageWidth = null;
    public ?int $imageHeight = null;
    protected $client;

    /**
     * Create the component instance.
     */
    public function __construct(
        int|string $id,
        int        $quality = 75,
        int        $blur = 0,
        string     $flip = null,
        bool       $sepia = false,
        bool       $grayscale = false,
        string     $format = 'webp',
        bool       $oilpaint = false,
        bool       $lazy = false,
        bool       $preload = false,
        ?Client $client = null
    ) {
        $this->id         = $id;
        $this->quality    = $quality;
        $this->blur       = $blur;
        $this->oilpaint   = $oilpaint;
        $this->format     = $format;
        $this->sepia      = $sepia;
        $this->flip       = $flip;
        $this->grayscale  = $grayscale;
        $this->lazy       = $lazy;
        $this->preload    = $preload;
        $this->isLoading  = true;

        // Fetch data (URL, alt text, maybe width/height)
        $this->fetchImageData();
        $this->client = $client ?? new Client();

        // If we have a valid URL, generate breakpoints (srcset).
        if ($this->imageUrl) {
            $this->generateUrls();
        }
        $this->isLoading = false;
    }

    /**
     * Gather all data from the external API.
     */
    private function fetchImageData(): void
    {
        try {
            $baseUrl  = Config::get('compress-my-photos.api_url');
            $endpoint = rtrim($baseUrl, '/') . "/api/image-data/{$this->id}";

            $client   = new Client();
            $response = $client->get($endpoint, [
                'query' => [
                    'quality'   => $this->quality,
                    'blur'      => $this->blur,
                    'oilpaint'  => (bool)$this->oilpaint,
                    'sepia'     => (bool)$this->sepia,
                    'format'    => $this->format,
                    'flip'      => $this->flip,
                    'grayscale' => (bool)$this->grayscale,
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . Config::get('compress-my-photos.api_key'),
                ],
            ]);


            $json = json_decode((string)$response->getBody(), true);

            if (isset($json['url'], $json['alt'])) {
                $this->imageUrl = $json['url'];
                $this->altText  = $json['alt'];

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

    /**
     * Generate responsive breakpoints for srcset.
     */
    private function generateUrls(): void
    {
        // If no official width from the API, default to e.g. 1920.
        $originalWidth = $this->imageWidth ?: 1920;

        // Standard breakpoints (adjust to your needs).
        $breakpoints = [320, 640, 768, 1024, 1280, 1536, 1920];

        // Only keep those below or equal to the original
        $filtered = array_filter($breakpoints, fn($bp) => $bp <= $originalWidth);

        // Also ensure the original (if not already included)
        if (! in_array($originalWidth, $filtered)) {
            $filtered[] = $originalWidth;
            sort($filtered);
        }

        // Build srcset URLs
        foreach ($filtered as $bp) {
            if (str_contains($this->imageUrl, '?')) {
                $this->urls[$bp] = $this->imageUrl . "&width={$bp}";
            } else {
                $this->urls[$bp] = $this->imageUrl . "?width={$bp}";
            }
        }
    }

    /**
     * Render method returns the existing Blade file.
     */
    public function render(): View
    {
        return view('compress-my-photos::image');
    }
}

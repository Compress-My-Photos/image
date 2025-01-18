@if ($lazy)
    <div class="image-container" style="position: relative; width: 100%; height: auto;">
        <div class="placeholder"
             style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #f0f0f0;">
            @if(isset($placeholder))
                {{ $placeholder }}
            @else
                <div class="animate-pulse bg-gray-200" style="width: 100%; height: 100%;"></div>
            @endif
        </div>

        @php
            $finalWidth  = $imageWidth  ?: 1920;
            $finalHeight = $imageHeight ?: 1080;
        @endphp

        <img
            alt="{{ $altText }}"
            loading="lazy"
            decoding="async"

            width="{{ $finalWidth }}"
            height="{{ $finalHeight }}"

            style="display: block; width: 100%; height: auto; opacity: 0; transition: opacity 0.5s;"

            sizes="(max-width: 600px) 100vw,
                   (max-width: 1024px) 50vw,
                   {{ $finalWidth }}px"

            srcset="{{ collect($urls)->map(fn($url, $bp) => "$url {$bp}w")->join(', ') }}"
            src="{{ end($urls) ?: $imageUrl }}"
            onload="
                this.style.opacity=1;
                this.previousElementSibling.style.display='none';
            "
        />
    </div>
@else
    @php
        $finalWidth  = $imageWidth  ?: 1920;
        $finalHeight = $imageHeight ?: 1080;
    @endphp

    <img
        alt="{{ $altText }}"
        width="{{ $finalWidth }}"
        height="{{ $finalHeight }}"
        style="display: block; width: 100%; height: auto;"

        sizes="(max-width: 600px) 100vw,
               (max-width: 1024px) 50vw,
               {{ $finalWidth }}px"

        srcset="{{ collect($urls)->map(fn($url, $bp) => "$url {$bp}w")->join(', ') }}"
        src="{{ end($urls) ?: $imageUrl }}"
    />
@endif

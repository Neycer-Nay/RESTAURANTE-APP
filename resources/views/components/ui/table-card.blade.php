@props(['title' => '', 'subtitle' => null])

<section class="card">
    <header class="card-head">
        <div>
            <h2 class="card-title">{{ $title }}</h2>
            @if ($subtitle)
                <p class="card-subtitle">{{ $subtitle }}</p>
            @endif
        </div>

        @isset($actions)
            <div class="card-actions">{{ $actions }}</div>
        @endisset
    </header>

    <div class="card-content">
        {{ $slot }}
    </div>
</section>

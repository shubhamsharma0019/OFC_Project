@php
    $manifestPath = public_path('build/manifest.json');
    $manifest = file_exists($manifestPath)
        ? json_decode(file_get_contents($manifestPath), true)
        : [];

    $assetEntries = [
        'resources/css/app.css' => 'style',
        'resources/js/app.js' => 'script',
    ];
@endphp

@foreach ($assetEntries as $entry => $type)
    @php $file = $manifest[$entry]['file'] ?? null; @endphp

    @if ($file && $type === 'style')
        <link rel="stylesheet" href="{{ asset('build/' . $file) }}">
    @elseif ($file && $type === 'script')
        <script type="module" src="{{ asset('build/' . $file) }}"></script>
    @endif
@endforeach

@php
    $files = $getFiles();
    $fragment = $getPdfUrlFragment();
    $height = $getPdfPreviewHeight();
    $isDownloadable = $isDownloadable();
    $isOpenable = $isOpenable();
    $label = $getLabel();
@endphp

<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    @if (empty($files))
        <div class="asmit-pdf-entry-placeholder">
            {{ $getPlaceholder() }}
        </div>
    @else
        <div class="asmit-pdf-entry">
            @foreach ($files as $url => $name)
                <div>
                    <iframe
                        src="{{ $url . $fragment }}"
                        title="{{ $label ?: $name }}"
                        loading="lazy"
                        class="asmit-pdf-entry-frame"
                        style="height: {{ $height }}px"
                    ></iframe>

                    @if ($isOpenable || $isDownloadable)
                        <div class="asmit-pdf-entry-actions">
                            @if ($isOpenable)
                                <x-filament::link
                                    :href="$url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    icon="heroicon-m-arrow-top-right-on-square"
                                >
                                    {{ __('Open') }}
                                </x-filament::link>
                            @endif

                            @if ($isDownloadable)
                                {{-- ponytail: the `download` attribute is ignored cross-origin (e.g. S3), where the browser opens the file instead --}}
                                <x-filament::link
                                    :href="$url"
                                    :download="$name"
                                    icon="heroicon-m-arrow-down-tray"
                                >
                                    {{ __('Download') }}
                                </x-filament::link>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</x-dynamic-component>

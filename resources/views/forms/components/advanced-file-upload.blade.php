@php 
    use Filament\Support\Facades\FilamentView;
    use Filament\Support\Facades\FilamentAsset;

    // TODO: do later
    $pdfPreviewHeight = 320;
    $scrollbar = 1;
    $displayPage = 3;
    $toolbar = false;
    $navPanes = false;
    $statusBar = false;
    $zoom = false;
    $view = "fitH";
@endphp

<div>
    <div 
    x-data="uploadPdf({
        pdfPreviewHeight: @js($pdfPreviewHeight),
        pdfScrollbar: @js($scrollbar),
        pdfDisplayPage: @js($displayPage),
        pdfToolbar: @js($toolbar),
        pdfNavPanes: @js($navPanes),
        pdfStatusBar: @js($statusBar),
        pdfZoom: @js($zoom),
        pdfView: @js($view)
    })"
    @if (FilamentView::hasSpaMode())
        {{-- format-ignore-start --}}x-load="visible || event (ax-modal-opened)"{{-- format-ignore-end --}}
    @else
        x-load
    @endif 
    x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filepond-pdf', 'asmit/filament-upload') }}"
    x-load-css="[@js(FilamentAsset::getStyleHref(id: 'filepond-pdf', package: 'asmit/filament-upload'))]"
    wire:ignore
    >
        @include('filament-forms::components.file-upload')
    </div>
</div>
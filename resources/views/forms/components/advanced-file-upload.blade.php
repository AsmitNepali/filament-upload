@php
    use Filament\Support\Facades\FilamentView;
    use Filament\Support\Facades\FilamentAsset;

    // TODO
    $pdfPreviewHeight = $getPdfPreviewHeight() ;
    $pdfScrollbar = 1;
    $pdfDisplayPage = $getPdfDisplayPage();
    $pdfToolbar = $getPdfToolbar();
    $pdfNavePanes = $getPdfNavPanes();
    $pdfZoomLevel = $getPdfZoomLevel();
    $pdfView = $getPdfFitType();
@endphp

<div>
    <div
        x-data="uploadPdf({
        pdfPreviewHeight: @js($pdfPreviewHeight),
        pdfScrollbar: @js($pdfScrollbar),
        pdfDisplayPage: @js($pdfDisplayPage),
        pdfToolbar: @js($pdfToolbar),
        pdfNavPanes: @js($pdfNavePanes),
        pdfZoom: @js($pdfZoomLevel),
        pdfView: @js($pdfView)
    })"
        @if (FilamentView::hasSpaMode())
            x-load="visible || event (ax-modal-opened)"
        @else
            x-load
        @endif
        x-load-src="{{ FilamentAsset::getAlpineComponentSrc('filepond-pdf', 'asmit/filament-upload') }}"
        x-load-css="[@js(FilamentAsset::getStyleHref(id: 'filepond-pdf', package: 'asmit/filament-upload'))]"
        wire:ignore
    >
        @include('filament-forms::components.file-upload')
    </div>
</div>

@php
    use Filament\Support\Facades\FilamentView;
    use Filament\Support\Facades\FilamentAsset;

    $pdfPreviewHeight = $getPdfPreviewHeight();
    $pdfScrollbar = 0;
    $pdfDisplayPage = 0;
    $pdfToolbar = false;
    $pdfNavePanes = false;
    $pdfZoomLevel = 100;
    $pdfView = '';
    $statePath = $getStatePath();
@endphp

<div>
    <div
        x-data="advancedFileUpload({
        pdfPreviewHeight: @js($pdfPreviewHeight),
        pdfScrollbar: @js($pdfScrollbar),
        pdfDisplayPage: @js($pdfDisplayPage),
        pdfToolbar: @js($pdfToolbar),
        pdfNavPanes: @js($pdfNavePanes),
        pdfZoom: @js($pdfZoomLevel),
        pdfView: @js($pdfView),
        allowPdfPreview: @js($isPreviewable()),
    })"
        @if (FilamentView::hasSpaMode())
            x-load="visible || event (ax-modal-opened)"
        @else
            x-load
        @endif
        x-load-src="{{ FilamentAsset::getAlpineComponentSrc('filepond-pdf', 'asmit/filament-upload') }}"
        x-load-css="[@js(FilamentAsset::getStyleHref(id: 'filepond-pdf', package: 'asmit/filament-upload'))]"
    >
        {{-- Filament v5.7 removed the `filament-forms::components.file-upload` Blade
            view and switched FileUpload to an embedded (HasEmbeddedView) renderer.
            Fall back to it when the Blade view is gone, while staying compatible
            with Filament v3/v4 which still ship the view. --}}
        @if (view()->exists('filament-forms::components.file-upload'))
            @include('filament-forms::components.file-upload')
        @else
            {!! $toEmbeddedHtml() !!}
        @endif
    </div>
</div>

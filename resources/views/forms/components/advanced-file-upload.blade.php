@php
    use Filament\Support\Facades\FilamentView;
    use Filament\Support\Facades\FilamentAsset;

    // TODO
    $pdfPreviewHeight = 320;
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
        getUploadedFilesUsing: async () => {
                    return await $wire.getFormUploadedFiles(@js($statePath))
                },
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
        wire:ignore
    >
        @include('filament-forms::components.file-upload')
    </div>
</div>

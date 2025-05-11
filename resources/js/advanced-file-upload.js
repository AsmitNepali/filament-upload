import PdfPreviewPlugin from "./pdf-preview-plugin";

export default function advancedFileUpload({
    pdfPreviewHeight,
    pdfScrollbar,
    pdfDisplayPage,
    pdfToolbar,
    pdfNavPanes,
    pdfZoom,
    pdfView,
    allowPdfPreview,
}) {
    document.addEventListener("FilePond:loaded", function () {
        const filePond = window.FilePond;

        // Register the plugin
        filePond.registerPlugin(PdfPreviewPlugin);

        // Configure Global Options
        filePond.setOptions({
            pdfPreviewHeight,
            pdfScrollbar,
            pdfDisplayPage,
            pdfToolbar,
            pdfNavPanes,
            pdfZoom,
            pdfView,
            allowPdfPreview,
        });
    });
}

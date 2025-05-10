import PdfPreviewPlugin from "./pdf-preview-plugin";

export default function uploadPdf(options) {
    document.addEventListener("FilePond:loaded", function () {
        const filePond = window.FilePond;

        // Register the plugin
        filePond.registerPlugin(PdfPreviewPlugin);

        // Configure Global Options
        filePond.setOptions(options);
    });
}

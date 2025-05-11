import PdfPreviewPlugin from "./pdf-preview-plugin";

export default function uploadPdf({
    getUploadedFilesUsing,
    pdfPreviewHeight,
    pdfScrollbar,
    pdfDisplayPage,
    pdfToolbar,
    pdfNavPanes,
    pdfZoom,
    pdfView
}) {
    const fileUploader = {
        fileKeyIndex: {},
        uploadedFileIndex: {},

        async getUploadedFiles() {
            const uploadedFiles = await getUploadedFilesUsing();
            this.fileKeyIndex = uploadedFiles ?? {};

            this.uploadedFileIndex = Object.entries(this.fileKeyIndex)
                .filter(([key, value]) => value?.url)
                .reduce((obj, [key, value]) => {
                    obj[value.url] = key;
                    return obj;
                }, {});
        },

        async getFiles() {
            await this.getUploadedFiles();

            let files = [];
            for (const uploadedFile of Object.values(this.fileKeyIndex)) {
                if (!uploadedFile) {
                    continue;
                }



                const type = uploadedFile.type;
                const isPdf = type === 'application/pdf';

                files.push({
                    source: uploadedFile.url,
                    options: {
                        type: 'local',
                    },
                });
            }

            return files;
        }
    };

    document.addEventListener("FilePond:loaded", async function () {
        console.log('FilePond initialized');
        const filePond = window.FilePond;

        filePond.files =  [
            {
                // the server file reference
                source: 'http://filament.test/storage/01JTXV4019X1639ZS42YWZZJ52.pdf',

                // set type to local to indicate an already uploaded file
                options: {
                    type: 'local',
                },
            }];

        // Register the plugin
        filePond.registerPlugin(PdfPreviewPlugin);

        // Configure Global Options
        filePond.setOptions({
            allowPdfPreview: true,
            pdfPreviewHeight: pdfPreviewHeight || 320,
            pdfScrollbar: pdfScrollbar || true,
            pdfDisplayPage: pdfDisplayPage || 1,
            pdfToolbar: pdfToolbar || false,
            pdfNavPanes: pdfNavPanes || false,
            pdfZoom: pdfZoom || false,
            pdfView: pdfView || 'fitW',

        });

        // Initialize files
        filePond.files = await fileUploader.getFiles();
    });

    return fileUploader;
}

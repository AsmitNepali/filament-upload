// checks if the file is a pdf
const isPdfFile = (file) => {
    return file.type === "application/pdf";
};

const buildParams = (root) => {
    return new URLSearchParams({
        toolbar: root.query("GET_PDF_TOOLBAR") ? 1 : 0,
        navpanes: root.query("GET_PDF_NAVPANE") ? 1 : 0,
        statusbar: root.query("GET_PDF_STATUS_BAR") ? 1 : 0,
        zoom: root.query("GET_PDF_ZOOM") ? 1 : 0,
        view: root.query("GET_PDF_VIEW"),
        scrollbar: root.query("GET_PDF_SCROLLBAR") ? 1 : 0,
        page: root.query("GET_PDF_DISPLAY_PAGE"),
    });
};

// create pdf preview view
const createPdfPreviewView = (utils) => {
    const didPdfPreviewLoad = ({ root, props }) => {
        const { id } = props;
        const item = root.query("GET_ITEM", id);
        const params = buildParams(root);

        const fileSource = () => {
            if (typeof item.source !== "string") {
                let URL = window.URL || window.webkitURL;

                const blob = new Blob([item.file], { type: item.file.type });
                return URL.createObjectURL(blob);
            }
            return item.source;
        };

        root.ref.pdf.src = `${fileSource()}#${params.toString()}`;

        root.ref.pdf.addEventListener(
            "load",
            () => {
                root.dispatch("DID_UPDATE_PANEL_HEIGHT", {
                    id: id,
                    height: root.ref.pdf.scrollHeight,
                });
            },
            false
        );
    };

    const create = ({ root, props }) => {
        const item = root.query("GET_ITEM", props.id);
        if (!item.file) return;

        root.ref.pdf = document.createElement("iframe");
        root.ref.pdf.setAttribute(
            "height",
            root.query("GET_PDF_PREVIEW_HEIGHT") || 320
        );

        root.ref.pdf.classList.add("filepond--pdf-preview-iframe");

        root.element.appendChild(root.ref.pdf);
    };

    return utils.createView({
        name: "pdf-preview",
        tag: "div",
        create,
        write: utils.createRoute({
            DID_PDF_PREVIEW_LOAD: didPdfPreviewLoad,
        }),
    });
};

// create overlay shadow view
const createOverlayShadowView = (utils) => {
    return utils.createView({
        name: "overlay-shadow",
        tag: "div",
        ignoreRect: true,
        create: ({ root, props }) => {
            root.element.classList.add(`overlay-shadow--${props.status}`);
        },
        mixins: {
            styles: ["opacity"],
            animations: {
                opacity: { type: "spring", mass: 25 },
            },
        },
    });
};

// create pdf wrapper view
const createPdfWrapperView = (_) => {
    const utils = _.utils;
    const pdfPreview = createPdfPreviewView(utils);
    const overlayShadowView = createOverlayShadowView(utils);

    const didCreatePreviewContainerView = ({ root, props }) => {
        const { id } = props;
        root.dispatch("DID_PDF_PREVIEW_LOAD", { id });
    };

    const create = ({ root, props }) => {
        root.ref.overlayShadow = root.appendChildView(
            root.createChildView(overlayShadowView, {
                opacity: 1,
                status: "idle",
            })
        );

        root.ref.overlaySuccess = root.appendChildView(
            root.createChildView(overlayShadowView, {
                opacity: 0,
                status: "success",
            })
        );

        root.ref.overlayError = root.appendChildView(
            root.createChildView(overlayShadowView, {
                opacity: 0,
                status: "failure",
            })
        );

        // create pdf preview
        root.ref.pdf = root.appendChildView(
            root.createChildView(pdfPreview, { id: props.id })
        );
    };

    const restoreOverlay = ({ root }) => {
        root.ref.overlayShadow.opacity = 1;
        root.ref.overlayError.opacity = 0;
        root.ref.overlaySuccess.opacity = 0;
    };

    const didThrowError = ({ root, props }) => {
        root.ref.overlayShadow.opacity = 0.1;
        root.ref.overlayError.opacity = 1;
    };

    const didCompleteProcessing = ({ root, props }) => {
        root.ref.overlayShadow.opacity = 0.1;
        root.ref.overlaySuccess.opacity = 1;
    };

    return utils.createView({
        name: "pdf-preview-wrapper",
        tag: "div",
        create,
        write: utils.createRoute({
            DID_CREATE_PDF_PREVIEW_CONTAINER_VIEW:
                didCreatePreviewContainerView,

            // Status change events
            DID_THROW_ITEM_LOAD_ERROR: didThrowError,
            DID_THROW_ITEM_PROCESSING_ERROR: didThrowError,
            DID_THROW_ITEM_INVALID: didThrowError,
            DID_COMPLETE_ITEM_PROCESSING: didCompleteProcessing,
            DID_START_ITEM_PROCESSING: restoreOverlay,
            DID_REVERT_ITEM_PROCESSING: restoreOverlay,
        }),
    });
};

// pdf preview plugin
const PdfPreviewPlugin = (fpInstance) => {
    const { addFilter, utils } = fpInstance;
    const { Type, createRoute } = utils;

    const pdfPreviewWrapperView = createPdfWrapperView(fpInstance);

    addFilter("CREATE_VIEW", (viewAPI) => {
        const { is, view, query } = viewAPI;

        // checks if file exists
        if (!is("file")) return;

        const didLoadItem = ({ root, props }) => {
            const { id } = props;
            const item = query("GET_ITEM", id);

            const isPreviewable = query("GET_ALLOW_PDF_PREVIEW");

            // exit if item does not exist or is not a file or is archived or is not previewable
            if (
                !item ||
                !isPdfFile(item?.file) ||
                item?.archived ||
                !isPreviewable
            )
                return;

            // set preview view
            root.ref.pdfPreview = view.appendChildView(
                view.createChildView(pdfPreviewWrapperView, { id })
            );

            root.dispatch("DID_CREATE_PDF_PREVIEW_CONTAINER_VIEW", { id });
        };

        view.registerWriter(
            createRoute({
                DID_LOAD_ITEM: didLoadItem,
            }),
            (root, props) => {
                // no preview view attached
                if (!root.ref.pdfPreview) return;

                // don't do anything while hidden
                if (root.rect.element.hidden) return;
            }
        );
    });

    return {
        options: {
            allowPdfPreview: [true, Type.BOOLEAN],
            pdfPreviewHeight: [400, Type.INT],
            pdfToolbar: [false, Type.BOOLEAN],
            pdfNavPanes: [false, Type.BOOLEAN],
            pdfStatusBar: [false, Type.BOOLEAN],
            pdfZoom: [false, Type.BOOLEAN],
            pdfView: ["fitW", Type.STRING],
            pdfDisplayPage: [1, Type.INT],
        },
    };
};

export default PdfPreviewPlugin;

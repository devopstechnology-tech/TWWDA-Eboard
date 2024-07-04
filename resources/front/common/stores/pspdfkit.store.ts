import {defineStore} from 'pinia';
import PSPDFKit from 'pspdfkit';
import {useSettingsStore} from '@/common/stores/settings.store';

export const usePSPDFStore = defineStore({
    id: 'pdf',
    state: () => ({
        pdfFile: '',
        instance: null,
    }),
    actions: {
        setPdfFile(file: string) {
            this.pdfFile = file;
        },
        async loadPdf(container, appUrl, hasAnnotatePermission) {
            if (this.instance) {
                PSPDFKit.unload(container);
                this.instance = null;
            }

            const settingsStore = useSettingsStore();
            const settings = settingsStore.getSettings();
            const licenseKey = settings?.pspdkitlicencekey;

            if (!licenseKey) {
                console.error('License key not found in settings');
                return;
            }

            if (this.pdfFile && this.pdfFile.startsWith('blob:')) {
                try {
                    this.instance = await PSPDFKit.load({
                        container,
                        document: this.pdfFile,
                        baseUrl: appUrl + '/js/',
                        licenseKey: licenseKey,
                        // initialViewState: new PSPDFKit.ViewState({readOnly: !hasAnnotatePermission}),
                        // isEditableAnnotation: (annotation) => {
                        //     return hasAnnotatePermission ? true : !(annotation instanceof PSPDFKit.Annotations.InkAnnotation);
                        // },
                    });
                } catch (error) {
                    console.error('Failed to load PDF:', error);
                    this.instance = null;
                }
            }
        },
        async createTextAnnotation(userName) {
            if (!this.instance) {
                console.error('PSPDFKit instance is not initialized');
                return;
            }

            const annotation = new PSPDFKit.Annotations.TextAnnotation({
                creatorName: userName,
                pageIndex: 0,
                font: 'Helvetica',
                isBold: true,
                horizontalAlign: 'left',
                boundingBox: new PSPDFKit.Geometry.Rect({
                    left: 50,
                    top: 200,
                    width: 100,
                    height: 80,
                }),
                fontColor: PSPDFKit.Color.BLUE,
            });

            this.instance.setAnnotationCreatorName(userName);
            const createdAnnotation = await this.instance.create(annotation);

            return createdAnnotation;
        },
        async createInkAnnotation({x1, y1, x2, y2}, userName) {
            if (!this.instance) {
                console.error('PSPDFKit instance is not initialized');
                return;
            }

            const {List} = PSPDFKit.Immutable;
            const {DrawingPoint, Rect} = PSPDFKit.Geometry;
            const {InkAnnotation} = PSPDFKit.Annotations;

            const annotation = new InkAnnotation({
                creatorName: userName,
                pageIndex: 0,
                boundingBox: new Rect({width: 400, height: 100}),
                strokeColor: new PSPDFKit.Color({r: 255, g: 0, b: 255}),
                lines: List([
                    List([
                        new DrawingPoint({x: x1, y: y1}),
                        new DrawingPoint({x: x2, y: y2}),
                    ]),
                ]),
            });

            this.instance.setAnnotationCreatorName(userName);
            const createdAnnotation = await this.instance.create(annotation);
            return createdAnnotation;
        },
        async createSignatureField(pageIndex, boundingBox, fieldName) {
            if (!this.instance) {
                console.error('PSPDFKit instance is not initialized');
                return;
            }

            const widget = new PSPDFKit.Annotations.WidgetAnnotation({
                pageIndex,
                boundingBox: new PSPDFKit.Geometry.Rect(boundingBox),
                formFieldName: fieldName,
                id: PSPDFKit.generateInstantId(),
            });

            const formField = new PSPDFKit.FormFields.SignatureFormField({
                name: fieldName,
                annotationIds: PSPDFKit.Immutable.List([widget.id]),
            });

            await this.instance.create([widget, formField]);

            return {widget, formField};
        },
        async savePdf(fileName: string) {
            if (!this.instance) {
                console.error('PSPDFKit instance is not initialized');
                return;
            }

            const buffer = await this.instance.exportPDF({
                incremental: true,
            });
            const blob = new Blob([buffer], {type: 'application/pdf'});
            const file = new File([blob], fileName, {type: 'application/pdf'});
            return file;
        },
        unloadPdf(container) {
            if (this.instance) {
                PSPDFKit.unload(container);
                this.instance = null;
            }
        },
    },
});

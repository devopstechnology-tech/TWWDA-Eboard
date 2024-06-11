import {defineStore} from 'pinia';
import PSPDFKit from 'pspdfkit';

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
        async loadPdf(container, appUrl) {
            if (this.instance) {
                PSPDFKit.unload(container);
            }
            if (this.pdfFile && this.pdfFile.startsWith('blob:')) {
                try {
                    this.instance = await PSPDFKit.load({
                        container,
                        document: this.pdfFile,
                        baseUrl: appUrl +'/js/',
                        licenseKey: 'hAdDDq6qP4-NhrrzYinXA5Z2_LbgdXehQlveuQR78LR8FbZOiYsDT71uK_EpZ8dznX5UIlKVishLMON2TeEGB7EnEjoRJpO-RJiSyufdWDrgYX5kgr8mHn77AYVwcdidHtqXrAlze5iPE3gXFY1sny3TE3YDqqwd_3aQH9gP8GhuIQkfdh5hLfFk6oLHY_kv1lbTUqBQjqCqVYP6',
                        // toolbarItems: PSPDFKit.defaultToolbarItems.concat([
                        //     {
                        //         type: 'custom',
                        //         id: 'save-pdf',
                        //         title: 'Save',
                        //         onPress: () => {
                        //             savePdf();
                        //         },
                        //     },
                        // ]),
                    });
                } catch (error) {
                    console.error('Failed to load PDF:', error);
                }
            }
        },
        async createTextAnnotation(userName) {
            const annotation = new PSPDFKit.Annotations.TextAnnotation({
                creatorName: userName,
                pageIndex: 0, // Specify the page number for the annotation.
                // text: {
                //     format: 'plain',
                //     value: 'Welcome to PSPDFKit', // Text to embed.
                // },
                font: 'Helvetica',
                isBold: true,
                horizontalAlign: 'left', // Align the annotation to the center of the bounding box.
                boundingBox: new PSPDFKit.Geometry.Rect({
                    // Position of the annotation.
                    left: 50,
                    top: 200,
                    width: 100,
                    height: 80,
                }),
                fontColor: PSPDFKit.Color.BLUE, // Color of the text.
            });

            // Attach this annotation to your PDF.
            this.instance.setAnnotationCreatorName(userName);
            const createdAnnotation = await this.instance.create(annotation);

            return createdAnnotation;
        },
        async createInkAnnotation({x1, y1, x2, y2}, userName) {
            // Extract the `List`, `DrawingPoint`, `Rect`, and `InkAnnotation` properties from PSPDFKit.
            // These are needed to render annotations onto the screen.
            const {List} = PSPDFKit.Immutable;
            const {DrawingPoint, Rect} = PSPDFKit.Geometry;
            const {InkAnnotation} = PSPDFKit.Annotations;

            // Create your ink annotation.
            const annotation = new InkAnnotation({
                creatorName: userName,
                pageIndex: 0,
                boundingBox: new Rect({width: 400, height: 100}), // position of annotation
                strokeColor: new PSPDFKit.Color({r: 255, g: 0, b: 255}), // color of stroke
                lines: List([
                    // Coordinates of stroke.
                    List([
                        new DrawingPoint({x: x1, y: y1}),
                        new DrawingPoint({x: x2, y: y2}),
                    ]),
                ]),
            });
            // Attach stroke to annotation:
            this.instance.setAnnotationCreatorName(userName);
            const createdAnnotation = await this.instance.create(annotation);
            return createdAnnotation;
        },
        async createSignatureField(pageIndex, boundingBox, fieldName) {
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

            // Create both the WidgetAnnotation and SignatureFormField together
            await this.instance.create([widget, formField]);

            return {widget, formField};
        },

        // async addInkAnnotation() {
        //     await this.createInkAnnotation({
        //         x1: 5, // Starting x-coordinate.
        //         y1: 5, // Starting y-coordinate.
        //         x2: 100, // Ending x-coordinate.
        //         y2: 100, // Ending y-coordinate.
        //     });
        // },
        async savePdf(fileName:string) {
            const buffer = await this.instance.exportPDF({
                incremental: true,
            });
            // let binary = '';
            // const bytes = new Uint8Array(buffer);
            // const len = bytes.byteLength;
            // for (let i = 0; i < len; i++) {
            //     binary += String.fromCharCode(bytes[i]);
            // }
            // Now `binary` is a binary string representation of the PDF
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

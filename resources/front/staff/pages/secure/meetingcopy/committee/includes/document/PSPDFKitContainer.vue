<template>
    <div ref="containerRef" style="width: 100%; height: 100vh;"></div>
</template>

<script setup lang="ts">
import PSPDFKit from 'pspdfkit';
import {onMounted, onUnmounted, ref, watch} from 'vue';

const containerRef = ref(null);
let instance = null;

// Define props
const props = defineProps({
    pdfFile: String,
});

// Define emit
const emit = defineEmits(['loaded']);

// Watch for changes to pdfFile
watch(
    () => props.pdfFile, // The source function
    loadPdf, // The callback function
    {immediate: true},
);

const appUrl = document.getElementById('app').dataset.appUrl;
async function loadPdf() {
    const container = containerRef.value;
    if (instance) {
        PSPDFKit.unload(container);
    }
    if (props.pdfFile && props.pdfFile.startsWith('blob:')) {
        try {
            instance = await PSPDFKit.load({
                container,
                document: props.pdfFile,
                baseUrl: appUrl +'/js/',
                licenseKey: 'TH8Qp7q9KPBLFnAItdIZ3lz9ihiqZxTUUuPhZhug2mGh7YkhmCqgMgi8gICcWSCNeCbti4-ZqzplTuKzRcYCBiPNFB6Ey_tnSVxl9tCDGkE5ZNrTMK8yXZ0nF8ykUnCrb7oVefIUwnxFdY51cDRAo2eXH2bvmGRyGbq66UWlepqciwqoqauW9oznmiUdWtna4dXMn6OLamI4g9d9',

            });
            emit('loaded', instance);
        } catch (error) {
            console.error('Failed to load PDF:', error);
        }
    }
};
async function createTextAnnotation({PSPDFKit, instance}) {
    const annotation = new PSPDFKit.Annotations.TextAnnotation({
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
    const createdAnnotation = await instance.create(annotation);
    return createdAnnotation;
};
async function createInkAnnotation({x1, y1, x2, y2}) {
    // Extract the `List`, `DrawingPoint`, `Rect`, and `InkAnnotation` properties from PSPDFKit.
    // These are needed to render annotations onto the screen.
    const {List} = PSPDFKit.Immutable;
    const {DrawingPoint, Rect} = PSPDFKit.Geometry;
    const {InkAnnotation} = PSPDFKit.Annotations;

    // Create your ink annotation.
    const annotation = new InkAnnotation({
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

    const instance = await this.loadPSPDFKit();
    // Attach stroke to annotation:
    const createdAnnotation = await instance.create(annotation);
    return createdAnnotation;
};
async function addInkAnnotation() {
    await this.createInkAnnotation({
        x1: 5, // Starting x-coordinate.
        y1: 5, // Starting y-coordinate.
        x2: 100, // Ending x-coordinate.
        y2: 100, // Ending y-coordinate.
    });
};

onUnmounted(() => {
    if (instance) {
        PSPDFKit.unload(containerRef.value);
    }
});
</script>

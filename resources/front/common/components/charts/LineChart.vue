<script setup lang="ts">
import {ref, toRef} from 'vue';


type seriesType = {
    name: string,
    data: number[]
}
type chartData = {
    series: seriesType[],
    categories: string[],
    title: string,
    ytitle?: string,
    annotations?: object,
}

const props = withDefaults(defineProps<{
    data: chartData,
    height?: number,
    zoom?: boolean,
    dataLabels?: boolean,
}>(), {
    height: 350,
    zoom: false,
    dataLabels: false,
});
const chartOptions = ref({
    chart: {
        height: toRef(props.height),
        type: 'line',
        zoom: {
            enabled: toRef(props.zoom),
        },
    },
    dataLabels: {
        enabled: toRef(props.dataLabels),
    },
    stroke: {
        curve: 'straight',
        width: 2,
    },
    title: {
        text: toRef(props.data.title),
        align: 'center',
        floating: true,
        style: {
            fontSize: '16px',
            fontWeight: 'bold',
            fontFamily: undefined,
            color: '#263238',
        },
    },
    grid: {
        row: {
            colors: ['#aba8a8', 'transparent'],
            opacity: 0.4,
        },
    },
    yaxis: {
        title: {
            text: toRef(props.data.ytitle),
        },
    },
    xaxis: {
        categories: toRef(props.data.categories),
    },
    // annotations: toRef(props.data.annotations),
});
</script>

<template>
    <apexchart type="line" height="350" :options="chartOptions" :series="props.data.series"
               class="flex flex-1 h-full rounded-md text-accent border dark:border-green-350 z-1 border-green-950"/>
</template>

<style scoped>

</style>

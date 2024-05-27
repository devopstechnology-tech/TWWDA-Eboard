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
        type: 'bar',
        height: 350,
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded',
        },
    },
    dataLabels: {
        enabled: false,
    },
    title: {
        text: toRef(props.data.title),
        align: 'center',
        floating: true,
        style: {
            fontSize: '16px',
            fontWeight: 'bold',
            fontFamily: undefined,
            color: '#0d5062',
        },
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent'],
    },
    xaxis: {
        categories:toRef(props.data.categories),
    },
    yaxis: {
        title: {
            text: toRef(props.data.ytitle),
        },
    },
    fill: {
        opacity: 1,
    },
    grid: {
        row: {
            colors: ['#888787', 'transparent'],
            opacity: 0.4,
        },
    },
});


</script>

<template>
    <apexchart type="bar" :height="props.height" :options="chartOptions" :series="props.data.series"
               class="flex flex-1 h-full rounded-md text-accent border dark:border-green-350 border-green-950"/>
</template>

<style scoped>

</style>

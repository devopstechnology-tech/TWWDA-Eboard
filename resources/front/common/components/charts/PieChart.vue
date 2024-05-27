<script setup lang="ts">
import {ref, toRef} from 'vue';

type chartData = {
    series: number[],
    categories: string[],
    title: string,

}

const props = withDefaults(defineProps<{
    data: chartData,
    width?: number,
    type?: string,
}>(), {
    width: 350,
    type: 'donut',
});
const chartOptions = ref({
    chart: {
        width: 380,
        type: toRef(props.type),
    },
    title: {
        text: toRef(props.data.title),
        align: 'center',
        floating: false,
        style: {
            fontSize: '16px',
            fontWeight: 'bold',
            fontFamily: undefined,
            color: '#263238',
        },
    },
    labels: toRef(props.data.categories),
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 200,
            },
            legend: {
                position: 'bottom',
            },
        },
    }],
});
</script>

<template>
    <apexchart :type="props.type" :width="props.width" :options="chartOptions" :series="props.data.series"
               class="pie"></apexchart>

</template>

<style scoped>
.pie {
    @apply flex justify-center h-full w-full rounded-md text-accent border dark:border-green-900 border-green-950;
}
</style>

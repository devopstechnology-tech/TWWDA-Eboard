<template>
    <div class="w-full lg:m-1 rounded-md "
         :class="[
             props.direction==='up'?'bg-gradient-to-t':'bg-gradient-to-r',
             props.startColor,
             props.midColor,
             props.endColor,
             props.padding!
         ]">
        <slot></slot>
    </div>
</template>

<script lang='ts' setup>
interface Props {
    direction?: string;
    startColor: string;
    midColor: string;
    endColor: string;
    padding?: string;
}

const props = withDefaults(defineProps<Props>(), {
    direction: 'down',
    startColor: 'white',
    midColor: 'black',
    endColor: 'white',
    padding: 'p-0.5',
});
</script>

<style scoped>
</style>

<template>
    <ol>
        <agenda-template-item v-for="item in items" :key="'item'+item.id" :item="item"></agenda-template-item>
    </ol>
</template>

<script>

export default {
    name: 'AgendaTemplateItemList',
    props: ['items'],
};
</script>
<template>
    <div class="p-4">
        <h2 class="h2">{{ template.name }}</h2>
        <agenda-template-item-list
            :items="template.items"
            class="agenda-list mb-0"
        ></agenda-template-item-list>
    </div>
</template>

<script>

import AgendaTemplateItemList from './AgendaTemplateItemList.vue';

export default {
    name: 'AgendaTemplatePreview',
    props: ['template'],
    components: {AgendaTemplateItemList},
};

</script>

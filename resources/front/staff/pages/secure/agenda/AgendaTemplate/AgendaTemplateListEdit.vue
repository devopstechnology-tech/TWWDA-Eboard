<template>
    <draggable
        :list="items"
        tag="ol"
        @change="() => $emit('order_updated', level)"
        :group="{ name: 'items' }"
        ghost-class="agenda-sort-placeholder"
        :swapThreshold="0.65"
        :emptyInsertThreshold="40"
    >
        <agenda-template-list-item-edit
            v-for="item in items"
            :item="item"
            :key="'item' + item.id"
            :level="level"
            :selected_item="selected_item"
            :template_id="template_id"
            @item_selected="(i) => $emit('item_selected', i)"
            @template_item_added="(i) => $emit('template_item_added', i)"
            @order_updated="() => $emit('order_updated')"
        ></agenda-template-list-item-edit>
    </draggable>
</template>

<script>

import draggable from 'vuedraggable.vue';
import AgendaTemplateListItemEdit from './AgendaTemplateListItemEdit.vue';

export default {
    name: 'AgendaTemplateListEdit',
    components: {draggable, AgendaTemplateListItemEdit},
    props: ['items', 'selected_item', 'level', 'template_id'],
};

</script>

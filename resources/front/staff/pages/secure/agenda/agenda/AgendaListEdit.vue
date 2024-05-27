<template>
    <draggable
        :list="items"
        :disabled="disableDraggable"
        tag="ol"
        @change="() => $emit('order_updated', level)"
        :group="{ name: 'agenda' }"
        ghost-class="agenda-sort-placeholder"
        :swapThreshold="0.65"
        :emptyInsertThreshold="40"
    >
        <agenda-list-item-edit
            v-for="item in items"
            :key="'agenda'+item.id"
            :item="item"
            :level="level"
            :selected_item="selected_item"
            :meeting="meeting"
            @item_selected="(i) => $emit('item_selected', i)"
            @agenda_item_added="(i) => $emit('agenda_item_added', i)"
            @order_updated="() => $emit('order_updated')"
        ></agenda-list-item-edit>
    </draggable>
</template>

<script>

import draggable from 'vuedraggable';

export default {
    name: 'AgendaListEdit',
    components: {draggable},
    props: ['items', 'meeting', 'selected_item', 'level'],
    computed: {
        disableDraggable() {
            // Tests whether there is no input device that can hover over components (only touch screen available)
            return window.matchMedia('(any-hover: none)').matches;
        },
    },
};

</script>
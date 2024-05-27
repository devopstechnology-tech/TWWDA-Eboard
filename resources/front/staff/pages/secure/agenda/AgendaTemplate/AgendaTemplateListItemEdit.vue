<template>
    <li class="mb-2 hover:border-gray-400 border-l border-transparent">

        <div class="rounded-lg border border-transparent hover:cursor-pointer -ml-7 p-2 pl-7"
             :class="{'border-blue': itemIsSelected}"
             @click="() => $emit('item_selected', item)"
        >
            <div class="font-medium">
                {{ item.text }}
            </div>
            <div v-if="item.description" v-html="item.description" class="text-sm text-gray-800"></div>
        </div>

        <agenda-template-list-edit
            :items="item.items"
            :level="level + 1"
            :selected_item="selected_item"
            :template_id="template_id"
            @item_selected="(i) => $emit('item_selected', i)"
            @template_item_added="(i) => $emit('template_item_added', i)"
            @order_updated="() => $emit('order_updated')"
        ></agenda-template-list-edit>

        <new-template-item
            v-if="level < 2"
            :parent_id="item.id"
            :template_id="template_id"
            @template_item_added="(i) => $emit('template_item_added', i)"
        ></new-template-item>
    </li>
</template>

<script>

import NewTemplateItem from './NewTemplateItem.vue';

export default {
    name: 'AgendaTemplateListItemEdit',
    components: {NewTemplateItem},
    props: ['item', 'selected_item', 'level', 'template_id'],
    computed: {
        itemIsSelected() {
            return this.selected_item && this.selected_item.id === this.item.id;
        },
    },
};

</script>

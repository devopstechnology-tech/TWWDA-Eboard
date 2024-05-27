<template>
    <div>
        <loading-icon v-if="!initialized"></loading-icon>
        <div class="flex gap-5" v-else>
            <card class="flex-1" style="min-height: 384px;">
                <template #body>
                    <agenda-template-list-edit
                        :items="items"
                        :selected_item="selected_item"
                        :level="0"
                        :template_id="template_id"
                        class="agenda-list"
                        :data-list_format="list_format"
                        @item_selected="handleItemSelected"
                        @template_item_added="handleItemAdded"
                        @order_updated="handleOrderUpdated"
                    ></agenda-template-list-edit>
                    <new-template-item
                        :parent_id="0"
                        :template_id="template_id"
                        button_type="top"
                        @template_item_added="handleItemAdded"
                        :start_active="true"
                    ></new-template-item>
                </template>
            </card>
            <div ref="sidebar" class="hidden md:block w-[350px]">
                <div ref="sidebar_inner" class="w-[350px]" :class="{'fixed top-8': sidebar_fixed}">
                    <div v-if="!selected_item" class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                        <div class="text-center text-gray-700">
                            Select a template item to edit <br />
                            <div class="text-xl mt-1">
                                <i class="fa-regular fa-turn-down-left"></i>
                            </div>
                        </div>
                    </div>
                    <agenda-template-edit-item-form
                        v-else
                        :selected_item="selected_item"
                        :template_id="template_id"
                        @editing_cancelled="() => selected_item = null"
                        @template_item_updated="handleItemUpdated"
                        @template_item_deleted="handleItemDeleted"
                    ></agenda-template-edit-item-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import AgendaTemplateEditItemForm from './AgendaTemplateEditItemForm';
import AgendaTemplateListEdit from './AgendaTemplateListEdit';
import NewTemplateItem from './NewTemplateItem';

export default {
    name: 'AgendaTemplateEditForm',
    components: {AgendaTemplateEditItemForm, AgendaTemplateListEdit, NewTemplateItem},
    props: ['template_id', 'list_format'],
    data() {
        return {
            items: [],
            initialized: false,
            sidebar_fixed: false,
            selected_item: null,
        };
    },
    mounted() {
        axios.get(Boardable.org_url + 'agenda-templates/' + this.template_id + '/data')
            .then((response) => {
                this.items = response.data.items;
                this.initialized = true;
            });

        this.setupStickySidebar();
    },
    methods: {
        setupStickySidebar() {
            window.addEventListener('scroll', () => {
                const bounding = this.$refs['sidebar'].getBoundingClientRect();
                this.sidebar_fixed = bounding.top <= 0;
            });
        },
        handleItemSelected(item) {
            if (this.selected_item && this.selected_item.id === item.id) {
                this.selected_item = null;
            }
            else {
                this.selected_item = item;
            }
        },

        handleItemUpdated(updated_item) {
            const item = this.findItem(updated_item.id, this.items);
            this.$set(item, 'text', updated_item.text);
            this.$set(item, 'description', updated_item.description);
        },

        findItem(id, list) {
            for (const item of list) {
                if (item.id === id) {
                    return item;
                }
                if (item.items && item.items.length) {
                    const sub_item = this.findItem(id, item.items);
                    if (sub_item)
                        return sub_item;
                }
            }
            return false;
        },

        handleItemAdded(item) {
            if (item.parent_item_id === 0) {
                this.items.push(item);
            }
            else {
                const parent = this.findItem(item.parent_item_id, this.items);
                parent.items.push(item);
            }
        },

        handleItemDeleted(item_id) {
            this.selected_item = null;
            this.$nextTick(() => this.deleteItem(item_id, this.items));
        },
        deleteItem(item_id, list) {
            const item_in_list = list.find((i) => i.id === item_id);
            if (item_in_list) {
                const index = list.indexOf(item_in_list);
                this.$delete(list, index);
            }
            else {
                list.forEach((i) => {
                    if (i.items.length)
                        this.deleteItem(item_id, i.items);
                });
            }
        },
        handleOrderUpdated() {
            const data = this.getFlatListOfParentIds(this.items, [], 0);
            axios.post(Boardable.org_url + 'agenda-templates/' + this.template_id + '/reorder', {items: data});
        },
        getFlatListOfParentIds(items, list, parent_id) {
            items.forEach((i) => {
                list.push({id: i.id, parent_item_id: parent_id});
                if (i.items && i.items.length) {
                    list = this.getFlatListOfParentIds(i.items, list, i.id);
                }
            });
            return list;
        },
    },
};

</script>
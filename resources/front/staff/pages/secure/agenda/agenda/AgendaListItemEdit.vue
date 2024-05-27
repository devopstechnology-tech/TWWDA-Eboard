<template>
    <li class="mb-2 hover:border-gray-400 border-l border-transparent">
        <div class="rounded-lg border border-transparent hover:cursor-pointer -ml-7 p-2 pl-7 relative"
             :class="{'border-blue': itemIsSelected}"
             @click="() => $emit('item_selected', item)"
        >
            <div v-if="item.time"
                 class="absolute border -right-16 top-4 text-[10px] rounded text-center py-0.5 text-gray-700 z-10 border-gray-200"
                 :class="{'bg-gray-200 px-2': level === 0, 'bg-white px-1': level > 0}"
            >
                {{ displayTime }}
            </div>
            <div class="flex gap-2 items-start">
                <div class="font-medium flex-1">
                    {{ item.text }}
                    <div v-if="item.description" v-html="item.description" class="text-sm text-gray-800 font-normal"></div>
                    <attachments-list v-if="item.uploads.length" :attachments="item.uploads" class="mt-2" context="agenda" :inline="true"></attachments-list>
                </div>
                <div class="flex items-center gap-2 mt-1 h-6">
                    <div v-if="item.duration" class="text-xs text-gray-600">
                        {{ item.duration }} minutes
                    </div>
                </div>
                <div>
                    <ul class="list-none">
                        <li v-if="item.people_responsible.length"  v-for="person in item.people_responsible" class="text-sm text-gray-800">
                            {{ person.name }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <agenda-list-edit
            v-if="level < 2"
            :items="item.agenda"
            :level="level + 1"
            :selected_item="selected_item"
            :meeting="meeting"
            @item_selected="(i) => $emit('item_selected', i)"
            @agenda_item_added="(i) => $emit('agenda_item_added', i)"
            @order_updated="() => $emit('order_updated')"
            class="min-h-6"
        ></agenda-list-edit>

        <new-agenda-item
            v-if="level < 2"
            :parent_id="item.id"
            :meeting="meeting"
            @agenda_item_added="(i) => $emit('agenda_item_added', i)"
        ></new-agenda-item>
    </li>
</template>

<script>

import NewAgendaItem from './NewAgendaItem';

export default {
    name: 'AgendaListItemEdit',
    props: ['item', 'selected_item', 'level', 'meeting'],
    components: {NewAgendaItem},
    computed: {
        itemIsSelected() {
            return this.selected_item && this.selected_item.id === this.item.id;
        },
        displayTime() {
            return localTime(this.item.time).format('h:mma');
        },
    },
};

</script>
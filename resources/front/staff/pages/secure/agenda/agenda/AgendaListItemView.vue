<template>
    <li class="mb-2">
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
                    <span v-if="item.user_notes && item.user_notes.length && !include_user_notes" class="text-gray-600 ml-2">
                        <i class="fa-solid fa-notebook"></i>
                        <span v-text="item.user_notes.length"></span>
                    </span>
                    <div v-if="item.description" v-html="item.description" class="text-sm text-gray-800"></div>
                    <attachments-list
                        v-if="item.uploads.length && !no_docs"
                        :attachments="item.uploads"
                        class="mt-2" context="agenda"
                        :inline="true"
                    ></attachments-list>
                    <div v-if="include_user_notes && item.user_notes.length" class="bg-yellow-soft px-4 py-3 flex rounded-lg">
                        <div class="mr-3">
                            <i class="fa-regular fa-note"></i>
                        </div>
                        <div>
                            <div class="font-medium mb-2">My Notes</div>
                            <div v-for="note in item.user_notes" v-html="note.text" class="text-sm"></div>
                        </div>
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
        <agenda-list-view
            v-if="item.agenda.length"
            :items="item.agenda"
            :selected_item="selected_item"
            @item_selected="(i) => $emit('item_selected', i)"
            :level="level+1"
            :ignore_thumbnails="ignore_thumbnails"
            :include_user_notes="include_user_notes"
            :no_docs="no_docs"
        ></agenda-list-view>
    </li>
</template>

<script>

import AvatarGroup from '../../frontend/AvatarGroup';
import AttachmentsListShowCondensed from '../Attachments/AttachmentsListShowCondensed';

export default {
    name: 'AgendaListItem',
    components: {AttachmentsListShowCondensed, AvatarGroup},
    props: ['item', 'selected_item', 'level', 'ignore_thumbnails', 'include_user_notes', 'no_docs'],
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
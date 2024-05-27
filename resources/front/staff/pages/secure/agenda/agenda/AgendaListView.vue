<template>
    <ol>
        <agenda-list-item-view
            v-for="item in items"
            :item="item"
            :selected_item="selected_item"
            @item_selected="(i) => $emit('item_selected', i)"
            :key="'agenda' + item.id"
            :level="level"
            :ignore_thumbnails="ignore_thumbnails"
            :include_user_notes="include_user_notes"
            :no_docs="no_docs"
        ></agenda-list-item-view>
    </ol>
</template>

<script>

export default {
    name: 'AgendaList',
    props: {
        'items': {},
        'selected_item': {default: null},
        'level': {},
        'ignore_thumbnails': {default: false},
        'include_user_notes': {default: false},
        'no_docs': {default: false},
    },
};

</script>
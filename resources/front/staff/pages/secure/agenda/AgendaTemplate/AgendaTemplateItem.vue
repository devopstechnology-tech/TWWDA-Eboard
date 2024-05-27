<template>
    <li class="mb-2">
        <div class="-ml-7 p-2 pl-7 ">
            <div class="font-medium">{{ item.text }}</div>
            <div v-if="item.description" class="text-sm" v-html="item.description"></div>
        </div>
        <agenda-template-item-list v-if="item.items.length" :items="item.items"></agenda-template-item-list>
    </li>
</template>

<script>

export default {
    name: 'AgendaTemplateItem',
    props: ['item'],
};

</script>
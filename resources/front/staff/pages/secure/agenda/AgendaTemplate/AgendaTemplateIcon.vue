<template>
    <div class="cursor-pointer" @click="setValue('num_la_lr')">
        <div class="border rounded-lg p-2 leading-4"
             :class="{
                 'border-blue text-blue':selected_format === format,
                 'text-gray-700': selected_format !== format
             }"
        >
            <div v-for="item in numberList"
                 class="flex gap-1 items-center"
                 :class="{'pl-5': item.level === 2, 'pl-10': item.level === 3 }"
            >
                <div class="text-sm leading-4">{{ item.number }}.</div>
                <div class="h-2 rounded-lg overflow-hidden flex-1"
                     :class="{
                         'bg-gray-200': selected_format !== format,
                         'bg-blue-soft': selected_format === format
                     }"
                >&nbsp;</div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'AgendaTemplateIcon',
    props: ['format', 'selected_format'],
    methods: {
        setValue() {
            this.$emit('format_selected', this.format);
        },
    },
    computed: {
        numberList() {
            if (this.format === 'num_la_lr') {
                return [
                    {number: '1', level: 1},
                    {number: 'a', level: 2},
                    {number: 'i', level: 3},
                    {number: '2', level: 1},
                    {number: '3', level: 1},
                    {number: 'a', level: 2},
                    {number: 'b', level: 2},
                    {number: 'i', level: 3},
                ];
            }
            if (this.format === 'ua_la_lr') {
                return [
                    {number: 'A', level: 1},
                    {number: 'a', level: 2},
                    {number: 'i', level: 3},
                    {number: 'B', level: 1},
                    {number: 'C', level: 1},
                    {number: 'a', level: 2},
                    {number: 'b', level: 2},
                    {number: 'i', level: 3},
                ];
            }
            if (this.format === 'ur_ua_num') {
                return [
                    {number: 'I', level: 1},
                    {number: 'A', level: 2},
                    {number: '1', level: 3},
                    {number: 'II', level: 1},
                    {number: 'III', level: 1},
                    {number: 'A', level: 2},
                    {number: 'B', level: 2},
                    {number: '1', level: 3},
                ];
            }
            if (this.format === 'ur_la_num') {
                return [
                    {number: 'I', level: 1},
                    {number: 'a', level: 2},
                    {number: '1', level: 3},
                    {number: 'II', level: 1},
                    {number: 'III', level: 1},
                    {number: 'a', level: 2},
                    {number: 'b', level: 2},
                    {number: '1', level: 3},
                ];
            }
            if (this.format === 'numbers') {
                return [
                    {number: '1', level: 1},
                    {number: '1.1', level: 2},
                    {number: '1.1.1', level: 3},
                    {number: '2', level: 1},
                    {number: '3', level: 1},
                    {number: '3.1', level: 2},
                    {number: '3.2', level: 2},
                    {number: '3.2.1', level: 3},
                ];
            }
        },
    },
};

</script>
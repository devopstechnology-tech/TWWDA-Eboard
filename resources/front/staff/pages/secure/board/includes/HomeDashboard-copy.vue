<template>
    <div class="flex gap-5">
        <div class="flex-1">
            <div class="card" style="min-height: 384px;">
                <div class="card-body">
                    <div class="flex w-full">
                        <div class="flex-1 col-lg-7 col-lg-6">
                            <ol data-list_format="num_la_lr" class="agenda-list mb-0">
                                <li v-for="(item, index) in items" :key="index" class="mb-2 hover:border-gray-400 border-l border-transparent" draggable="false">
                                    <div class="rounded-lg border border-transparent hover:cursor-pointer -ml-7 p-2 pl-7 relative">
                                        <div class="absolute border -right-16 top-4 text-[10px] rounded text-center py-0.5 text-gray-700 z-10 border-gray-200 bg-gray-200 px-2">
                                            10:30pm
                                        </div>
                                        <div class="flex gap-2 items-start">
                                            <div class="font-medium flex-1">
                                                {{ item.text }}
                                            </div>
                                            <div class="flex items-center gap-2 mt-1 h-6">
                                            </div>
                                            <div>
                                                <ul class="list-none"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <ol class="min-h-6">
                                        <li v-for="(subItem, subIndex) in item.subItems" :key="subIndex" class="mb-2 hover:border-gray-400 border-l border-transparent" draggable="false">
                                            <div class="rounded-lg border border-transparent hover:cursor-pointer -ml-7 p-2 pl-7 relative border-blue">
                                                <div class="flex gap-2 items-start">
                                                    <div class="font-medium flex-1">
                                                        {{ subItem }}
                                                    </div>
                                                    <div class="flex items-center gap-2 mt-1 h-6">
                                                    </div>
                                                    <div>
                                                        <ul class="list-none"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <ol class="min-h-6"></ol>
                                            <div>
                                                <div>
                                                    <a class="text-sm text-gray-600 cursor-pointer" data-uw-rm-kbnav="anohref" tabindex="0" draggable="false">
                                                        sub item
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                    <div>
                                        <div>
                                            <div class="flex gap-x-2">
                                                <input type="text" v-model="newItemText" placeholder="Agenda item text" class="form-control form-control-sm" aria-label="Agenda item text">
                                                <button @click="addItem(index)" class="btn btn-primary h-10">Save</button>
                                            </div>
                                            <a class="text-xs cursor-pointer" data-uw-rm-kbnav="anohref" tabindex="0" draggable="false">cancel</a>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                            <div class="w-full">
                                <div>
                                    <button @click="addItem()" class="btn btn-primary w-full h-10">Add Item</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            items: [
                {text: 'sgrsgr', subItems: []},
                {text: 'uiuluylui', subItems: []},
            ],
            newItemText: '',
        };
    },
    methods: {
        addItem(index) {
            if (index !== undefined) {
                this.items[index].subItems.push(this.newItemText);
            } else {
                this.items.push({text: this.newItemText, subItems: []});
            }
            this.newItemText = '';
        },
    },
};
</script>

  <style scoped>
  /* Add your CSS styles here */
  </style>

<script setup lang="ts">
import {ref} from 'vue';

interface SubItem {
    name: string;
    description: string;
}

interface Item {
    name: string;
    description: string;
    subItems: SubItem[];
}

const items = ref<Item[]>([]);
const selectedItem = ref<number | null>(null);

const addItem = () => {
    items.value.push({
        name: '',
        description: '',
        subItems: [],
    });
};

const saveItem = (index: number) => {
    // Item initial save logic here
    // Consider setting selectedItem to null or to the saved item for immediate editing
};

const selectItem = (index: number) => {
    selectedItem.value = index;
};

const updateItem = () => {
    // Logic to handle item update
    // After update, you might want to clear or reset the selectedItem
};
</script>


<template>
    <div class="container">
        <div class="left-card float-left">
            <button @click="addItem">Add Item</button>
            <div v-for="(item, index) in items" :key="index" class="item">
                <input v-model="item.name" placeholder="Item Name" @blur="saveItem(index)">
                <button @click="selectItem(index)">Edit</button>
                <!-- Add Sub-Items Button and Logic Here -->
            </div>
        </div>
        <div class="right-card float-right" v-if="selectedItem !== null">
            <h3>Edit Item/Sub-Item</h3>
            <!-- Display selected item or sub-item details for editing -->
            <input v-model="items[selectedItem].name" placeholder="Edit Name">
            <textarea v-model="items[selectedItem].description" placeholder="Edit Description"></textarea>
            <button @click="updateItem">Save Changes</button>
        </div>
    </div>
</template>

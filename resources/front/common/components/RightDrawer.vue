<template>

    <!-- drawer container -->
    <div class="fixed h-full w-full z-10 left-0 top-0 " v-if="rightDrawer.show">
        <!-- overlay -->
        <div class="fixed h-full w-full left-0 top-0 bg-black bg-opacity-50 z[-1]"></div>
        <!-- end overlay -->

        <!-- side -->
        <div class="fixed h-full right-0 top-0 bg-base-100 shadow-lg p-4">
            <div
                v-if="!rightDrawer.hideHeaderBar"
                :style="{ padding: '2px 2px 0px 2px'  }"
                class=""
            >
                <div class="flex justify-between items-center mb-1">
                    <button
                        class="btn btn-circle"
                        @click="()=>{
                            rightDrawer.close()
                        }"
                    >
                        X
                    </button>
                    <div class="pl-0" v-if="rightDrawer.header">
                        {{rightDrawer.header}}
                    </div>
                    <div v-else class="my-4"></div>
                </div>
            </div>
            <div class="flex w-full h-full gap-1"
                 :style="{  padding:  '2px 2px 0px 2px',width:drawerWidth }">
                <div v-if="rightDrawer && rightDrawer.component"
                     :style="{ padding: '2px', width: column1 }"
                     class="flex w-full"
                >
                    <component
                        :is="rightDrawer.component"
                        v-bind="rightDrawer.data"
                        class="overflow-y-auto h-full w-full"
                    />
                </div>
                <div
                    v-if="rightDrawer && rightDrawer.secondaryComponent"
                    :style="{ padding: '2px', width: column2 }"
                    class="flex w-full mb-2"
                >
                    <component
                        :is="rightDrawer.secondaryComponent"
                        class="overflow-y-auto mr-1 w-full"
                    />
                </div>
            </div>
        </div>
        <!-- end side -->
    </div>
    <!-- end drawer container -->
</template>

<script setup lang="ts">
import {computed, toRefs} from 'vue';
import useGlobalStore from '@/common/stores/global.store';

const {rightDrawer} = toRefs(useGlobalStore());
const drawerWidth = computed(() => {
    let width = 0;
    if (rightDrawer.value.component) {
        width += parseInt(rightDrawer.value.width, 10);
    }
    if (rightDrawer.value.secondaryComponent) {
        width += parseInt(rightDrawer.value.secondaryWidth, 10);
    }
    return width + 'px';
});
const column2 = computed(() => {
    let width = 0;
    if (rightDrawer.value.secondaryComponent) {
        width += parseInt(rightDrawer.value.secondaryWidth, 10);
    }
    return width + 'px';
});
const column1 = computed(() => {
    let width = 0;
    if (rightDrawer.value.component) {
        width += parseInt(rightDrawer.value.width, 10);
    }
    return width + 'px';
});
</script>

<style scoped>
* {
    @apply text-white dark:text-white
}
</style>


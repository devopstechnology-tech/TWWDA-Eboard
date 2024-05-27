<script setup lang="ts">
import Pollp from './Pollp.vue';
import Taskp from './Taskp.vue';
</script>

<style scoped>
</style>
<template>
    <div class="row">
        <div class="col-md-6">
            <Taskp/>
        </div>
        <div class="col-md-6">
            <Pollp/>
        </div>
    </div>
</template>
<style lang="scss">
.danger-color {
    color: #ff0000; /* Or any color/style for "danger" */
}

.ok-color {
    color: #008000; /* Or any color/style for "OK" */
}
</style>


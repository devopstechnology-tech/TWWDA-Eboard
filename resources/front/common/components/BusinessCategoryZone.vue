<script setup lang="ts">

import {computed, onMounted, ref} from 'vue';
import {useGetSingleItemsRequest} from '@/common/api/requests/finance/useItemsRequest';
import {
    useGetBusinessActivitiesRequest,
    useGetBusinessTypesRequest,
} from '@/common/api/requests/forms/useBusinessFormRequest';
import FormSelect from '@/common/components/FormSelect.vue';
import {Item} from '@/common/parsers/itemParser';
import {Section} from '@/common/parsers/sectionsParser';
import {Zone} from '@/common/parsers/zonesParser';

const props = defineProps<{
    section_id: string | number
}>();

interface SelectItem {
    name: string,
    value: string | boolean
}

const businessSections = ref<Section[]>([]);
const businessActivities = ref<Item[]>([]);
const businessCategories = computed(() => {
    const res: SelectItem[] = [];
    businessSections.value.reduce((res, item) => {
        res.push({name: item.name, value: item.id.toString()});
        return res;
    }, res);
    return res;
});
const business = computed(() => {
    const res: SelectItem[] = [];
    businessActivities.value.reduce((res, item) => {
        res.push({name: item.name, value: item.id.toString()});
        return res;
    }, res);
    return res;
});

const businessSelected = (e: number | string) => {
    getBusinessActivities(e);
};
const businessTypeSelected = (e: string) => {
    getZones(e);
};
const getZones = async (e: string) => {
    const schedules = await useGetSingleItemsRequest(e);
    // eslint-disable-next-line no-console
    allZones.value = schedules?.data?.class;
};
const getItems = async () => {
    const types = await useGetBusinessTypesRequest(props.section_id);
    // eslint-disable-next-line no-console
    businessSections.value = types?.data;
};
const getBusinessActivities = async (id: number | string) => {
    const types = await useGetBusinessActivitiesRequest(id);
    // eslint-disable-next-line no-console
    businessActivities.value = types?.data;
};
onMounted(() => {
    getItems();
});
const allZones = ref<Zone[]>([]);
const zones = computed(() => {
    const res: SelectItem[] = [];
    if (allZones.value && allZones.value.length > 0) {
        allZones.value.reduce((res, item) => {
            res.push({name: item.name, value: item.id.toString()});

            return res;
        }, res);
    }
    return res;
});
</script>

<template>
    <div>
        <FormSelect name="category_id"
                    class="text-black"
                    label="Select Business Category"
                    :options="businessCategories"
                    @selectedItem="businessSelected"/>
        <FormSelect name="activity_id"
                    class="text-black"
                    label="Select Business Activity"
                    :options="business"
                    @selectedItem="businessTypeSelected"/>
        <FormSelect name="zone_id"
                    class="text-black"
                    label="Select Zone"
                    :options="zones"/>
    </div>
</template>

<style scoped>

</style>

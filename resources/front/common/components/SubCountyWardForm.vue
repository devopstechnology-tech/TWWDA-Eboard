<script setup lang="ts">
import {computed, onMounted, ref} from 'vue';
import {
    useGetSubCountiesRequest,
    useGetSubCountyWardsRequest,
} from '@/common/api/requests/geography/useSubCountyRequest';
import FormSelect from '@/common/components/FormSelect.vue';
import {SubCounty} from '@/common/parsers/subCountyParser';
import {Ward} from '@/common/parsers/wardParser';
import {SelectItem} from '@/common/types/types';

const allSubCounties = ref<SubCounty[]>([]);
const subCounties = computed(() => {
    const res: SelectItem[] = [];
    allSubCounties.value.reduce((res, item) => {
        res.push({name: item.name, value: item?.id?.toString()});
        return res;
    }, res);
    return res;
});
const getSubCounties = async () => {
    const data = await useGetSubCountiesRequest();
    allSubCounties.value = data.data.data;
};
onMounted(() => {
    getSubCounties();
});
const allWards = ref<Ward[]>([]);
const wards = computed(() => {
    const res: SelectItem[] = [];
    allWards.value.reduce((res, item) => {
        res.push({name: item.name, value: item?.id?.toString()});
        return res;
    }, res);
    return res;
});
const getSubCountyWards = async (id: string) => {
    const data = await useGetSubCountyWardsRequest(id);
    allWards.value = data.data;
};
const subCountyId = ref('');
const wardId = ref('');
const subCountySelected = (e: string) => {
    subCountyId.value = e;
    getSubCountyWards(e);
};
const emit = defineEmits(['data']);
const wardSelected = (e: string) => {
    wardId.value = e;
    emit('data', {
        sub_county_id: subCountyId,
        ward_id: wardId,
    });
};
</script>

<template>
    <div>
        <FormSelect name="sub_county_id"
                    label="Select SubCounty"
                    :options="subCounties"
                    @selectedItem="subCountySelected"/>
        <FormSelect name="ward_id"
                    label="Select Ward"
                    :options="wards"
                    @selectedItem="wardSelected"/>
    </div>
</template>

<style scoped>

</style>

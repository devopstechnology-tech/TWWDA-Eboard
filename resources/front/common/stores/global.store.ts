import {defineStore} from 'pinia';
import {ref, toRefs} from 'vue';

const useGlobalStore = defineStore('global', () => {
    const rightDrawer = ref({
        show: false,
        update: false,
        component: null,
        hideButtons: {type: Boolean, default: false},
        data: {},
        refresh: false,
        header: null,
        width: '350',
        secondaryWidth: '260',
        secondaryComponent: null,
        hideHeaderBar: false,
        bgColor: '#fff',
        color: '#000',
        reset: () => {
            const {rightDrawer} = toRefs(useGlobalStore());
            rightDrawer.value.component = null;
            rightDrawer.value.data = {};
            rightDrawer.value.header = null;
            rightDrawer.value.width = '350';
            rightDrawer.value.bgColor = '#fff';
            rightDrawer.value.color = '#000';
            rightDrawer.value.secondaryWidth = '260';
            rightDrawer.value.secondaryComponent = null;
            rightDrawer.value.show = false;
            rightDrawer.value.update = false;
            updateHtmlTag();
        },
        resetSecondary: () => {
            const globalStore = useGlobalStore();
            globalStore.rightDrawer.secondaryWidth = '260';
            globalStore.rightDrawer.secondaryComponent = null;
            updateHtmlTag();
        },
        close: () => {
            const globalStore = useGlobalStore();
            if (globalStore.rightDrawer.component && globalStore.rightDrawer.secondaryComponent) {
                globalStore.rightDrawer.secondaryComponent = null;
                return;
            }
            globalStore.rightDrawer.show = false;
        },
    });

    function updateHtmlTag() {
        const element = document.querySelector('html');
        if (element !== null) {
            element.classList.toggle('nooverflow');
        }
    }

    function showRightDrawer(config: object) {
        const globalStore = useGlobalStore();
        globalStore.updateHtmlTag();
        globalStore.rightDrawer = {
            ...globalStore.rightDrawer,
            ...config,
        };
    }

    return {
        rightDrawer,
        updateHtmlTag,
        showRightDrawer,
        close,
    };
});

export default useGlobalStore;

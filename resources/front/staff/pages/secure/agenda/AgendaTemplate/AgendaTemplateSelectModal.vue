<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="agenda-template-select" aria-hidden="true" ref="agenda_template_select_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="edit-discussion-header">Select a template</h5>
                    <button type="button" class="btn btn-icon absolute right-2.5 top-2.5" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-regular fa-xmark"></i>
                    </button>
                </div>

                <div class="flex h-[450px]">
                    <loading-icon v-if="loading_list"></loading-icon>
                    <div v-else class="w-1/3 h-full overflow-y-auto border-r border-gray-300">
                        <div class="text-caps text-xxs pl-3 py-2 border-l-2 border-transparent mt-2">Default Templates</div>
                        <div v-for="template in default_templates"
                             class="py-2 text-gray-700 cursor-pointer border-l-2 border-transparent pl-4"
                             :class="{
                                 'bg-blue border-blue text-white': selectedTemplate === template ,
                                 'hover:text-primary hover:bg-gray-200': selectedTemplate !== template
                             }"
                             @click="selectDefaultTemplate(template.id)"
                        >
                            {{ template.name }}
                        </div>
                        <div class="text-caps text-xxs pl-3 py-2 border-l-2 border-transparent mt-2">Custom Templates</div>
                        <div v-for="template in org_templates"
                             class="py-2 text-gray-700 cursor-pointer border-l-2 border-transparent pl-4"
                             :class="{
                                 'bg-blue border-blue text-white': selectedTemplate === template ,
                                 'hover:text-primary hover:bg-gray-200': selectedTemplate !== template
                             }"
                             @click="selectOrgTemplate(template.id)"
                        >
                            {{ template.name }}
                        </div>
                    </div>
                    <div class="w-2/3 h-full overflow-y-auto">
                        <agenda-template-preview
                            v-if="selectedTemplate"
                            :template="selectedTemplate"
                        ></agenda-template-preview>
                    </div>
                </div>

                <div class="modal-footer">

                    <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                    <button v-if="form.submitting" class="btn btn-primary h-10 disabled" disabled>
                        <loading-icon size="sm"></loading-icon>
                    </button>
                    <button v-else class="btn btn-primary h-10" :disabled="!form.data.id" @click="submit">
                        Use template
                    </button>

                </div>
            </div>
        </div>
    </div>

</template>

<script>

import AgendaTemplatePreview from './AgendaTemplatePreview.vue';

export default {
    name: 'AgendaTemplateSelectModal',
    props: ['meeting', 'current_date'],
    components: {AgendaTemplatePreview},
    modal: null,
    data() {
        return {
            default_templates: [],
            org_templates: [],
            loading_list: false,
            loading_template: false,
            form: {
                data: {
                    meeting_id: this.meeting.id,
                    type: null,
                    id: null,
                    date: null,
                },
                submitting: false,
            },
        };
    },
    mounted() {
        this.$refs['agenda_template_select_modal'].addEventListener('hide.bs.modal', () => {
            this.reset();
        });
        this.modal = new Modal(this.$refs['agenda_template_select_modal']);
        if (this.current_date)
            this.form.data.date = this.current_date.id;
    },
    methods: {
        async open() {
            this.modal.show();
            await this.fetchItems();
            this.selectFirstTemplate();
        },
        async fetchItems() {
            this.loading = true;
            const response = await axios.get(Boardable.org_url + 'agenda-templates/list');
            this.default_templates = response.data['default_templates'];
            this.org_templates = response.data['org_templates'];
            this.loading = false;
        },
        submit() {
            this.form.submitting = true;
            axios.post(Boardable.org_url + 'agenda-templates/import', this.form.data)
                .then(() => {
                    this.form.submitting = false;
                    this.modal.hide();
                    this.$nextTick(() => { this.$emit('start_editing'); });
                });

        },
        selectDefaultTemplate(template_id) {
            this.loading_template = true;
            this.form.data.type = 'default';
            this.form.data.id = template_id;
        },
        selectOrgTemplate(template_id) {
            this.loading_template = true;
            this.form.data.type = 'org';
            this.form.data.id = template_id;
        },
        reset() {
            this.form.data.type = null;
            this.form.data.id = null;
            this.form.submitting = false;
            this.loading_list = false;
            this.loading_template = false;
        },
        selectFirstTemplate() {
            this.selectDefaultTemplate(this.default_templates[0].id);
        },
    },
    computed: {
        selectedTemplate() {
            if (this.form.data.type === 'default') {
                return this.default_templates.find((i) => i.id === this.form.data.id);
            }
            if (this.form.data.type === 'org') {
                return this.org_templates.find((i) => i.id === this.form.data.id);
            }
            return null;
        },
    },
    watch: {
        current_date() {
            this.form.data.date = this.current_date.id;
        },
    },
};

</script>

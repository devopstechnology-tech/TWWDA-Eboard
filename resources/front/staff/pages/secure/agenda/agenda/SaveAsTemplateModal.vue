<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="save-as-template-header" aria-hidden="true" ref="save-as-template-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="save-as-template-header">Save as template</h5>
                    <button type="button" class="btn btn-icon absolute right-2.5 top-2.5" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="new_or_existing_new" value="new" v-model="form.data.new_or_existing" />
                        <label class="form-check-label" for="new_or_existing_new">
                            Save as a new template
                        </label>
                    </div>
                    <div class="form-group px-6 mt-2 mb-8">
                        <label
                            class="form-label text-caps"
                            :class="{'opacity-75':form.data.new_or_existing !== 'new'}"
                            for="template_name"
                        >Name</label>
                        <input
                            class="form-control"
                            type="text"
                            id="template_name"
                            v-model="form.data.name"
                            :disabled="form.data.new_or_existing !== 'new'"
                        />
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="new_or_existing" id="new_or_existing_existing" value="existing" v-model="form.data.new_or_existing" />
                        <label class="form-check-label" for="new_or_existing_existing">
                            Replace existing template
                        </label>
                    </div>
                    <div class="form-group px-6 mt-2 mb-8">
                        <label
                            class="form-label text-caps"
                            for="existing_template"
                            :class="{'opacity-75':form.data.new_or_existing !== 'existing'}"
                        >
                            Choose template
                        </label>
                        <select
                            class="form-select"
                            id="existing_template"
                            v-model="form.data.template_id"
                            aria-label="template list"
                            :class="{'opacity-75':form.data.new_or_existing !== 'existing'}"
                            :disabled="form.data.new_or_existing !== 'existing'"
                        >
                            <option v-for="template in templates" :value="template.id">{{ template.name }}</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">

                    <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                    <button v-if="form.submitting" class="btn btn-primary h-10 disabled" disabled>
                        <loading-icon size="sm"></loading-icon>
                    </button>
                    <button v-else class="btn btn-primary h-10" @click="submit">
                        Save
                    </button>

                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'SaveAsTemplateModal',
    props: ['meeting', 'current_date'],
    modal: null,
    data() {
        return {
            form: {
                data: {
                    meeting_id: this.meeting.id,
                    new_or_existing: 'new',
                    name: '',
                    template_id: null,
                    date: null,
                },
                submitting: false,
            },
            templates: [],
        };
    },
    mounted() {
        this.modal = new Modal(this.$refs['save-as-template-modal']);
        if (this.current_date)
            this.form.data.date = this.current_date.id;
    },
    methods: {
        open() {
            this.modal.show();
            this.fetchTemplates();
        },
        submit() {
            this.form.submitting = true;
            axios.post(Boardable.org_url + 'agenda-templates', this.form.data)
                .then((response) => {
                    this.modal.hide();
                    $toast.success('Agenda template saved');
                    this.reset();
                });
        },
        fetchTemplates() {
            axios.get(Boardable.org_url + 'agenda-templates/list')
                .then((response) => {
                    this.templates = response.data.org_templates;
                });
        },
        reset() {
            this.form.data.name = '';
            this.form.data.new_or_existing = 'new';
            this.form.submitting = false;
            this.form.data.template_id = null;
        },
    },
};

</script>
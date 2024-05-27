<template>
    <app-modal :title="'New template'" as="div" id="create-template" ref="modal">

        <form @submit.prevent="submit">
            <div class="form-group">
                <label class="form-label" for="new-agenda-template-name">Name</label>
                <input type="text" v-model="form.data.name" class="form-control" id="new-agenda-template-name" />
                <p class="text-danger" v-if="form.errors['name']" v-text="form.errors['name'][0]"></p>
            </div>
            <div class="max-w-2xl">
                <legend class="form-label">List Style</legend>
                <div class="flex gap-2 max-w-2xl">
                    <agenda-template-icon
                        v-for="format in formats"
                        :key="format"
                        :format="format"
                        :selected_format="form.data.agenda_list_format"
                        class="flex-1 bg-white"
                        @format_selected="() => form.data.agenda_list_format = format"
                    ></agenda-template-icon>
                </div>
            </div>
        </form>

        <template #footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button v-if="form.submitting" class="btn btn-primary disabled h-10" disabled>
                <loading-icon size="sm"></loading-icon>
            </button>
            <button v-else type="submit" class="btn btn-primary h-10" @click="submit">Save</button>
        </template>

    </app-modal>
</template>

<script>

export default {
    name: 'AgendaTemplateCreateModal',
    props: ['default_list_format'],
    data() {
        return {
            form: {
                data: {
                    name: '',
                    agenda_list_format: this.default_list_format,
                },
                errors: {},
                submitting: false,
            },
            formats: ['num_la_lr', 'ua_la_lr', 'ur_ua_num', 'ur_la_num', 'numbers'],
        };
    },
    methods: {
        show() {
            this.$refs['modal'].show();
        },
        submit() {
            this.form.submitting = true;
            this.form.errors = [];
            axios.post(Boardable.org_url + 'agenda-templates', this.form.data)
                .then((response) => {
                    window.location = Boardable.org_url + 'agenda-templates/' + response.data.id + '/edit';
                })
                .catch((e) => { this.form.errors = e.response.data.errors; })
                .then(() => { this.form.submitting = false; });
        },
    },
};

</script>
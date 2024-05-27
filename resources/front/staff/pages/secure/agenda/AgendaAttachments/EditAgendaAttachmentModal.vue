<template>
    <app-modal ref="modal" size="md" id="`edit-agenda-attachment-${attachment.id}`" @hidden="() => $emit('hidden')">

        <template #header>
            <h3 class="modal-title">Edit agenda attachment</h3>
        </template>

        <form @submit.prevent="submit">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" class="form-control" v-model="form.data.name" />
                <p class="text-danger" v-if="form.errors.name">{{form.errors.name[0]}}</p>
            </div>
        </form>

        <template #footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary h-10" :disabled="form.submitting" @click="submit">
                <loading-icon size="sm" v-if="form.submitting"></loading-icon>
                <span v-else>Save</span>
            </button>
        </template>

    </app-modal>
</template>
<script>
export default {
    name: 'EditAgendaAttachmentModal',
    props: ['attachment'],
    data() {
        return {
            form: {
                submitting: false,
                errors: {},
                data: {
                    id: null,
                    name: null,
                },
            },
        };
    },
    mounted() {
        this.form.data.id = this.attachment.id;
        this.form.data.name = this.attachment.name;
    },
    methods: {
        open() {
            this.$refs.modal.show();
        },
        submit() {
            this.form.submitting = true;
            this.form.errors = {};
            axios.post(Boardable.org_url + 'agenda/uploads/update', this.form.data)
                .then((response) => {
                    this.$emit('agenda_attachment_updated', response.data.data);
                    this.$refs.modal.hide();
                })
                .catch((e) => this.form.errors = e.response.data.errors)
                .then(() => this.form.submitting = false);
        },
    },
};
</script>
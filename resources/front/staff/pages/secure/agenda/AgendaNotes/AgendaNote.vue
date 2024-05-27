<template>
    <div>
        <div v-if="!editing" class="group">

            <div class="relative">
                <div class="text-sm text-gray-700" v-text="displayDate"></div>
                <div class="hidden group-hover:block absolute right-0 -top-1">
                    <button class="btn btn-sm btn-icon" @click="edit">
                        <i class="fa-regular fa-pencil"></i>
                    </button>
                </div>
            </div>

            <div v-html="note.text"></div>
        </div>
        <div v-else class="bg-gray-200 p-4 -mx-6">
            <rich-text-editor v-model="form.data.text" :with_emoji_picker="false">
                <template v-slot:buttons>
                    <button class="btn btn-sm btn-secondary h-7 mr-2" @click="cancelEdit">Cancel</button>
                    <button v-if="form.submitting" class="btn-sm btn-primary h-7 opacity-75" disabled>
                        <loading-icon size="sm"></loading-icon>
                    </button>
                    <button v-else class="btn-sm btn-primary h-7" @click="saveNote">Save</button>
                </template>
                <template v-slot:addons_menu>
                    <button class="btn btn-sm btn-icon" @click="deleteNote">
                        <i class="fa-regular fa-trash-can text-red"></i>
                    </button>
                </template>
            </rich-text-editor>
        </div>
    </div>
</template>

<script>

export default {
    name: 'AgendaNote',
    props: ['note'],
    data() {
        return {
            editing: false,
            form: {
                data: {
                    text: '',
                    id: null,
                },
                submitting: false,
            },
            errors: [],
        };
    },
    mounted() {
        this.form.data.text = this.note.text;
        this.form.data.id = this.note.id;
    },
    methods: {
        edit() {
            this.editing = true;
        },
        cancelEdit() {
            this.editing = false;
            this.form.data.text = this.note.text;
        },
        saveNote() {
            this.form.submitting = true;
            axios.post(Boardable.org_url + 'agenda-notes/update', this.form.data)
                .then((response) => {
                    this.form.submitting = false;
                    this.editing = false;
                    this.note.text = response.data.text;
                });
        },
        deleteNote() {
            Alert.confirm('Do you want to delete this note?', () => {
                axios.post(Boardable.org_url + 'agenda-notes/delete', {id: this.note.id});
                this.$emit('note_deleted', this.note.id);
            });
        },
    },
    computed: {
        displayDate() {
            return localTime(this.note.created_at).format('MMM D, YYYY h:mma');
        },
    },
};

</script>
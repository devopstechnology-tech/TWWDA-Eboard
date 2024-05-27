<template>
    <card>

        <template v-slot:rich_title>
            <div class="w-full">
                <div class="uppercase text-xxs text-gray-700">My Notes</div>
                <h3 class="card-header-title h3 truncate w-full leading-5">{{ item.text }}</h3>
            </div>
        </template>

        <template v-slot:body>

            <loading-icon v-if="loading"></loading-icon>

            <div v-else>

                <agenda-note v-for="note in notes"
                             :note="note"
                             class="mb-6"
                             :key="'note'+note.id"
                             @note_deleted="handleNoteDeleted"
                ></agenda-note>

                <p class="text-danger" v-if="form.errors['text']">{{ form.errors['text'][0] }}</p>
                <rich-text-editor id="my-notes-editor" v-model="form.data.text" :with_emoji_picker="false" :min_height="120" placeholder="Add a note...">
                    <template v-slot:buttons>
                        <button v-if="form.submitting" class="btn-sm btn-primary h-7 opacity-75" disabled>
                            <loading-icon size="sm"></loading-icon>
                        </button>
                        <button v-else class="btn-sm btn-primary h-7" @click="createNote">Save</button>
                    </template>
                </rich-text-editor>
            </div>
        </template>
    </card>
</template>

<script>
import AgendaNote from './AgendaNote';
export default {
    name: 'AgendaNotes',
    components: {AgendaNote},
    props: ['item'],
    data() {
        return {
            notes: [],
            form: {
                data: {
                    text: '',
                    agenda_id: this.item.id,
                },
                submitting: false,
                errors: {},
            },
            text: '',
            loading: false,
        };
    },
    mounted() {
        this.fetchNotes();
    },
    methods: {
        fetchNotes() {
            this.loading = true;
            axios.get(Boardable.org_url + 'agenda/' + this.item.id)
                .then((response) => {
                    this.notes = response.data.notes;
                    this.loading = false;
                });
        },
        createNote() {
            this.form.submitting = true;
            this.form.errors = {};
            axios.post(Boardable.org_url + 'agenda-notes', this.form.data)
                .then((response) => {
                    this.notes.push(response.data);
                    this.resetForm();
                    this.$emit('agenda_note_added', response.data);
                })
                .catch((e) => {
                    this.form.errors = e.response.data.errors;
                    this.form.submitting = false;
                });
        },
        resetForm() {
            this.form.data = {
                text: '',
                agenda_id: this.item.id,
            };
            this.form.errors = {};
            this.form.submitting = false;
        },
        handleNoteDeleted(note_id) {
            const note = this.notes.find((note) => note.id === note_id);
            this.notes.splice(this.notes.indexOf(note), 1);
            this.$emit('note_deleted', note_id);
        },
    },
    watch: {
        item() {
            this.fetchNotes();
            this.resetForm();
        },
    },
};
</script>

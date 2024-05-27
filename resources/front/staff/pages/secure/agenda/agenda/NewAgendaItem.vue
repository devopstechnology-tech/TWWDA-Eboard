<template>
    <div>
        <div v-if="is_editing">
            <div v-if="form.errors['text']" class="text-danger">
                {{ form.errors['text'][0] }}
            </div>
            <div class="flex gap-x-2">
                <input type="text"
                       v-model="form.data.text"
                       class="form-control form-control-sm"
                       ref="input"
                       placeholder="Agenda item text"
                       @keyup.enter="submit"
                />
                <button class="btn btn-primary h-10" @click="submit">Save</button>
            </div>
            <a class="text-xs cursor-pointer" @click.prevent="disableEditing">cancel</a>
        </div>
        <div v-else-if="button_type === 'sub'">
            <a class="text-sm text-gray-600 cursor-pointer" @click.prevent="enableEditing">
                <FAIcon icon="plus"></FAIcon>
                sub item
            </a>
        </div>
        <div v-else-if="button_type === 'top'">
            <button class="btn btn-secondary block w-full" @click.prevent="enableEditing">
                Add agenda item
            </button>
        </div>
    </div>
</template>

<script>
import FAIcon from '../FAIcon';
export default {
    name: 'NewAgendaItem',
    components: {FAIcon},
    props: {
        parent_id: {},
        meeting: {},
        button_type: {default: 'sub'},
        start_active: {default: false},
        current_date: {default: null},
    },
    data() {
        return {
            is_editing: false,
            form: {
                data: {
                    text: '',
                    parent_id: this.parent_id,
                    date: this.current_date ? this.current_date.id : '',
                },
                submitting: false,
                errors: [],
            },
        };
    },
    mounted() {
        if (this.start_active) {
            this.enableEditing();
        }
    },
    methods: {
        enableEditing() {
            this.is_editing = true;
            this.$nextTick(() => this.$refs['input'].focus());
        },
        disableEditing() {
            this.reset();
            this.is_editing = false;
        },
        reset() {
            this.form.data.text = '';
        },
        submit() {
            this.form.submitting = true;
            this.form.errors = [];
            axios.post(this.meeting.url + '/agenda', this.form.data)
                .then((response) => {
                    this.form.submitting = false;
                    this.$emit('agenda_item_added', response.data);
                    this.reset();
                    this.$nextTick(() => this.$refs['input'].focus());
                })
                .catch((e) => {
                    this.form.errors = e.response.data.errors;
                    this.form.submitting = false;
                });
        },
    },
};
</script>
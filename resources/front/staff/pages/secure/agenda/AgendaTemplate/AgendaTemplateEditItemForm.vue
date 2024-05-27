<template>
    <card>
        <template v-slot:body>
            <div class="form-group">
                <label class="text-xs uppercase font-medium text-gray-700 tracking-wide">Text</label>
                <input type="text" v-model="form.data.text" class="form-control" placeholder="Text" />
            </div>
            <div class="form-group">
                <label class="text-xs uppercase font-medium text-gray-700 tracking-wide">Description</label>
                <rich-text-editor
                    ref="editor"
                    v-model="form.data.description"
                    :with_emoji_picker="false"
                    :min_height="100"
                    placeholder="Description"
                ></rich-text-editor>
            </div>
            <div class="flex justify-between">
                <button class="btn btn-link btn-sm text-danger h-7" @click="deleteItem">
                    Delete
                </button>
                <div>
                    <button class="btn btn-secondary btn-sm h-7" @click="cancel">Cancel</button>
                    <button v-if="form.submitting" class="btn btn-sm btn-primary h-7 opacity-75" disabled>
                        <loading-icon size="sm"></loading-icon>
                    </button>
                    <button v-else class="btn btn-sm btn-primary h-7" @click="submit">Save</button>
                </div>
            </div>
        </template>
    </card>
</template>

<script>

export default {
    name: 'AgendaTemplateEditItemForm',
    props: ['template_id', 'selected_item'],
    data() {
        return {
            form: {
                data: {
                    id: this.selected_item.id,
                    text: this.selected_item.text,
                    description: this.selected_item.description,
                },
                submitting: false,
            },
        };
    },
    methods: {
        deleteItem() {
            Alert.confirm('Do you want to delete this template item?', () => {
                axios.post(Boardable.org_url + 'agenda-template-items/delete', {id: this.selected_item.id})
                    .then(() => this.$emit('template_item_deleted', this.selected_item.id));
            });
        },
        cancel() {
            this.$emit('editing_cancelled');
        },
        submit() {
            this.form.submitting = true;
            const params = this.form.data;
            const url = Boardable.org_url + 'agenda-template-items/update';
            axios.post(url, params)
                .then((response) => {
                    this.$emit('template_item_updated', response.data);
                })
                .catch((e) => {
                    console.log(e.response);
                })
                .then(() => {
                    this.form.submitting = false;
                });
        },
    },
    watch: {
        selected_item() {
            this.form.data.text = this.selected_item.text;
            this.form.data.description = this.selected_item.description;
            this.form.data.id = this.selected_item.id;
            this.$nextTick(() => this.$refs['editor'].reset());
        },
    },
};

</script>
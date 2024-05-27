<template>
    <card class="mb-0">
        <template v-slot:body>
            <div class="form-group">
                <label class="text-xs uppercase font-medium text-gray-700 tracking-wide">Text</label>
                <input type="text" v-model="form.data.text" class="form-control" placeholder="Text" />
                <p v-if="form.errors['text']" class="text-danger">{{ form.errors['text'][0] }}</p>
            </div>
            <div class="form-group">
                <label class="text-xs uppercase font-medium text-gray-700 tracking-wide">Description</label>
                <rich-text-editor
                    ref="editor"
                    v-model="form.data.description"
                    :with_emoji_picker="false"
                    :min_height="100"
                    placeholder="Description"
                    class="rich-text-editor"
                ></rich-text-editor>
            </div>
            <div class="form-group">
                <label class="text-xs uppercase font-medium text-gray-700 tracking-wide">Duration</label>
                <select class="form-control" v-model="form.data.duration">
                    <option value="0">- none -</option>
                    <option v-for="i in durationOptions" :value="i">{{ i }} minutes</option>
                </select>
            </div>
            <div class="form-group">
                <label class="text-xs uppercase font-medium text-gray-700 tracking-wide">People Responsible</label>
                <user-and-group-select
                    :assignable_users="assignablePeople"
                    :assignable_groups="[]"
                    :user_ids="assignedPeopleIds"
                    @updated_user_ids="handleUsersUpdated"
                    :empty_state="false"
                    :list_labels="false"
                    ref="user_select"
                    :condensed="true"
                    :show_recently_removed="false"
                    :orderable="true"
                ></user-and-group-select>
            </div>
            <div class="form-group">
                <label class="text-xs uppercase font-medium text-gray-700 tracking-wide">Attachments</label>
                <drop-zone @files-added="handleDroppedFiles">
                    <template #default="{ dropZoneActive }">
                        <div class="relative">
                            <attachments-menu v-model="attachments">
                                <template v-slot:label>
                                    <button class="btn btn-secondary block w-full" aria-label="Attach a document">
                                        <i class="fa-regular fa-paperclip" aria-hidden="true"></i>
                                        Attach a document
                                    </button>
                                </template>
                            </attachments-menu>
                            <attachments-list
                                class="mt-2"
                                :attachments="attachments"
                                @attachment_removed="handleAttachmentRemoved"
                                :removable="true"
                                :sortable="true"
                                @sorting_started="handleAttachmentsSortingStarted"
                                @sorting_ended="handleAttachmentsSortingEnded"
                            />
                            <div v-if="dropZoneActive && !sorting_attachments"
                                 class="absolute inset-0 bg-gray-300 opacity-50 rounded-lg"
                            ></div>
                        </div>
                    </template>
                </drop-zone>
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

import DropZone from '../../frontend/DropZone';
import AttachmentsFormData from '../../support/AttachmentsFormData';

export default {
    name: 'AgendaEditItemForm',
    props: ['item', 'meeting'],
    components: {DropZone},
    data() {
        return {
            form: {
                data: {
                    id: null,
                    text: '',
                    description: '',
                    people_responsible: [],
                    duration: 0,
                },
                submitting: false,
                errors: [],
            },
            attachments: [],
            sorting_attachments: false,
            attachments_changed: false,
        };
    },
    mounted() {
        this.form.data.id = this.item.id;
        this.form.data.text = this.item.text;
        this.form.data.description = this.item.description;
        this.form.data.people_responsible = this.assignedPeopleIds;
        this.form.data.duration = this.item.duration;
        this.attachments = this.item.uploads;
        this.$nextTick(() => { this.attachments_changed = false; });
    },
    methods: {
        submit() {
            this.form.submitting = true;
            this.form.errors = [];
            const form_data = (new AttachmentsFormData(this.attachments)).export();
            form_data.append('id', this.form.data.id);
            form_data.append('text', this.form.data.text);
            form_data.append('description', this.form.data.description);
            this.form.data.people_responsible.forEach(
                p => form_data.append('people_responsible[]', p),
            );
            form_data.append('duration', this.form.data.duration);
            axios.post(this.meeting.url + '/agenda/update', form_data)
                .then((response) => {
                    this.$emit('agenda_item_updated', response.data.data);
                    this.form.submitting = false;
                    this.attachments = response.data.uploads;
                    this.attachments_changed = false;
                })
                .catch((e) => {
                    this.form.submitting = false;
                    this.form.errors = e.response.data.errors;
                    console.log(e.response);
                });
        },
        handleAttachmentRemoved(attachment) {
            this.attachments.splice(this.attachments.indexOf(attachment), 1);
        },
        cancel() {
            this.$emit('editing_cancelled');
        },
        deleteItem() {
            Alert.confirm('Do you want to delete this agenda item?', () => {
                axios.post(Boardable.org_url + 'agenda/delete', {id: this.item.id})
                    .then(() => this.$emit('agenda_item_deleted', this.item.id));
            });
        },
        handleDroppedFiles(files) {
            files.forEach(f => {
                const attachment = {type: 'upload', file: f};
                this.attachments.push(attachment);
            });
        },
        handleAttachmentsSortingStarted() {
            this.sorting_attachments = true;
        },
        handleAttachmentsSortingEnded() {
            setTimeout(() => {
                this.sorting_attachments = false;
            }, 300);
        },
        handleUsersUpdated(user_ids) {
            this.form.data.people_responsible = user_ids;
        },
    },
    computed: {
        assignablePeople() {
            return [...this.meeting.members, ...this.meeting.guest_members, ...this.meeting.guests];
        },
        assignedPeopleIds() {
            return this.item.people_responsible.map(u => u.id);
        },
        durationOptions() {
            const options = [];
            const meeting_duration = moment(this.meeting.end).diff(moment(this.meeting.start));
            const minutes = (moment.duration(meeting_duration).hours() * 60) + moment.duration(meeting_duration).minutes();
            for (let i = 5; i <= minutes; i = i+5) {
                if (i >= this.item.duration_range.min && i <= this.item.duration_range.max) {
                    options.push(i);
                }
            }
            return options;
        },
        isDirty() {
            return this.attachments_changed
                || this.form.data.text !== this.item.text
                || this.form.data.description !== this.item.description
                || this.form.data.duration !== this.item.duration
                || this.form.data.people_responsible.sort().join(',') !== this.assignedPeopleIds.sort().join(',');
        },
    },
    watch: {
        item(new_val) {
            this.form.data.id = new_val.id;
            this.form.data.text = new_val.text;
            this.form.data.description = new_val.description;
            this.form.data.people_responsible = this.assignedPeopleIds;
            this.form.data.duration = new_val.duration;
            this.attachments = new_val.uploads;
            this.$nextTick(() => {
                this.$refs['editor'].reset();
                this.$refs['user_select'].reset();
                this.attachments_changed = false;
            });
        },
        attachments() {
            this.attachments_changed = true;
        },
    },
};

</script>
i have 4 folders:  Agenda template, Agendanotes, anda attchment and agenda itself, let shsow what is in each folder: for agenda we have folder wee have: <template>
    <div>
        <button
            v-if="isAdmin || has_bpqp"
            class="btn btn-secondary"
            :class="{'disabled': !num_agenda_uploads}"
            @click="openBoardPacketModal"
        >
            <i class="fa-regular fa-print mr-1"></i>
            Board Packet
        </button>

        <button
            v-else
            class="btn btn-secondary"
            @click="() => $refs['board_packet_upgrade_modal'].open()"
        >
            <i class="fa-regular fa-print mr-0.5"></i>
            Board Packet
        </button>

        <board-packet-modal
            ref="board_packet_modal"
            :meeting="meeting"
            :current_date="current_date"
            :has_bpqp="has_bpqp"
        ></board-packet-modal>

        <board-packet-upgrade-modal ref="board_packet_upgrade_modal"></board-packet-upgrade-modal>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Agenda Options
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" class="dropdown-item" @click="() => $refs['save_as_template_modal'].open()">Save as template</a>
                    <portal to="modals">
                        <save-as-template-modal :meeting="meeting" :current_date="current_date" ref="save_as_template_modal"></save-as-template-modal>
                    </portal>
                </li>
                <li>
                    <a :href="pdfUrl" target="_blank" class="dropdown-item">View as PDF</a>
                </li>
                <li>
                    <a :href="pdfNoDocsUrl" target="_blank" class="dropdown-item">View PDF (No Docs)</a>
                </li>
                <li>
                    <a :href="browserUrl" target="_blank" class="dropdown-item">View in browser</a>
                </li>
                <li>
                    <a href="#" class="dropdown-item" @click.prevent="$refs['agenda_settings_modal'].open()">Agenda settings</a>
                    <portal to="modals">
                        <agenda-settings-modal
                            :meeting="meeting"
                            :current_date="current_date"
                            ref="agenda_settings_modal"
                            @agenda_format_updated="(format) => $emit('agenda_format_updated', format)"
                        ></agenda-settings-modal>
                    </portal>
                </li>
                <li>
                    <a href="#" class="dropdown-item dropdown-item text-red hover:text-red hover:bg-red-soft" @click.prevent="handleClearAgenda">Clear Agenda</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

import BoardPacketUpgradeModal from '../Meetings/BoardPacketUpgradeModal.vue';
import AgendaSettingsModal from './AgendaSettingsModal.vue';
import SaveAsTemplateModal from './SaveAsTemplateModal.vue';
export default {
    name: 'AgendaAdminMenu',
    components: {BoardPacketUpgradeModal, AgendaSettingsModal, SaveAsTemplateModal},
    props: ['meeting', 'num_agenda_uploads', 'has_bpqp', 'current_date'],
    methods: {
        handleOpenTemplateModal() {
            this.$refs['save_as_template_modal'].open();
        },
        handleClearAgenda() {
            Alert.confirm({
                title: 'Clear agenda',
                message: 'Are you sure you want delete all the items in this agenda?',
                button_label: 'Clear',
                footer_text: 'This action cannot be undone',
            }, () => {

                let url = this.meeting.url + '/agenda/clear';
                if (this.current_date)
                    url += '?date=' + this.current_date.id;

                axios.post(url).then(() => this.$emit('agenda_cleared'));});
        },
        openBoardPacketModal() {
            if (this.has_bpqp)
                this.$refs['board_packet_modal'].show();
            else
                this.$refs['board_packet_upgrade_modal'].open();
        },
    },
    computed: {
        isAdmin() {
            return Boardable.user.isAdmin;
        },
        pdfUrl() {
            let url = this.meeting.url + '/agenda/pdf';
            if (this.current_date)
                url += '?date=' + this.current_date.id;

            return url;
        },
        pdfNoDocsUrl() {
            let url = this.meeting.url + '/agenda/pdf/no_docs';
            if (this.current_date)
                url += '?date=' + this.current_date.id;

            return url;
        },
        browserUrl() {
            let url = this.meeting.url + '/agenda?open=1';
            if (this.current_date)
                url += '&date=' + this.current_date.id;

            return url;
        },
    },
};

</script>, <template>
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

import DropZone from "../../frontend/DropZone";
import AttachmentsFormData from "../../support/AttachmentsFormData";

export default {
    name: "AgendaEditItemForm",
    props: ['item', 'meeting'],
    components: { DropZone },
    data() {
        return {
            form: {
                data: {
                    id: null,
                    text: '',
                    description: '',
                    people_responsible: [],
                    duration: 0
                },
                submitting: false,
                errors: []
            },
            attachments: [],
            sorting_attachments: false,
            attachments_changed: false
        }
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
            let form_data = (new AttachmentsFormData(this.attachments)).export();
            form_data.append('id', this.form.data.id);
            form_data.append('text', this.form.data.text);
            form_data.append('description', this.form.data.description);
            this.form.data.people_responsible.forEach(
                p => form_data.append('people_responsible[]', p)
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
                axios.post(Boardable.org_url + 'agenda/delete', { id: this.item.id })
                    .then(() => this.$emit('agenda_item_deleted', this.item.id));
            });
        },
        handleDroppedFiles(files) {
            files.forEach(f => {
                let attachment = {type: 'upload', file: f};
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
        }
    },
    computed: {
        assignablePeople() {
            return [...this.meeting.members, ...this.meeting.guest_members, ...this.meeting.guests];
        },
        assignedPeopleIds() {
            return this.item.people_responsible.map(u => u.id);
        },
        durationOptions() {
            let options = [];
            let meeting_duration = moment(this.meeting.end).diff(moment(this.meeting.start));
            let minutes = (moment.duration(meeting_duration).hours() * 60) + moment.duration(meeting_duration).minutes();
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
        }
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
        }
    }
}

</script>, <template>
    <draggable
        :list="items"
        :disabled="disableDraggable"
        tag="ol"
        @change="() => $emit('order_updated', level)"
        :group="{ name: 'agenda' }"
        ghost-class="agenda-sort-placeholder"
        :swapThreshold="0.65"
        :emptyInsertThreshold="40"
    >
        <agenda-list-item-edit
            v-for="item in items"
            :key="'agenda'+item.id"
            :item="item"
            :level="level"
            :selected_item="selected_item"
            :meeting="meeting"
            @item_selected="(i) => $emit('item_selected', i)"
            @agenda_item_added="(i) => $emit('agenda_item_added', i)"
            @order_updated="() => $emit('order_updated')"
        ></agenda-list-item-edit>
    </draggable>
</template>

<script>

import draggable from 'vuedraggable';

export default {
    name: "AgendaListEdit",
    components: { draggable },
    props: ['items', 'meeting', 'selected_item', 'level'],
    computed: {
      disableDraggable() {
        // Tests whether there is no input device that can hover over components (only touch screen available)
        return window.matchMedia("(any-hover: none)").matches
      }
    }
}

</script>, <template>
    <li class="mb-2 hover:border-gray-400 border-l border-transparent">
        <div class="rounded-lg border border-transparent hover:cursor-pointer -ml-7 p-2 pl-7 relative"
             :class="{'border-blue': itemIsSelected}"
             @click="() => $emit('item_selected', item)"
        >
            <div v-if="item.time"
                 class="absolute border -right-16 top-4 text-[10px] rounded text-center py-0.5 text-gray-700 z-10 border-gray-200"
                 :class="{'bg-gray-200 px-2': level === 0, 'bg-white px-1': level > 0}"
            >
                {{ displayTime }}
            </div>
            <div class="flex gap-2 items-start">
                <div class="font-medium flex-1">
                    {{ item.text }}
                    <div v-if="item.description" v-html="item.description" class="text-sm text-gray-800 font-normal"></div>
                    <attachments-list v-if="item.uploads.length" :attachments="item.uploads" class="mt-2" context="agenda" :inline="true"></attachments-list>
                </div>
                <div class="flex items-center gap-2 mt-1 h-6">
                    <div v-if="item.duration" class="text-xs text-gray-600">
                        {{ item.duration }} minutes
                    </div>
                </div>
                <div>
                    <ul class="list-none">
                        <li v-if="item.people_responsible.length"  v-for="person in item.people_responsible" class="text-sm text-gray-800">
                            {{ person.name }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <agenda-list-edit
            v-if="level < 2"
            :items="item.agenda"
            :level="level + 1"
            :selected_item="selected_item"
            :meeting="meeting"
            @item_selected="(i) => $emit('item_selected', i)"
            @agenda_item_added="(i) => $emit('agenda_item_added', i)"
            @order_updated="() => $emit('order_updated')"
            class="min-h-6"
        ></agenda-list-edit>

        <new-agenda-item
            v-if="level < 2"
            :parent_id="item.id"
            :meeting="meeting"
            @agenda_item_added="(i) => $emit('agenda_item_added', i)"
        ></new-agenda-item>
    </li>
</template>

<script>

import NewAgendaItem from "./NewAgendaItem";

export default {
    name: "AgendaListItemEdit",
    props: ['item', 'selected_item', 'level', 'meeting'],
    components: { NewAgendaItem },
    computed: {
        itemIsSelected() {
            return this.selected_item && this.selected_item.id === this.item.id;
        },
        displayTime() {
            return localTime(this.item.time).format('h:mma');
        }
    }
}

</script>, <template>
    <li class="mb-2">
        <div class="rounded-lg border border-transparent hover:cursor-pointer -ml-7 p-2 pl-7 relative"
             :class="{'border-blue': itemIsSelected}"
             @click="() => $emit('item_selected', item)"
        >
            <div v-if="item.time"
                 class="absolute border -right-16 top-4 text-[10px] rounded text-center py-0.5 text-gray-700 z-10 border-gray-200"
                 :class="{'bg-gray-200 px-2': level === 0, 'bg-white px-1': level > 0}"
            >
                {{ displayTime }}
            </div>
            <div class="flex gap-2 items-start">
                <div class="font-medium flex-1">
                    {{ item.text }}
                    <span v-if="item.user_notes && item.user_notes.length && !include_user_notes" class="text-gray-600 ml-2">
                        <i class="fa-solid fa-notebook"></i>
                        <span v-text="item.user_notes.length"></span>
                    </span>
                    <div v-if="item.description" v-html="item.description" class="text-sm text-gray-800"></div>
                    <attachments-list
                        v-if="item.uploads.length && !no_docs"
                        :attachments="item.uploads"
                        class="mt-2" context="agenda"
                        :inline="true"
                    ></attachments-list>
                    <div v-if="include_user_notes && item.user_notes.length" class="bg-yellow-soft px-4 py-3 flex rounded-lg">
                        <div class="mr-3">
                            <i class="fa-regular fa-note"></i>
                        </div>
                        <div>
                            <div class="font-medium mb-2">My Notes</div>
                            <div v-for="note in item.user_notes" v-html="note.text" class="text-sm"></div>
                        </div>
                    </div>
                </div>
                <div>
                    <ul class="list-none">
                        <li v-if="item.people_responsible.length"  v-for="person in item.people_responsible" class="text-sm text-gray-800">
                            {{ person.name }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <agenda-list-view
            v-if="item.agenda.length"
            :items="item.agenda"
            :selected_item="selected_item"
            @item_selected="(i) => $emit('item_selected', i)"
            :level="level+1"
            :ignore_thumbnails="ignore_thumbnails"
            :include_user_notes="include_user_notes"
            :no_docs="no_docs"
        ></agenda-list-view>
    </li>
</template>

<script>

import AvatarGroup from "../../frontend/AvatarGroup";
import AttachmentsListShowCondensed from "../Attachments/AttachmentsListShowCondensed";

export default {
    name: "AgendaListItem",
    components: {AttachmentsListShowCondensed, AvatarGroup },
    props: ['item', 'selected_item', 'level', 'ignore_thumbnails', 'include_user_notes', 'no_docs'],
    computed: {
        itemIsSelected() {
            return this.selected_item && this.selected_item.id === this.item.id;
        },
        displayTime() {
            return localTime(this.item.time).format('h:mma');
        }
    }
}

</script>, <template>
    <ol>
        <agenda-list-item-view
            v-for="item in items"
            :item="item"
            :selected_item="selected_item"
            @item_selected="(i) => $emit('item_selected', i)"
            :key="'agenda' + item.id"
            :level="level"
            :ignore_thumbnails="ignore_thumbnails"
            :include_user_notes="include_user_notes"
            :no_docs="no_docs"
        ></agenda-list-item-view>
    </ol>
</template>

<script>

export default {
    name: "AgendaList",
    props: {
        'items': {},
        'selected_item': { default: null },
        'level': {},
        'ignore_thumbnails': { default: false },
        'include_user_notes': { default: false },
        'no_docs': { default: false }
    }
}

</script>, <template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="agenda-settings-header" aria-hidden="true" ref="agenda-settings-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="agenda-settings-header">Agenda settings</h5>
                    <button type="button" class="btn btn-icon absolute right-2.5 top-2.5" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-regular fa-xmark"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="max-w-2xl mx-auto my-4">

                        <div class="text-caps mb-2">Choose a list style</div>
                        <div class="flex gap-4">

                            <agenda-template-icon
                                format="num_la_lr"
                                :selected_format="form.data.agenda_list_format"
                                class="flex-1"
                                @format_selected="form.data.agenda_list_format = 'num_la_lr'"
                            ></agenda-template-icon>

                            <agenda-template-icon
                                format="ua_la_lr"
                                :selected_format="form.data.agenda_list_format"
                                class="flex-1"
                                @format_selected="form.data.agenda_list_format = 'ua_la_lr'"
                            ></agenda-template-icon>

                            <agenda-template-icon
                                format="ur_ua_num"
                                :selected_format="form.data.agenda_list_format"
                                class="flex-1"
                                @format_selected="form.data.agenda_list_format = 'ur_ua_num'"
                            ></agenda-template-icon>

                            <agenda-template-icon
                                format="ur_la_num"
                                :selected_format="form.data.agenda_list_format"
                                class="flex-1"
                                @format_selected="form.data.agenda_list_format = 'ur_la_num'"
                            ></agenda-template-icon>

                            <agenda-template-icon
                                format="numbers"
                                :selected_format="form.data.agenda_list_format"
                                class="flex-1"
                                @format_selected="form.data.agenda_list_format = 'numbers'"
                            ></agenda-template-icon>

                        </div>

                    </div>
                </div>

                <div class="modal-footer">

                    <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>

                    <button v-if="form.submitting" class="btn btn-primary h-10 disabled" disabled>
                        <loading-icon size="sm"></loading-icon>
                    </button>
                    <button v-else class="btn btn-primary h-10" @click="submit" :disabled="form.data.agenda_list_format === ''">
                        Save
                    </button>

                </div>
            </div>
        </div>
    </div>
</template>

<script>

import AgendaTemplateIcon from "../AgendaTemplates/AgendaTemplateIcon";

export default {
    name: "AgendaSettingsModal",
    components: {AgendaTemplateIcon},
    props: ['meeting', 'current_date'],
    modal: null,
    data() {
        return {
            form: {
                data: {
                    agenda_list_format: null,
                    date: null
                },
                submitting: false
            }
        }
    },
    mounted() {
        this.modal = new Modal(this.$refs['agenda-settings-modal']);
        this.form.data.agenda_list_format = this.current_date
            ? this.current_date.agenda_list_format
            : this.meeting.agenda_list_format;
        this.form.data.date = this.current_date ? this.current_date.id : null;
    },
    methods: {
        submit() {
            this.form.submitting = true;
            axios.post(this.meeting.url + '/agenda/settings/update', this.form.data)
                .then(() => {
                    this.$emit('agenda_format_updated', this.form.data.agenda_list_format);
                    this.form.submitting = false;
                    this.modal.hide();
                })
        },
        open() {
            this.modal.show();
        },
        setValue(val) {
            this.form.data.agenda_list_format = val;
        }
    }
}

</script>, <template>
    <card class="max-w-3xl mx-auto">
        <template v-slot:body>
            <div class="flex flex-col items-center justify-center py-4">

                <div class="text-gray-900">How would you like to start?</div>

                <div class="mt-8 w-full max-w-lg">

                    <image-card
                        image_src="/img/bg_abstract-green.png"
                        image_alt="Start with a template backdrop"
                        title="Start with a template"
                        icon="fa-regular fa-list"
                        class="hover:bg-gray-200 hover:border-gray-500 cursor-pointer"
                        @click.native="startFromTemplate"
                    ></image-card>

                    <portal to="modals">
                        <agenda-template-select-modal
                            ref="agenda_template_select_modal"
                            :meeting="meeting"
                            :current_date="current_date"
                            @start_editing="() => $emit('start_editing')"
                        ></agenda-template-select-modal>
                    </portal>

                    <image-card
                        v-if="can_import_previous_agenda"
                        image_src="/img/bg_abstract-orange.png"
                        image_alt="Start from last meetings's agenda backdrop"
                        title="Start with last meeting's agenda"
                        icon="fa-regular fa-file"
                        class="hover:bg-gray-200 hover:border-gray-500 cursor-pointer"
                        @click.native="importFromPreviousMeeting"
                    ></image-card>

                    <image-card
                        image_src="/img/bg_abstract-blue.png"
                        image_alt="Start from scratch backdrop"
                        title="Start from scratch"
                        icon="fa-regular fa-file"
                        class="hover:bg-gray-200 hover:border-gray-500 cursor-pointer"
                        @click.native="startFromScratch"
                    ></image-card>

                </div>
            </div>
        </template>
    </card>
</template>

<script>

import AgendaTemplateSelectModal from "../AgendaTemplates/AgendaTemplateSelectModal";
export default {
    name: "AgendaStart",
    components: { AgendaTemplateSelectModal },
    props: ['meeting', 'can_import_previous_agenda', 'current_date'],
    methods: {
        startFromScratch() {
            this.$emit('start_editing');
        },
        startFromTemplate() {
            this.$refs['agenda_template_select_modal'].open();
        },
        importFromPreviousMeeting() {
            axios.post(this.meeting.url + '/agenda/import-previous')
                .then(() => {
                    this.$emit('start_editing');
                });
        }
    }
}

</script>,<template>
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
                <button v-if="form.submitting" class="btn btn-primary disabled h-10" disabled>
                    <loading-icon size="sm"></loading-icon>
                </button>
                <button v-else class="btn btn-primary h-10" @click="submit">Save</button>
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
import FAIcon from "../FAIcon";
export default {
    name: "NewAgendaItem",
    components: {FAIcon},
    props: {
        parent_id: {},
        meeting: {},
        button_type: { default: 'sub' },
        start_active: { default: false },
        current_date: { default: null }
    },
    data() {
        return {
            is_editing: false,
            form: {
                data: {
                    text: '',
                    parent_id: this.parent_id,
                    date: this.current_date ? this.current_date.id : ''
                },
                submitting: false,
                errors: []
            }
        }
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
        }
    }
}
</script>, <template>
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
    name: "SaveAsTemplateModal",
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
                    date: null
                },
                submitting: false
            },
            templates: []
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
                })
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
        }
    }
}

</script> nowon AgendaAttachments we have: <template>
    <table class="table mb-0 w-full">
        <tbody>
            <tr>
                <td class="w-12">
                    <a :href="url" class="w-12 h-12 flex justify-center items-center block cursor-pointer relative">
                        <img src="/img/icons/doc_center/folder.svg" class="w-12">
                        <div
                            class="bg-white rounded-full absolute -bottom-0.5 -right-0.5 text-gray-600 flex justify-center items-center drop-shadow-sm"
                            style="font-size: 9px; width: 17px; height: 17px;"
                        >
                            <i class="fa-solid fa-link"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <span class="relative max-w-full flex align-text-bottom h-6">
                        <span class="absolute whitespace-nowrap overflow-x-hidden max-w-full w-full top-0 left-0 text-ellipsis">
                            <a :href="url" class="text-gray-900 cursor-pointer">
                                Agenda Documents
                            </a>
                        </span>
                    </span>
                </td>
                <td class="w-20 hidden sm:table-cell text-center">
                    <button
                        v-if="download_enabled"
                        :disabled="!num_agenda_attachments"
                        class="btn btn-secondary !border-transparent w-10"
                        @click="handleDownloadAgendaFolder"
                    >
                        <i class="fa-regular fa-arrow-down-to-line"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
export default {
    name: 'AgendaAttachmentsFolder',
    props: ['url', 'num_agenda_attachments'],
    inject: ['download_enabled'],
    methods: {
        handleDownloadAgendaFolder() {
            window.open(this.url + '/download');
        }
    }
}
</script>, <template>
    <tr>
        <td class="w-12">
            <a :href="url"
               class="w-12 h-12 flex justify-center items-center block"
            >
                <img :src="iconUrl"
                     class="h-12 w-12 object-contain mx-auto rounded"
                     :class="{
                        'border border-gray-200': attachment.pdf && attachment.pdf.isConverted,
                        'google-thumb': attachment.type === 'google',
                        'dropbox-thumb': attachment.type === 'dropbox',
                        'onedrive-thumb': attachment.type === 'onedrive'
                     }"
                />
            </a>
        </td>

        <td>
            <span class="relative max-w-full flex align-text-bottom h-6">
                <span class="absolute whitespace-nowrap overflow-x-hidden max-w-full w-full top-0 left-0 text-ellipsis">
                    <a :href="url" class="text-gray-900">
                        {{ attachment.name }}
                    </a>
                </span>
            </span>
        </td>

        <td class="w-28 hidden sm:table-cell">
            <div class="whitespace-nowrap text-sm">{{ displayDate }}</div>
            <div class="whitespace-nowrap text-xs text-muted">{{ displayTime }}</div>
        </td>

        <td class="w-20">
            <div v-if="is_admin" class="dropdown">
                <button
                    class="btn btn-secondary !border-transparent w-10"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#" class="dropdown-item" @click.prevent="handleEdit">Edit</a>
                        <portal to="modals" v-if="editing">
                            <edit-agenda-attachment-modal
                                :attachment="attachment"
                                ref="edit_modal"
                                @agenda_attachment_updated="(attachment) => $emit('agenda_attachment_updated', attachment)"
                                @hidden="() => editing = false"
                            ></edit-agenda-attachment-modal>
                        </portal>
                    </li>
                    <li v-if="downloadUrl && !attachment?.disable_downloads">
                        <a :href="downloadUrl" download class="dropdown-item">Download</a>
                    </li>
                    <li v-else-if="openUrl">
                        <a :href="openUrl" class="dropdown-item" target="_blank">Open</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a href="#" class="dropdown-item text-danger" @click.prevent="handleDelete">Delete</a>
                    </li>
                </ul>
            </div>

            <a v-else-if="downloadUrl"
               class="btn btn-secondary !border-transparent w-10"
               :href="downloadUrl"
               download
            >
                <i class="fa-regular fa-arrow-down-to-line" />
            </a>

            <a v-else-if="openUrl"
               class="btn btn-secondary !border-transparent w-10 text-sm"
               :href="openUrl"
               target="_blank"
            >
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
        </td>
    </tr>
</template>
<script>
import EditAgendaAttachmentModal from "./EditAgendaAttachmentModal.vue";

export default {
    name: 'AgendaAttachmentsItem',
    components: {EditAgendaAttachmentModal},
    props: ['attachment', 'is_admin'],
    data() {
        return {
            editing: false
        };
    },
    methods: {
        handleDelete() {
            Alert.confirm('Do you want to remove this attachment?', () => {
                axios.post(Boardable.org_url + 'agenda/uploads/delete', { id: this.attachment.id});
                this.$emit('agenda_attachment_removed', this.attachment);
            });
        },
        handleEdit() {
            this.editing = true;
            this.$nextTick(() => {
                this.$refs['edit_modal'].open();
            })
        }
    },
    computed: {
        url() {
            return window.Boardable.org_url + 'documents/' + this.attachment.uuid.short_slug + '?redirect=docs';
        },
        displayDate() {
            let date_str = this.attachment.updated_at;
            date_str = typeof date_str === 'string' ? date_str : date_str.date;
            return localTime(date_str).format("MMM DD, YYYY");
        },
        displayTime() {
            let date_str = this.attachment.updated_at;
            date_str = typeof date_str === 'string' ? date_str : date_str.date;
            return localTime(date_str).format("h:mm A");
        },
        iconUrl() {
            if (this.attachment.type === 'document') {
                return this.attachment.document.iconUrl;
            }
            if (this.attachment.pdf && this.attachment.pdf.isConverted) {
                return this.attachment.pdf.thumbUrl;
            }
            return this.attachment.icon_url;
        },
        downloadUrl() {
            if (this.attachment.type === 'upload')
                return this.attachment.url;
            if (this.attachment.type === 'document' && this.attachment.document.upload_type === 'computer')
                return this.attachment.document.downloadUrl;
            return null;
        },
        openUrl() {
            if (['google', 'dropbox', 'onedrive'].includes(this.attachment.type))
                return this.attachment.url;
            if (this.attachment.type === 'document' && ['google', 'dropbox', 'onedrive'].includes(this.attachment.document.upload_type))
                return this.attachment.document.downloadUrl;
            return null;
        }
    }
}
</script>, <template>
    <div>
        <div class="p-4 bg-gray-100 rounded-lg my-4">
            <div class="flex">
                <div class="flex-1">
                    <h2 class="mb-0">Agenda documents</h2>
                    <div class="text-sm mt-2.5 text-gray-700">
                        <span class="mr-1"><i class="fa-solid fa-link"></i></span>
                        This folder is synced with the agenda. All documents attached to the agenda will be displayed here.
                    </div>
                </div>
                <div v-if="download_enabled">
                    <button class="btn btn-secondary btn-sm" @click="handleDownloadAgendaFolder" :disabled="!(attachments && attachments.length)">
                        <span class="mr-1"><i class="fa-regular fa-arrow-down-to-line"></i></span> Download
                    </button>
                </div>
            </div>
        </div>
        <table class="table" v-if="attachments && attachments.length">
            <tbody>
                <agenda-attachments-item
                    v-for="attachment in attachments"
                    :attachment="attachment"
                    :key="'attachment'+attachment.id"
                    :is_admin="is_admin"
                    @agenda_attachment_removed="(attachment) => $emit('agenda_attachment_removed', attachment)"
                    @agenda_attachment_updated="(attachment) => $emit('agenda_attachment_updated', attachment)"
                ></agenda-attachments-item>
            </tbody>
        </table>
        <empty-state
            v-else
            type="documents"
            :text="emptyStateText"
        ></empty-state>
    </div>
</template>
<script>
import AttachmentFolderMenu from "../Attachments/AttachmentFolderMenu.vue";
import AgendaAttachmentsItem from "./AgendaAttachmentsItem.vue";

export default {
    name: 'AgendaAttachmentsTable',
    components: {AgendaAttachmentsItem, AttachmentFolderMenu},
    props: ['attachments', 'meeting', 'is_admin'],
    inject: ['download_enabled'],
    methods: {
        handleDownloadAgendaFolder() {
            window.open(Boardable.app_url + window.location.pathname + '/download');
        }
    },
    computed: {
        emptyStateText() {
            return 'No documents are attached to the agenda yet';
        }
    }
}
</script>, <template>
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
                    name: null
                }
            }
        }
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
        }
    }
}
</script> now in AgendaNotes we have: <template>
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
    name: "AgendaNote",
    props: ['note'],
    data() {
        return {
            editing: false,
            form: {
                data: {
                    text: '',
                    id: null
                },
                submitting: false,
            },
            errors: []
        }
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
                axios.post(Boardable.org_url + 'agenda-notes/delete', { id: this.note.id });
                this.$emit('note_deleted', this.note.id);
            });
        }
    },
    computed: {
        displayDate() {
            return localTime(this.note.created_at).format('MMM D, YYYY h:mma');
        }
    }
}

</script>, <template>
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
import AgendaNote from "./AgendaNote";
export default {
    name: "AgendaNotes",
    components: {AgendaNote},
    props: ['item'],
    data() {
        return {
            notes: [],
            form: {
                data: {
                    text: '',
                    agenda_id: this.item.id
                },
                submitting: false,
                errors: {}
            },
            text: '',
            loading: false
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
                agenda_id: this.item.id
            };
            this.form.errors = {};
            this.form.submitting = false;
        },
        handleNoteDeleted(note_id) {
            let note = this.notes.find((note) => note.id === note_id);
            this.notes.splice(this.notes.indexOf(note), 1);
            this.$emit('note_deleted', note_id);
        }
    },
    watch: {
        item() {
            this.fetchNotes();
            this.resetForm();
        }
    }
}
</script> and nowwin AgendaTemplate we ave: <template>
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
    name: "AgendaTemplateCreateModal",
    props: ['default_list_format'],
    data() {
        return {
            form: {
                data: {
                    name: '',
                    agenda_list_format: this.default_list_format
                },
                errors: {},
                submitting: false
            },
            formats: ['num_la_lr', 'ua_la_lr', 'ur_ua_num', 'ur_la_num', 'numbers']
        }
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
                .then(() => { this.form.submitting = false; })
        }
    }
}

</script>, <template>
    <div>
        <loading-icon v-if="!initialized"></loading-icon>
        <div class="flex gap-5" v-else>
            <card class="flex-1" style="min-height: 384px;">
                <template #body>
                    <agenda-template-list-edit
                        :items="items"
                        :selected_item="selected_item"
                        :level="0"
                        :template_id="template_id"
                        class="agenda-list"
                        :data-list_format="list_format"
                        @item_selected="handleItemSelected"
                        @template_item_added="handleItemAdded"
                        @order_updated="handleOrderUpdated"
                    ></agenda-template-list-edit>
                    <new-template-item
                        :parent_id="0"
                        :template_id="template_id"
                        button_type="top"
                        @template_item_added="handleItemAdded"
                        :start_active="true"
                    ></new-template-item>
                </template>
            </card>
            <div ref="sidebar" class="hidden md:block w-[350px]">
                <div ref="sidebar_inner" class="w-[350px]" :class="{'fixed top-8': sidebar_fixed}">
                    <div v-if="!selected_item" class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                        <div class="text-center text-gray-700">
                            Select a template item to edit <br />
                            <div class="text-xl mt-1">
                                <i class="fa-regular fa-turn-down-left"></i>
                            </div>
                        </div>
                    </div>
                    <agenda-template-edit-item-form
                        v-else
                        :selected_item="selected_item"
                        :template_id="template_id"
                        @editing_cancelled="() => selected_item = null"
                        @template_item_updated="handleItemUpdated"
                        @template_item_deleted="handleItemDeleted"
                    ></agenda-template-edit-item-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import AgendaTemplateListEdit from "./AgendaTemplateListEdit";
import AgendaTemplateEditItemForm from "./AgendaTemplateEditItemForm";
import NewTemplateItem from "./NewTemplateItem";

export default {
    name: "AgendaTemplateEditForm",
    components: { AgendaTemplateEditItemForm, AgendaTemplateListEdit, NewTemplateItem },
    props: ['template_id', 'list_format'],
    data() {
        return {
            items: [],
            initialized: false,
            sidebar_fixed: false,
            selected_item: null
        }
    },
    mounted() {
        axios.get(Boardable.org_url + 'agenda-templates/' + this.template_id + '/data')
            .then((response) => {
                this.items = response.data.items;
                this.initialized = true;
            });

        this.setupStickySidebar();
    },
    methods: {
        setupStickySidebar() {
            window.addEventListener('scroll', () => {
                let bounding = this.$refs['sidebar'].getBoundingClientRect();
                this.sidebar_fixed = bounding.top <= 0;
            });
        },
        handleItemSelected(item) {
            if (this.selected_item && this.selected_item.id === item.id) {
                this.selected_item = null;
            }
            else {
                this.selected_item = item;
            }
        },

        handleItemUpdated(updated_item) {
            let item = this.findItem(updated_item.id, this.items);
            this.$set(item, 'text', updated_item.text);
            this.$set(item, 'description', updated_item.description);
        },

        findItem(id, list) {
            for (let item of list) {
                if (item.id === id) {
                    return item;
                }
                if (item.items && item.items.length) {
                    let sub_item = this.findItem(id, item.items);
                    if (sub_item)
                        return sub_item;
                }
            }
            return false;
        },

        handleItemAdded(item) {
            if (item.parent_item_id === 0) {
                this.items.push(item);
            }
            else {
                let parent = this.findItem(item.parent_item_id, this.items);
                parent.items.push(item);
            }
        },

        handleItemDeleted(item_id) {
            this.selected_item = null;
            this.$nextTick(() => this.deleteItem(item_id, this.items));
        },
        deleteItem(item_id, list) {
            let item_in_list = list.find((i) => i.id === item_id);
            if (item_in_list) {
                let index = list.indexOf(item_in_list);
                this.$delete(list, index);
            }
            else {
                list.forEach((i) => {
                    if (i.items.length)
                        this.deleteItem(item_id, i.items);
                })
            }
        },
        handleOrderUpdated() {
            let data = this.getFlatListOfParentIds(this.items, [], 0);
            axios.post(Boardable.org_url + 'agenda-templates/' + this.template_id + '/reorder', { items: data });
        },
        getFlatListOfParentIds(items, list, parent_id) {
            items.forEach((i) => {
                list.push({ id: i.id, parent_item_id: parent_id});
                if (i.items && i.items.length) {
                    list = this.getFlatListOfParentIds(i.items, list, i.id);
                }
            });
            return list;
        }
    }
}

</script>, <template>
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
    name: "AgendaTemplateEditItemForm",
    props: ['template_id', 'selected_item'],
    data() {
        return {
            form: {
                data: {
                    id: this.selected_item.id,
                    text: this.selected_item.text,
                    description: this.selected_item.description
                },
                submitting: false
            }
        };
    },
    methods: {
        deleteItem() {
            Alert.confirm('Do you want to delete this template item?', () => {
                axios.post(Boardable.org_url + 'agenda-template-items/delete', { id: this.selected_item.id })
                    .then(() => this.$emit('template_item_deleted', this.selected_item.id));
            });
        },
        cancel() {
            this.$emit('editing_cancelled');
        },
        submit() {
            this.form.submitting = true;
            let params = this.form.data;
            let url = Boardable.org_url + 'agenda-template-items/update';
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
        }
    },
    watch: {
        selected_item() {
            this.form.data.text = this.selected_item.text;
            this.form.data.description = this.selected_item.description;
            this.form.data.id = this.selected_item.id;
            this.$nextTick(() => this.$refs['editor'].reset());
        }
    }
}

</script>, <template>
    <div class="cursor-pointer" @click="setValue('num_la_lr')">
        <div class="border rounded-lg p-2 leading-4"
             :class="{
                'border-blue text-blue':selected_format === format,
                'text-gray-700': selected_format !== format
             }"
        >
            <div v-for="item in numberList"
                 class="flex gap-1 items-center"
                 :class="{'pl-5': item.level === 2, 'pl-10': item.level === 3 }"
            >
                <div class="text-sm leading-4">{{ item.number }}.</div>
                <div class="h-2 rounded-lg overflow-hidden flex-1"
                     :class="{
                        'bg-gray-200': selected_format !== format,
                        'bg-blue-soft': selected_format === format
                     }"
                >&nbsp;</div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "AgendaTemplateIcon",
    props: ['format', 'selected_format'],
    methods: {
        setValue() {
            this.$emit('format_selected', this.format);
        }
    },
    computed: {
        numberList() {
            if (this.format === 'num_la_lr') {
                return [
                    { number: '1', level: 1 },
                    { number: 'a', level: 2 },
                    { number: 'i', level: 3 },
                    { number: '2', level: 1 },
                    { number: '3', level: 1 },
                    { number: 'a', level: 2 },
                    { number: 'b', level: 2 },
                    { number: 'i', level: 3 },
                ];
            }
            if (this.format === 'ua_la_lr') {
                return [
                    { number: 'A', level: 1 },
                    { number: 'a', level: 2 },
                    { number: 'i', level: 3 },
                    { number: 'B', level: 1 },
                    { number: 'C', level: 1 },
                    { number: 'a', level: 2 },
                    { number: 'b', level: 2 },
                    { number: 'i', level: 3 },
                ];
            }
            if (this.format === 'ur_ua_num') {
                return [
                    { number: 'I', level: 1 },
                    { number: 'A', level: 2 },
                    { number: '1', level: 3 },
                    { number: 'II', level: 1 },
                    { number: 'III', level: 1 },
                    { number: 'A', level: 2 },
                    { number: 'B', level: 2 },
                    { number: '1', level: 3 },
                ];
            }
            if (this.format === 'ur_la_num') {
                return [
                    { number: 'I', level: 1 },
                    { number: 'a', level: 2 },
                    { number: '1', level: 3 },
                    { number: 'II', level: 1 },
                    { number: 'III', level: 1 },
                    { number: 'a', level: 2 },
                    { number: 'b', level: 2 },
                    { number: '1', level: 3 },
                ];
            }
            if (this.format === 'numbers') {
                return [
                    { number: '1', level: 1 },
                    { number: '1.1', level: 2 },
                    { number: '1.1.1', level: 3 },
                    { number: '2', level: 1 },
                    { number: '3', level: 1 },
                    { number: '3.1', level: 2 },
                    { number: '3.2', level: 2 },
                    { number: '3.2.1', level: 3 },
                ];
            }
        }
    }
}

</script>, <template>
    <li class="mb-2">
        <div class="-ml-7 p-2 pl-7 ">
            <div class="font-medium">{{ item.text }}</div>
            <div v-if="item.description" class="text-sm" v-html="item.description"></div>
        </div>
        <agenda-template-item-list v-if="item.items.length" :items="item.items"></agenda-template-item-list>
    </li>
</template>

<script>

export default {
    name: "AgendaTemplateItem",
    props: ['item']
}

</script>, , <template>
    <ol>
        <agenda-template-item v-for="item in items" :key="'item'+item.id" :item="item"></agenda-template-item>
    </ol>
</template>

<script>

export default {
    name: "AgendaTemplateItemList",
    props: ['items']
}
</script>, <template>
    <draggable
        :list="items"
        tag="ol"
        @change="() => $emit('order_updated', level)"
        :group="{ name: 'items' }"
        ghost-class="agenda-sort-placeholder"
        :swapThreshold="0.65"
        :emptyInsertThreshold="40"
    >
        <agenda-template-list-item-edit
            v-for="item in items"
            :item="item"
            :key="'item' + item.id"
            :level="level"
            :selected_item="selected_item"
            :template_id="template_id"
            @item_selected="(i) => $emit('item_selected', i)"
            @template_item_added="(i) => $emit('template_item_added', i)"
            @order_updated="() => $emit('order_updated')"
        ></agenda-template-list-item-edit>
    </draggable>
</template>

<script>

import draggable from 'vuedraggable';
import AgendaTemplateListItemEdit from "./AgendaTemplateListItemEdit";

export default {
    name: "AgendaTemplateListEdit",
    components: { draggable, AgendaTemplateListItemEdit },
    props: ['items', 'selected_item', 'level', 'template_id']
}

</script>, <template>
    <li class="mb-2 hover:border-gray-400 border-l border-transparent">

        <div class="rounded-lg border border-transparent hover:cursor-pointer -ml-7 p-2 pl-7"
             :class="{'border-blue': itemIsSelected}"
             @click="() => $emit('item_selected', item)"
        >
            <div class="font-medium">
                {{ item.text }}
            </div>
            <div v-if="item.description" v-html="item.description" class="text-sm text-gray-800"></div>
        </div>

        <agenda-template-list-edit
            :items="item.items"
            :level="level + 1"
            :selected_item="selected_item"
            :template_id="template_id"
            @item_selected="(i) => $emit('item_selected', i)"
            @template_item_added="(i) => $emit('template_item_added', i)"
            @order_updated="() => $emit('order_updated')"
        ></agenda-template-list-edit>

        <new-template-item
            v-if="level < 2"
            :parent_id="item.id"
            :template_id="template_id"
            @template_item_added="(i) => $emit('template_item_added', i)"
        ></new-template-item>
    </li>
</template>

<script>

import NewTemplateItem from "./NewTemplateItem";

export default {
    name: "AgendaTemplateListItemEdit",
    components: {NewTemplateItem},
    props: ['item', 'selected_item', 'level', 'template_id'],
    computed: {
        itemIsSelected() {
            return this.selected_item && this.selected_item.id === this.item.id;
        },
    }
}

</script>,  <template>
    <div class="p-4">
        <h2 class="h2">{{ template.name }}</h2>
        <agenda-template-item-list
            :items="template.items"
            class="agenda-list mb-0"
        ></agenda-template-item-list>
    </div>
</template>

<script>

import AgendaTemplateItemList from "./AgendaTemplateItemList";

export default {
    name: "AgendaTemplatePreview",
    props: ['template'],
    components: { AgendaTemplateItemList }
}

</script>, <template>
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

import AgendaTemplatePreview from "./AgendaTemplatePreview";

export default {
    name: "AgendaTemplateSelectModal",
    props: ['meeting', 'current_date'],
    components: { AgendaTemplatePreview },
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
                    date: null
                },
                submitting: false
            }
        }
    },
    mounted() {
        this.$refs['agenda_template_select_modal'].addEventListener('hide.bs.modal', () => {
            this.reset();
        })
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
            let response = await axios.get(Boardable.org_url + 'agenda-templates/list');
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
            this.loading_template = true
            this.form.data.type = 'default';
            this.form.data.id = template_id;
        },
        selectOrgTemplate(template_id) {
            this.loading_template = true
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
        }
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
        }
    },
    watch: {
        current_date() {
            this.form.data.date = this.current_date.id;
        }
    }
}

</script>, <template>
    <app-modal :title="'Edit template'" as="div" id="edit-template" ref="modal">

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
                        :selected_format="form.data.list_format"
                        class="flex-1 bg-white"
                        @format_selected="() => form.data.list_format = format"
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
    name: "AgendaTemplateSettingsModal",
    props: ['template'],
    data() {
        return {
            form: {
                data: {
                    name: this.template.name,
                    list_format: this.template.list_format
                },
                submitting: false,
                errors: []
            },
            formats: ['num_la_lr', 'ua_la_lr', 'ur_ua_num', 'ur_la_num', 'numbers']
        }
    },
    methods: {
        show() {
            this.$refs['modal'].show();
        },
        submit() {
            this.form.submitting = true;
            axios.post(Boardable.org_url + 'agenda-templates/'  + this.template.id, this.form.data)
                .then((response) => {
                    this.form.submitting = false;
                    this.$emit('template_updated', response.data);
                    this.$refs['modal'].hide();
                })
        }
    },
    watch: {
        template() {
            this.form.data.name = this.template.name;
            this.form.data.list_format = this.template.list_format;
        }
    }
}

</script><template>
    <div>
        <div v-if="is_editing">
            <div class="flex gap-x-2">
                <input type="text"
                       v-model="form.data.text"
                       class="form-control form-control-sm"
                       ref="input"
                       placeholder="Template item text"
                       @keyup.enter="submit"
                />
                <button v-if="form.submitting" class="btn btn-primary disabled h-10" disabled>
                    <loading-icon size="sm"></loading-icon>
                </button>
                <button v-else class="btn btn-primary h-10" @click="submit">Save</button>
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
                Add template item
            </button>
        </div>
    </div>
</template>

<script>

import FAIcon from "../FAIcon";

export default {
    name: "NewTemplateItem",
    props: {
        parent_id: {},
        template_id: {},
        button_type: { default: 'sub' },
        start_active: { default: false }
    },
    components: { FAIcon },
    data() {
        return {
            is_editing: false,
            form: {
                data: {
                    text: '',
                    parent_id: this.parent_id
                },
                submitting: false,
                errors: null
            }
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
            let url = Boardable.org_url + 'agenda-templates/' + this.template_id + '/items';
            axios.post(url, this.form.data)
                .then((response) => {
                    this.form.submitting = false;
                    this.$emit('template_item_added', response.data);
                    this.reset();
                    this.$nextTick(() => this.$refs['input'].focus());
                });
        }
    }
}

</script> now you get he logic 

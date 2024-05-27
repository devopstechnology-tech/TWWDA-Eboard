<template>
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
import EditAgendaAttachmentModal from './EditAgendaAttachmentModal.vue';

export default {
    name: 'AgendaAttachmentsItem',
    components: {EditAgendaAttachmentModal},
    props: ['attachment', 'is_admin'],
    data() {
        return {
            editing: false,
        };
    },
    methods: {
        handleDelete() {
            Alert.confirm('Do you want to remove this attachment?', () => {
                axios.post(Boardable.org_url + 'agenda/uploads/delete', {id: this.attachment.id});
                this.$emit('agenda_attachment_removed', this.attachment);
            });
        },
        handleEdit() {
            this.editing = true;
            this.$nextTick(() => {
                this.$refs['edit_modal'].open();
            });
        },
    },
    computed: {
        url() {
            return window.Boardable.org_url + 'documents/' + this.attachment.uuid.short_slug + '?redirect=docs';
        },
        displayDate() {
            let date_str = this.attachment.updated_at;
            date_str = typeof date_str === 'string' ? date_str : date_str.date;
            return localTime(date_str).format('MMM DD, YYYY');
        },
        displayTime() {
            let date_str = this.attachment.updated_at;
            date_str = typeof date_str === 'string' ? date_str : date_str.date;
            return localTime(date_str).format('h:mm A');
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
        },
    },
};
</script>
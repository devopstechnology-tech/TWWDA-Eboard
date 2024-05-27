<template>
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
import AttachmentFolderMenu from '../Attachments/AttachmentFolderMenu.vue';
import AgendaAttachmentsItem from './AgendaAttachmentsItem.vue';

export default {
    name: 'AgendaAttachmentsTable',
    components: {AgendaAttachmentsItem, AttachmentFolderMenu},
    props: ['attachments', 'meeting', 'is_admin'],
    inject: ['download_enabled'],
    methods: {
        handleDownloadAgendaFolder() {
            window.open(Boardable.app_url + window.location.pathname + '/download');
        },
    },
    computed: {
        emptyStateText() {
            return 'No documents are attached to the agenda yet';
        },
    },
};
</script>
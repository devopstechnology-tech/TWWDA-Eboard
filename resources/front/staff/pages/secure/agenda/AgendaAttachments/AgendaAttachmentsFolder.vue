<template>
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
        },
    },
};
</script>


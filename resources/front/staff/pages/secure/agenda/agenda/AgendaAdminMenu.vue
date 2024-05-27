<template>
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

import BoardPacketUpgradeModal from '../Meetings/BoardPacketUpgradeModal';
import AgendaSettingsModal from './AgendaSettingsModal';
import SaveAsTemplateModal from './SaveAsTemplateModal';
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

</script>
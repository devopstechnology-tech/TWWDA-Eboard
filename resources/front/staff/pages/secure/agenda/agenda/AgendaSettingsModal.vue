<template>
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

import AgendaTemplateIcon from '../AgendaTemplates/AgendaTemplateIcon';

export default {
    name: 'AgendaSettingsModal',
    components: {AgendaTemplateIcon},
    props: ['meeting', 'current_date'],
    modal: null,
    data() {
        return {
            form: {
                data: {
                    agenda_list_format: null,
                    date: null,
                },
                submitting: false,
            },
        };
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
                });
        },
        open() {
            this.modal.show();
        },
        setValue(val) {
            this.form.data.agenda_list_format = val;
        },
    },
};

</script>
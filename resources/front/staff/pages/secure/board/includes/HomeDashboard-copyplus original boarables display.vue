<!-- eslint-disable max-len -->

 <<template>
    <div id="page-content" class="page-content flex-1 flex relative pl-6 pb-10 bg-gray-100 border-t border-gray-300 pt-8">
        <div class="flex-1">
            <div class="mx-auto w-full max-w-7xl" id="agenda-app">
                <!---->
                <div>

                    <div class="flex gap-5">
                        <div class="flex-1">
                            <div class="card" style="min-height: 384px;">
                                <!----> <!---->
                                <div class="card-body">
                                    <div class="flex w-full">
                                        <div class="flex-1 col-lg-7 col-lg-6">
                                            <ol data-list_format="num_la_lr" class="agenda-list mb-0"></ol>
                                            <div class="mt-4">
                                                <div>
                                                    <!---->
                                                    <div class="flex gap-x-2"><input type="text" placeholder="Agenda item text" class="form-control form-control-sm" data-sider-select-id="fb2fb7a5-ba84-4b9b-8478-1814f60a62bc" data-sider-insert-id="0538a39f-8fc9-44f9-a5b7-51b65432ed91" data-uw-rm-form="fx" aria-label="Agenda item text"> <button class="btn btn-primary h-10">Save</button></div>
                                                    <a class="text-xs cursor-pointer" data-uw-rm-kbnav="anohref" tabindex="0">cancel</a>
                                                </div>
                                            </div>
                                            <!---->
                                        </div>
                                        <!---->
                                    </div>
                                </div>
                                <!---->
                            </div>
                        </div>
                        <div class="hidden md:block w-[350px]">
                            <div class="w-[350px] relative">
                                <div class="w-[350px]">
                                    <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                                        <div class="text-center text-gray-700">
                                            Select an agenda item to edit <br role="presentation" data-uw-rm-sr="">
                                            <div class="text-xl mt-1">
                                                <svg class="svg-inline--fa fa-turn-down-left" aria-hidden="true" focusable="false" data-prefix="far" data-icon="turn-down-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M6.5 271.6c-8.7 9.2-8.7 23.7 0 32.9l121.4 129c8.8 9.3 21 14.6 33.7 14.6c25.6 0 46.3-20.7 46.3-46.3l0-41.7 144 0c88.4 0 160-71.6 160-160l0-112c0-30.9-25.1-56-56-56l-32 0c-30.9 0-56 25.1-56 56l0 120c0 4.4-3.6 8-8 8l-152 0 0-41.7c0-25.6-20.7-46.3-46.3-46.3c-12.8 0-25 5.3-33.7 14.6L6.5 271.6zm153.5-93l0 61.5c0 13.3 10.7 24 24 24l176 0c30.9 0 56-25.1 56-56l0-120c0-4.4 3.6-8 8-8l32 0c4.4 0 8 3.6 8 8l0 112c0 61.9-50.1 112-112 112l-168 0c-13.3 0-24 10.7-24 24l0 61.5L57 288 160 178.5z"></path>
                                                </svg>
                                                <!-- <i class="fa-regular fa-turn-down-left"></i> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="vue-portal-target">
                    <div tabindex="-1" role="dialog" aria-hidden="true" class="modal fade" style="z-index: 1062;">
                        <div role="document" class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title h3" data-uw-rm-heading="level" role="heading" aria-level="3">Attach a file</h5>
                                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-icon absolute right-2.5 top-2.5">
                                        <svg class="svg-inline--fa fa-xmark" aria-hidden="true" focusable="false" data-prefix="far" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M345 137c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-119 119L73 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l119 119L39 375c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l119-119L311 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-119-119L345 137z"></path>
                                        </svg>
                                        <!-- <i class="fa-regular fa-xmark"></i> -->
                                    </button>
                                </div>
                                <ul class="nav nav-tabs px-4">
                                    <li class="nav-item"><a href="#" class="nav-link active">
                                        All Files
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <svg class="svg-inline--fa fa-star" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                            </svg>
                                            <!-- <i class="fa-solid fa-star"></i> -->
                                            Starred
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <svg class="svg-inline--fa fa-magnifying-glass" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="magnifying-glass" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path>
                                            </svg>
                                            <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                                            Search
                                        </a>
                                    </li>
                                </ul>
                                <!---->
                                <div class="h-96 overflow-y-auto bg-gray-100">
                                    <div class="h-full flex justify-center items-center">
                                        <div class="flex flex-col justify-center items-center h-100 flex-grow-1">
                                            <div role="status" class="spinner-border text-gray-500"><span class="sr-only">Loading...</span></div>
                                        </div>
                                    </div>
                                    <!---->
                                </div>
                                <div class="modal-footer">
                                    <!----> <a type="button" data-bs-dismiss="modal" class="btn btn-secondary" data-uw-rm-kbnav="anohref" tabindex="0">Cancel</a> <button type="button" class="btn btn-primary">Select</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div aria-labelledby="modal-80" aria-hidden="true" tabindex="-1" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 id="modal-80" class="modal-title h3 mb-0">New Folder</h2>
                                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-icon absolute right-2.5 top-2.5">
                                        <svg ariaHidden="true" class="fill-current fa-icon">
                                            <!-- <!-- <use xlink:href="/v4/icons/fa-sprite.svg#solid-xmark"></use> --> -->
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Name</label> <input type="text" class="form-control" data-uw-rm-form="fx" aria-label="Name" data-uw-hidden-control="hidden-control-element"> <!---->
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <div class="border border-gray-400 rounded-lg bg-white">
                                            <div id="new_folder_description_toolbar_container">
                                                <div role="application" class="tox tox-tinymce tox-tinymce-inline" aria-disabled="false" style="visibility: hidden; display: flex;">
                                                    <div class="tox-editor-container">
                                                        <div data-alloy-vertical-dir="toptobottom" class="tox-editor-header">
                                                            <div role="group" class="tox-toolbar-overlord" aria-disabled="false">
                                                                <div role="group" class="tox-toolbar__primary">
                                                                    <div title="" role="toolbar" data-alloy-tabstop="true" tabindex="-1" class="tox-toolbar__group">
                                                                        <button aria-label="Bold" title="Bold" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                            <span class="tox-icon tox-tbtn__icon-wrap">
                                                                                <svg viewBox="0 0 384 512" width="18" height="18" focusable="false">
                                                                                    <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                                    <path d="M321.1 242.4C340.1 220.1 352 191.6 352 160c0-70.59-57.42-128-128-128L32 32.01c-17.67 0-32 14.31-32 32s14.33 32 32 32h16v320H32c-17.67 0-32 14.31-32 32s14.33 32 32 32h224c70.58 0 128-57.41 128-128C384 305.3 358.6 264.8 321.1 242.4zM112 96.01H224c35.3 0 64 28.72 64 64s-28.7 64-64 64H112V96.01zM256 416H112v-128H256c35.3 0 64 28.71 64 63.1S291.3 416 256 416z"></path>
                                                                                </svg>
                                                                            </span>
                                                                        </button>
                                                                        <button aria-label="Italic" title="Italic" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                            <span class="tox-icon tox-tbtn__icon-wrap">
                                                                                <svg viewBox="0 0 384 512" width="18" height="18" focusable="false">
                                                                                    <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                                    <path d="M384 64.01c0 17.69-14.31 32-32 32h-58.67l-133.3 320H224c17.69 0 32 14.31 32 32s-14.31 32-32 32H32c-17.69 0-32-14.31-32-32s14.31-32 32-32h58.67l133.3-320H160c-17.69 0-32-14.31-32-32s14.31-32 32-32h192C369.7 32.01 384 46.33 384 64.01z"></path>
                                                                                </svg>
                                                                            </span>
                                                                        </button>
                                                                        <button aria-label="Bullet list" title="Bullet list" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                            <span class="tox-icon tox-tbtn__icon-wrap">
                                                                                <svg viewBox="0 0 512 512" width="20" height="20" focusable="false">
                                                                                    <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                                    <path d="M88 48C101.3 48 112 58.75 112 72V120C112 133.3 101.3 144 88 144H40C26.75 144 16 133.3 16 120V72C16 58.75 26.75 48 40 48H88zM488 72C501.3 72 512 82.75 512 96C512 109.3 501.3 120 488 120H184C170.7 120 160 109.3 160 96C160 82.75 170.7 72 184 72H488zM488 232C501.3 232 512 242.7 512 256C512 269.3 501.3 280 488 280H184C170.7 280 160 269.3 160 256C160 242.7 170.7 232 184 232H488zM488 392C501.3 392 512 402.7 512 416C512 429.3 501.3 440 488 440H184C170.7 440 160 429.3 160 416C160 402.7 170.7 392 184 392H488zM16 232C16 218.7 26.75 208 40 208H88C101.3 208 112 218.7 112 232V280C112 293.3 101.3 304 88 304H40C26.75 304 16 293.3 16 280V232zM88 368C101.3 368 112 378.7 112 392V440C112 453.3 101.3 464 88 464H40C26.75 464 16 453.3 16 440V392C16 378.7 26.75 368 40 368H88z"></path>
                                                                                </svg>
                                                                            </span>
                                                                        </button>
                                                                        <button aria-label="Numbered list" title="Numbered list" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                            <span class="tox-icon tox-tbtn__icon-wrap">
                                                                                <svg viewBox="0 0 576 512" width="20" height="20" focusable="false">
                                                                                    <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                                    <path d="M55.1 56.04C55.1 42.78 66.74 32.04 79.1 32.04H111.1C125.3 32.04 135.1 42.78 135.1 56.04V176H151.1C165.3 176 175.1 186.8 175.1 200C175.1 213.3 165.3 224 151.1 224H71.1C58.74 224 47.1 213.3 47.1 200C47.1 186.8 58.74 176 71.1 176H87.1V80.04H79.1C66.74 80.04 55.1 69.29 55.1 56.04V56.04zM118.7 341.2C112.1 333.8 100.4 334.3 94.65 342.4L83.53 357.9C75.83 368.7 60.84 371.2 50.05 363.5C39.26 355.8 36.77 340.8 44.47 330.1L55.59 314.5C79.33 281.2 127.9 278.8 154.8 309.6C176.1 333.1 175.6 370.5 153.7 394.3L118.8 432H152C165.3 432 176 442.7 176 456C176 469.3 165.3 480 152 480H64C54.47 480 45.84 474.4 42.02 465.6C38.19 456.9 39.9 446.7 46.36 439.7L118.4 361.7C123.7 355.9 123.8 347.1 118.7 341.2L118.7 341.2zM520 72C533.3 72 544 82.75 544 96C544 109.3 533.3 120 520 120H248C234.7 120 224 109.3 224 96C224 82.75 234.7 72 248 72H520zM520 232C533.3 232 544 242.7 544 256C544 269.3 533.3 280 520 280H248C234.7 280 224 269.3 224 256C224 242.7 234.7 232 248 232H520zM520 392C533.3 392 544 402.7 544 416C544 429.3 533.3 440 520 440H248C234.7 440 224 429.3 224 416C224 402.7 234.7 392 248 392H520z"></path>
                                                                                </svg>
                                                                            </span>
                                                                        </button>
                                                                        <button aria-label="Insert/edit link" title="Insert/edit link" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                            <span class="tox-icon tox-tbtn__icon-wrap">
                                                                                <svg viewBox="0 0 640 512" width="20" height="20" focusable="false">
                                                                                    <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                                    <path d="M172.5 131.1C228.1 75.51 320.5 75.51 376.1 131.1C426.1 181.1 433.5 260.8 392.4 318.3L391.3 319.9C381 334.2 361 337.6 346.7 327.3C332.3 317 328.9 297 339.2 282.7L340.3 281.1C363.2 249 359.6 205.1 331.7 177.2C300.3 145.8 249.2 145.8 217.7 177.2L105.5 289.5C73.99 320.1 73.99 372 105.5 403.5C133.3 431.4 177.3 435 209.3 412.1L210.9 410.1C225.3 400.7 245.3 404 255.5 418.4C265.8 432.8 262.5 452.8 248.1 463.1L246.5 464.2C188.1 505.3 110.2 498.7 60.21 448.8C3.741 392.3 3.741 300.7 60.21 244.3L172.5 131.1zM467.5 380C411 436.5 319.5 436.5 263 380C213 330 206.5 251.2 247.6 193.7L248.7 192.1C258.1 177.8 278.1 174.4 293.3 184.7C307.7 194.1 311.1 214.1 300.8 229.3L299.7 230.9C276.8 262.1 280.4 306.9 308.3 334.8C339.7 366.2 390.8 366.2 422.3 334.8L534.5 222.5C566 191 566 139.1 534.5 108.5C506.7 80.63 462.7 76.99 430.7 99.9L429.1 101C414.7 111.3 394.7 107.1 384.5 93.58C374.2 79.2 377.5 59.21 391.9 48.94L393.5 47.82C451 6.731 529.8 13.25 579.8 63.24C636.3 119.7 636.3 211.3 579.8 267.7L467.5 380z"></path>
                                                                                </svg>
                                                                            </span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tox-throbber" aria-hidden="true" style="display: none;"></div>
                                                </div>
                                                <div class="tox tox-silver-sink tox-tinymce-aux" style="position: relative;"></div>
                                            </div>
                                            <div id="new_folder_description" class="px-4 pt-2 overflow-y-auto text-gray-900 mce-content-body mce-edit-focus" style="min-height: 100px; max-height: 200px; position: relative;" contenteditable="true" data-gramm="false" wt-ignore-input="true">
                                                <p><br data-mce-bogus="1"></p>
                                            </div>
                                            <div></div>
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer"><button type="button" data-bs-dismiss="modal" class="btn btn-secondary mr-2">Cancel</button> <button class="btn btn-primary h-10"><span>Save</span></button></div>
                            </div>
                        </div>
                    </div>
                    <div tabindex="-1" role="dialog" aria-labelledby="save-as-template-header" aria-hidden="true" class="modal fade">
                        <div role="document" class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 id="save-as-template-header" class="modal-title" data-uw-rm-heading="level" role="heading" aria-level="3">Save as template</h5>
                                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-icon absolute right-2.5 top-2.5">
                                        <svg class="svg-inline--fa fa-xmark" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                                        </svg>
                                        <!-- <i class="fa-solid fa-xmark"></i> -->
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-check"><input type="radio" id="new_or_existing_new" value="new" class="form-check-input" data-uw-rm-form="nfx"> <label for="new_or_existing_new" class="form-check-label">
                                        Save as a new template
                                    </label>
                                    </div>
                                    <div class="form-group px-6 mt-2 mb-8"><label for="template_name" class="form-label text-caps">Name</label> <input type="text" id="template_name" class="form-control" data-uw-rm-form="nfx"></div>
                                    <div class="form-check"><input type="radio" name="new_or_existing" id="new_or_existing_existing" value="existing" class="form-check-input" data-uw-rm-form="nfx"> <label for="new_or_existing_existing" class="form-check-label">
                                        Replace existing template
                                    </label>
                                    </div>
                                    <div class="form-group px-6 mt-2 mb-8"><label for="existing_template" class="form-label text-caps opacity-75">
                                        Choose template
                                    </label> <select id="existing_template" aria-label="template list" disabled="disabled" class="form-select opacity-75" data-uw-rm-form="nfx"></select>
                                    </div>
                                </div>
                                <div class="modal-footer"><a type="button" data-bs-dismiss="modal" class="btn btn-secondary" data-uw-rm-kbnav="anohref" tabindex="0">Cancel</a> <button class="btn btn-primary h-10">
                                    Save
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div tabindex="-1" role="dialog" aria-labelledby="agenda-settings-header" aria-hidden="true" class="modal fade">
                        <div role="document" class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 id="agenda-settings-header" class="modal-title" data-uw-rm-heading="level" role="heading" aria-level="4">Agenda settings</h5>
                                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-icon absolute right-2.5 top-2.5">
                                        <svg class="svg-inline--fa fa-xmark" aria-hidden="true" focusable="false" data-prefix="far" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M345 137c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-119 119L73 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l119 119L39 375c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l119-119L311 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-119-119L345 137z"></path>
                                        </svg>
                                        <!-- <i class="fa-regular fa-xmark"></i> -->
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="max-w-2xl mx-auto my-4">
                                        <div class="text-caps mb-2">Choose a list style</div>
                                        <div class="flex gap-4">
                                            <div class="cursor-pointer flex-1">
                                                <div class="border rounded-lg p-2 leading-4 border-blue text-blue">
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">1.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">a.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-10">
                                                        <div class="text-sm leading-4">i.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">2.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">3.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">a.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">b.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-10">
                                                        <div class="text-sm leading-4">i.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cursor-pointer flex-1">
                                                <div class="border rounded-lg p-2 leading-4 text-gray-700">
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">A.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">a.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-10">
                                                        <div class="text-sm leading-4">i.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">B.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">C.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">a.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">b.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-10">
                                                        <div class="text-sm leading-4">i.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cursor-pointer flex-1">
                                                <div class="border rounded-lg p-2 leading-4 text-gray-700">
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">I.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">A.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-10">
                                                        <div class="text-sm leading-4">1.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">II.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">III.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">A.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">B.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-10">
                                                        <div class="text-sm leading-4">1.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cursor-pointer flex-1">
                                                <div class="border rounded-lg p-2 leading-4 text-gray-700">
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">I.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">a.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-10">
                                                        <div class="text-sm leading-4">1.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">II.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">III.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">a.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">b.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-10">
                                                        <div class="text-sm leading-4">1.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cursor-pointer flex-1">
                                                <div class="border rounded-lg p-2 leading-4 text-gray-700">
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">1.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">1.1.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-10">
                                                        <div class="text-sm leading-4">1.1.1.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">2.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-sm leading-4">3.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">3.1.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-5">
                                                        <div class="text-sm leading-4">3.2.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center pl-10">
                                                        <div class="text-sm leading-4">3.2.1.</div>
                                                        <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer"><a type="button" data-bs-dismiss="modal" class="btn btn-secondary" data-uw-rm-kbnav="anohref" tabindex="0">Cancel</a> <button class="btn btn-primary h-10">
                                    Save
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="page-spacer" class="flex-none" style="transition: width 0.3s ease-in-out 0s; width: 0px;"></div>
        <div id="page-sb" class="top-0 bottom-0 ml-6 -my-8 right-0 border-l border-gray-300 bg-white px-2 py-4">
            <button class="btn btn-icon" type="button" data-bs-toggle="offcanvas" data-bs-target="#page-offcanvas" aria-controls="page-offcanvas">
                <svg aria-hidden="true" class="fill-current fa-icon">
                    <!-- <!-- <use xlink:href="/v4/icons/fa-sprite.svg#message-lines"></use> --> -->
                </svg>
                <span class="sr-only">View Comments</span>
            </button>
        </div>
        <div id="meeting-sidebar-app">
            <div id="page-offcanvas" tabindex="-1" aria-labelledby="page-offcanvas-label" data-bs-scroll="true" data-bs-backdrop="false" class="offcanvas offcanvas-end border border-l-gray-300" style="top: 142px;">
                <div class="offcanvas-header">
                    <h5 id="page-offcanvas-label" class="offcanvas-title">Comments</h5>
                    <button type="button" data-bs-dismiss="offcanvas" aria-label="Close" class="btn-close text-reset"></button>
                </div>
                <div class="bg-white offcanvas-body !p-0">
                    <div class="flex flex-col justify-end h-full">
                        <div class="overflow-y-auto p-4">
                            <div></div>
                        </div>
                        <div class="relative p-4">
                            <div class="absolute top-0 left-0 bottom-0 right-0 bg-gray-200 flex items-center justify-center text-gray-600 rounded-lg hidden">
                                Drop
                            </div>
                            <!---->
                            <div class="border border-gray-400 rounded-lg bg-white rich-text-editor">
                                <div id="new-comment-editor-70_toolbar_container">
                                    <div role="application" class="tox tox-tinymce tox-tinymce-inline" aria-disabled="false" style="visibility: hidden; display: flex;">
                                        <div class="tox-editor-container">
                                            <div data-alloy-vertical-dir="toptobottom" class="tox-editor-header">
                                                <div role="group" class="tox-toolbar-overlord" aria-disabled="false">
                                                    <div role="group" class="tox-toolbar__primary">
                                                        <div title="" role="toolbar" data-alloy-tabstop="true" tabindex="-1" class="tox-toolbar__group">
                                                            <button aria-label="Bold" title="Bold" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                <span class="tox-icon tox-tbtn__icon-wrap">
                                                                    <svg viewBox="0 0 384 512" width="18" height="18" focusable="false">
                                                                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                        <path d="M321.1 242.4C340.1 220.1 352 191.6 352 160c0-70.59-57.42-128-128-128L32 32.01c-17.67 0-32 14.31-32 32s14.33 32 32 32h16v320H32c-17.67 0-32 14.31-32 32s14.33 32 32 32h224c70.58 0 128-57.41 128-128C384 305.3 358.6 264.8 321.1 242.4zM112 96.01H224c35.3 0 64 28.72 64 64s-28.7 64-64 64H112V96.01zM256 416H112v-128H256c35.3 0 64 28.71 64 63.1S291.3 416 256 416z"></path>
                                                                    </svg>
                                                                </span>
                                                            </button>
                                                            <button aria-label="Italic" title="Italic" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                <span class="tox-icon tox-tbtn__icon-wrap">
                                                                    <svg viewBox="0 0 384 512" width="18" height="18" focusable="false">
                                                                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                        <path d="M384 64.01c0 17.69-14.31 32-32 32h-58.67l-133.3 320H224c17.69 0 32 14.31 32 32s-14.31 32-32 32H32c-17.69 0-32-14.31-32-32s14.31-32 32-32h58.67l133.3-320H160c-17.69 0-32-14.31-32-32s14.31-32 32-32h192C369.7 32.01 384 46.33 384 64.01z"></path>
                                                                    </svg>
                                                                </span>
                                                            </button>
                                                            <button aria-label="Bullet list" title="Bullet list" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                <span class="tox-icon tox-tbtn__icon-wrap">
                                                                    <svg viewBox="0 0 512 512" width="20" height="20" focusable="false">
                                                                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                        <path d="M88 48C101.3 48 112 58.75 112 72V120C112 133.3 101.3 144 88 144H40C26.75 144 16 133.3 16 120V72C16 58.75 26.75 48 40 48H88zM488 72C501.3 72 512 82.75 512 96C512 109.3 501.3 120 488 120H184C170.7 120 160 109.3 160 96C160 82.75 170.7 72 184 72H488zM488 232C501.3 232 512 242.7 512 256C512 269.3 501.3 280 488 280H184C170.7 280 160 269.3 160 256C160 242.7 170.7 232 184 232H488zM488 392C501.3 392 512 402.7 512 416C512 429.3 501.3 440 488 440H184C170.7 440 160 429.3 160 416C160 402.7 170.7 392 184 392H488zM16 232C16 218.7 26.75 208 40 208H88C101.3 208 112 218.7 112 232V280C112 293.3 101.3 304 88 304H40C26.75 304 16 293.3 16 280V232zM88 368C101.3 368 112 378.7 112 392V440C112 453.3 101.3 464 88 464H40C26.75 464 16 453.3 16 440V392C16 378.7 26.75 368 40 368H88z"></path>
                                                                    </svg>
                                                                </span>
                                                            </button>
                                                            <button aria-label="Numbered list" title="Numbered list" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                <span class="tox-icon tox-tbtn__icon-wrap">
                                                                    <svg viewBox="0 0 576 512" width="20" height="20" focusable="false">
                                                                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                        <path d="M55.1 56.04C55.1 42.78 66.74 32.04 79.1 32.04H111.1C125.3 32.04 135.1 42.78 135.1 56.04V176H151.1C165.3 176 175.1 186.8 175.1 200C175.1 213.3 165.3 224 151.1 224H71.1C58.74 224 47.1 213.3 47.1 200C47.1 186.8 58.74 176 71.1 176H87.1V80.04H79.1C66.74 80.04 55.1 69.29 55.1 56.04V56.04zM118.7 341.2C112.1 333.8 100.4 334.3 94.65 342.4L83.53 357.9C75.83 368.7 60.84 371.2 50.05 363.5C39.26 355.8 36.77 340.8 44.47 330.1L55.59 314.5C79.33 281.2 127.9 278.8 154.8 309.6C176.1 333.1 175.6 370.5 153.7 394.3L118.8 432H152C165.3 432 176 442.7 176 456C176 469.3 165.3 480 152 480H64C54.47 480 45.84 474.4 42.02 465.6C38.19 456.9 39.9 446.7 46.36 439.7L118.4 361.7C123.7 355.9 123.8 347.1 118.7 341.2L118.7 341.2zM520 72C533.3 72 544 82.75 544 96C544 109.3 533.3 120 520 120H248C234.7 120 224 109.3 224 96C224 82.75 234.7 72 248 72H520zM520 232C533.3 232 544 242.7 544 256C544 269.3 533.3 280 520 280H248C234.7 280 224 269.3 224 256C224 242.7 234.7 232 248 232H520zM520 392C533.3 392 544 402.7 544 416C544 429.3 533.3 440 520 440H248C234.7 440 224 429.3 224 416C224 402.7 234.7 392 248 392H520z"></path>
                                                                    </svg>
                                                                </span>
                                                            </button>
                                                            <button aria-label="Insert/edit link" title="Insert/edit link" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                <span class="tox-icon tox-tbtn__icon-wrap">
                                                                    <svg viewBox="0 0 640 512" width="20" height="20" focusable="false">
                                                                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                        <path d="M172.5 131.1C228.1 75.51 320.5 75.51 376.1 131.1C426.1 181.1 433.5 260.8 392.4 318.3L391.3 319.9C381 334.2 361 337.6 346.7 327.3C332.3 317 328.9 297 339.2 282.7L340.3 281.1C363.2 249 359.6 205.1 331.7 177.2C300.3 145.8 249.2 145.8 217.7 177.2L105.5 289.5C73.99 320.1 73.99 372 105.5 403.5C133.3 431.4 177.3 435 209.3 412.1L210.9 410.1C225.3 400.7 245.3 404 255.5 418.4C265.8 432.8 262.5 452.8 248.1 463.1L246.5 464.2C188.1 505.3 110.2 498.7 60.21 448.8C3.741 392.3 3.741 300.7 60.21 244.3L172.5 131.1zM467.5 380C411 436.5 319.5 436.5 263 380C213 330 206.5 251.2 247.6 193.7L248.7 192.1C258.1 177.8 278.1 174.4 293.3 184.7C307.7 194.1 311.1 214.1 300.8 229.3L299.7 230.9C276.8 262.1 280.4 306.9 308.3 334.8C339.7 366.2 390.8 366.2 422.3 334.8L534.5 222.5C566 191 566 139.1 534.5 108.5C506.7 80.63 462.7 76.99 430.7 99.9L429.1 101C414.7 111.3 394.7 107.1 384.5 93.58C374.2 79.2 377.5 59.21 391.9 48.94L393.5 47.82C451 6.731 529.8 13.25 579.8 63.24C636.3 119.7 636.3 211.3 579.8 267.7L467.5 380z"></path>
                                                                    </svg>
                                                                </span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tox-throbber" aria-hidden="true" style="display: none;"></div>
                                    </div>
                                    <div class="tox tox-silver-sink tox-tinymce-aux" style="position: relative;"></div>
                                </div>
                                <div id="new-comment-editor-70" class="px-4 pt-2 overflow-y-auto text-gray-900 mce-content-body mce-edit-focus" style="min-height: 60px; max-height: 200px; position: relative;" contenteditable="true" data-mce-placeholder="Leave a comment" aria-placeholder="Leave a comment" data-gramm="false" wt-ignore-input="true">
                                    <p><br data-mce-bogus="1"></p>
                                </div>
                                <div>
                                    <div class="mt-2 mx-2 flex flex-wrap">
                                        <div></div>
                                    </div>
                                </div>
                                <div class="py-2 pl-2 pr-4 flex items-center">
                                    <div class="flex-1 flex">
                                        <div class="relative mr-1">
                                            <button aria-label="Add emoji" class="btn btn-sm btn-icon">
                                                <svg class="svg-inline--fa fa-face-smile" aria-hidden="true" focusable="false" data-prefix="far" data-icon="face-smile" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm177.6 62.1C192.8 334.5 218.8 352 256 352s63.2-17.5 78.4-33.9c9-9.7 24.2-10.4 33.9-1.4s10.4 24.2 1.4 33.9c-22 23.8-60 49.4-113.6 49.4s-91.7-25.5-113.6-49.4c-9-9.7-8.4-24.9 1.4-33.9s24.9-8.4 33.9 1.4zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path>
                                                </svg>
                                                <!-- <i class="fa-regular fa-face-smile"></i> -->
                                            </button>
                                            <div class="dropdown" style="bottom: 250px;">
                                                <div class="dropdown-menu p-0 border-0">
                                                    <emoji-picker class="w-72"></emoji-picker>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-1 justify-between items-center mr-4 text-sm">
                                            <div class="relative">
                                                <span data-bs-toggle="dropdown" aria-expanded="false" class="cursor-pointer">
                                                    <button aria-label="Attach a document" class="btn btn-sm btn-icon">
                                                        <svg aria-hidden="true" class="svg-inline--fa fa-paperclip" focusable="false" data-prefix="far" data-icon="paperclip" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M375 73c-26-26-68.1-26-94.1 0L89 265C45.3 308.6 45.3 379.4 89 423s114.4 43.6 158.1 0L399 271c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L281 457c-62.4 62.4-163.5 62.4-225.9 0S-7.4 293.4 55 231L247 39C291.7-5.7 364.2-5.7 409 39s44.7 117.2 0 161.9L225.2 384.7c-31.6 31.6-83.6 28.7-111.5-6.2c-23.8-29.8-21.5-72.8 5.5-99.8L271 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L153.2 312.7c-9.7 9.7-10.6 25.1-2 35.8c10 12.5 28.7 13.6 40 2.2L375 167c26-26 26-68.1 0-94.1z"></path>
                                                        </svg>
                                                        <!-- <i aria-hidden="true" class="fa-regular fa-paperclip"></i> -->
                                                    </button>
                                                </span>
                                                <ul class="dropdown-menu">
                                                    <!---->
                                                    <li>
                                                        <a href="#" class="dropdown-item flex items-center">
                                                            <span class="w-5 block text-center mr-2">
                                                                <svg aria-hidden="true" class="svg-inline--fa fa-cloud-arrow-up" focusable="false" data-prefix="far" data-icon="cloud-arrow-up" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                                    <path fill="currentColor" d="M354.9 121.7c13.8 16 36.5 21.1 55.9 12.5c8.9-3.9 18.7-6.2 29.2-6.2c39.8 0 72 32.2 72 72c0 4-.3 7.9-.9 11.7c-3.5 21.6 8.1 42.9 28.1 51.7C570.4 276.9 592 308 592 344c0 46.8-36.6 85.2-82.8 87.8c-.6 0-1.3 .1-1.9 .2H504 144c-53 0-96-43-96-96c0-41.7 26.6-77.3 64-90.5c19.2-6.8 32-24.9 32-45.3l0-.2v0 0c0-66.3 53.7-120 120-120c36.3 0 68.8 16.1 90.9 41.7zM512 480v-.2c71.4-4.1 128-63.3 128-135.8c0-55.7-33.5-103.7-81.5-124.7c1-6.3 1.5-12.8 1.5-19.3c0-66.3-53.7-120-120-120c-17.4 0-33.8 3.7-48.7 10.3C360.4 54.6 314.9 32 264 32C171.2 32 96 107.2 96 200l0 .2C40.1 220 0 273.3 0 336c0 79.5 64.5 144 144 144H464h40 8zM223 255c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V384c0 13.3 10.7 24 24 24s24-10.7 24-24V249.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0l-80 80z"></path>
                                                                </svg>
                                                                <!-- <i aria-hidden="true" class="fa-regular fa-cloud-arrow-up"></i> -->
                                                            </span>
                                                            <div class="flex-1">Upload a file</div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider" role="presentation" data-uw-rm-sr="">
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item flex items-center">
                                                            <div class="w-5 text-center mr-2">
                                                                <!-- <img src="/img/boardable-mark.svg" data-uw-rm-alt-original="" role="presentation" alt="" data-uw-rm-alt="SVG"> -->
                                                            </div>
                                                            <div class="flex-1">Boardable</div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item flex items-center">
                                                            <div class="w-5 text-center mr-2">
                                                                <!-- <img src="/img/icons/24/google-drive.png" data-uw-rm-alt-original="" alt="Google Drive" data-uw-rm-alt="CT"> -->
                                                            </div>
                                                            <div class="flex-1">Google Drive</div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item flex items-center">
                                                            <div class="w-5 text-center mr-2">
                                                                <!-- <img src="/img/icons/24/dropbox.png" class="relative top-px" data-uw-rm-alt-original="" alt="Dropbox" data-uw-rm-alt="CT"> -->
                                                            </div>
                                                            <div class="flex-1">Dropbox</div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item flex items-center">
                                                            <div class="w-5 text-center mr-2">
                                                                <!-- <img src="/img/icons/24/onedrive.png" data-uw-rm-alt-original="" alt="OneDrive" data-uw-rm-alt="CT"> -->
                                                            </div>
                                                            <div class="flex-1">OneDrive</div>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <input type="file" multiple="multiple" hidden="hidden" data-uw-rm-form="fx" aria-label="File field" data-uw-hidden-control="hidden-control-element">
                                                <div class="v-portal" style="display: none;"></div>
                                            </div>
                                            <div>
                                                <label class="h-fit w-fit bg-transparent cursor-pointer !rounded-none">
                                                    <label class="cursor-pointer flex flex-row items-center gap-2 w-fit p-0">
                                                        <!----> <input type="checkbox" class="cursor-pointer focus:outline-none rounded-sm border-2 border-gray-600 focus:border-primary checked:bg-primary checked:border-primary checked:bg-checkbox disabled:bg-gray-300 disabled:checked:bg-white disabled:border-gray-400 focus:ring-[3px] ring-primary/25 w-4 h-4 accent-transparent bg-contain bg-no-repeat bg-center appearance-none" value="" data-uw-rm-form="nfx"> <span>Notify everyone</span>
                                                    </label>
                                                    <!----></label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm h-7"><span>Send</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="vue-portal-target">
                <div tabindex="-1" role="dialog" aria-hidden="true" class="modal fade" style="z-index: 1062;">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title h3">Attach a file</h5>
                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-icon absolute right-2.5 top-2.5">
                                    <svg class="svg-inline--fa fa-xmark" aria-hidden="true" focusable="false" data-prefix="far" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M345 137c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-119 119L73 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l119 119L39 375c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l119-119L311 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-119-119L345 137z"></path>
                                    </svg>
                                    <!-- <i class="fa-regular fa-xmark"></i> -->
                                </button>
                            </div>
                            <ul class="nav nav-tabs px-4">
                                <li class="nav-item"><a href="#" class="nav-link active">
                                    All Files
                                </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <svg class="svg-inline--fa fa-star" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                        </svg>
                                        <!-- <i class="fa-solid fa-star"></i> -->
                                        Starred
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <svg class="svg-inline--fa fa-magnifying-glass" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="magnifying-glass" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path>
                                        </svg>
                                        <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                                        Search
                                    </a>
                                </li>
                            </ul>
                            <!---->
                            <div class="h-96 overflow-y-auto bg-gray-100">
                                <div class="h-full flex justify-center items-center">
                                    <div class="flex flex-col justify-center items-center h-100 flex-grow-1">
                                        <div role="status" class="spinner-border text-gray-500"><span class="sr-only">Loading...</span></div>
                                    </div>
                                </div>
                                <!---->
                            </div>
                            <div class="modal-footer">
                                <!----> <a type="button" data-bs-dismiss="modal" class="btn btn-secondary" data-uw-rm-kbnav="anohref" tabindex="0">Cancel</a> <button type="button" class="btn btn-primary">Select</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div aria-labelledby="modal-86" aria-hidden="true" tabindex="-1" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 id="modal-86" class="modal-title h3 mb-0">New Folder</h2>
                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-icon absolute right-2.5 top-2.5">
                                    <svg ariaHidden="true" class="fill-current fa-icon">
                                        <!-- <!-- <use xlink:href="/v4/icons/fa-sprite.svg#solid-xmark"></use> --> -->
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name</label> <input type="text" class="form-control" data-uw-rm-form="fx" aria-label="Name" data-uw-hidden-control="hidden-control-element"> <!---->
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <div class="border border-gray-400 rounded-lg bg-white">
                                        <div id="new_folder_description_toolbar_container"></div>
                                        <div id="new_folder_description" class="px-4 pt-2 overflow-y-auto text-gray-900" style="min-height: 100px; max-height: 200px;"></div>
                                        <div></div>
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer"><button type="button" data-bs-dismiss="modal" class="btn btn-secondary mr-2">Cancel</button> <button class="btn btn-primary h-10"><span>Save</span></button></div>
                        </div>
                    </div>
                </div>
                <div tabindex="-1" role="dialog" aria-labelledby="save-as-template-header" aria-hidden="true" class="modal fade">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="save-as-template-header" class="modal-title" data-uw-rm-heading="level" role="heading" aria-level="3">Save as template</h5>
                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-icon absolute right-2.5 top-2.5">
                                    <svg class="svg-inline--fa fa-xmark" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                                    </svg>
                                    <!-- <i class="fa-solid fa-xmark"></i> -->
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-check"><input type="radio" id="new_or_existing_new" value="new" class="form-check-input" data-uw-rm-form="nfx"> <label for="new_or_existing_new" class="form-check-label">
                                    Save as a new template
                                </label>
                                </div>
                                <div class="form-group px-6 mt-2 mb-8"><label for="template_name" class="form-label text-caps">Name</label> <input type="text" id="template_name" class="form-control" data-uw-rm-form="nfx"></div>
                                <div class="form-check"><input type="radio" name="new_or_existing" id="new_or_existing_existing" value="existing" class="form-check-input" data-uw-rm-form="nfx"> <label for="new_or_existing_existing" class="form-check-label">
                                    Replace existing template
                                </label>
                                </div>
                                <div class="form-group px-6 mt-2 mb-8"><label for="existing_template" class="form-label text-caps opacity-75">
                                    Choose template
                                </label> <select id="existing_template" aria-label="template list" disabled="disabled" class="form-select opacity-75" data-uw-rm-form="nfx"></select>
                                </div>
                            </div>
                            <div class="modal-footer"><a type="button" data-bs-dismiss="modal" class="btn btn-secondary" data-uw-rm-kbnav="anohref" tabindex="0">Cancel</a> <button class="btn btn-primary h-10">
                                Save
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div tabindex="-1" role="dialog" aria-labelledby="agenda-settings-header" aria-hidden="true" class="modal fade">
                    <div role="document" class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="agenda-settings-header" class="modal-title" data-uw-rm-heading="level" role="heading" aria-level="4">Agenda settings</h5>
                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-icon absolute right-2.5 top-2.5">
                                    <svg class="svg-inline--fa fa-xmark" aria-hidden="true" focusable="false" data-prefix="far" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M345 137c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-119 119L73 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l119 119L39 375c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l119-119L311 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-119-119L345 137z"></path>
                                    </svg>
                                    <!-- <i class="fa-regular fa-xmark"></i> -->
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="max-w-2xl mx-auto my-4">
                                    <div class="text-caps mb-2">Choose a list style</div>
                                    <div class="flex gap-4">
                                        <div class="cursor-pointer flex-1">
                                            <div class="border rounded-lg p-2 leading-4 border-blue text-blue">
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">1.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">a.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-10">
                                                    <div class="text-sm leading-4">i.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">2.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">3.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">a.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">b.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-10">
                                                    <div class="text-sm leading-4">i.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-blue-soft">&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cursor-pointer flex-1">
                                            <div class="border rounded-lg p-2 leading-4 text-gray-700">
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">A.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">a.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-10">
                                                    <div class="text-sm leading-4">i.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">B.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">C.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">a.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">b.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-10">
                                                    <div class="text-sm leading-4">i.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cursor-pointer flex-1">
                                            <div class="border rounded-lg p-2 leading-4 text-gray-700">
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">I.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">A.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-10">
                                                    <div class="text-sm leading-4">1.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">II.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">III.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">A.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">B.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-10">
                                                    <div class="text-sm leading-4">1.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cursor-pointer flex-1">
                                            <div class="border rounded-lg p-2 leading-4 text-gray-700">
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">I.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">a.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-10">
                                                    <div class="text-sm leading-4">1.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">II.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">III.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">a.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">b.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-10">
                                                    <div class="text-sm leading-4">1.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cursor-pointer flex-1">
                                            <div class="border rounded-lg p-2 leading-4 text-gray-700">
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">1.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">1.1.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-10">
                                                    <div class="text-sm leading-4">1.1.1.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">2.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center">
                                                    <div class="text-sm leading-4">3.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">3.1.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-5">
                                                    <div class="text-sm leading-4">3.2.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                                <div class="flex gap-1 items-center pl-10">
                                                    <div class="text-sm leading-4">3.2.1.</div>
                                                    <div class="h-2 rounded-lg overflow-hidden flex-1 bg-gray-200">&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer"><a type="button" data-bs-dismiss="modal" class="btn btn-secondary" data-uw-rm-kbnav="anohref" tabindex="0">Cancel</a> <button class="btn btn-primary h-10">
                                Save
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

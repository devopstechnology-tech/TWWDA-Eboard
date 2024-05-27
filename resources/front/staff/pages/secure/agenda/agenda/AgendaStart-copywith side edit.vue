<template>
    <div class="flex gap-5">
        <div class="flex-1">
            <div class="card" style="min-height: 384px">
                <div class="card-body">
                    <div class="flex w-full">
                        <div class="flex-1">
                            <ol data-list_format="num_la_lr" class="agenda-list mb-0">
                                <li class="mb-2 hover:border-gray-400 border-l border-blue" draggable="false">
                                    <div
                                        class="rounded-lg border border-transparent hover:cursor-pointer border-blue -ml-7 p-2 pl-7 relative border-blue"
                                    >
                                        <div
                                            class="absolute border -right-16 top-4 text-[10px] rounded text-center py-0.5 text-gray-700 z-10 border-gray-200 bg-gray-200 px-2"
                                        >
                                            10:30pm
                                        </div>
                                        <div class="flex gap-2 items-start">
                                            <div class="font-medium flex-1">
                                                Agenda
                                                <div class="text-sm text-gray-800 font-normal">
                                                    <p>decsritpion</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 mt-1 h-6">
                                                <div class="text-xs text-gray-600">15 minutes</div>
                                            </div>
                                            <div>
                                                <ul class="list-none">
                                                    <li class="text-sm text-gray-800">User Allocated</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <ol class="min-h-6">
                                        <li class="mb-2 hover:border-gray-400 border-l border-blue" draggable="false">
                                            <div
                                                class="rounded-lg border border-transparent hover:cursor-pointer border-blue -ml-7 p-2 pl-7 relative border-blue"
                                            >
                                                <div
                                                    class="absolute border -right-16 top-4 text-[10px] rounded text-center py-0.5 text-gray-700 z-10 border-gray-200 bg-white px-1"
                                                >
                                                    10:30pm
                                                </div>
                                                <div class="flex gap-2 items-start">
                                                    <div class="font-medium flex-1">
                                                        SUb genda
                                                        <div class="text-sm text-gray-800 font-normal">
                                                            <p>Description</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2 mt-1 h-6">
                                                        <div class="text-xs text-gray-600">10 minutes</div>
                                                    </div>
                                                    <div>
                                                        <ul class="list-none">
                                                            <li class="text-sm text-gray-800">Assignee</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div>
                                                    <a
                                                        class="text-sm text-gray-600 cursor-pointer"
                                                        data-uw-rm-kbnav="anohref"
                                                        tabindex="0"
                                                        draggable="false"
                                                    >
                                                        sub item
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                    <div>
                                        <div>
                                            <!---->
                                            <div class="flex gap-x-2">
                                                <input
                                                    type="text"
                                                    placeholder="Agenda item text"
                                                    class="form-control form-control-sm"
                                                    data-uw-rm-form="fx"
                                                    aria-label="Agenda item text"
                                                    data-sider-insert-id="dfa95bf2-5492-438f-ae2b-9da1702cccb6"
                                                    data-sider-select-id="0d875fb5-2320-420c-972f-2354939ede47"
                                                />
                                                <button class="btn btn-primary h-10">Save</button>
                                            </div>
                                            <a
                                                class="text-xs cursor-pointer"
                                                data-uw-rm-kbnav="anohref"
                                                tabindex="0"
                                                draggable="false"
                                            >cancel
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                            <div class="mt-4">
                                <div><button class="btn btn-secondary block w-full">Add agenda item</button></div>
                            </div>
                            <div class="relative h-8">
                                <div
                                    class="absolute border -right-16 text-[10px] bottom-2 rounded text-center px-2 py-0.5 text-gray-700 z-10 border-gray-200 bg-gray-200"
                                >
                                    <div class="absolute left-0 right-0 text-green text-xxs bold -top-2.5">END</div>
                                    11:30pm
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="w-16 flex h-full justify-center py-4">
                                <div class="bg-gray-200 h-full relative left-1.5" style="width: 1px">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!---->
            </div>
        </div>
        <div class="hidden md:block w-[350px]">
            <div class="w-[350px] relative">
                <div class="w-[350px]">
                    <div class="card mb-0">
                        <!---->
                        <!---->
                        <div class="card-body">
                            <div class="form-group">
                                <label class="text-xs uppercase font-medium text-gray-700 tracking-wide">Text</label>
                                <input
                                    type="text"
                                    placeholder="Text"
                                    class="form-control"
                                    data-uw-rm-form="fx"
                                    aria-label="Text"
                                />
                                <!---->
                            </div>
                            <div class="form-group">
                                <label class="text-xs uppercase font-medium text-gray-700 tracking-wide"
                                >Description</label
                                >
                                <div class="border border-gray-400 rounded-lg bg-white rich-text-editor">
                                    <div id="undefined_toolbar_container">
                                        <div
                                            role="application"
                                            class="tox tox-tinymce tox-tinymce-inline"
                                            aria-disabled="false"
                                            style="visibility: hidden; display: flex"
                                        >
                                            <div class="tox-editor-container">
                                                <div data-alloy-vertical-dir="toptobottom" class="tox-editor-header">
                                                    <div
                                                        role="group"
                                                        class="tox-toolbar-overlord"
                                                        aria-disabled="false"
                                                    >
                                                        <div role="group" class="tox-toolbar__primary">
                                                            <div
                                                                title=""
                                                                role="toolbar"
                                                                data-alloy-tabstop="true"
                                                                tabindex="-1"
                                                                class="tox-toolbar__group"
                                                            >
                                                                <button
                                                                    aria-label="Bold"
                                                                    title="Bold"
                                                                    type="button"
                                                                    tabindex="-1"
                                                                    class="tox-tbtn"
                                                                    aria-disabled="false"
                                                                    aria-pressed="false"
                                                                    style="width: 25px"
                                                                >
                                                                    <span class="tox-icon tox-tbtn__icon-wrap">
                                                                        <!-- <svg
                                                                            viewBox="0 0 384 512"
                                                                            width="18"
                                                                            height="18"
                                                                            focusable="false"
                                                                        > -->
                                                                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                        <!-- <path
                                                                                d="M321.1 242.4C340.1 220.1 352 191.6 352 160c0-70.59-57.42-128-128-128L32 32.01c-17.67 0-32 14.31-32 32s14.33 32 32 32h16v320H32c-17.67 0-32 14.31-32 32s14.33 32 32 32h224c70.58 0 128-57.41 128-128C384 305.3 358.6 264.8 321.1 242.4zM112 96.01H224c35.3 0 64 28.72 64 64s-28.7 64-64 64H112V96.01zM256 416H112v-128H256c35.3 0 64 28.71 64 63.1S291.3 416 256 416z"
                                                                            ></path> -->
                                                                        <!-- </svg> -->
                                                                    </span>
                                                                </button>
                                                                <button
                                                                    aria-label="Italic"
                                                                    title="Italic"
                                                                    type="button"
                                                                    tabindex="-1"
                                                                    class="tox-tbtn"
                                                                    aria-disabled="false"
                                                                    aria-pressed="false"
                                                                    style="width: 25px"
                                                                >
                                                                    <span class="tox-icon tox-tbtn__icon-wrap">
                                                                        <!-- <svg
                                                                            viewBox="0 0 384 512"
                                                                            width="18"
                                                                            height="18"
                                                                            focusable="false"
                                                                        > -->
                                                                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                        <!-- <path
                                                                                d="M384 64.01c0 17.69-14.31 32-32 32h-58.67l-133.3 320H224c17.69 0 32 14.31 32 32s-14.31 32-32 32H32c-17.69 0-32-14.31-32-32s14.31-32 32-32h58.67l133.3-320H160c-17.69 0-32-14.31-32-32s14.31-32 32-32h192C369.7 32.01 384 46.33 384 64.01z"
                                                                            ></path>
                                                                        </svg> -->
                                                                    </span>
                                                                </button>
                                                                <button
                                                                    aria-label="Bullet list"
                                                                    title="Bullet list"
                                                                    type="button"
                                                                    tabindex="-1"
                                                                    class="tox-tbtn"
                                                                    aria-disabled="false"
                                                                    aria-pressed="false"
                                                                    style="width: 25px"
                                                                >
                                                                    <span class="tox-icon tox-tbtn__icon-wrap">
                                                                        <!-- <svg
                                                                            viewBox="0 0 512 512"
                                                                            width="20"
                                                                            height="20"
                                                                            focusable="false"
                                                                        > -->
                                                                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                        <!-- <path
                                                                                d="M88 48C101.3 48 112 58.75 112 72V120C112 133.3 101.3 144 88 144H40C26.75 144 16 133.3 16 120V72C16 58.75 26.75 48 40 48H88zM488 72C501.3 72 512 82.75 512 96C512 109.3 501.3 120 488 120H184C170.7 120 160 109.3 160 96C160 82.75 170.7 72 184 72H488zM488 232C501.3 232 512 242.7 512 256C512 269.3 501.3 280 488 280H184C170.7 280 160 269.3 160 256C160 242.7 170.7 232 184 232H488zM488 392C501.3 392 512 402.7 512 416C512 429.3 501.3 440 488 440H184C170.7 440 160 429.3 160 416C160 402.7 170.7 392 184 392H488zM16 232C16 218.7 26.75 208 40 208H88C101.3 208 112 218.7 112 232V280C112 293.3 101.3 304 88 304H40C26.75 304 16 293.3 16 280V232zM88 368C101.3 368 112 378.7 112 392V440C112 453.3 101.3 464 88 464H40C26.75 464 16 453.3 16 440V392C16 378.7 26.75 368 40 368H88z"
                                                                            ></path>
                                                                        </svg> -->
                                                                    </span>
                                                                </button>
                                                                <button
                                                                    aria-label="Numbered list"
                                                                    title="Numbered list"
                                                                    type="button"
                                                                    tabindex="-1"
                                                                    class="tox-tbtn"
                                                                    aria-disabled="false"
                                                                    aria-pressed="false"
                                                                    style="width: 25px"
                                                                >
                                                                    <span class="tox-icon tox-tbtn__icon-wrap">
                                                                        <!-- <svg
                                                                            viewBox="0 0 576 512"
                                                                            width="20"
                                                                            height="20"
                                                                            focusable="false"
                                                                        > -->
                                                                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                        <!-- <path
                                                                                d="M55.1 56.04C55.1 42.78 66.74 32.04 79.1 32.04H111.1C125.3 32.04 135.1 42.78 135.1 56.04V176H151.1C165.3 176 175.1 186.8 175.1 200C175.1 213.3 165.3 224 151.1 224H71.1C58.74 224 47.1 213.3 47.1 200C47.1 186.8 58.74 176 71.1 176H87.1V80.04H79.1C66.74 80.04 55.1 69.29 55.1 56.04V56.04zM118.7 341.2C112.1 333.8 100.4 334.3 94.65 342.4L83.53 357.9C75.83 368.7 60.84 371.2 50.05 363.5C39.26 355.8 36.77 340.8 44.47 330.1L55.59 314.5C79.33 281.2 127.9 278.8 154.8 309.6C176.1 333.1 175.6 370.5 153.7 394.3L118.8 432H152C165.3 432 176 442.7 176 456C176 469.3 165.3 480 152 480H64C54.47 480 45.84 474.4 42.02 465.6C38.19 456.9 39.9 446.7 46.36 439.7L118.4 361.7C123.7 355.9 123.8 347.1 118.7 341.2L118.7 341.2zM520 72C533.3 72 544 82.75 544 96C544 109.3 533.3 120 520 120H248C234.7 120 224 109.3 224 96C224 82.75 234.7 72 248 72H520zM520 232C533.3 232 544 242.7 544 256C544 269.3 533.3 280 520 280H248C234.7 280 224 269.3 224 256C224 242.7 234.7 232 248 232H520zM520 392C533.3 392 544 402.7 544 416C544 429.3 533.3 440 520 440H248C234.7 440 224 429.3 224 416C224 402.7 234.7 392 248 392H520z"
                                                                            ></path>
                                                                        </svg> -->
                                                                    </span>
                                                                </button>
                                                                <button
                                                                    aria-label="Insert/edit link"
                                                                    title="Insert/edit link"
                                                                    type="button"
                                                                    tabindex="-1"
                                                                    class="tox-tbtn"
                                                                    aria-disabled="false"
                                                                    aria-pressed="false"
                                                                    style="width: 25px"
                                                                >
                                                                    <span class="tox-icon tox-tbtn__icon-wrap">
                                                                        <!-- <svg
                                                                            viewBox="0 0 640 512"
                                                                            width="20"
                                                                            height="20"
                                                                            focusable="false"
                                                                        > -->
                                                                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                        <!-- <path
                                                                                d="M172.5 131.1C228.1 75.51 320.5 75.51 376.1 131.1C426.1 181.1 433.5 260.8 392.4 318.3L391.3 319.9C381 334.2 361 337.6 346.7 327.3C332.3 317 328.9 297 339.2 282.7L340.3 281.1C363.2 249 359.6 205.1 331.7 177.2C300.3 145.8 249.2 145.8 217.7 177.2L105.5 289.5C73.99 320.1 73.99 372 105.5 403.5C133.3 431.4 177.3 435 209.3 412.1L210.9 410.1C225.3 400.7 245.3 404 255.5 418.4C265.8 432.8 262.5 452.8 248.1 463.1L246.5 464.2C188.1 505.3 110.2 498.7 60.21 448.8C3.741 392.3 3.741 300.7 60.21 244.3L172.5 131.1zM467.5 380C411 436.5 319.5 436.5 263 380C213 330 206.5 251.2 247.6 193.7L248.7 192.1C258.1 177.8 278.1 174.4 293.3 184.7C307.7 194.1 311.1 214.1 300.8 229.3L299.7 230.9C276.8 262.1 280.4 306.9 308.3 334.8C339.7 366.2 390.8 366.2 422.3 334.8L534.5 222.5C566 191 566 139.1 534.5 108.5C506.7 80.63 462.7 76.99 430.7 99.9L429.1 101C414.7 111.3 394.7 107.1 384.5 93.58C374.2 79.2 377.5 59.21 391.9 48.94L393.5 47.82C451 6.731 529.8 13.25 579.8 63.24C636.3 119.7 636.3 211.3 579.8 267.7L467.5 380z"
                                                                            ></path>
                                                                        </svg> -->
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div aria-hidden="true" class="tox-throbber" style="display: none"></div>
                                        </div>
                                        <div
                                            class="tox tox-silver-sink tox-tinymce-aux"
                                            style="position: relative"
                                        ></div>
                                    </div>
                                    <div
                                        class="px-4 pt-2 overflow-y-auto text-gray-900 mce-content-body mce-edit-focus"
                                        id="mce_9"
                                        style="min-height: 100px; max-height: 200px; position: relative"
                                        contenteditable="true"
                                        data-mce-placeholder="Description"
                                        aria-placeholder="Description"
                                        data-gramm="false"
                                        wt-ignore-input="true"
                                    >
                                        <p><br data-mce-bogus="1" /></p>
                                    </div>
                                    <div></div>
                                    <!---->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="text-xs uppercase font-medium text-gray-700 tracking-wide"
                                >Duration</label
                                >
                                <select class="form-control" data-uw-rm-form="fx" aria-label="Duration">
                                    <option value="0">- none -</option>
                                    <option value="5">5 minutes</option>
                                    <option value="10">10 minutes</option>
                                    <option value="15">15 minutes</option>
                                    <option value="20">20 minutes</option>
                                    <option value="25">25 minutes</option>
                                    <option value="30">30 minutes</option>
                                    <option value="35">35 minutes</option>
                                    <option value="40">40 minutes</option>
                                    <option value="45">45 minutes</option>
                                    <option value="50">50 minutes</option>
                                    <option value="55">55 minutes</option>
                                    <option value="60">60 minutes</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-xs uppercase font-medium text-gray-700 tracking-wide"
                                >People Responsible</label
                                >
                                <div id="user-group-select" class="relative">
                                    <div
                                        class="choices"
                                        data-type="select-one"
                                        tabindex="0"
                                        role="combobox"
                                        aria-autocomplete="list"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <div class="form-control user-and-group user-select">
                                            <select
                                                name="create-assigner"
                                                data-placeholder="Type a person"
                                                class="form-control user-and-group user-select choices__input"
                                                hidden=""
                                                tabindex="-1"
                                                data-choice="active"
                                                data-uw-rm-form="nfx"
                                                aria-label="Single select"
                                                data-uw-hidden-control="hidden-control-element"
                                            ></select>
                                            <div class="choices__list choices__list--single"></div>
                                        </div>
                                        <div class="choices__list choices__list--dropdown" aria-expanded="false">
                                            <input
                                                type="text"
                                                class="choices__input focus-visible:outline-none w-full absolute -top-8 px-2"
                                                autocomplete="off"
                                                autocapitalize="off"
                                                spellcheck="false"
                                                role="textbox"
                                                aria-autocomplete="list"
                                                aria-label="false"
                                                placeholder=""
                                                data-uw-rm-form="nfx"
                                            />
                                            <div class="choices__list" role="listbox">
                                                <div
                                                    class="choices__group"
                                                    role="group"
                                                    data-group=""
                                                    data-id="737180410088"
                                                    data-value=""
                                                >
                                                    <div
                                                        class="text-muted px-3 pt-2 text-xs font-bold antialiased uppercase"
                                                    ></div>
                                                </div>
                                                <div
                                                    id="choices--create-assigner-3p-item-choice-3"
                                                    class="choices__item dropdown-item choices__item--selectable is-highlighted"
                                                    role="treeitem"
                                                    data-choice=""
                                                    data-id="3"
                                                    data-value="u274103"
                                                    data-select-text="Press to select"
                                                    data-choice-selectable=""
                                                    aria-selected="true"
                                                >
                                                    <img
                                                        data-name="Cynthia Muriithi"
                                                        src="https://app.boardable.com/img/default_user.svg"
                                                        class="w-6 rounded-full inline-block mr-2 ml-1"
                                                        data-uw-rm-alt-original=""
                                                        role="presentation"
                                                        alt=""
                                                        data-uw-rm-alt="SVG"
                                                    />
                                                    Cynthia Muriithi
                                                </div>
                                                <div
                                                    id="choices--create-assigner-3p-item-choice-1"
                                                    class="choices__item dropdown-item choices__item--selectable"
                                                    role="treeitem"
                                                    data-choice=""
                                                    data-id="1"
                                                    data-value="u323280"
                                                    data-select-text="Press to select"
                                                    data-choice-selectable=""
                                                >
                                                    <img
                                                        data-name="Nyariki Felix"
                                                        src="https://app.boardable.com/img/default_user.svg"
                                                        class="w-6 rounded-full inline-block mr-2 ml-1"
                                                        data-uw-rm-alt-original=""
                                                        role="presentation"
                                                        alt=""
                                                        data-uw-rm-alt="SVG"
                                                    />
                                                    Nyariki Felix
                                                </div>
                                                <div
                                                    id="choices--create-assigner-3p-item-choice-2"
                                                    class="choices__item dropdown-item choices__item--selectable"
                                                    role="treeitem"
                                                    data-choice=""
                                                    data-id="2"
                                                    data-value="u323280"
                                                    data-select-text="Press to select"
                                                    data-choice-selectable=""
                                                >
                                                    <img
                                                        data-name="Nyariki Felix"
                                                        src="https://app.boardable.com/img/default_user.svg"
                                                        class="w-6 rounded-full inline-block mr-2 ml-1"
                                                        data-uw-rm-alt-original=""
                                                        role="presentation"
                                                        alt=""
                                                        data-uw-rm-alt="SVG"
                                                    />
                                                    Nyariki Felix
                                                </div>
                                                <div
                                                    id="choices--create-assigner-3p-item-choice-4"
                                                    class="choices__item dropdown-item choices__item--selectable"
                                                    role="treeitem"
                                                    data-choice=""
                                                    data-id="4"
                                                    data-value="u323957"
                                                    data-select-text="Press to select"
                                                    data-choice-selectable=""
                                                >
                                                    <img
                                                        data-name="Nyariki Felix"
                                                        src="https://app.boardable.com/img/default_user.svg"
                                                        class="w-6 rounded-full inline-block mr-2 ml-1"
                                                        data-uw-rm-alt-original=""
                                                        role="presentation"
                                                        alt=""
                                                        data-uw-rm-alt="SVG"
                                                    />
                                                    Nyariki Felix
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!---->
                                    <div class="">
                                        <!---->
                                        <!---->
                                        <div>
                                            <!---->
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="text-xs uppercase font-medium text-gray-700 tracking-wide"
                                >Attachments</label
                                >
                                <div>
                                    <div class="relative">
                                        <div class="relative">
                                            <span
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false"
                                                class="cursor-pointer"
                                            >
                                                <button
                                                    aria-label="Attach a document"
                                                    class="btn btn-secondary block w-full"
                                                >
                                                    <!-- <svg
                                                        aria-hidden="true"
                                                        class="svg-inline--fa fa-paperclip"
                                                        focusable="false"
                                                        data-prefix="far"
                                                        data-icon="paperclip"
                                                        role="img"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 448 512"
                                                        data-fa-i2svg=""
                                                    >
                                                        <path
                                                            fill="currentColor"
                                                            d="M375 73c-26-26-68.1-26-94.1 0L89 265C45.3 308.6 45.3 379.4 89 423s114.4 43.6 158.1 0L399 271c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L281 457c-62.4 62.4-163.5 62.4-225.9 0S-7.4 293.4 55 231L247 39C291.7-5.7 364.2-5.7 409 39s44.7 117.2 0 161.9L225.2 384.7c-31.6 31.6-83.6 28.7-111.5-6.2c-23.8-29.8-21.5-72.8 5.5-99.8L271 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L153.2 312.7c-9.7 9.7-10.6 25.1-2 35.8c10 12.5 28.7 13.6 40 2.2L375 167c26-26 26-68.1 0-94.1z"
                                                        ></path>
                                                    </svg> -->
                                                    <!-- <i aria-hidden="true" class="fa-regular fa-paperclip"></i> -->
                                                    Attach a document
                                                </button>
                                            </span>
                                            <ul class="dropdown-menu">
                                                <!---->
                                                <li>
                                                    <a href="#" class="dropdown-item flex items-center">
                                                        <span class="w-5 block text-center mr-2">
                                                            <!-- <svg
                                                                aria-hidden="true"
                                                                class="svg-inline--fa fa-cloud-arrow-up"
                                                                focusable="false"
                                                                data-prefix="far"
                                                                data-icon="cloud-arrow-up"
                                                                role="img"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 640 512"
                                                                data-fa-i2svg=""
                                                            >
                                                                <path
                                                                    fill="currentColor"
                                                                    d="M354.9 121.7c13.8 16 36.5 21.1 55.9 12.5c8.9-3.9 18.7-6.2 29.2-6.2c39.8 0 72 32.2 72 72c0 4-.3 7.9-.9 11.7c-3.5 21.6 8.1 42.9 28.1 51.7C570.4 276.9 592 308 592 344c0 46.8-36.6 85.2-82.8 87.8c-.6 0-1.3 .1-1.9 .2H504 144c-53 0-96-43-96-96c0-41.7 26.6-77.3 64-90.5c19.2-6.8 32-24.9 32-45.3l0-.2v0 0c0-66.3 53.7-120 120-120c36.3 0 68.8 16.1 90.9 41.7zM512 480v-.2c71.4-4.1 128-63.3 128-135.8c0-55.7-33.5-103.7-81.5-124.7c1-6.3 1.5-12.8 1.5-19.3c0-66.3-53.7-120-120-120c-17.4 0-33.8 3.7-48.7 10.3C360.4 54.6 314.9 32 264 32C171.2 32 96 107.2 96 200l0 .2C40.1 220 0 273.3 0 336c0 79.5 64.5 144 144 144H464h40 8zM223 255c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V384c0 13.3 10.7 24 24 24s24-10.7 24-24V249.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0l-80 80z"
                                                                ></path>
                                                            </svg> -->
                                                            <i
                                                                aria-hidden="true"
                                                                class="fa-regular fa-cloud-arrow-up"
                                                            ></i>
                                                        </span>
                                                        <div class="flex-1">Upload a file</div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown-item flex items-center">
                                                        <div class="w-5 text-center mr-2">
                                                            <img
                                                                src=""
                                                                data-uw-rm-alt-original=""
                                                                role="presentation"
                                                                alt=""
                                                                data-uw-rm-alt="SVG"
                                                            />
                                                        </div>
                                                        <div class="flex-1">Boardable</div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown-item flex items-center">
                                                        <div class="w-5 text-center mr-2">
                                                            <img
                                                                src=""
                                                                data-uw-rm-alt-original=""
                                                                alt="Google Drive"
                                                                data-uw-rm-alt="CT"
                                                            />
                                                        </div>
                                                        <div class="flex-1">Google Drive</div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown-item flex items-center">
                                                        <div class="w-5 text-center mr-2">
                                                            <img
                                                                src=""
                                                                class="relative top-px"
                                                                data-uw-rm-alt-original=""
                                                                alt="Dropbox"
                                                                data-uw-rm-alt="CT"
                                                            />
                                                        </div>
                                                        <div class="flex-1">Dropbox</div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown-item flex items-center">
                                                        <div class="w-5 text-center mr-2">
                                                            <img
                                                                src=""
                                                                data-uw-rm-alt-original=""
                                                                alt="OneDrive"
                                                                data-uw-rm-alt="CT"
                                                            />
                                                        </div>
                                                        <div class="flex-1">OneDrive</div>
                                                    </a>
                                                </li>
                                            </ul>
                                            <input
                                                type="file"
                                                multiple="multiple"
                                                hidden="hidden"
                                                data-uw-rm-form="fx"
                                                aria-label="File field"
                                                data-uw-hidden-control="hidden-control-element"
                                            />
                                            <div class="v-portal" style="display: none"></div>
                                        </div>
                                        <div class="mt-2">
                                            <div></div>
                                        </div>
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <button class="btn btn-link btn-sm text-danger h-7">Delete</button>
                                <div>
                                    <button class="btn btn-secondary btn-sm h-7">Cancel</button>
                                    <button class="btn btn-sm btn-primary h-7">Save</button>
                                </div>
                            </div>
                        </div>
                        <!---->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref} from 'vue';
</script>
<style scoped>
    .font-medium {
        font-weight: bolder;
    }
    ol.agenda-list,
    ol.agenda-list > li > ol,
    ol.agenda-list > li > ol > li > ol {
        counter-reset: list-counter;
        left: -9px;
        list-style: none;
        margin-right: -9px;
        padding-left: 0;
        position: relative;
    }
    ol.agenda-list > li,
    ol.agenda-list > li > ol > li,
    ol.agenda-list > li > ol > li > ol > li {
        counter-increment: list-counter;
        padding-left: 32px;
        position: relative;
    }
    .hover\:cursor-pointer:hover {
        cursor: pointer;
    }

    .pl-7 {
        padding-left: 1.75rem;
    }
    .p-2 {
        padding: 0.5rem;
    }
    .border-blue {
        --tw-border-opacity: 1;
        border-color: rgb(64 104 235 / var(--tw-border-opacity));
    }
</style>

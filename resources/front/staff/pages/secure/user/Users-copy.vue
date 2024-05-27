<template>
    <div class="mx-auto w-full max-w-7xl">
        <div class="header">
            <div class="header-body">
                <div class="flex flex-wrap items-center">
                    <div class="mr-auto"><h1 class="header-title text-truncate leading-10 mr-3" role="heading" aria-level="2" data-uw-rm-heading="level">People</h1></div>
                    <div class="flex items-center space-x-2">
                        <a href="https://app.boardable.com/felix-1/people/export" class="btn btn-tertiary w-icon">

                            <i class="far fa-file-download"></i>
                            Export Directory
                        </a>
                        <a class="btn btn-tertiary w-icon" data-uw-rm-kbnav="anohref" tabindex="0">
                            <i class="far fa-table"></i>
                            Custom Data
                        </a>
                        <button
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#invite-people"
                            class="bg-primary hover:bg-primary-dark disabled:bg-primary-soft
                         text-white py-2 px-3 rounded-md text-base flex gap-1 items-center
                         justify-center min-w-fit">
                            Add Users
                        </button>
                    </div>
                </div>
                <ul id="documents-tabs" role="tablist" class="nav nav-tabs nav-overflow header-tabs">
                    <li role="presentation" class="nav-item">
                        <a id="everyone" data-bs-target="#everyone-pane" role="tab" aria-controls="everyone-pane" href="https://app.boardable.com/felix-1/people" class="nav-link flex items-center whitespace-nowrap active" aria-selected="true">
                            Everyone
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a
                            id="unaccepted"
                            data-bs-target="#unaccepted-pane"
                            role="tab"
                            aria-controls="unaccepted-pane"
                            href="https://app.boardable.com/felix-1/people/unaccepted-invites"
                            class="nav-link flex items-center whitespace-nowrap"
                            aria-selected="false"
                        >
                            Unaccepted Invitations
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a
                            id="unsent"
                            data-bs-target="#unsent-pane"
                            role="tab"
                            aria-controls="unsent-pane"
                            href="https://app.boardable.com/felix-1/people/unsent-invites"
                            class="nav-link flex items-center whitespace-nowrap"
                            aria-selected="false"
                        >
                            Unsent Invitations
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="people-list">
            <div>
                <div class="md:flex items-center mb-4 space-y-2 md:space-y-0 divide-x-2 divide-gray-400">
                    <p class="m-0 pr-2">3 people (max 150)</p>
                    <!---->
                    <!---->
                </div>
                <div class="flex mb-6 space-x-4 w-full">
                    <div role="search" class="input-group input-group-merge flex-1">
                        <div class="input-group-text">
                            magnifyglass
                        </div>
                        <label for="search-people" class="sr-only">Search People</label> <input id="search-people" type="search" placeholder="Search" name="q" class="form-control !pl-0" data-uw-rm-form="nfx" />
                    </div>
                    <div>
                        <div role="search" class="input-group input-group-merge flex-1">
                            <div class="input-group-text !pr-2">
                                <label for="sort-people-select">Sort<span class="sr-only"> people</span>: </label>
                            </div>
                            <select id="sort-people-select" aria-label="Sort By" class="form-select" data-uw-rm-form="nfx">
                                <option value="[object Object]">First Name</option>
                                <option value="[object Object]">Last Name</option>
                                <option value="[object Object]">Invitation Status</option>
                                <option value="[object Object]">Last activity - oldest to newest</option>
                                <option value="[object Object]">Last activity - newest to oldest</option>
                            </select>
                        </div>
                    </div>
                    <div role="group" aria-label="Display Type" class="btn-group">
                        <button type="button" class="btn btn-primary">
                            <!-- <svg ariaHidden="true" class="fill-current fa-icon"> -->
                            <!-- <use xlink:href="/v4/icons/fa-sprite.svg#grid-2"></use></svg>  -->
                            <span class="sr-only">View expanded list</span>
                        </button>
                        <button type="button" class="btn btn-secondary">
                            <!-- <svg ariaHidden="true" class="fill-current fa-icon">
                            <use xlink:href="/v4/icons/fa-sprite.svg#list"></use></svg>  -->
                            <span class="sr-only">View condensed list</span>
                        </button>
                    </div>
                </div>
                <div style="">
                    <div class="card">
                        <div class="card-body flex">
                            <div class="mr-6">
                                <label for="profile-card-106" class="sr-only">Select profile</label>
                                <label class="h-fit w-fit bg-transparent cursor-pointer !rounded-none" id="profile-card-106">
                                    <label class="cursor-pointer flex flex-row items-center gap-2 w-fit p-0">
                                        <!---->
                                        <input
                                            type="checkbox"
                                            id="profile-card-106"
                                            class="cursor-pointer focus:outline-none rounded-sm border-2 border-gray-600 focus:border-primary checked:bg-primary checked:border-primary checked:bg-checkbox disabled:bg-gray-300 disabled:checked:bg-white disabled:border-gray-400 focus:ring-[3px] ring-primary/25 w-4 h-4 accent-transparent bg-contain bg-no-repeat bg-center appearance-none"
                                            value=""
                                            data-uw-rm-form="nfx"
                                        />
                                        <!---->
                                    </label>
                                    <!---->
                                </label>
                            </div>
                            <div class="avatar avatar-xl mr-5">
                                <a href="https://app.boardable.com/felix-1/people/cynthia-muriithi" aria-label="Open Cynthia Muriithi User Profile">
                                    <img
                                        src="https://app.boardable.com/img/default_user.svg"
                                        alt="Cynthia Muriithi profile image"
                                        class="avatar-img min-w-[82px] w-[82px] rounded-full"
                                        data-uw-rm-alt-original="Cynthia Muriithi profile image"
                                        role="img"
                                        data-uw-rm-alt="ALT"
                                    />
                                </a>
                            </div>
                            <div class="mr-5">
                                <h3 class="name mb-0 flex items-center">
                                    <a href="https://app.boardable.com/felix-1/people/cynthia-muriithi" aria-label="Open Cynthia Muriithi User Profile">
                                        Cynthia Muriithi
                                        <!---->
                                    </a>
                                    <a href="https://app.boardable.com/felix-1/people/cynthia-muriithi/edit" title="" class="mx-2 text-muted btn btn-sm btn-icon" data-bs-original-title="Edit user profile" aria-label="Edit user profile">
                                        <!-- <svg ariaHidden="true" class="fill-current fa-icon">
                                        <use xlink:href="/v4/icons/fa-sprite.svg#pen-to-square"></use></svg> -->
                                    </a>
                                    <button
                                        title=""
                                        data-copy-text="https://app.boardable.com/felix-1/profile/setup/phyJ7tyoDUOylqpvbzOb6TQ49AdtsOtyYh4kFFvC"
                                        class="text-muted btn btn-sm btn-icon"
                                        data-bs-original-title="Copy account invitation link"
                                        aria-label="Copy account invitation link"
                                    >
                                        <!-- <svg ariaHidden="true" class="fill-current fa-icon">
                                        <use xlink:href="/v4/icons/fa-sprite.svg#solid-link"></use></svg> -->
                                    </button>
                                </h3>
                                <!---->
                                <dl class="inline icons !items-start mb-0">
                                    <!---->
                                    <!---->
                                    <dt>
                                        <!-- <svg ariaHidden="true" class="fill-current fa-icon"> -->
                                        <!-- <use xlink:href="/v4/icons/fa-sprite.svg#user-group"></use></svg> -->
                                        <span class="sr-only">Contact groups</span>
                                    </dt>
                                    <dd class="flex flex-wrap gap-1">
                                        <span><a class="rounded-[9px] flex items-center justify-center px-2 text-sm w-fit bg-gray-200 text-gray-700" href="https://app.boardable.com/felix-1/groups/dff155-board">Board</a></span>
                                        <span>
                                            <a class="rounded-[9px] flex items-center justify-center px-2 text-sm w-fit bg-gray-200 text-gray-700" href="https://app.boardable.com/felix-1/groups/ae969a-finance-and-administration-committee">
                                                Finance and Administration Committee
                                            </a>
                                        </span>
                                    </dd>
                                    <!---->
                                </dl>
                            </div>
                            <div class="ml-auto flex flex-col justify-between items-end mb-2">
                                <div class="social-icons flex">
                                    <!---->
                                    <!---->
                                    <!---->
                                </div>
                                <p class="whitespace-nowrap"><span>Last Activity:</span> <span>Mar 20, 2024</span></p>
                                <!---->
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body flex">
                            <div class="mr-6">
                                <label for="profile-card-113" class="sr-only">Select profile</label>
                                <label class="h-fit w-fit bg-transparent cursor-pointer !rounded-none" id="profile-card-113">
                                    <label class="cursor-pointer flex flex-row items-center gap-2 w-fit p-0">
                                        <!---->
                                        <input
                                            type="checkbox"
                                            id="profile-card-113"
                                            class="cursor-pointer focus:outline-none rounded-sm border-2 border-gray-600 focus:border-primary checked:bg-primary checked:border-primary checked:bg-checkbox disabled:bg-gray-300 disabled:checked:bg-white disabled:border-gray-400 focus:ring-[3px] ring-primary/25 w-4 h-4 accent-transparent bg-contain bg-no-repeat bg-center appearance-none"
                                            value=""
                                            data-uw-rm-form="nfx"
                                        />
                                        <!---->
                                    </label>
                                    <!---->
                                </label>
                            </div>
                            <div class="avatar avatar-xl mr-5">
                                <a href="https://app.boardable.com/felix-1/people/nyariki-felix" aria-label="Open Nyariki Felix User Profile">
                                    <img
                                        src="https://app.boardable.com/img/default_user.svg"
                                        alt="Nyariki Felix profile image"
                                        class="avatar-img min-w-[82px] w-[82px] rounded-full"
                                        data-uw-rm-alt-original="Nyariki Felix profile image"
                                        role="img"
                                        data-uw-rm-alt="ALT"
                                    />
                                </a>
                            </div>
                            <div class="mr-5">
                                <h3 class="name mb-0 flex items-center">
                                    <a href="https://app.boardable.com/felix-1/people/nyariki-felix" aria-label="Open Nyariki Felix User Profile">
                                        Nyariki Felix
                                        <!---->
                                    </a>
                                    <a href="https://app.boardable.com/felix-1/people/nyariki-felix/edit" title="" class="mx-2 text-muted btn btn-sm btn-icon" data-bs-original-title="Edit user profile" aria-label="Edit user profile">
                                        <!-- <svg ariaHidden="true" class="fill-current fa-icon"> -->
                                        <!-- <use xlink:href="/v4/icons/fa-sprite.svg#pen-to-square"></use></svg> -->
                                    </a>
                                    <button
                                        title=""
                                        data-copy-text="https://app.boardable.com/felix-1/profile/setup/KNlfBS7HITtJcxO4MBRxvNIU7IW8KQvY9pGjPzvE"
                                        class="text-muted btn btn-sm btn-icon"
                                        data-bs-original-title="Copy account invitation link"
                                        aria-label="Copy account invitation link"
                                    >
                                        <!-- <svg ariaHidden="true" class="fill-current fa-icon"> -->
                                        <!-- <use xlink:href="/v4/icons/fa-sprite.svg#solid-link"></use></svg> -->
                                    </button>
                                </h3>
                                <!---->
                                <dl class="inline icons !items-start mb-0">
                                    <!---->
                                    <!---->
                                    <dt>
                                        <!-- <svg ariaHidden="true" class="fill-current fa-icon"> -->
                                        <!-- <use xlink:href="/v4/icons/fa-sprite.svg#user-group"></use></svg> -->
                                        <span class="sr-only">Contact groups</span>
                                    </dt>
                                    <dd class="flex flex-wrap gap-1">
                                        <span>
                                            <a class="rounded-[9px] flex items-center justify-center px-2 text-sm w-fit bg-gray-200 text-gray-700" href="https://app.boardable.com/felix-1/groups/ae969a-finance-and-administration-committee">
                                                Finance and Administration Committee
                                            </a>
                                        </span>
                                    </dd>
                                    <!---->
                                </dl>
                            </div>
                            <div class="ml-auto flex flex-col justify-between items-end mb-2">
                                <div class="social-icons flex">
                                    <!---->
                                    <!---->
                                    <!---->
                                </div>
                                <p class="whitespace-nowrap"><span>Last Activity:</span> <span>9:53 AM</span></p>
                                <!---->
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body flex">
                            <div class="mr-6">
                                <label for="profile-card-119" class="sr-only">Select profile</label>
                                <label class="h-fit w-fit bg-transparent cursor-pointer !rounded-none" id="profile-card-119">
                                    <label class="cursor-pointer flex flex-row items-center gap-2 w-fit p-0">
                                        <!---->
                                        <input
                                            type="checkbox"
                                            id="profile-card-119"
                                            class="cursor-pointer focus:outline-none rounded-sm border-2 border-gray-600 focus:border-primary checked:bg-primary checked:border-primary checked:bg-checkbox disabled:bg-gray-300 disabled:checked:bg-white disabled:border-gray-400 focus:ring-[3px] ring-primary/25 w-4 h-4 accent-transparent bg-contain bg-no-repeat bg-center appearance-none"
                                            value=""
                                            data-uw-rm-form="nfx"
                                        />
                                        <!---->
                                    </label>
                                    <!---->
                                </label>
                            </div>
                            <div class="avatar avatar-xl mr-5">
                                <a href="https://app.boardable.com/felix-1/people/nyariki-felix-1" aria-label="Open Nyariki Felix User Profile">
                                    <img
                                        src="https://app.boardable.com/img/default_user.svg"
                                        alt="Nyariki Felix profile image"
                                        class="avatar-img min-w-[82px] w-[82px] rounded-full"
                                        data-uw-rm-alt-original="Nyariki Felix profile image"
                                        role="img"
                                        data-uw-rm-alt="ALT"
                                    />
                                </a>
                            </div>
                            <div class="mr-5">
                                <h3 class="name mb-0 flex items-center">
                                    <a href="https://app.boardable.com/felix-1/people/nyariki-felix-1" aria-label="Open Nyariki Felix User Profile">
                                        Nyariki Felix
                                        <!---->
                                    </a>
                                    <a href="https://app.boardable.com/felix-1/people/nyariki-felix-1/edit" title="" class="mx-2 text-muted btn btn-sm btn-icon" data-bs-original-title="Edit user profile" aria-label="Edit user profile">
                                        <!-- <svg ariaHidden="true" class="fill-current fa-icon"> -->
                                        <!-- <use xlink:href="/v4/icons/fa-sprite.svg#pen-to-square"></use></svg> -->
                                    </a>
                                    <button
                                        title=""
                                        data-copy-text="https://app.boardable.com/felix-1/profile/setup/WYPUEpwoB7SLs0yuSCx27WvsmdMNerAN2lMS779I"
                                        class="text-muted btn btn-sm btn-icon"
                                        data-bs-original-title="Copy account invitation link"
                                        aria-label="Copy account invitation link"
                                    >
                                        <!-- <svg ariaHidden="true" class="fill-current fa-icon"> -->
                                        <!-- <use xlink:href="/v4/icons/fa-sprite.svg#solid-link"></use></svg> -->
                                    </button>
                                </h3>
                                <!---->
                                <dl class="inline icons !items-start mb-0">
                                    <!---->
                                    <!---->
                                    <dt>
                                        <!-- <svg ariaHidden="true" class="fill-current fa-icon"> -->
                                        <!-- <use xlink:href="/v4/icons/fa-sprite.svg#user-group"></use></svg><span class="sr-only">Contact groups</span> -->
                                    </dt>
                                    <dd class="flex flex-wrap gap-1">
                                        <span>
                                            <a class="rounded-[9px] flex items-center justify-center px-2 text-sm w-fit bg-gray-200 text-gray-700" href="https://app.boardable.com/felix-1/groups/ae969a-finance-and-administration-committee">
                                                Finance and Administration Committee
                                            </a>
                                        </span>
                                    </dd>
                                    <!---->
                                </dl>
                            </div>
                            <div class="ml-auto flex flex-col justify-between items-end mb-2">
                                <div class="social-icons flex">
                                    <!---->
                                    <!---->
                                    <!---->
                                </div>
                                <!---->
                                <!---->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" style="display: none;">
                    <div id="member-list" class="table-responsive">
                        <table class="card-table table">
                            <thead>
                                <tr>
                                    <th>
                                        <div>
                                            <label class="h-fit w-fit bg-transparent cursor-pointer !rounded-none" id="users-select-all" name="users-select-all">
                                                <label class="cursor-pointer flex flex-row items-center gap-2 w-fit p-0">
                                                    <!---->
                                                    <input
                                                        type="checkbox"
                                                        id="users-select-all"
                                                        name="users-select-all"
                                                        class="cursor-pointer focus:outline-none rounded-sm border-2 border-gray-600 focus:border-primary checked:bg-primary checked:border-primary checked:bg-checkbox disabled:bg-gray-300 disabled:checked:bg-white disabled:border-gray-400 focus:ring-[3px] ring-primary/25 w-4 h-4 accent-transparent bg-contain bg-no-repeat bg-center appearance-none"
                                                        value=""
                                                        data-uw-rm-form="nfx"
                                                    />
                                                    <!---->
                                                </label>
                                                <!---->
                                            </label>
                                            <label for="users-select-all" class="form-check-label sr-only">Select All Users</label>
                                        </div>
                                    </th>
                                    <th data-sort="user-name" class="list-sort">Member</th>
                                    <th data-sort="board-role" class="list-sort">Board Role</th>
                                    <th data-sort="role-name" class="list-sort">Account Role</th>
                                    <th data-sort="last-activity" class="list-sort">Last Activity</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <tr>
                                    <td>
                                        <label class="h-fit w-fit bg-transparent cursor-pointer !rounded-none" id="user-select-342753">
                                            <label class="cursor-pointer flex flex-row items-center gap-2 w-fit p-0">
                                                <!---->
                                                <input
                                                    type="checkbox"
                                                    id="user-select-342753"
                                                    class="cursor-pointer focus:outline-none rounded-sm border-2 border-gray-600 focus:border-primary checked:bg-primary checked:border-primary checked:bg-checkbox disabled:bg-gray-300 disabled:checked:bg-white disabled:border-gray-400 focus:ring-[3px] ring-primary/25 w-4 h-4 accent-transparent bg-contain bg-no-repeat bg-center appearance-none"
                                                    value=""
                                                    data-uw-rm-form="nfx"
                                                />
                                                <!---->
                                            </label>
                                            <!---->
                                        </label>
                                        <label for="user-select-342753" class="form-check-label sr-only">Select item</label>
                                    </td>
                                    <td data-user-name="Cynthia Muriithi" class="user-name">
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar avatar-sm">
                                                <img
                                                    src="https://app.boardable.com/img/default_user.svg"
                                                    alt="Cynthia Muriithi profile image"
                                                    class="avatar-img rounded-full"
                                                    data-uw-rm-alt-original="Cynthia Muriithi profile image"
                                                    role="img"
                                                    data-uw-rm-alt="ALT"
                                                />
                                            </div>
                                            <h3 class="m-0">
                                                <a href="https://app.boardable.com/felix-1/people/cynthia-muriithi">
                                                    Cynthia Muriithi
                                                    <!---->
                                                </a>
                                            </h3>
                                        </div>
                                    </td>
                                    <td data-board-role="" class="board-role"><div></div></td>
                                    <td data-role-name="admin" class="role-name">
                                        <div><span class="capitalize">admin</span></div>
                                    </td>
                                    <td data-last-activity="2024-03-20 19:47:51" class="last-activity"><div>Wednesday, March 20 2024</div></td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="h-fit w-fit bg-transparent cursor-pointer !rounded-none" id="user-select-342754">
                                            <label class="cursor-pointer flex flex-row items-center gap-2 w-fit p-0">
                                                <!---->
                                                <input
                                                    type="checkbox"
                                                    id="user-select-342754"
                                                    class="cursor-pointer focus:outline-none rounded-sm border-2 border-gray-600 focus:border-primary checked:bg-primary checked:border-primary checked:bg-checkbox disabled:bg-gray-300 disabled:checked:bg-white disabled:border-gray-400 focus:ring-[3px] ring-primary/25 w-4 h-4 accent-transparent bg-contain bg-no-repeat bg-center appearance-none"
                                                    value=""
                                                    data-uw-rm-form="nfx"
                                                />
                                                <!---->
                                            </label>
                                            <!---->
                                        </label>
                                        <label for="user-select-342754" class="form-check-label sr-only">Select item</label>
                                    </td>
                                    <td data-user-name="Nyariki Felix" class="user-name">
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar avatar-sm">
                                                <img
                                                    src="https://app.boardable.com/img/default_user.svg"
                                                    alt="Nyariki Felix profile image"
                                                    class="avatar-img rounded-full"
                                                    data-uw-rm-alt-original="Nyariki Felix profile image"
                                                    role="img"
                                                    data-uw-rm-alt="ALT"
                                                />
                                            </div>
                                            <h3 class="m-0">
                                                <a href="https://app.boardable.com/felix-1/people/nyariki-felix">
                                                    Nyariki Felix
                                                    <!---->
                                                </a>
                                            </h3>
                                        </div>
                                    </td>
                                    <td data-board-role="" class="board-role"><div></div></td>
                                    <td data-role-name="admin" class="role-name">
                                        <div><span class="capitalize">admin</span></div>
                                    </td>
                                    <td data-last-activity="2024-04-16 06:53:13" class="last-activity"><div>Tuesday, April 16 2024</div></td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="h-fit w-fit bg-transparent cursor-pointer !rounded-none" id="user-select-343467">
                                            <label class="cursor-pointer flex flex-row items-center gap-2 w-fit p-0">
                                                <!---->
                                                <input
                                                    type="checkbox"
                                                    id="user-select-343467"
                                                    class="cursor-pointer focus:outline-none rounded-sm border-2 border-gray-600 focus:border-primary checked:bg-primary checked:border-primary checked:bg-checkbox disabled:bg-gray-300 disabled:checked:bg-white disabled:border-gray-400 focus:ring-[3px] ring-primary/25 w-4 h-4 accent-transparent bg-contain bg-no-repeat bg-center appearance-none"
                                                    value=""
                                                    data-uw-rm-form="nfx"
                                                />
                                                <!---->
                                            </label>
                                            <!---->
                                        </label>
                                        <label for="user-select-343467" class="form-check-label sr-only">Select item</label>
                                    </td>
                                    <td data-user-name="Nyariki Felix" class="user-name">
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar avatar-sm">
                                                <img
                                                    src="https://app.boardable.com/img/default_user.svg"
                                                    alt="Nyariki Felix profile image"
                                                    class="avatar-img rounded-full"
                                                    data-uw-rm-alt-original="Nyariki Felix profile image"
                                                    role="img"
                                                    data-uw-rm-alt="ALT"
                                                />
                                            </div>
                                            <h3 class="m-0">
                                                <a href="https://app.boardable.com/felix-1/people/nyariki-felix-1">
                                                    Nyariki Felix
                                                    <!---->
                                                </a>
                                            </h3>
                                        </div>
                                    </td>
                                    <td data-board-role="" class="board-role"><div></div></td>
                                    <td data-role-name="admin" class="role-name">
                                        <div><span class="capitalize">admin</span></div>
                                    </td>
                                    <td data-last-activity="0" class="last-activity"><div></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div role="alert" class="list-alert alert bg-gray-800 pr-10 fade">
                    <div class="flex items-center space-x-2">
                        <p class="m-0 text-gray-100">0 user selected</p>
                        <button type="button" class="btn btn-sm btn-secondary">
                            Send Invitations
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary">
                            Delete
                        </button>
                    </div>
                    <button type="button" aria-label="Close" class="absolute top-3 right-2 !text-gray-100 btn btn-sm btn-icon hover:!text-gray-800">
                        <!-- <svg ariaHidden="true" class="fill-current fa-icon"> -->
                        <!-- <use xlink:href="/v4/icons/fa-sprite.svg#solid-xmark"></use></svg> -->
                    </button>
                </div>
                <div>
                    <div aria-labelledby="modal-73" aria-hidden="true" tabindex="-1" class="modal fade" id="send-invites">
                        <form class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 id="modal-73" class="modal-title h3 mb-0">Send Invitation</h2>
                                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-icon absolute right-2.5 top-2.5">
                                        <!-- <svg ariaHidden="true" class="fill-current fa-icon"> -->
                                        <!-- <use xlink:href="/v4/icons/fa-sprite.svg#solid-xmark"></use></svg> -->
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="textarea-75" class="form-label">
                                            Message
                                            <!----><!---->
                                        </label>
                                        <textarea id="textarea-75" class="form-control" style="display: none;" aria-hidden="true" data-gramm="false" wt-ignore-input="true" data-uw-rm-form="nfx"></textarea>
                                        <div role="application" class="tox tox-tinymce" aria-disabled="false" style="visibility: hidden; height: 100px;" data-mce-style="visibility: hidden; height: 100px;">
                                            <div class="tox-editor-container">
                                                <div data-alloy-vertical-dir="toptobottom" class="tox-editor-header">
                                                    <div role="group" class="tox-toolbar-overlord" aria-disabled="false">
                                                        <div role="group" class="tox-toolbar__primary">
                                                            <div title="" role="toolbar" data-alloy-tabstop="true" tabindex="-1" class="tox-toolbar__group">
                                                                <button aria-label="Bold" title="Bold" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                    <span class="tox-icon tox-tbtn__icon-wrap">
                                                                        <svg viewBox="0 0 384 512" width="18" height="18" focusable="false">
                                                                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                            <path
                                                                                d="M321.1 242.4C340.1 220.1 352 191.6 352 160c0-70.59-57.42-128-128-128L32 32.01c-17.67 0-32 14.31-32 32s14.33 32 32 32h16v320H32c-17.67 0-32 14.31-32 32s14.33 32 32 32h224c70.58 0 128-57.41 128-128C384 305.3 358.6 264.8 321.1 242.4zM112 96.01H224c35.3 0 64 28.72 64 64s-28.7 64-64 64H112V96.01zM256 416H112v-128H256c35.3 0 64 28.71 64 63.1S291.3 416 256 416z"
                                                                            ></path>
                                                                        </svg>
                                                                    </span>
                                                                </button>
                                                                <button aria-label="Italic" title="Italic" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                    <span class="tox-icon tox-tbtn__icon-wrap">
                                                                        <svg viewBox="0 0 384 512" width="18" height="18" focusable="false">
                                                                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                            <path
                                                                                d="M384 64.01c0 17.69-14.31 32-32 32h-58.67l-133.3 320H224c17.69 0 32 14.31 32 32s-14.31 32-32 32H32c-17.69 0-32-14.31-32-32s14.31-32 32-32h58.67l133.3-320H160c-17.69 0-32-14.31-32-32s14.31-32 32-32h192C369.7 32.01 384 46.33 384 64.01z"
                                                                            ></path>
                                                                        </svg>
                                                                    </span>
                                                                </button>
                                                                <button aria-label="Bullet list" title="Bullet list" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                    <span class="tox-icon tox-tbtn__icon-wrap">
                                                                        <svg viewBox="0 0 512 512" width="20" height="20" focusable="false">
                                                                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                            <path
                                                                                d="M88 48C101.3 48 112 58.75 112 72V120C112 133.3 101.3 144 88 144H40C26.75 144 16 133.3 16 120V72C16 58.75 26.75 48 40 48H88zM488 72C501.3 72 512 82.75 512 96C512 109.3 501.3 120 488 120H184C170.7 120 160 109.3 160 96C160 82.75 170.7 72 184 72H488zM488 232C501.3 232 512 242.7 512 256C512 269.3 501.3 280 488 280H184C170.7 280 160 269.3 160 256C160 242.7 170.7 232 184 232H488zM488 392C501.3 392 512 402.7 512 416C512 429.3 501.3 440 488 440H184C170.7 440 160 429.3 160 416C160 402.7 170.7 392 184 392H488zM16 232C16 218.7 26.75 208 40 208H88C101.3 208 112 218.7 112 232V280C112 293.3 101.3 304 88 304H40C26.75 304 16 293.3 16 280V232zM88 368C101.3 368 112 378.7 112 392V440C112 453.3 101.3 464 88 464H40C26.75 464 16 453.3 16 440V392C16 378.7 26.75 368 40 368H88z"
                                                                            ></path>
                                                                        </svg>
                                                                    </span>
                                                                </button>
                                                                <button aria-label="Numbered list" title="Numbered list" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                    <span class="tox-icon tox-tbtn__icon-wrap">
                                                                        <svg viewBox="0 0 576 512" width="20" height="20" focusable="false">
                                                                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                            <path
                                                                                d="M55.1 56.04C55.1 42.78 66.74 32.04 79.1 32.04H111.1C125.3 32.04 135.1 42.78 135.1 56.04V176H151.1C165.3 176 175.1 186.8 175.1 200C175.1 213.3 165.3 224 151.1 224H71.1C58.74 224 47.1 213.3 47.1 200C47.1 186.8 58.74 176 71.1 176H87.1V80.04H79.1C66.74 80.04 55.1 69.29 55.1 56.04V56.04zM118.7 341.2C112.1 333.8 100.4 334.3 94.65 342.4L83.53 357.9C75.83 368.7 60.84 371.2 50.05 363.5C39.26 355.8 36.77 340.8 44.47 330.1L55.59 314.5C79.33 281.2 127.9 278.8 154.8 309.6C176.1 333.1 175.6 370.5 153.7 394.3L118.8 432H152C165.3 432 176 442.7 176 456C176 469.3 165.3 480 152 480H64C54.47 480 45.84 474.4 42.02 465.6C38.19 456.9 39.9 446.7 46.36 439.7L118.4 361.7C123.7 355.9 123.8 347.1 118.7 341.2L118.7 341.2zM520 72C533.3 72 544 82.75 544 96C544 109.3 533.3 120 520 120H248C234.7 120 224 109.3 224 96C224 82.75 234.7 72 248 72H520zM520 232C533.3 232 544 242.7 544 256C544 269.3 533.3 280 520 280H248C234.7 280 224 269.3 224 256C224 242.7 234.7 232 248 232H520zM520 392C533.3 392 544 402.7 544 416C544 429.3 533.3 440 520 440H248C234.7 440 224 429.3 224 416C224 402.7 234.7 392 248 392H520z"
                                                                            ></path>
                                                                        </svg>
                                                                    </span>
                                                                </button>
                                                                <button aria-label="Insert/edit link" title="Insert/edit link" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false" style="width: 25px;">
                                                                    <span class="tox-icon tox-tbtn__icon-wrap">
                                                                        <svg viewBox="0 0 640 512" width="20" height="20" focusable="false">
                                                                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                            <path
                                                                                d="M172.5 131.1C228.1 75.51 320.5 75.51 376.1 131.1C426.1 181.1 433.5 260.8 392.4 318.3L391.3 319.9C381 334.2 361 337.6 346.7 327.3C332.3 317 328.9 297 339.2 282.7L340.3 281.1C363.2 249 359.6 205.1 331.7 177.2C300.3 145.8 249.2 145.8 217.7 177.2L105.5 289.5C73.99 320.1 73.99 372 105.5 403.5C133.3 431.4 177.3 435 209.3 412.1L210.9 410.1C225.3 400.7 245.3 404 255.5 418.4C265.8 432.8 262.5 452.8 248.1 463.1L246.5 464.2C188.1 505.3 110.2 498.7 60.21 448.8C3.741 392.3 3.741 300.7 60.21 244.3L172.5 131.1zM467.5 380C411 436.5 319.5 436.5 263 380C213 330 206.5 251.2 247.6 193.7L248.7 192.1C258.1 177.8 278.1 174.4 293.3 184.7C307.7 194.1 311.1 214.1 300.8 229.3L299.7 230.9C276.8 262.1 280.4 306.9 308.3 334.8C339.7 366.2 390.8 366.2 422.3 334.8L534.5 222.5C566 191 566 139.1 534.5 108.5C506.7 80.63 462.7 76.99 430.7 99.9L429.1 101C414.7 111.3 394.7 107.1 384.5 93.58C374.2 79.2 377.5 59.21 391.9 48.94L393.5 47.82C451 6.731 529.8 13.25 579.8 63.24C636.3 119.7 636.3 211.3 579.8 267.7L467.5 380z"
                                                                            ></path>
                                                                        </svg>
                                                                    </span>
                                                                </button>
                                                                <button aria-label="Remove link" title="Remove link" type="button" tabindex="-1" class="tox-tbtn tox-tbtn--disabled" aria-disabled="true" style="width: 25px;">
                                                                    <span class="tox-icon tox-tbtn__icon-wrap">
                                                                        <svg viewBox="0 0 640 512" width="20" height="20" focusable="false">
                                                                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                            <path
                                                                                d="M185.7 120.2C242.1 75.56 324.3 79.31 376.5 131.5C419.8 174.8 429.1 239.4 405.7 292.7L451.3 328.4L546.4 233.3C583.8 195.8 583.8 135.1 546.4 97.71C510.7 62.02 453.4 60.11 415.5 93.35L409.3 98.7C399.4 107.4 384.2 106.4 375.5 96.44C366.7 86.47 367.8 71.31 377.7 62.58L383.9 57.22C440.9 7.351 526.8 10.21 580.3 63.77C636.5 119.9 636.5 211 580.3 267.2L489.3 358.2L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L185.7 120.2zM225.1 151.1L366.3 261.8C376.6 228.7 368.5 191.4 342.5 165.4C310.7 133.5 261.1 128.8 225.1 151.1L225.1 151.1zM263.5 380.5C233.4 350.5 219.3 310.2 221.6 270.6L275.8 313.3C280.4 325.4 287.7 336.8 297.4 346.6C312.1 362.1 332.5 371.2 352.6 373.8L406.9 416.6C357.8 431.3 302.3 419.3 263.5 380.5V380.5zM116.6 187.9L154.6 217.8L93.63 278.7C56.19 316.2 56.19 376.9 93.63 414.3C129.3 449.1 186.6 451.9 224.5 418.7L230.7 413.3C240.6 404.6 255.8 405.6 264.5 415.6C273.2 425.5 272.2 440.7 262.3 449.4L256.1 454.8C199.1 504.7 113.2 501.8 59.69 448.2C3.505 392.1 3.505 300.1 59.69 244.8L116.6 187.9z"
                                                                            ></path>
                                                                        </svg>
                                                                    </span>
                                                                </button>
                                                                <button aria-label="Clear formatting" title="Clear formatting" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" style="width: 25px;">
                                                                    <span class="tox-icon tox-tbtn__icon-wrap">
                                                                        <svg width="24" height="24" focusable="false">
                                                                            <path
                                                                                d="M13.2 6a1 1 0 0 1 0 .2l-2.6 10a1 1 0 0 1-1 .8h-.2a.8.8 0 0 1-.8-1l2.6-10H8a1 1 0 1 1 0-2h9a1 1 0 0 1 0 2h-3.8ZM5 18h7a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Zm13 1.5L16.5 18 15 19.5a.7.7 0 0 1-1-1l1.5-1.5-1.5-1.5a.7.7 0 0 1 1-1l1.5 1.5 1.5-1.5a.7.7 0 0 1 1 1L17.5 17l1.5 1.5a.7.7 0 0 1-1 1Z"
                                                                                fill-rule="evenodd"
                                                                            ></path>
                                                                        </svg>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                            <div title="" role="toolbar" data-alloy-tabstop="true" tabindex="-1" class="tox-toolbar__group">
                                                                <button
                                                                    title="Block Paragraph"
                                                                    aria-label="Block Paragraph"
                                                                    aria-haspopup="true"
                                                                    type="button"
                                                                    tabindex="-1"
                                                                    unselectable="on"
                                                                    class="tox-tbtn tox-tbtn--select tox-tbtn--bespoke"
                                                                    aria-expanded="false"
                                                                    style="user-select: none; width: auto;"
                                                                >
                                                                    <span class="tox-tbtn__select-label">Paragraph</span>
                                                                    <div class="tox-tbtn__select-chevron">
                                                                        <svg width="10" height="10" focusable="false">
                                                                            <path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 0 1 0-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8Z" fill-rule="nonzero"></path>
                                                                        </svg>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tox-anchorbar"></div>
                                                </div>
                                                <div class="tox-sidebar-wrap">
                                                    <div class="tox-edit-area">
                                                        <iframe
                                                            id="textarea-75_ifr"
                                                            frameborder="0"
                                                            allowtransparency="true"
                                                            title="Accessibility Menu"
                                                            class="tox-edit-area__iframe"
                                                            srcdoc='<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /></head><body id="tinymce" class="mce-content-body " data-id="textarea-75" aria-label="Rich Text Area. Press ALT-0 for help."><br></body></html>'
                                                            data-uw-rm-iframe="gn"
                                                        ></iframe>
                                                    </div>
                                                    <div role="presentation" class="tox-sidebar">
                                                        <div data-alloy-tabstop="true" tabindex="-1" class="tox-sidebar__slider tox-sidebar--sliding-closed" style="width: 0px;"><div class="tox-sidebar__pane-container"></div></div>
                                                    </div>
                                                </div>
                                                <div class="tox-bottom-anchorbar"></div>
                                            </div>
                                            <div aria-hidden="true" class="tox-view-wrap" style="display: none;"><div class="tox-view-wrap__slot-container"></div></div>
                                            <div class="tox-throbber" aria-hidden="true" style="display: none;"></div>
                                        </div>
                                        <!---->
                                    </div>
                                    <div class="form-group">
                                        <p>Invitations will be sent to:</p>
                                        <ul class="list-unstyled"></ul>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary mr-2">Cancel</button>
                                    <button type="submit" class="btn btn-primary">
                                        <!---->
                                        Send Invitations
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup lang="ts">
import {onMounted, ref} from 'vue';

const users = ref([
    {id: 1, name: 'John Doe', email: 'john.doe@example.com', role: 'Administrator'},
    {id: 2, name: 'Jane Doe', email: 'jane.doe@example.com', role: 'User'},
    // Add more users as needed
]);
onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Users'}));
    // getUsers();
});
</script>

<style scoped>
</style>

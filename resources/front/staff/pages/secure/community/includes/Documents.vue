<script setup lang="">

</script>

<style scoped>
</style>
<template>
    <div class="card">
        <div class="card-header flex items-center h-auto p-4">
            <div class="flex items-center flex-1 w-full">
                <div class="block sm:flex w-full items-center">
                    <nav aria-label="Breadcrumbs" class="text-sm overflow-x-hidden mr-2 flex-1">
                        <ol class="breadcrumb hidden sm:flex">
                            <li class="breadcrumb-item whitespace-nowrap"><a href="https://app.boardable.com/felix-1/groups/ae969a-finance-and-administration-committee/documents/" class="text-gray-800 font-medium whitespace-nowrap">
                                Documents
                            </a>
                            </li>
                        </ol>
                        <!---->
                    </nav>
                    <div class="flex justify-between">
                        <div class="flex items-center mr-6">
                            <!---->
                            <div class="dropdown">
                                <a href="#" type="button" id="sort_button" data-bs-toggle="dropdown" aria-haspopup="true" class="btn btn-secondary btn-sm dropdown-toggle"><span class="text-gray-600">sort by:</span> <strong>Default</strong></a>
                                <div class="dropdown-menu"><a href="#" class="dropdown-item">Default</a> <a href="#" class="dropdown-item">Name (A-Z)</a> <a href="#" class="dropdown-item">Name (Z-A)</a> <a href="#" class="dropdown-item">Newest to oldest</a> <a href="#" class="dropdown-item">Oldest to newest</a></div>
                            </div>
                        </div>
                        <div class="relative">
                            <span data-bs-toggle="dropdown" aria-expanded="false" class="cursor-pointer">
                                <button aria-label="Attach a document" class="btn btn-secondary btn-sm w-icon">
                                    <svg ariaHidden="true" class="fill-current fa-icon">
                                    </svg>
                                    New
                                </button>
                            </span>
                            <ul class="dropdown-menu">
                                <li>
                                    <button aria-label="Create a folder" class="dropdown-item w-icon flex">
                                        <span class="w-5 block text-center mr-2">
                                            <svg aria-hidden="true" class="svg-inline--fa fa-folder-plus" focusable="false" data-prefix="far" data-icon="folder-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H289.9L247 53.1C233.5 39.6 215.2 32 196.1 32H64zM48 96c0-8.8 7.2-16 16-16H196.1c6.4 0 12.5 2.5 17 7l45.3 45.3c7.5 7.5 17.7 11.7 28.3 11.7H448c8.8 0 16 7.2 16 16V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V96zM232 376c0 13.3 10.7 24 24 24s24-10.7 24-24V312h64c13.3 0 24-10.7 24-24s-10.7-24-24-24H280V200c0-13.3-10.7-24-24-24s-24 10.7-24 24v64H168c-13.3 0-24 10.7-24 24s10.7 24 24 24h64v64z"></path>
                                            </svg>
                                            <!-- <i aria-hidden="true" class="fa-regular fa-folder-plus"></i> -->
                                        </span>
                                        New folder
                                    </button>
                                </li>
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
                                        <div class="w-5 text-center mr-2"><img src="" data-uw-rm-alt-original="" role="presentation" alt="" data-uw-rm-alt="SM"></div>
                                        <div class="flex-1">Boardable</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item flex items-center">
                                        <div class="w-5 text-center mr-2"><img src="" data-uw-rm-alt-original="" role="presentation" alt="" data-uw-rm-alt="SM"></div>
                                        <div class="flex-1">Google Drive</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item flex items-center">
                                        <div class="w-5 text-center mr-2"><img src="" class="relative top-px" data-uw-rm-alt-original="" role="presentation" alt="" data-uw-rm-alt="SM"></div>
                                        <div class="flex-1">Dropbox</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item flex items-center">
                                        <div class="w-5 text-center mr-2"><img src="" data-uw-rm-alt-original="" role="presentation" alt="" data-uw-rm-alt="SM"></div>
                                        <div class="flex-1">OneDrive</div>
                                    </a>
                                </li>
                            </ul>
                            <input type="file" multiple="multiple" hidden="hidden" data-uw-rm-form="fx" aria-label="File field" data-uw-hidden-control="hidden-control-element">
                            <div class="v-portal" style="display: none;"></div>
                        </div>
                    </div>
                </div>
                <!---->
            </div>
            <!----> <!---->
        </div>
        <!---->
        <div class="py-0 px-4 min-h-[300px] relative -top-px z-10" style="">
            <!----> <!----> <!---->
            <div>
                <div>
                    <div>
                        <div>
                            <table class="table mb-0">
                                <tbody></tbody>
                            </table>
                            <table class="table">
                                <tbody>
                                    <tr class="group bg-white hover:cursor-move hover:bg-gray-100">
                                        <td class="w-12"><a href="https://app.boardable.com/felix-1/documents/5da61ed2?redirect=documents" class="w-12 h-12 flex justify-center items-center block" aria-label="app.boardable.com" data-uw-rm-empty-ctrl=""><img src="https://app.boardable.com/felix-1/pdfs/1785440/members-1xlsxpdf/thumb" class="mx-auto rounded object-contain w-12 h-12 border border-gray-200" data-uw-rm-alt-original="" role="presentation" alt="" data-uw-rm-alt="SM"></a></td>
                                        <td><span class="relative max-w-full flex align-text-bottom h-6"><span class="absolute whitespace-nowrap overflow-x-hidden max-w-full w-full top-0 left-0 text-ellipsis"><a href="https://app.boardable.com/felix-1/documents/5da61ed2?redirect=documents" class="text-gray-900">
                                            members (1).xlsx
                                        </a></span></span>
                                        </td>
                                        <td class="w-28 hidden sm:table-cell">
                                            <div class="whitespace-nowrap text-sm">Mar 20, 2024</div>
                                            <div class="whitespace-nowrap text-xs text-muted">9:58 AM</div>
                                        </td>
                                        <td class="w-20 hidden sm:table-cell text-center">
                                            <div class="dropdown">
                                                <button role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-secondary !border-transparent w-10" aria-label="ellipsis-vertical" data-uw-rm-empty-ctrl="" data-uw-rm-kbnav="role" tabindex="0">
                                                    <svg class="svg-inline--fa fa-ellipsis-vertical" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis-vertical" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512" data-fa-i2svg="">
                                                        <path fill="currentColor" d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"></path>
                                                    </svg>
                                                    <!-- <i class="fa-solid fa-ellipsis-vertical"></i> -->
                                                </button>
                                                <div class="dropdown-menu"><a href="#" class="dropdown-item">Edit</a> <a href="https://app.boardable.com/felix-1/attachments/uploads/download/428353/members+%281%29.xlsx" download="" class="dropdown-item" aria-label="Edit Download Move" uw-rm-vague-link-id="https://app.boardable.com/felix-1/attachments/uploads/download/428353/members+%281%29.xlsx$download" data-uw-rm-vglnk="">Download</a> <a href="#" class="dropdown-item">Move</a> <a href="#" class="dropdown-item text-danger">Delete</a></div>
                                            </div>
                                        </td>
                                        <div class="v-portal" style="display: none;"></div>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!---->
                </div>
            </div>
            <div style="display: none;">
                <div class="p-4 bg-gray-100 rounded-lg my-4">
                    <div class="flex">
                        <div class="flex-1">
                            <h2 class="mb-0">Agenda documents</h2>
                            <div class="text-sm mt-2.5 text-gray-700">
                                <span class="mr-1">
                                    <svg class="svg-inline--fa fa-link" aria-hidden="true" focusable="false" data-prefix="fas"
                                         data-icon="link" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6
                                                            1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5
                                                            82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4-10.3 17.7-30.3 7.4-44.6s-30.3-17.7-44.6-7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z"></path>
                                    </svg>
                                    <!-- <i class="fa-solid fa-link"></i> -->
                                </span>
                                This folder is synced with the agenda. All documents attached to the agenda will be displayed here.
                            </div>
                        </div>
                        <!---->
                    </div>
                </div>
                <div class="text-center my-12 space-y-4 text-muted text-sm">
                    <img src="" alt="" class="mx-auto h-32" data-uw-rm-alt-original="Illustration of a person looking at a document" role="presentation" data-uw-rm-alt="SM">
                    <p>No documents are attached to the agenda yet</p>
                </div>
            </div>
        </div>
        <!---->
    </div>
</template>


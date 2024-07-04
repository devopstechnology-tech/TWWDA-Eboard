<template>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Search Discussions</h3>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control rounded-end" 
                               placeholder="Search discussions" 
                               aria-label="Search discussions">
                    </div>
                    <div class="flex gap-x-2">
                        <div class="dropdown">
                            <button  class="nav-link dropdown-toggle btn-sm btn btn-secondary btn-block p-1" 
                                     href="#" id="sortDropdown"
                                     type="button" role="button" data-toggle="dropdown" 
                                     aria-haspopup="true"
                                     aria-expanded="false">
                                <span>{{ currentSortName }}</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a v-for="option in sortOptions" :key="option.id"
                                   href="#" class="dropdown-item"
                                   @click.prevent="applySort(option.id)">
                                    {{ option.name }}
                                </a>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button  class="nav-link dropdown-toggle btn-sm btn btn-secondary btn-block p-1" 
                                     href="#" id="sortGroupDropdown"
                                     type="button" role="button" data-toggle="dropdown" 
                                     aria-haspopup="true"
                                     aria-expanded="false">
                                <span>{{ currentGroupSortName }}</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a v-for="option in sortGroupOptions" :key="option.id"
                                   href="#" class="dropdown-item"
                                   @click.prevent="applyGroupSort(option.id)">
                                    {{ option.name }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="card-body p-0" style="height: 500px; overflow-y: auto;">
                        <div v-for="discussion in discussions" :key="discussion.id" 
                             class="card mb-2 border border-primary hover:cursor-pointer">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-user-circle fa-2x me-3"></i>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ discussion.topic }}</h6>
                                    <small class="text-muted">Nyariki Felix</small>
                                    <p class="mb-0">{{ discussion.content }}</p>
                                    <small class="text-muted">{{ discussion.lastPost }}</small>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-secondary">
                                    <i class="far fa-star"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class=" flex items-center bg-success">
                    <h3 class="ml-2 card-title">Discussion</h3>
                    <div class="ml-auto flex self-end">
                        <a class="nav-link " href="#" id="navbarDropdown"
                           role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a v-for="option in discussionOptions" :key="option.id"
                               class="dropdown-item" href="#" 
                               @click.prevent="handleDiscussionOption(option.id)">
                                <i :class="option.icon"></i> {{ option.name }}
                            </a>
                        </div>
                        <button class="btn btn-sm  text-white mr-2" @click.prevent="openMemberModal()">
                            <i class="fas fa-users "></i>
                        </button>
                    </div>
                </div>
                <div class="card-header">
                    <h5>Topic testing</h5>
                    <span class="badge bg-secondary">Board</span>
                </div>
                <div class="card-body">
                    <div class="flex-1 mb-8">
                        <div class="bg-gray-200 text-gray-700 rounded-lg px-4 pt-1 pb-1">
                            <div class="text-xs font-medium subpixel-antialiased mb-2 text-gray-900">
                                <a href="#" class="text-gray-800" data-bs-original-title="" title="">
                                    Nyariki Felix
                                </a>
                                created this discussion on June 29, 2024
                            </div>
                            <div><p>&nbsp;testing &nbsp;testing &nbsp;testing&nbsp;&nbsp;</p></div>
                        </div>
                    </div>
                    <div class="direct-chat-messages">
                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-left">Alexander Pierce</span>
                                <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                            </div>
                            <!-- <img class="direct-chat-img" src="../dist/img/user1-128x128.jpg" alt="Message User Image" /> -->
                            <i class="fas fa-user-circle fa-2x me-3"></i>
                            <div class="direct-chat-text">
                                Is this template really for free? That's unbelievable!
                            </div>
                        </div>
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-right">Sarah Bullock</span>
                                <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                            </div>
                            <!-- <img class="direct-chat-img" src="../dist/img/user3-128x128.jpg" alt="Message User Image" /> -->
                            <i class="fas fa-user-circle fa-2x me-3"></i>
                            <div class="direct-chat-text">
                                You better believe it!
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Leave a comment">
                        <button class="btn btn-primary" type="button">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script setup lang="ts">
import {computed, onMounted, ref} from 'vue';


const currentSort = ref('latest');
const currentGroupName = ref('board');


// Sort options
const sortGroupOptions = [
    {id: 'all-groups', name: 'All Groups'},
    {id: 'board', name: 'Board'},
];

// Sort options
const sortOptions = [
    {id: 'latest', name: 'Latest'},
    {id: 'starred', name: 'Starred'},
    {id: 'unread', name: 'Unread'},
    {id: 'mentions', name: 'Mentions'},
    {id: 'archived', name: 'Archived'},
];
// Discussion options
const discussionOptions = [
    {id: 'leave', name: 'Leave Discussion', icon: 'fas fa-sign-out-alt'},
    // {id: 'copy', name: 'Copy Link', icon: 'fas fa-copy'},
    {id: 'unread', name: 'Mark as Unread', icon: 'fas fa-envelope-open-text'},
    {id: 'print', name: 'Print', icon: 'fas fa-print'},
    {id: 'edit', name: 'Edit Description', icon: 'fas fa-edit'},
    {id: 'close', name: 'Close Discussion', icon: 'fas fa-times'},
    // {id: 'archive', name: 'Archive Discussion', icon: 'fas fa-archive'},
    {id: 'delete', name: 'Delete Discussion', icon: 'far fa-trash-alt text-danger'},
];
// Sample discussions data
const discussions = ref([
    {id: 1, topic: 'Vue 3 Composition API', content: 'testing testing testing', lastPost: '7:57am'},
    {id: 2, topic: 'TypeScript in Vue', content: 'testing testing testing', lastPost: '7:57am'},
    {id: 2, topic: 'TypeScript in Vue', content: 'testing testing testing', lastPost: '7:57am'},
    {id: 2, topic: 'TypeScript in Vue', content: 'testing testing testing', lastPost: '7:57am'},
    {id: 2, topic: 'TypeScript in Vue', content: 'testing testing testing', lastPost: '7:57am'},
    {id: 2, topic: 'TypeScript in Vue', content: 'testing testing testing', lastPost: '7:57am'},
]);
// filtering sort
function applySort(option: string) {
    currentSort.value = option;
    // Implement sorting logic here
}
// Computed property to return the name of the current sort
const currentSortName = computed(() => {
    const option = sortOptions.find(option => option.id === currentSort.value);
    return option ? option.name : 'Latest';  // Default to 'Unknown' if not found

});

// filtering sort
function applyGroupSort(option: string) {
    currentGroupName.value = option;
    // Implement sorting logic here
}
// Computed property to return the name of the current sort
const currentGroupSortName = computed(() => {
    const option = sortOptions.find(option => option.id === currentSort.value);
    return option ? option.name : 'Board';  // Default to 'Unknown' if not found

});

// Handle discussion options
function handleDiscussionOption(optionId: string) {
    // Implement the functionality for each discussion option
    console.log('optionId', optionId);
}

onMounted(() => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Discussions'}));
});
</script>
  
  <style scoped>
  .card-header .card-title {
    color: white;
  }
  .input-group .form-control.rounded-end {
    border-radius: 0 0.375rem 0.375rem 0;
  }

  </style>
  
import Polls from "../../poll/Polls.vue";

<script setup lang="ts">

</script>

<style scoped>
</style>
<template>
    <div class="row">
        <div class="col-md-6">
            <div>
                <div class="card h-full">
                    <div class="card-header flex items-center">
                        <div class="flex items-center flex-1 w-full">
                            <!---->
                            <h2 class="card-header-title h3">
                                Tasks
                            </h2>
                        </div>
                        <!---->
                        <div class="flex items-center space-x-2">
                            <button class="btn btn-secondary btn-sm btn-icon">

                                <span class="sr-only">Add task</span>
                            </button>
                            <!----> <!---->
                        </div>
                    </div>
                    <!---->
                    <div class="px-6" style="">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="flex items-center -mt-3">
                                    <h3 class="flex-1 truncate mb-0"><a href="#">ewegwegwg</a></h3>
                                    <p class="text-sm ml-2 mb-0">
                                        <!----> <span>Apr 10</span>
                                    </p>
                                    <div class="ml-2">
                                        <button aria-label="task incomplete" class="btn">
                                            hhh
                                        </button>
                                    </div>
                                    <!---->
                                </div>
                                <div class="flex space-x-4 text-muted text-sm">
                                    <p><span>Nyariki Felix</span></p>
                                    <p>
                                        <a href="">
                                            <svg ariaHidden="true" class="fill-current mr-1 fa-icon">
                                                <!-- <use xlink:href="/v4/icons/fa-sprite.svg#list"></use> -->
                                            </svg>
                                            <span>Test Board Meeting</span>
                                        </a>
                                        <!---->
                                    </p>
                                    <!---->
                                </div>
                                <!---->
                            </div>
                        </div>
                        <!----> <!---->
                    </div>
                    <!---->
                </div>
                <div class="v-portal" style="display: none;"></div>
                <div class="v-portal" style="display: none;"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-widget">
                <div class="card-header">
                    <div class="user-block">
                        <div class="username">Polls</div>
                    </div>
                    <!-- /.user-block -->
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" title="Mark as read">
                            Published
                        </button>
                        <button type="button" class="btn btn-tool" >
                            UnPublished
                        </button>
                        <button type="button" class="btn btn-tool">
                            Past
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- post text -->
                    <p>Far far away, behind the word mountains, far from the
                        countries Vokalia and Consonantia, there live the blind
                        texts. Separated they live in Bookmarksgrove right at</p>

                </div>
            </div>
        </div>
    </div>
</template>


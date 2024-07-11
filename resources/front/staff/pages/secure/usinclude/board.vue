


<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useGetBoardsRequest, useGetLatestBoardsRequest} from '@/common/api/requests/modules/board/useBoardRequest';
import useAuthStore from '@/common/stores/auth.store';
import { useGetCommitteesRequest, useGetLatestCommitteesRequest } from '@/common/api/requests/modules/committee/useCommitteeRequest';

const authStore = useAuthStore();
const getBoards = () => {
    return useQuery({
        queryKey: ['getLatestBoardsKey'],
        queryFn: async () => {
            const response = await useGetLatestBoardsRequest({paginate: 'false'});
            return response.data;
        },
    });
};
const {isLoading, data: Boards, refetch: fetchBoards} = getBoards();
const getCommittees = () => {
    return useQuery({
        queryKey: ['getLatestCommitteesKey'],
        queryFn: async () => {
            const response = await useGetLatestCommitteesRequest({paginate: 'false'});
            return response.data;
        },
    });
};
const {isLoading:committeeloading, data: Committees, refetch: fetchCommittees} = getCommittees();
</script>
<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h1 class="h2 mb-2">Boards & Committees</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Boards Table -->
                        <div class="col-md-6 col-12">
                            <h2 class="h4 mb-2">Boards</h2>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Board Name</th>
                                        <th scope="col">Owner</th>
                                        <th scope="col">Members Count</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="board in Boards" :key="board.id">
                                        <td>
                                            <h3 class="mb-2">
                                                <router-link :to="{ 
                                                    name: 'BoardDetails', 
                                                    params: { boardId: board.id } 
                                                }" class="text-primary">
                                                    {{ board.name }}
                                                </router-link>
                                            </h3>
                                        </td>
                                        <td>
                                            <span>{{ board.owner }}</span>
                                        </td>
                                        <td>
                                            <span>{{ board.members.length }}</span>
                                        </td>
                                        <td>
                                            <router-link v-if="authStore.hasPermission(['view board'])" 
                                                         :to="{ 
                                                             name: 'BoardDetails', 
                                                             params: { 
                                                                 boardId: board.id 
                                                             } 
                                                         }" 
                                                         class="text-green-500 hover:text-green-700 transition 
                                            duration-150 ease-in-out">
                                                <i class="fa fa-eye"></i>
                                            </router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Committees Table -->
                        <div class="col-md-6 col-12">
                            <h2 class="h4 mb-2">Committees</h2>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Committee Name</th>
                                        <th scope="col">Board Name</th>
                                        <th scope="col">Members Count</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="committee in Committees" :key="committee.id">
                                        <td>
                                            <h3 class="mb-2">
                                                <router-link :to="{ 
                                                    name: 'CommitteeDetails', 
                                                    params: { 
                                                        committeeId: committee.id 
                                                    } 
                                                }" class="text-primary">
                                                    {{ committee.name }}
                                                </router-link>
                                            </h3>
                                        </td>
                                        <td>
                                            <h3 class="mb-1">
                                                <router-link :to="{ 
                                                    name: 'BoardDetails', 
                                                    params: { 
                                                        boardId: committee.committeeable.details.id 
                                                    } 
                                                }" class="text-small">
                                                    {{ committee.committeeable.details.name }}
                                                </router-link>
                                            </h3>
                                        </td>
                                        <td>
                                            <span>{{ committee.members.length }}</span>
                                        </td>
                                        <td>
                                            <router-link v-if="authStore.hasPermission(['view committee'])" 
                                                         :to="{ 
                                                             name: 'CommitteeDetails', 
                                                             params: { 
                                                                 committeeId: committee.id 
                                                             } 
                                                         }" class="text-green-500 hover:text-green-700 
                                                    transition duration-150 ease-in-out">
                                                <i class="fa fa-eye"></i>
                                            </router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


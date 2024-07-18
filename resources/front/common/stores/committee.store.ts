import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import useClient from '@/common/api/client';
import { committeesRoute } from '@/common/api/committees_routes';
import { LOCAL_COMMITTEES } from '@/common/constants/localStorageKeys';
import { Committee, committeeParser, committeesResponse } from '@/common/parsers/committeeParser';

export const useCommitteesStore = defineStore('committees', () => {
    const committees = ref<Committee[]>([]);
    const latestCommittees = ref<Committee[]>([]);

    const initializeCommittees = () => {
        const storedCommittees = localStorage.getItem(LOCAL_COMMITTEES);
        if (storedCommittees) {
            committees.value = JSON.parse(storedCommittees) as Committee[];
        }
    };

    const setCommittees = (newCommittees: Committee[]) => {
        committees.value = newCommittees;
        localStorage.setItem(LOCAL_COMMITTEES, JSON.stringify(newCommittees));
    };

    const setLatestCommittees = (newCommittees: Committee[]) => {
        latestCommittees.value = newCommittees;
    };

    const fetchAndSetCommittees = async (): Promise<committeesResponse> => {
        const client = useClient();
        try {
            const response: committeesResponse = await client.get(committeesRoute()).json();
            const result = committeeParser.safeParse(response.data);

            if (result.success) {
                const fetchedCommittees = result.data;
                setCommittees(fetchedCommittees);
                return response;
            } else {
                console.error('Validation error:', result.error);
                throw new Error('Failed to validate committees from the backend.');
            }
        } catch (error) {
            console.error('Error fetching committees:', error);
            throw new Error('Error during fetching and setting committees.');
        }
    };

    const loadAndSaveCommittees = async () => {
        const storedCommittees = localStorage.getItem(LOCAL_COMMITTEES);
        if (storedCommittees) {
            committees.value = JSON.parse(storedCommittees) as Committee[];
        } else {
            try {
                const response = await fetchAndSetCommittees();
                committees.value = response.data;
            } catch (error) {
                console.error('Failed to fetch committees:', error);
                committees.value = [];
            }
        }
    };

    const filterCommittees = (predicate: (committee: Committee) => boolean): Committee[] => {
        return committees.value.filter(predicate);
    };

    const resetCommittees = () => {
        committees.value = [];
        localStorage.removeItem(LOCAL_COMMITTEES);
    };

    const getCommittees = () => {
        return committees.value;
    };

    const getLatestCommittees = computed(() => {
        return latestCommittees.value;
    });

    // Initialize committees on store creation
    initializeCommittees();

    return {
        setCommittees,
        setLatestCommittees,
        getCommittees,
        getLatestCommittees,
        fetchAndSetCommittees,
        resetCommittees,
        loadAndSaveCommittees,
        filterCommittees,
    };
});

export default useCommitteesStore;

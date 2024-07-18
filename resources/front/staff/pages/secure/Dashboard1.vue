


<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {onMounted} from 'vue';
import {useGetBoardsRequest} from '@/common/api/requests/modules/board/useBoardRequest';
import  Board from './usinclude/board.vue';

onMounted(async () => {
    window.dispatchEvent(new CustomEvent('updateTitle', {detail: 'Dashboard'}));
});
</script>
<template>
    <div class="row">
        <div class="col-12">
            <Board/>
        </div>
    </div>
</template>
  
  
  <style scoped>
  .info-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border: 1px solid #e3e6f0;
    border-radius: .35rem;
    box-shadow: 0 0 1rem rgba(0, 0, 0, .15);
  }
  .info-box img {
    border-radius: 50%;
  }
  .info-box h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
  }
  .info-box p {
    margin: 0;
    font-size: 1rem;
  }
  </style>
  

<template>
    <section class="mt-8 bg-gray-200 flex lg:flex-row flex-col items-center justify-center">
        <div class="flex flex-col justify-center items-center lg:px-12 lg:w-1/3">
            <img src="@assets/images/logo.svg" class="lg:w-28 md:w-32 w-32" alt="">
            <div class="flex">
                <div class="mb-6 text-left lg:order-1 order-3">
                    <p class="text-sm">&copy; {{ new Date().getFullYear() }} ERev<sup>&reg;</sup> . All rights reserved
                    </p>
                </div>
            </div>
        </div>
        <div class="flex lg:flex-row flex-col lg:gap-12 items-center gap-6 my-6 lg:w-2/3 justify-center lg:mr-12">
            <a target="_blank" href="/privacy"
               class="border-b border-blue-200  text-xs text-blue-600">Privacy
                Policy</a>
            <a target="_blank" href="/terms"
               class="border-b border-blue-200 text-xs text-blue-600">Terms of
                Service</a>
            <a target="_blank" href="https://moffhubsolutions.com"
               class="text-xs border-b border-blue-200 text-blue-600">
                A product of Moffhub Solutions <sup>&reg;</sup></a>
        </div>
    </section>
</template>

<script lang='ts' setup>


</script>

<style scoped>

</style>

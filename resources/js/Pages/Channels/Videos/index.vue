<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ channel.name }}
            </h2>
            <div class="flex justify-end">
                <form @submit.prevent="submit">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Sync Videos
                    </button>
                </form>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="text-center p-6 border-gray-200">
                        <ul>
                            <li v-for="video in channel.video" :key="video.id" class="font-bold">{{ video.name }}</li>
                        </ul>
                    </div>
                    <p class="text-center text-gray-500 text-xs">
                        &copy;2021 Ahmed Helal Ahmed. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import {Inertia} from '@inertiajs/inertia'

export default defineComponent({
    setup() {
        function submit() {
            if (confirm('Sync videos! Are you sure?')) {
                Inertia.post('/sync-videos');
            }
        }

        return {submit}
    },
    props: {
        channel: Object,
    },
    components: {
        AppLayout,
    },
})
</script>

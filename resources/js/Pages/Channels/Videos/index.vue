<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ channel.name }} ({{ videos.total }})
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

                        <div
                            v-for="video in videos.data"
                            :key="video.id"
                            class="bg-gray-100 p-2">
                            <div class="space-y-10">

                                <div
                                    class="flex items-center p-6 space-x-6 bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-500  justify-content-start">
                                    <div class="flex bg-gray-100 p-4 w-72 space-x-4 rounded-lg">
                                        <a :href="video.link"
                                           target="_blank">
                                            <img :src="video.thumbnail" alt="video thumbnail">
                                            <p class="text-center text-gray-500 text-xs mt-1">
                                                {{ video.published_at }}</p>

                                        </a>
                                    </div>

                                    <section class="items-center justify-center px-4 bg-white">
                                        <div class="max-w-xl w-full rounded-lg shadow-lg p-4 flex md:flex-row flex-col">
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-lg tracking-wide">
                                                    <a :href="video.link" target="_blank">{{ video.title }}</a>
                                                </h3>
                                                <p class="text-gray-500 my-1" v-if="!video.show_more">
                                                    {{ video.description.substring(0, 100) }}
                                                </p>
                                                <p class="text-gray-500 my-1" v-if="video.show_more">
                                                    {{ video.description }}
                                                </p>
                                                <button class="text-center text-gray-500 text-xs"
                                                        @click="video.show_more=!video.show_more">Show
                                                    {{ video.show_more ? 'less' : 'more' }}
                                                </button>

                                            </div>
                                        </div>
                                    </section>
                                    <section class="items-center justify-center px-4 ">
                                        <div class="max-w-xl w-full rounded-lg  p-4 flex md:flex-row flex-col">
                                            <div class="flex-1">

                                                <div class="md:px-2 mt-3 md:mt-0 items-center flex">
                                                    <button
                                                        :class="{'cursor-not-allowed': video.seen_at}"
                                                        class="bg-blue-500 text-white font-bold px-4 py-2 text-sm uppercase rounded tracking-wider focus:outline-none hover:bg-blue-600">
                                                        <svg class="h-8 w-8 text-white" viewBox="0 0 24 24" fill="none"
                                                             stroke="currentColor" stroke-width="2"
                                                             stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                                            <polyline points="22 4 12 14.01 9 11.01"/>
                                                        </svg>
                                                    </button>

                                                    <button
                                                        :class="{'cursor-not-allowed': video.favorite_at}"
                                                        class="inline-block ml-1 bg-indigo-500 px-4 py-2 text-white font-semibold rounded-lg hover:shadow-lg transition duration-3000 cursor-pointer hover:bg-indigo-600">

                                                        <svg class="h-8 w-8 text-white" viewBox="0 0 24 24" fill="none"
                                                             stroke="currentColor" stroke-width="2"
                                                             stroke-linecap="round" stroke-linejoin="round">
                                                            <polygon
                                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                </div>

                            </div>
                        </div>
                    </div>
                    <pagination class="mt-6 mb-6 p-2" :links="videos.links"/>


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
import Pagination from '@/Components/Pagination'
import Button from "../../../Jetstream/Button";

export default defineComponent({
    setup() {
        function submit() {
            if (confirm('Sync videos! Are you sure?')) {
                Inertia.post(route('channels.show.sync-videos', this.channel.id));
            }
        }

        return {submit}
    },
    props: {
        channel: Object,
        videos: Object,
    },
    components: {
        Button,
        AppLayout,
        Pagination
    },
})
</script>

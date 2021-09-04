<template>
    <app-layout title="Videos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ channel.name }} ({{ videos.total }})
            </h2>

            <div class="flex justify-between mt-2">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    @click="show_filters=!show_filters">{{ show_filters ? 'Hide' : 'Show' }} Filters
                </button>

                <form @submit.prevent="submit">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Sync Videos
                    </button>
                </form>

            </div>
            <div v-if="show_filters">
                <form @submit.prevent="filter">
                    <div class="pt-2 relative mx-auto text-gray-600">
                        <input
                            class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                            type="search" name="title" placeholder="Search by title" v-model="form.title">
                    </div>
                    <div class="mt-4">
                        <span class="text-gray-700">Is favourite?</span>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" class="form-radio" name="is_favorite" v-model="form.is_favorite"
                                       value="yes">
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="inline-flex items-center ml-6">
                                <input type="radio" class="form-radio" name="is_favorite" v-model="form.is_favorite"
                                       value="no">
                                <span class="ml-2">No</span>
                            </label>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-gray-700">Is seen?</span>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" class="form-radio" name="is_seen" v-model="form.is_seen"
                                       value="yes">
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="inline-flex items-center ml-6">
                                <input type="radio" class="form-radio" name="is_seen" v-model="form.is_seen" value="no">
                                <span class="ml-2">No</span>
                            </label>
                        </div>
                    </div>
                    <button
                        class="bg-purple-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="submit">
                        Filter
                    </button>
                    <button
                        class="bg-red-500 text-white active:bg-red-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="reset" @click="resetForm">
                        Reset
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
                                                        @click="markVideoAsSeen(video.id)"
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
                                                        @click="addVideoToFavourites(video.id)"
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



                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent, reactive} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import {Inertia} from '@inertiajs/inertia';
import Pagination from '@/Components/Pagination';
import Button from "../../../Jetstream/Button";

export default defineComponent({
    setup() {
        const params = route().params;

        const form = reactive({
            is_seen: params.is_seen ? params.is_seen : null,
            is_favorite: params.is_favorite ? params.is_favorite : null,
            title: params.title ? params.title : null,
            page: 1
        });

        function filter() {
            console.log(form);
            // form.page=this.videos.current_page;
            Inertia.get(route('channels.show', this.channel.id), form);
        }

        function submit() {
            if (confirm('Sync videos! Are you sure?')) {
                Inertia.post(route('channels.show.sync-videos', this.channel.id));
            }
        }

        function resetForm() {
            form.is_seen = null;
            form.is_favorite = null;
            form.title = null;
            console.log(form);
        }

        return {submit, filter, form, params, resetForm};
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
    data() {
        return {
            show_filters: false
        }
    },
    methods: {
        markVideoAsSeen(videoId) {
            Inertia.post(route('videos.toggle-seen', videoId));

        },
        addVideoToFavourites(videoId) {
            Inertia.post(route('videos.toggle-favourite', videoId));
        }
    },
    mounted() {
        let parameterValidCount = 0;
        for (let parameterName in this.params) {
            if (this.params[parameterName] && parameterName != 'channel') {
                console.log(this.params[parameterName]);
                ++parameterValidCount;
            }
        }
        if (parameterValidCount > 1) {
            this.show_filters = true;
        }
    }
})
</script>

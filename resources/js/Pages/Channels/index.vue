<template>
    <app-layout title="Channels">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Channels
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="w-full ">
                        <h1 class="text-center mt-10 text-4xl font-bold">Add channel</h1>

                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                    Name <code class="text-red-600">*</code>
                                </label>
                                <input v-model="form.name"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       id="name" type="text" name="name" placeholder="Channel name">
                                <div v-if="errors.name" class="text-red-600">{{ errors.name }}</div>

                            </div>
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="link">
                                    Link <code class="text-red-600">*</code>
                                </label>
                                <input v-model="form.link"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                       id="link" type="url" name="link" placeholder="Channel link">
                                <div v-if="errors.link" class="text-red-600">{{ errors.link }}</div>
                                <div v-if="errors.remote_identifier" class="text-red-600">{{ errors.remote_identifier }}</div>

                            </div>
                            <div class="flex items-center justify-between">
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                    type="submit">
                                    Save
                                </button>
                            </div>
                        </form>

                    </div>
                    <section class="text-center">
                        <h1 class="text-center mt-10 text-4xl font-bold">Channels</h1>
                        <div v-for="channel in channels.data" :key="channel.id" class="font-bold p-6 border-gray-200">
                            <a :href="route('channels.show',channel.id)">
                                <div
                                    class=" text-center items-center p-6 space-x-6 bg-gray-50 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-500">
                                    {{ channel.name }}
                                    -
                                    {{ channel.videos_count }} videos
                                </div>
                            </a>

                        </div>
                        <pagination class="mt-6 mb-6 p-2" :links="channels.links"/>
                    </section>
                    <p class="text-center text-gray-500 text-xs">
                        &copy;2021 Ahmed Helal Ahmed. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent, reactive} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import {Inertia} from '@inertiajs/inertia'
import Pagination from '@/Components/Pagination';

export default defineComponent({
    setup() {
        const form = reactive({
            name: null,
            link: null,
        })

        function submit() {
            Inertia.post('/channels', form)
        }

        return {form, submit}
    },
    props: {
        channels: Object,
        errors: Object,
    },
    components: {
        AppLayout,
        Pagination
    },
})
</script>

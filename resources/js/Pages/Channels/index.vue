<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="w-full ">
                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                    Name
                                </label>
                                <input v-model="form.name"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       id="name" type="text" placeholder="Username">
                            </div>
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="remote_identifier">
                                    Remote identifier
                                </label>
                                <input v-model="form.remote_identifier"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                       id="remote_identifier" type="text" placeholder="Remote identifier">
                            </div>
                            <div class="flex items-center justify-between">
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                    type="submit">
                                    Submit
                                </button>
                            </div>
                        </form>

                    </div>

                    <div class="text-center p-6 border-gray-200">
                        <ul>
                            <li v-for="channel in channels" :key="channel.id" class="font-bold">
                                <a :href="route('channels.show',channel.id)">{{ channel.name }}</a>
                            </li>
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
import {defineComponent, reactive} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import {Inertia} from '@inertiajs/inertia'

export default defineComponent({
    setup() {
        const form = reactive({
            name: null,
            remote_identifier: null,
        })

        function submit() {
            Inertia.post('/channels', form)
        }

        return {form, submit}
    },
    props: {
        channels: Array,
    },
    components: {
        AppLayout,
    },
})
</script>

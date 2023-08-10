<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
// import Pagination from '@/Components/Pagination.vue';
import { useForm } from "@inertiajs/vue3";

defineProps({
    groups: Object,
});

const form = useForm({
    search_data: '',
});


const submit = () => {
    form.post(route("groups.search"));
};

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route('groups.destroy', id));
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div>
                            <div class="flow-root ">
                                <p class="float-left text-blue-600">
                                    <b>Group List</b>
                                    <br>
                                    <br>
                                    <Link href="/groups/create" method="get" as="button" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        Create Group
                                    </Link>
                                </p>
                        
                                <p class="float-right text-green-800">
                                    
                                    <!-- GRID search -->
                                        <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                                                <div>
                                                
                                                </div>
                                                <div>
                                                    <form @submit.prevent="submit" style="padding-top: 50px;">
                                                    <!-- GRID search -->
                                                        <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <input type="text" id="search_data" v-model="form.search_data" name="search_data" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Group name" required>
                                                            </div>
                                                            <div>
                                                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                                                            </div>
                                                        </div>
                                                    </form>  
                                                </div>
                                        </div>
                                     
                                </p>
                            </div>

                            
                            


                        </div>
                        <div class="pt-5">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Group Name

                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Group Type
                                            </th>
                                            
                                            <th scope="col" class="px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="group in groups.data" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Name: {{ group.name }}
                                                
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ group.type }}
                                            </td>
                                            


                                            <td class="px-6 py-4">
                                                <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                                                    <div>
                                                         <Link :href="route('groups.edit',group.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" >Edit</Link>
                                                    </div>
                                                    <div>
                                                        <button @click="destroy(group.id)" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="m-2 p-2">
                                  
                                    <div class="flex">
                                        <template v-for="group in groups.links" :key="groups.id" :href="group.url">
                                            <div v-if="group.url == null" v-html="group.label"
                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                            ></div>
                                            <Link v-else :href="group.url" v-html="group.label"
                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                            ></Link>
                                        </template>
                                    </div>
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


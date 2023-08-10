<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
// import Pagination from '@/Components/Pagination.vue';
import { useForm } from "@inertiajs/vue3";


defineProps({
    items: Object,
});

const form = useForm({
    search_data: '',
});


const submit = () => {
    form.post(route("items.search"));
};


function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route('items.destroy', id));
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
                                <p class="float-left text-green-600">
                                    <Link href="/items/create" method="get" as="button" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        Add Item
                                    </Link>
                                </p>
                        
                                <p class="float-right text-green-800">
                                    <form @submit.prevent="submit">
                                    <!-- GRID search -->
                                        <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                                            
                                                <div>
                                                    <input type="text" id="search_data" v-model="form.search_data" name="search_data" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" required>

                                                </div>
                                                <div>
                                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>

                                                </div>
                                        </div>
                                    </form>    
                                </p>
                            </div>

                            
                            


                        </div>
                        <div class="pt-5">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Item

                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Opening Stock
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Price
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Date
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Units
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in items.data" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Name: {{ item.name }}
                                                <br><small>Group: {{ item.group }}</small>
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ item.stock_opening }}
                                            </td>
                                            <td class="px-6 py-4">
                                                Purchase: {{ item.purchase_price }}
                                                <br>Selling: {{ item.selling_price }}
                                            </td>
                                            <td class="px-6 py-4">
                                                MFG: {{ item.manufacture_date }}
                                                <br>Expiry: {{ item.expiry_date }}
                                            </td>

                                            <td class="px-6 py-4">
                                                Main: {{ item.units_main }}
                                                <br>Secondary: {{ item.units_secondary }}
                                                <br>Relation: {{ item.units_relation }}
                                            </td>


                                            <td class="px-6 py-4">
                                                <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                                                    <div>
                                                         <Link :href="route('items.edit',item.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" >Edit</Link>
                                                    </div>
                                                    <div>
                                                        <button @click="destroy(item.id)" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="m-2 p-2">
                                    <!-- <Link v-for="item in items.links" :key="item.id" :href="item.url">{{ item.label }}</Link> -->
                                    <div class="flex">
                                        <template v-for="item in items.links" :key="items.id" :href="item.url">
                                            <div v-if="item.url == null" v-html="item.label"
                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                            ></div>
                                            <Link v-else :href="item.url" v-html="item.label"
                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                            ></Link>
                                        </template>
                                    </div>
                                     <!-- <Pagination :links="items.links" /> -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


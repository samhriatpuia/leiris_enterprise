<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    items: Array,
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="pt-5">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <!-- <table class="w-full text-sm text-left text-red-500 dark:text-red-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Items Expiring Soon

                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                               
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                               
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                               
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                
                                            </th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in items.data" class="bg-white border-b dark:bg-red-500 dark:border-red-500">
                                            <th scope="row" class="px-6 py-4 font-medium text-red-500 whitespace-nowrap dark:text-white">
                                                Name: {{ item.name }}
                                                <br><small>Group: {{ item.group }}</small>
                                            </th>
                                            <td class="px-6 py-4">
                                                Stock: {{ item.stock_opening }}
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


                                            
                                        </tr>
                                    </tbody>
                                </table> -->
                                <!-- <div class="m-2 p-2">
                                  
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
                                   
                                </div> -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

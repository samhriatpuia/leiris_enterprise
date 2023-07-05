<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
// import Pagination from '@/Components/Pagination.vue';
import { useForm } from "@inertiajs/vue3";

defineProps({
    customers: Object,
});

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
                                    <b>Customer List</b>
                                </p>
                        
                                <p class="float-right text-green-800">
                                    
                                    <!-- GRID search -->
                                        <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                                                <div>
                                                
                                                </div>
                                                <div>
                                                    <Link href="/customers/create" method="get" as="button" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                                        Create New Customer
                                                    </Link>
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
                                                 Name and Details

                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                 GST and contact
                                            </th>

                                            <th scope="col" class="px-6 py-3">
                                                Bank Details
                                            </th>

                                            
                                            <th scope="col" class="px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="customer in customers.data" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Name: {{ customer.name }}
                                                <br><small>Address: {{ customer.address }}</small>
                                                
                                                
                                            </th>
                                            <td class="px-6 py-4">
                                                GST No.: {{ customer.gst }}
                                                <br><small>Contact: {{ customer.phone }}</small>
                                            </td>
                                            
                                            <td class="px-6 py-4">
                                                Bank Acc : {{ customer.bank_account }}
                                                <br><small>IFSC Code: {{ customer.bank_ifsc }}</small>
                                                <br><small>Bank name: {{ customer.bank_name }}</small>
                                                <br><small>Bank Branch: {{ customer.bank_branch }}</small>
                                            </td>


                                            <td class="px-6 py-4">
                                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="m-2 p-2">
                                  
                                    <div class="flex">
                                        <template v-for="customer in customers.links" :key="customers.id" :href="customer.url">
                                            <div v-if="customer.url == null" v-html="customer.label"
                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                            ></div>
                                            <Link v-else :href="customer.url" v-html="customer.label"
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


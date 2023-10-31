<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
// import Pagination from '@/Components/Pagination.vue';
import { useForm } from "@inertiajs/vue3";

defineProps({
    sales: Object,
});
const form = useForm({
    search_data: '',
    date: '',
});


const submit = () => {
    form.post(route("sales.search"));
};
</script>

<template>
    <Head title="Sales" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div>
                            <div class="flow-root ">
                                <p class="float-left text-blue-600">
                                    <b>Sales List</b> <br> <br>
                                    <Link href="/sales/create" method="get" as="button" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        Create New Sales/Invoice
                                    </Link>
                                </p>
                        
                                <p class="float-right text-green-800">
                                    
                                    <!-- GRID search -->
                                        <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                                                <div>
                                                
                                                </div>
                                                <div>
                                                    <form @submit.prevent="submit" >
                                                    <!-- GRID search -->
                                                        <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                                                            <div>
                                                                <input type="date" v-model="form.date" name="date" id="date" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                                            </div>
                                                            <div>
                                                                <input type="text" id="search_data" v-model="form.search_data" name="search_data" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search customer name">
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
                                        <tr v-for="sale in sales.data" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Customer Name: {{ sale.customer_name }} <br>
                                                Invoice: {{ sale.invoice_number }}
                                                <br><small>Date: {{ sale.date }}</small>
                                                
                                                
                                            </th>
                                            <td class="px-6 py-4">
                                                Logistic Charge: {{ sale.logistic_charge }}
                                                <br><small>Handling Charge: {{ sale.handling_charge }}</small>
                                            </td>
                                            
                                            <td class="px-6 py-4">
                                                Discount : {{ sale.discount }}
                                                <br><small>Scheme: {{ sale.scheme }}</small>
                                                
                                            </td>


                                            <td class="px-6 py-4">
                                                <Link :href="route('sales.invoice.edit',sale.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2">Edit</Link>
                                                <Link :href="route('sales.invoice.index',sale.id)" class="font-medium text-green-600 dark:text-blue-500 hover:underline">Invoice</Link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="m-2 p-2">
                                  
                                    <div class="flex">
                                        <template v-for="sale in sales.links" :key="sales.id" :href="sale.url">
                                            <div v-if="sale.url == null" v-html="sale.label"
                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                            ></div>
                                            <Link v-else :href="sale.url" v-html="sale.label"
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


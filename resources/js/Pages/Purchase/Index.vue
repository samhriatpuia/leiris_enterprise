<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
// import Pagination from '@/Components/Pagination.vue';
import { useForm } from "@inertiajs/vue3";

defineProps({
    purchases: Object,
});
const form = useForm({
    search_data: '',
});


const submit = () => {
    form.post(route("purchases.search"));
};



function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route('purchases.destroy', id));
    }
}
</script>

<template>
    <Head title="Purchase" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div>
                            <div class="flow-root ">
                                <p class="float-left text-green-600">
                                    <b>Purchase List</b> <br> <br>
                                    <Link href="/purchases/create" method="get" as="button" type="button" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        Create Purchase
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
                                                                <input type="text" id="search_data" v-model="form.search_data" name="search_data" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search By Invoice" required>
                                                            </div>
                                                            <div>
                                                                <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
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
                                        <tr v-for="purchase in purchases.data" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Vendor: {{ purchase.vendor }} <br>
                                                Invoice: {{ purchase.invoice_number }}
                                                <br><small>Date: {{ purchase.date }}</small>
                                                
                                                
                                            </th>
                                            <td class="px-6 py-4">
                                                Logistic Charge: {{ purchase.logistic_charge }}
                                                <br><small>Handling Charge: {{ purchase.handling_charge }}</small>
                                            </td>
                                            
                                            <td class="px-6 py-4">
                                                Discount : {{ purchase.discount }}
                                                <br><small>Scheme: {{ purchase.scheme }}</small>
                                                
                                            </td>


                                            <td class="px-6 py-4">
                                                <Link :href="route('purchases.edit',purchase.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2">Edit</Link>
                                                <Link :href="route('purchases.invoice.index',purchase.id)" class="font-medium text-green-600 dark:text-blue-500 hover:underline">Invoice</Link> <br> <br>
                                                <button @click="destroy(purchase.id)" class="px-2 font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="m-2 p-2">
                                  
                                    <div class="flex">
                                        <template v-for="purchase in purchases.links" :key="purchases.id" :href="purchase.url">
                                            <div v-if="purchase.url == null" v-html="purchase.label"
                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                            ></div>
                                            <Link v-else :href="purchase.url" v-html="purchase.label"
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


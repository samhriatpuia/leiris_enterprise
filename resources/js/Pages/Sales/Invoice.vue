<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { useForm } from "@inertiajs/vue3";


const props = defineProps({
    
    customer: {
        customer: Object,
    },
    sale: {
        sale: Object
    },
    details: {
        details: Object
    },
    items: {
        items: Object
    }
});

const form = useForm({
    particulars: '',
    // unit: '',
    quantity: '',
    // price: '',
    // amount: '',
    sales_id: props.sale.id,

});

const submit = () => {
    form.post(route("sales.invoice.store"),{
        preserveScroll: true,
        onSuccess: () => form.reset(), // reset form if everything went OK
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div>
                                <b>Customer Name:</b> {{ customer.name }}
                            </div>
                            <div>
                                <b>Address:</b> {{ customer.address }}
                            </div>
                            <div>
                                <b>Phone No.:</b> {{ customer.phone }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-8 mb-8">
                            <div>
                                <b>Invoice Number:</b> {{ sale.invoice_number }}
                            </div>
                            <div>
                                <b>Date:</b> {{ sale.date }}
                            </div>
                            <div>
                                <b>Sub-total:</b> {{ sale.sub_total }}
                            </div>
                        </div>

                       
                        <div class="mb-4">
                            <form @submit.prevent="submit" class="border border-gray-200 rounded-lg px-7">
                                <div class="mt-5">
                                    <div class="">
                                        <label for="quantity" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">ID(Do not Change)</label>
                                        <input type="hidden " v-model="form.sales_id" name="sales_id" disabled>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                                    
                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <select id="particulars" v-model="form.particulars" name="particulars" for='particulars' class="mt-7 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Choose Customer">
                                                <option value="" disabled selected hidden> Choose Item</option>
                                                <option v-for="(name, id) in items" :key="id" :value="id">{{ name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                                            <input type="text" v-model="form.quantity" id="quantity" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div>
                                    
                                </div>

                                

                                

                                <button type="submit" class="mb-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">save</button>
                            </form>
                        </div>

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Particulars

                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Unit
                                            </th>

                                            <th scope="col" class="px-6 py-3">
                                                Quantity
                                            </th>

                                            <th scope="col" class="px-6 py-3">
                                                Price
                                            </th>

                                            <th scope="col" class="px-6 py-3">
                                                Amount
                                            </th>
                                            
                                            <th scope="col" class="px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="detail in details.data" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ detail.particulars }}                                             
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ detail.unit }}
                                            </td>
                                            
                                            <td class="px-6 py-4">
                                                {{ detail.quantity }}                                               
                                            </td>

                                            <td class="px-6 py-4">
                                                {{ detail.price }}                                               
                                            </td>

                                            <td class="px-6 py-4">
                                                {{ detail.amount }}                                               
                                            </td>


                                            <td class="px-6 py-4">
                                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2">Edit</a>
                                                <Link :href="route('sales.invoice.index',detail.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Invoice</Link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="float-right" style="margin-right:315px">Sub-Total: {{ sale.sub_total }}</div>
                                <div class="m-2 p-2">
                                  
                                    <div class="flex">
                                        <template v-for="detail in details.links" :key="details.id" :href="detail.url">
                                            <div v-if="detail.url == null" v-html="detail.label"
                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                            ></div>
                                            <Link v-else :href="detail.url" v-html="detail.label"
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
    </AuthenticatedLayout>
</template>

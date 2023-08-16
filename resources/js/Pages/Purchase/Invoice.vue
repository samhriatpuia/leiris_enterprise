<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { useForm } from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    
    purchase: {
        purchase: Object,
    },
    purchaseDetails: {
        purchaseDetails: Object
    },
});

const form = useForm({
    particulars: '',
    unit: '',
    quantity: '',
    discount: '',
    amount: '',
    price:'',
    purchase_id: props.purchase.id,

});

const submit = () => {
    form.post(route("purchases.invoice.store"),{
        preserveScroll: true,
        onSuccess: () => form.reset(), // reset form if everything went OK
    });
};

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route('purchaseDetails.destroy', id));
        
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
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <!-- <div>
                                <b>Customer Name:</b> {{ customer.name }}
                            </div>
                            <div>
                                <b>Address:</b> {{ customer.address }}
                            </div>
                            <div>
                                <b>Phone No.:</b> {{ customer.phone }}
                            </div> -->
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-8 mb-8">
                            <div>
                                <b>Invoice Number:</b> {{ purchase.invoice_number }}
                            </div>
                            <div>
                                <b>Date:</b> {{ purchase.date }}
                            </div>
                            <div>
                                <b>Sub-total:</b> {{ purchase.sub_total }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-8 mb-8">
                            <div>
                                <b>Logistic Charge:</b> {{ purchase.logistic_charge }}
                            </div>
                            <div>
                                <b>Handling Charge</b> {{ purchase.handling_charge }}
                            </div>
                            <div>
                                <b>Discount</b> {{ purchase.discount }}
                            </div>
                        </div>

                       
                        <div class="mb-4">
                            <form @submit.prevent="submit" class="border border-gray-200 rounded-lg px-7">
                                <div class="mt-5">
                                    <div class="">
                                        <label for="purchase_id" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">ID(Do not Change)</label>
                                        <input type="hidden " v-model="form.purchase_id" name="purchase_id" disabled>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="particulars" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Particulars</label>
                                            <input type="text" v-model="form.particulars" id="particulars" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div>
                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                                            <input type="text" v-model="form.quantity" id="quantity" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="unit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit</label>
                                            <input type="text" v-model="form.unit" id="unit" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div>
                                </div>


                                <!--  -->
                                <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                                    <!-- <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="quantity" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                                            <input type="text" v-model="form.quantity" id="quantity" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div> -->
                                    <!-- <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amount</label>
                                            <input type="text" v-model="form.amount" id="amount" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div> -->

                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                                            <input type="text" v-model="form.price" id="price" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="discount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount</label>
                                            <input type="text" v-model="form.discount" id="discount" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div>
                                </div>

                            
                                <button type="submit" class="mb-3 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ADD</button>
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
                                                Discount
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
                                        <tr v-for="purchaseDetail in purchaseDetails.data" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ purchaseDetail.particulars }}                                             
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ purchaseDetail.unit }}
                                            </td>
                                            
                                            <td class="px-6 py-4">
                                                {{ purchaseDetail.quantity }}                                               
                                            </td>

                                            <td class="px-6 py-4">
                                                {{ purchaseDetail.price }}                                               
                                            </td>

                                            <td class="px-6 py-4">
                                                {{ purchaseDetail.discount }}                                               
                                            </td>

                                            <td class="px-6 py-4">
                                                {{ purchaseDetail.amount }}                                               
                                            </td>


                                            <td class="px-6 py-4">
                                                <!-- <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2">Edit</a> -->
                                                <button @click="destroy(purchaseDetail.id)" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</button>
                                                <!-- <Link :href="route('details.destroy',detail.id)" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</Link> -->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="float-right" style="margin-right:315px">Sub-Total: {{ purchase.sub_total }}</div> <br>
                                <div class="float-right" style="margin-right:315px">Grand-Total: {{ purchase.grand_total }}</div>
                                <div class="m-2 p-2">
                                  
                                    <div class="flex">
                                        <template v-for="purchaseDetail in purchaseDetails.links" :key="purchaseDetails.id" :href="purchaseDetail.url">
                                            <div v-if="purchaseDetail.url == null" v-html="purchaseDetail.label"
                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                            ></div>
                                            <Link v-else :href="purchaseDetail.url" v-html="purchaseDetail.label"
                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                            ></Link>
                                        </template>
                                    </div>
                                    
                                </div>


                                <!-- <div class="grid grid-cols-2 md:grid-cols-2 gap-4 p-5">
                                    <div>
                                        <Link :href="route('settlements.index',purchase.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Settlement Details</Link>
                                    </div>

                                    <div>
                                        <a :href="route('invoice_generate',purchase.id)" class="font-medium text-green-600 dark:text-blue-500 hover:underline" >
                                            <div><u>Download Invoice</u></div>
                                        </a>
                                    </div>

                                </div> -->
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

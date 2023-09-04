<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { useForm } from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';


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
    unit: '',
    quantity: '',
    discount: '',
    price: '',
    sales_id: props.sale.id,

});

const isModalOpen = ref(false);


const { visit, inertia } = usePage(); // Add 'inertia' here

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
  customer.value.name = '';
  customer.value.phone = '';
};


const salesForm = ref({
    id:props.sale.id,
    logistic_charge: props.sale.logistic_charge,
    handling_charge: props.sale.handling_charge,
    discount: props.sale.discount,
    
});

const submitSaleForm = async () => {
  try {
    const response = await router.post('/sales/invoice/calculate', salesForm.value);
    console.log('Response from server (Customer):', response);
  } catch (error) {
    console.error('Error while submitting customer form:', error);
  }
};


// *******
const invoiceForm = ref({
    particulars: '',
    unit: '',
    quantity: '',
    discount: '',
    price: '',
    sales_id: props.sale.id,
});

const submitInvoiceForm = async () => {
  try {
    const response = await router.post('/sales/invoice/store', invoiceForm.value);

    console.log('Response from server (Customer):', response);
    invoiceForm.value = {
        particulars: '',
        unit: '',
        quantity: '',
        discount: '',
        price: '',
        sales_id: props.sale.id,
        new_name: '',
        batch:'',
    };
  } catch (error) {
    console.error('Error while submitting customer form:', error);
  }
};
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route('details.destroy', id));
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
                            <div>
                                <b>Customer Name:</b> {{ customer.name }}
                            </div>
                            <!-- <div>
                                <b>Address:</b> {{ customer.address }}
                            </div> -->
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
                           
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-8 mb-8">
                           
                        </div>

                       
                        <div class="mb-4">
                            <form @submit.prevent="submitInvoiceForm" class="border border-gray-200 rounded-lg px-7">
                                <div class="mt-5">
                                    <div class="">
                                        <label for="quantity" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">ID(Do not Change)</label>
                                        <input type="hidden " v-model="invoiceForm.sales_id" name="sales_id" disabled>
                                    </div>
                                </div>
                                <div class="grid grid-cols-5 md:grid-cols-5 gap-4">
                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="unit" class="block text-sm font-medium text-gray-900 dark:text-white">Select Item</label>
                                            <select id="particulars" v-model="invoiceForm.particulars" name="particulars" for='particulars' class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Choose Customer">
                                                <option value="" disabled selected hidden> Choose Item</option>
                                                <option v-for="(name, id) in items" :key="id" :value="id">{{ name }}</option>
                                                <!-- <option @click="openModal" class="text-green-900"><b>New Item</b></option> -->
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="unit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit</label>
                                            <input type="text" v-model="invoiceForm.unit" id="unit" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                                            <input type="text" v-model="invoiceForm.price" id="unit" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div>


                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                                            <input type="text" v-model="invoiceForm.quantity" id="quantity" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="discount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount</label>
                                            <input type="text" v-model="invoiceForm.discount" id="discount" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div>
                                    
                                </div>
                            
                                <div class="grid grid-cols-4 md:grid-cols-3 gap-1">
                                    <div>
                                        <button type="submit" class="mb-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Add
                                        </button>
                                    </div>
                                    <div @click="openModal" class="mb-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        New Item
                                    </div>
                                </div>

                                
                                <portal to="modals">
                                    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
                                        <div class="modal-container bg-white w-1/2 p-6 rounded shadow-lg">
                                            <h2 class="text-lg font-semibold mb-4">Create New Item</h2>

                                                
                                            <div class="mb-6">
                                                <label for="new_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item Name</label>
                                                <input v-model="invoiceForm.new_name" type="text" id="new_name" name="new_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                                                <!-- <div v-if="errors.name">{{ errors.name }}</div> -->
                                            </div>
                                                                                        
                                            <div class="mb-6">
                                                <label for="batch" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Batch</label>
                                                <input v-model="invoiceForm.batch" type="text" id="batch" name="batch" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <!-- <div v-if="errors.phone">{{ errors.phone }}</div> -->
                                            </div>
                                                                                        

                                            <button @click="closeModal" class="mt-4 text-gray-500 hover:text-gray-700">Save</button>
                                        </div>
                                    </div>
                                </portal>

                               
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
                                                {{ detail.discount }}                                               
                                            </td>

                                            <td class="px-6 py-4">
                                                {{ detail.amount }}                                               
                                            </td>


                                            <td class="px-6 py-4">
                                                <!-- <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2">Edit</a> -->
                                                <button @click="destroy(detail.id)" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</button>
                                                <!-- <Link :href="route('details.destroy',detail.id)" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</Link> -->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                <form @submit.prevent="submitSaleForm">
                                    <div class="float-right" style="margin-right:370px">Sub-Total: {{ sale.sub_total }}</div> <br>
                                    
                                    <div class="mt-2 float-right " style="margin-right:315px">
                                        <div class="grid grid-cols-2 md:grid-cols-2 gap-1">
                                            <label for="logistic_charge" class="mt-2 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Logistic charge</label>
                                            <input type="text" v-model="salesForm.logistic_charge" id="logistic_charge" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" >
                                        </div>
                                    </div> <br>

                                    <div class="float-right" style="margin-right:315px">
                                        <div class="mt-2 grid grid-cols-2 md:grid-cols-2 gap-1">
                                            <label for="handling_charge" class="mt-2 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Handling charge</label>
                                            <input type="text" v-model="salesForm.handling_charge" id="handling_charge" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" >
                                        </div>    
                                    </div> <br>

                                    <div class="float-right" style="margin-right:315px">
                                        <div class="mt-2 grid grid-cols-2 md:grid-cols-2 gap-1">
                                            <label for="discount" class="mt-2 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount</label>
                                            <input type="text" v-model="salesForm.discount" id="discount" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" >
                                            <br>
                                            <div >Grand Total: {{ sale.grand_total }}</div>
                                            <br>
                                            <button type="submit" class="mt-3 mb-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Calculate</button>
                                        
                                        </div>    
                                    </div> <br>
                                  
                                    
                                </form>

                                <div class="grid grid-cols-2 md:grid-cols-2 gap-4 p-5">
                                   

                                    <div>
                                        <a :href="route('invoice_generate',sale.id)" class="font-medium text-green-600 dark:text-blue-500 hover:underline" >
                                            <div><u>Download Invoice</u></div>
                                        </a>
                                    </div>
                                    <div>
                                        
                                    </div>

                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

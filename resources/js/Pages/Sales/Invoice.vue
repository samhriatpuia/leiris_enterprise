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
    },
    batches: {
        batches: Object
    }
});
const form = useForm({
    particulars: '',
    unit: '',
    quantity: '',
    discount: '',
    price: '',
    sales_id: props.sale.id,
    batch_no: '',

});

const isModalOpen = ref(false);
const displayedData = ref(''); // Initialize with an empty string


const { visit, inertia } = usePage(); // Add 'inertia' here

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;

  displayedData.value = `Item Name: ${invoiceForm.value.new_name}, Batch: ${invoiceForm.value.batch}`;

  customer.value.name = '';
  customer.value.phone = '';

};


const salesForm = ref({
    id:props.sale.id,
    logistic_charge: props.sale.logistic_charge,
    handling_charge: props.sale.handling_charge,
    discount: props.sale.discount,
    paid: props.sale.paid,
   payment_mode: props.sale.payment_mode,
    // current_balance: props.sale.current_balance,

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
    batch_no: '',
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
        // batch:'',
        stock_opening:'',
        selling_price:'',
        units_secondary:'',
        units_main:'',
        units_relation:'',
        secondary_unit_price:'',
    };
    displayedData.value = '';
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
                                <div class="grid grid-cols-6 md:grid-cols-6 gap-4">
                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="unit" class="block text-sm font-medium text-gray-900 dark:text-white">Select Item</label>
                                            <select id="particulars" v-model="invoiceForm.particulars" name="particulars" for='particulars' class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Choose Customer">
                                                <option value="" disabled selected hidden> Choose Item</option>
                                                <option v-for="item in items" :value="item.id">{{ item.name }}({{ item.main_stock }} {{ item.units_main }}, {{ item.secondary_stock }}{{ item.units_secondary }})</option>
                                               
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="unit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit</label>
                                           
                                            <select id="unit" v-model="invoiceForm.unit" name="unit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Choose Units(main)">
                                                <option value="" disabled selected hidden>Choose Unit</option>
                                                <option value="primary">Primary(Bag,Case,Tin,Packet)</option>
                                                <option value="secondary">Secondary(Kg, liter)</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="batch_no" class="block text-sm font-medium text-gray-900 dark:text-white">Select Batch</label>
                                            <select id="batch_no" v-model="invoiceForm.batch_no" name="batch_no" for='batch_no' class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Choose Customer">
                                                <option value="" disabled selected hidden> Choose batch</option>
                                                <option v-for="(batch_no, id) in batches" :key="id" :value="batch_no">{{ batch_no }}</option>
                                               
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                                            <input type="text" v-model="invoiceForm.price" id="unit" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div> -->


                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                                            <input type="text" v-model="invoiceForm.quantity" id="quantity" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="Price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                                            <input type="text" v-model="invoiceForm.price" id="price" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <div class="mb-6">
                                            <label for="discount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount</label>
                                            <input type="text" v-model="invoiceForm.discount" id="discount" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-2 mb-2">

                                    <!-- <span id="displayedDataLabel" v-text="displayedData"></span> -->
                                    <span id="displayedDataLabel" v-if="displayedData">{{ displayedData }}</span>
                                </div>

                                <div class="grid grid-cols-4 md:grid-cols-3 gap-1">
                                    <div>
                                        <button type="submit" class="mb-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Save
                                        </button>
                                    </div>
                                    <div @click="openModal" class="mb-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        New Item
                                    </div>
                                </div>


                                <portal to="modals">
                                    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50 overflow-y-auto">
                                        <div class="modal-container bg-white w-1/2 p-6 rounded shadow-lg">
                                            <h2 class="text-lg font-semibold mb-4">Create New Item</h2>


                                            <div class="mb-6">
                                                <label for="new_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item Name</label>
                                                <input v-model="invoiceForm.new_name" type="text" id="new_name" name="new_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                                                <!-- <div v-if="errors.name">{{ errors.name }}</div> -->
                                            </div>

                                            <!-- <div class="mb-6">
                                                <label for="batch" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Batch</label>
                                                <input v-model="invoiceForm.batch" type="text" id="batch" name="batch" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                            </div> -->

                                            <div class="mb-6">
                                                <label for="stock_opening" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">stock opening</label>
                                                <input v-model="invoiceForm.stock_opening" type="text" id="stock_opening" name="stock_opening" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                            </div>

                                            <div class="mb-6">
                                                <label for="selling_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">selling price</label>
                                                <input v-model="invoiceForm.selling_price" type="text" id="selling_price" name="selling_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                            </div>

                                            <div class="mb-6">
                                                <label for="units_main" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit(main)</label>
                                                <select id="units_main" v-model="invoiceForm.units_main" name="units_main" for='units_main' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                                                    <option value="" disabled selected hidden>Choose Units(main)</option>
                                                    <option value="BAG">Bag</option>
                                                    <option value="CASE">Case</option>
                                                    <option value="PIECE">Piece</option>
                                                    <option value="TIN">Tin</option>
                                                    <option value="PACKET">Packet</option>

                                                </select>

                                            </div>

                                            <div class="mb-6">
                                                <label for="units_secondary" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">units secondary</label>
                                                <input v-model="invoiceForm.units_secondary" type="text" id="units_secondary" name="units_secondary" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                            </div>

                                            <div class="mb-6">
                                                <label for="secondary_unit_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">secondary unit price</label>
                                                <input v-model="invoiceForm.secondary_unit_price" type="text" id="secondary_unit_price" name="secondary_unit_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                            </div>

                                            <div class="mb-6">
                                                <label for="units_relation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">units relation</label>
                                                <input v-model="invoiceForm.units_relation" type="text" id="units_relation" name="units_relation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                            </div>


                                            <div class="mb-6">
                                                <label for="batch_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Batch No.</label>
                                                <input v-model="invoiceForm.batch_no" type="text" id="batch_no" name="batch_no" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

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
                                        </div>
                                    </div> <br>

                                    <div class="float-right" style="margin-right:315px">
                                        <div class="mt-2 grid grid-cols-2 md:grid-cols-2 gap-1">
                                            <label for="paid" class="mt-2 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Paid</label>
                                            <input type="text" v-model="salesForm.paid" id="paid" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" >
                                        </div>
                                    </div> <br>

                                    <div class="float-right" style="margin-right:320px">
                                        <div class="mt-2 grid grid-cols-2 md:grid-cols-2 gap-2">
                                        
                                            <label for="payment_mode" class="mt-3 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Payment Mode</label>
                                            <select id="payment_mode" v-model="salesForm.payment_mode" name="payment_mode" for='payment_mode' required class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" >
                                                <option value="" disabled selected hidden>Choose Payment Mode</option>
                                                <option value="CASH">CASH</option>
                                                <option value="UPI">UPI</option>
                                                <option value="NET BANKING">NET BANKING</option>
                                            </select>
                                        </div>
                                        
                                    </div> <br>


                                    <div class="float-right" style="margin-right:315px">
                                        <div class="mt-2 grid grid-cols-2 md:grid-cols-2 gap-1">
                                            <div >Current Balance: {{ sale.current_balance }}</div>
                                            <br>
                                            <div >Grand Total: {{ sale.grand_total }}</div>
                                            <br>
                                            
                                        </div>
                                        <div class="mt-2 grid grid-cols-2 md:grid-cols-2 gap-10">
                                            <button type="submit" class="mt-3 mb-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Calculate/Save</button>
                                            <div class="mt-7 ml-7">
                                                <a :href="route('invoice_generate',sale.id)" class="font-medium text-green-600 dark:text-blue-500 hover:underline" >
                                                    <div><u>Download Invoice</u></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>


                                </form>

                                <!-- <div class="grid grid-cols-2 md:grid-cols-2 gap-4 p-5">

                                </div> -->
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

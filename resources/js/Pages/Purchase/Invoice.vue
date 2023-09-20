<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { useForm } from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';




const props = defineProps({
    
    purchase: {
        purchase: Object,
    },
    purchaseDetails: {
        purchaseDetails: Object
    },
    items: {
        items: Object
    },
});


const isModalOpen = ref(false);
const displayedData = ref(''); // Initialize with an empty string


const { visit, inertia } = usePage(); // Add 'inertia' here

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
  
//   displayedData.value = `Item Name: ${form.value.new_name}, Batch: ${form.value.batch}`;

//   form.value.name = '';
//   form.value.phone = '';
  
};

const form = useForm({
    particulars: '',
    unit: '',
    quantity: '',
    discount: '',
    amount: '',
    price:'',
    purchase_id: props.purchase.id,

    new_name: '',
    batch:'',
    stock_opening:'',
    selling_price:'',
    units_secondary:'',
    units_main:'',
    units_relation:'',
    secondary_unit_price:'',

});


const purchaseForm = ref({
    id:props.purchase.id,
    logistic_charge: props.purchase.logistic_charge,
    handling_charge: props.purchase.handling_charge,
    discount: props.purchase.discount,
    sub_total: props.purchase.sub_total,
    grand_total: props.purchase.grand_total,
    
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


const submitPurchaseForm = async () => {
  try {
    const response = await router.post('/pruchase/invoice/calculate', purchaseForm.value);
    console.log('Response from server (Customer):', response);
  } catch (error) {
    console.error('Error while submitting customer form:', error);
  }
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
                           
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-8 mb-8">
                            <div>
                                <b>Invoice Number:</b> {{ purchase.invoice_number }}
                            </div>
                            <div>
                                <b>Date:</b> {{ purchase.date }}
                            </div>
                            <div>
                                <b>Vendor:</b> {{ purchase.vendor }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-8 mb-8">
                            <div>
                                <span id="displayedDataLabel" v-if="displayedData">{{ displayedData }}</span>
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
                                            <label for="particulars" class="mb-1 text-sm font-medium text-gray-900 dark:text-white">Particulars</label>
                                            <!-- <input type="text" v-model="form.particulars" id="particulars" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required> -->
                                            <!-- <label for="unit" class="block text-sm font-medium text-gray-900 dark:text-white">Select Item</label> -->
                                            <select id="particulars" v-model="form.particulars" name="particulars" for='particulars' class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Choose Customer">
                                                <option value="" disabled selected hidden> Choose Item</option>
                                                <option v-for="(name, id) in items" :key="id" :value="name">{{ name }}</option>
                                                <!-- <option @click="openModal" class="text-green-900"><b>New Item</b></option> -->
                                            </select>
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
                                            <label for="unit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">unit</label>
                                            <input type="text" v-model="form.unit" id="unit" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                                        </div>
                                    </div>
                                </div>


                                <!--  -->
                                <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                                   
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

                                    <div class="mt-5">
                                        <div @click="openModal" class="mt-7 mb-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-24">
                                            New Item
                                        </div>
                                    </div>
                                </div>

                                
                                <button type="submit" class="mb-3 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ADD</button>
                                

                                <portal to="modals">
                                    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50 overflow-y-auto">
                                        <div class="modal-container bg-white w-1/2 p-6 rounded shadow-lg">
                                            <h2 class="text-lg font-semibold mb-4">Create New Item</h2>

                                            <div class="mb-6">
                                                <label for="new_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item Name</label>
                                                <input v-model="form.new_name" type="text" id="new_name" name="new_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                                                <!-- <div v-if="errors.name">{{ errors.name }}</div> -->
                                            </div>
                                                                                        
                                            <div class="mb-6">
                                                <label for="batch" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Batch</label>
                                                <input v-model="form.batch" type="text" id="batch" name="batch" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                
                                            </div>

                                            <div class="mb-6">
                                                <label for="stock_opening" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">stock opening</label>
                                                <input v-model="form.stock_opening" type="text" id="stock_opening" name="stock_opening" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                
                                            </div>

                                            <div class="mb-6">
                                                <label for="selling_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">selling price</label>
                                                <input v-model="form.selling_price" type="text" id="selling_price" name="selling_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                
                                            </div>

                                            <div class="mb-6">
                                                <label for="units_main" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit(main)</label>
                                                <select id="units_main" v-model="form.units_main" name="units_main" for='units_main' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
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
                                                <input v-model="form.units_secondary" type="text" id="units_secondary" name="units_secondary" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                
                                            </div>

                                            <div class="mb-6">
                                                <label for="secondary_unit_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">secondary unit price</label>
                                                <input v-model="form.secondary_unit_price" type="text" id="secondary_unit_price" name="secondary_unit_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                
                                            </div>

                                            <div class="mb-6">
                                                <label for="units_relation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">units relation</label>
                                                <input v-model="form.units_relation" type="text" id="units_relation" name="units_relation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                
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
                                <!-- <div class="float-right" style="margin-right:315px">Sub-Total: {{ purchase.sub_total }}</div> <br>
                                <div class="float-right" style="margin-right:315px">Grand-Total: {{ purchase.grand_total }}</div> -->
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


                                <form @submit.prevent="submitPurchaseForm">
                                    <div class="float-right" style="margin-right:370px">Sub-Total: {{ purchase.sub_total }}</div> <br>
                                    
                                    <div class="mt-2 float-right " style="margin-right:315px">
                                        <div class="grid grid-cols-2 md:grid-cols-2 gap-1">
                                            <label for="logistic_charge" class="mt-2 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Logistic charge</label>
                                            <input type="text" v-model="purchaseForm.logistic_charge" id="logistic_charge" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" >
                                        </div>
                                    </div> <br>

                                    <div class="float-right" style="margin-right:315px">
                                        <div class="mt-2 grid grid-cols-2 md:grid-cols-2 gap-1">
                                            <label for="handling_charge" class="mt-2 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Handling charge</label>
                                            <input type="text" v-model="purchaseForm.handling_charge" id="handling_charge" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" >
                                        </div>    
                                    </div> <br>
                                    <div class="float-right" style="margin-right:315px">
                                        <div class="mt-2 grid grid-cols-2 md:grid-cols-2 gap-1">
                                            <label for="discount" class="mt-2 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount</label>
                                            <input type="text" v-model="purchaseForm.discount" id="discount" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" >
                                        </div>    
                                    </div> <br>

                                    <div class="float-right" style="margin-right:315px">
                                        <div class="mt-2 grid grid-cols-2 md:grid-cols-2 gap-1">
                                            <label for="scheme" class="mt-2 block mb-2 text-sm font-medium text-gray-900 dark:text-white">scheme</label>
                                            <input type="text" v-model="purchaseForm.scheme" id="scheme" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" >
                                        </div>    
                                    </div> <br>

                                    
                                                                     

                                    <div class="float-right" style="margin-right:315px">
                                        <div class="mt-2 grid grid-cols-2 md:grid-cols-2 gap-1">
                                            
                                            <div >Grand Total: {{ purchase.grand_total }}</div>
                                            <br>
                                            <button type="submit" class="mt-3 mb-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Calculate</button>
                                        
                                        </div>    
                                    </div> <br>
                                  
                                    
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

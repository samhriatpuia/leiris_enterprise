<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { useForm } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

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


function getTodayFormattedDate() {
  const today = new Date();
  const year = today.getFullYear();
  const month = (today.getMonth() + 1).toString().padStart(2, '0');
  const day = today.getDate().toString().padStart(2, '0');
  return `${year}-${month}-${day}`;
}

const props = defineProps({
    
    customers: {
        customers: Object,
    },
    methods: {
    closeModal() {
      this.$emit('close');
    },
  },
});

const form = useForm({
    customer_id: '',
    date: getTodayFormattedDate(),
    invoice_number: '',
    logistic_charge: '',
    handling_charge: '',
    discount : '',
    scheme : '',
    sub_total : '',
    new_name: '',
    phone:'',
});

const submit = () => {
    form.post(route("sales.store"));
};


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div >
                            Create New Sales/Invoice
                            <form @submit.prevent="submit" class="p-7">

                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" v-model="form.invoice_number" name="invoice_number" id="invoice_number" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                            Invoice Number
                                        </label>

                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="date" v-model="form.date" name="date" id="date" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <label for="gst" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                            Date
                                        </label>

                                    </div>
                                </div>


                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div >
                                        <select id="customer_id" v-model="form.customer_id" name="customer_id" for='customer_id' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Choose Customer">
                                            <option value="" disabled selected hidden> Choose Customer</option>
                                            <option v-for="(name, id) in customers" :key="id" :value="id">{{ name }}</option>
                                        </select>

                                    </div>
                                    <div >
                                        <div @click="openModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Add Customer
                                        </div>
                                            <portal to="modals">
                                            <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
                                                <div class="modal-container bg-white w-1/2 p-6 rounded shadow-lg">
                                                    <h2 class="text-lg font-semibold mb-4">Create New Customer</h2>

                                                
                                                    <div class="mb-6">
                                                        <label for="new_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer Name</label>
                                                        <input v-model="form.new_name" type="text" id="new_name" name="new_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required>
                                                        <!-- <div v-if="errors.name">{{ errors.name }}</div> -->
                                                    </div>
                                                                                        
                                                    <div class="mb-6">
                                                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                                                        <input v-model="form.phone" type="text" id="phone" name="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                        <!-- <div v-if="errors.phone">{{ errors.phone }}</div> -->
                                                    </div>
                                                                                        

                                                    <button @click="closeModal" class="mt-4 text-gray-500 hover:text-gray-700">Save</button>
                                                </div>
                                            </div>
                                        </portal>
                                    </div>
                                </div>


                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Next
                                </button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>



        
    </AuthenticatedLayout>
</template>

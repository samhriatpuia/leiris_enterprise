<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { useForm } from "@inertiajs/vue3";
import { onMounted } from 'vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    items: {
        type: Object,
        default: () => ({}),
    },
    groups: {
        groups: Object,
    },
    errors: {
        Object
    },
});


const form = useForm({
    name: '',
    gst: '',
    main_selling_price: '',
    secondary_selling_price: '',
    mrp: '',
    batch_no: '',
    // HSN: '',
    manufacture_date: '',
    expiry_date: '',
    units_main: '',
    units_secondary: '',
    units_relation: '',
    secondary_unit_price: '',
    purchase_price: '',
    main_stock: '',
    main_selling_price: '',
    role: ''
});

const submit = () => {
    form.post(route("items.store"));
};


const number1Input = ref(null);
const number2Input = ref(null);
const resultLabel = ref(null);

const updateResult = () => {
  const num1 = parseFloat(number1Input.value.value);
  const num2 = parseFloat(number2Input.value.value);

  if (!isNaN(num1) && !isNaN(num2)) {
    resultLabel.value.textContent = "Result(Main Stock x Units Relation): " + num1 * num2;
  } else {
    resultLabel.value.textContent = "Result(Main Stock x Units Relation): ";
  }
};

onMounted(() => {
  number1Input.value = document.getElementById("main_stock");
  number2Input.value = document.getElementById("units_relation");
  resultLabel.value = document.getElementById("resultLabel");

  if (number1Input.value && number2Input.value) {
    number1Input.value.addEventListener("input", updateResult);
    number2Input.value.addEventListener("input", updateResult);
    
    // Call updateResult to handle the default values
    updateResult();
  }
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div >
                            <form @submit.prevent="submit" class="p-7">

                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" v-model="form.name" name="name" id="name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <div v-if="errors.name">{{ errors.name }}</div>
                                        <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Item Name</label>

                                    </div>
                                   
                                    <div class="relative z-0 w-full mb-6 group">
                                        <select id="gst" v-model="form.gst" name="gst" for='gst' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                                            <option value="" disabled selected hidden>Choose GST %</option>
                                            <option value="18">18 percent</option>
                                            <option value="12">12 percent</option>
                                            <option value="5">5 percent</option>
                                            <option value="0">0%</option>

                                        </select>
                                        <div v-if="errors.gst">{{ errors.gst }}</div>
                                    </div>
                                    
                                </div>


                                <div class="grid md:grid-cols-2 md:gap-6">
                                    
                                    <!-- <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" v-model="form.secondary_unit_price" name="secondary_unit_price" id="secondary_unit_price" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <div v-if="errors.secondary_unit_price">{{ errors.secondary_unit_price }}</div>
                                        <label for="secondary_unit_price" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Secondary Selling Price</label>
                                    </div> -->
                                </div>

                                <br>
                                <br>


                                <div class="grid md:grid-cols-2 md:gap-6">
                                    
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" v-model="form.mrp" name="mrp" id="mrp" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <div v-if="errors.mrp">{{ errors.mrp }}</div>
                                        <label for="mrp" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">MRP</label>
                                    </div>

                                    <div class="relative z-0 w-full mb-6 group">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" v-model="form.purchase_price" name="purchase_price" id="purchase_price" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <div v-if="errors.purchase_price">{{ errors.purchase_price }}</div>
                                            <label for="purchase_price" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Purchase Price</label>
                                        </div>
                                    </div>
                                   
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6">
                                   
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" v-model="form.batch_no" name="batch_no" id="batch_no" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <div v-if="errors.batch_no">{{ errors.batch_no }}</div>
                                        <label for="batch_no" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Batch Number</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <!-- Choose Role -->
                                        <select id="role" v-model="form.role" name="role" for='role' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="" disabled selected >Choose User Role</option>
                                            <option value="user">User1 for (LE)</option>
                                            <option value="user2">User2 for (LC-Chips)</option>
                                        </select>
                                        <div v-if="errors.role">{{ errors.role }}</div>
                                    </div>  
                                                                      
                                </div>
                                <br>


                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="date" v-model="form.manufacture_date" name="manufacture_date" id="manufacture_date" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <div v-if="errors.manufacture_date">{{ errors.manufacture_date }}</div>
                                        <label for="manufacture_date" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Manufacturing Date</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="date" v-model="form.expiry_date" name="expiry_date" id="expiry_date" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <div v-if="errors.expiry_date">{{ errors.expiry_date }}</div>
                                        <label for="expiry_date" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Expiry Date</label>
                                    </div>
                                </div>

                                <br>

                                <div class="grid md:grid-cols-3 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <select id="units_main" v-model="form.units_main" name="units_main" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Choose Units(main)">
                                            <option value="" disabled selected hidden>Choose Units(main)</option>
                                            <option value="BAG">Bag</option>
                                            <option value="CASE">Case</option>
                                            <option value="TIN">Tin</option>
                                            
                                        </select>
                                        <div v-if="errors.units_main">{{ errors.units_main }}</div>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" v-model="form.main_stock" name="main_stock" id="main_stock" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <div v-if="errors.main_stock">{{ errors.main_stock }}</div>
                                        <label for="main_stock" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Main Stock</label>
                                    </div>

                                    <div class="relative z-0 w-full mb-6 group">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" v-model="form.main_selling_price" name="main_selling_price" id="main_selling_price" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <div v-if="errors.main_selling_price">{{ errors.main_selling_price }}</div>
                                            <label for="main_selling_price" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Mains Selling Price</label>
                                        </div>
                                    </div>

                                    
                                    
                                </div>

                                <div class="grid md:grid-cols-3 md:gap-6">
                                    
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" v-model="form.units_relation" name="units_relation" id="units_relation" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                        <div v-if="errors.units_relation">{{ errors.units_relation }}</div>
                                        <label for="units_relation" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Units Relation</label>
                                    </div>

                                    <div class="relative z-0 w-full mb-6 group">
                                       
                                        <div class="relative z-0 w-full mb-6 group">
                                            <select id="units_secondary" v-model="form.units_secondary" name="units_secondary" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Choose Units(main)">
                                                <option value="" disabled selected hidden>Choose Units(Secondary)</option>
                                                <option value="PIECE">Piece</option>
                                                <option value="Packet">Packet</option>
                                                <option value="DOZEN">Dozen</option>
                                                <option value="KG">KG</option>
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" v-model="form.secondary_unit_price" name="secondary_unit_price" id="secondary_unit_price" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                        <div v-if="errors.secondary_unit_price">{{ errors.secondary_unit_price }}</div>
                                        <label for="secondary_unit_price" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Secondary Unit Price</label>

                                    </div>
                                   
                                </div>


                                <div class="grid md:grid-cols-3 md:gap-6 ">
                                    <div id="resultLabel">Result(Main Stock x Units Relation):</div>
                                </div>
                                <br>

                                <div class="grid md:grid-cols-4 md:gap-6 ">
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>

                                    <Link :href="route('items.index')" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" >Cancel</Link>
                                </div>

                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

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
    
    item: {
        item: Object,
    },
    batches: {
        batches: Object
    },
    // items: {
    //     items: Object
    // },
});




const form = useForm({
    
    main_selling_price: '',
    secondary_selling_price: '',
    mrp: '',
    batch_no: '',
    HSN: '',
    manufacture_date: '',
    expiry_date: '',
    units_main: '',
    units_secondary: '',
    units_relation: '',
    secondary_unit_price: '',
    purchase_price: '',
    main_stock: '',
    main_selling_price: '',

    item_id: props.item.id,

});

const submit = () => {
    form.post(route("batches.store"),{
        preserveScroll: true,
        onSuccess: () => form.reset(), // reset form if everything went OK
    });
};

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route('batches.destroy', id));
        
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
                           
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-8 mb-2">
                            <div>
                                <b>Item Name:</b> {{ item.name }}
                            </div>
                            <div>
                                <b>GST:</b> {{ item.gst }}
                            </div>
                            <div>
                                <b>main stock:</b> {{ item.main_stock }}
                            </div>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-2 mb-8">
                            <div>
                                <b>Main Unit Price:</b> {{ item.main_selling_price }}
                            </div>
                            <div>
                                <b>Secondary stock:</b> {{ item.secondary_stock }}
                            </div>
                            <div>
                                <b>Secondary Unit Price:</b> {{ item.secondary_selling_price }}
                            </div>
                            
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-8 mb-8">
                            <div>
                                <span id="displayedDataLabel" v-if="displayedData">{{ displayedData }}</span>
                            </div>
                        </div>

                    

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Particulars

                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Date
                                            </th>

                                            <th scope="col" class="px-6 py-3">
                                                Main(Primary)
                                            </th>

                                            <th scope="col" class="px-6 py-3">
                                                Secondary
                                            </th>

                                            
                                            <th scope="col" class="px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="batch in batches.data" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                HSN: {{ batch.HSN }} 
                                                <br>
                                                Batch: {{ batch.batch }}    
                                                MRP: {{ batch.mrp }}                                        
                                            </th>
                                            <td class="px-6 py-4">
                                                MFG date: {{ batch.manufature_date }}
                                                <br>
                                                EXP Date:   {{ batch.expirey_date }}
                                            </td>
                                            
                                            <td class="px-6 py-4">
                                                Unit: {{ batch.units_main }}
                                                <br>
                                                Stock: {{ batch.main_stock }}    
                                                <br>
                                                Price: {{ batch.main_selling_price }}    
                                                <br>
                                                Relation: {{ batch.units_relation }}                                       
                                            </td>

                                            <td class="px-6 py-4">
                                                Unit: {{ batch.units_secondary }}
                                                <br>
                                                Stock: {{ batch.secondary_stock }}    
                                                <br>
                                                Price: {{ batch.secondary_unit_price }}                                                  
                                            </td>

                                           

                                            <td class="px-6 py-4">
                                               
                                                <button @click="destroy(batch.id)" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</button>
                                               
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <div class="m-2 p-2">
                                  
                                    <div class="flex">
                                        <template v-for="batch in batches.links" :key="batches.id" :href="batch.url">
                                            <div v-if="batch.url == null" v-html="batch.label"
                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                            ></div>
                                            <Link v-else :href="batch.url" v-html="batch.label"
                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                            ></Link>
                                        </template>
                                    </div>
                                    
                                </div>

                                <form @submit.prevent="submit" class="p-7 border p-4">

                                   <div class="grid md:grid-cols-2 md:gap-6">
                                        
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" v-model="form.mrp" name="mrp" id="mrp" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <!-- <div v-if="errors.mrp">{{ errors.mrp }}</div> -->
                                            <label for="mrp" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">MRP</label>
                                        </div>

                                        <div class="relative z-0 w-full mb-6 group">
                                            <div class="relative z-0 w-full mb-6 group">
                                                <input type="text" v-model="form.purchase_price" name="purchase_price" id="purchase_price" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                                <!-- <div v-if="errors.purchase_price">{{ errors.purchase_price }}</div> -->
                                                <label for="purchase_price" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Purchase Price</label>
                                            </div>
                                        </div>
                                    
                                    </div>

                                    <div class="grid md:grid-cols-2 md:gap-6">
                                    
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" v-model="form.batch_no" name="batch_no" id="batch_no" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <!-- <div v-if="errors.batch_no">{{ errors.batch_no }}</div> -->
                                            <label for="batch_no" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Batch Number</label>
                                        </div>

                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" v-model="form.HSN" name="HSN" id="HSN" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <!-- <div v-if="errors.HSN">{{ errors.HSN }}</div> -->
                                            <label for="HSN" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">HSN</label>

                                        </div>

                                        
                                    </div>
                                    <br>


                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="date" v-model="form.manufacture_date" name="manufacture_date" id="manufacture_date" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <!-- <div v-if="errors.manufacture_date">{{ errors.manufacture_date }}</div> -->
                                            <label for="manufacture_date" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Manufacturing Date</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="date" v-model="form.expiry_date" name="expiry_date" id="expiry_date" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <!-- <div v-if="errors.expiry_date">{{ errors.expiry_date }}</div> -->
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
                                                <option value="PIECE">Piece</option>
                                                <option value="TIN">Tin</option>
                                                <option value="PACKET">Packet</option>
                                            </select>
                                            <!-- <div v-if="errors.units_main">{{ errors.units_main }}</div> -->
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" v-model="form.main_stock" name="main_stock" id="main_stock" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <!-- <div v-if="errors.main_stock">{{ errors.main_stock }}</div> -->
                                            <label for="main_stock" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Main Stock</label>
                                        </div>

                                        <div class="relative z-0 w-full mb-6 group">
                                            <div class="relative z-0 w-full mb-6 group">
                                                <input type="text" v-model="form.main_selling_price" name="main_selling_price" id="main_selling_price" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                                <!-- <div v-if="errors.main_selling_price">{{ errors.main_selling_price }}</div> -->
                                                <label for="main_selling_price" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Mains Selling Price</label>
                                            </div>
                                        </div>

                                        
                                        
                                    </div>

                                    <div class="grid md:grid-cols-3 md:gap-6">
                                        
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" v-model="form.units_relation" name="units_relation" id="units_relation" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <!-- <div v-if="errors.units_relation">{{ errors.units_relation }}</div> -->
                                            <label for="units_relation" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Units Relation</label>
                                        </div>

                                        <div class="relative z-0 w-full mb-6 group">
                                            <div class="relative z-0 w-full mb-6 group">
                                                <input type="text" v-model="form.units_secondary" name="units_secondary" id="units_secondary" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                                <!-- <div v-if="errors.units_secondary">{{ errors.units_secondary }}</div> -->
                                                <label for="units_secondary" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Units Secondary</label>
                                            </div>
                                        </div>

                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" v-model="form.secondary_unit_price" name="secondary_unit_price" id="secondary_unit_price" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <!-- <div v-if="errors.secondary_unit_price">{{ errors.secondary_unit_price }}</div> -->
                                            <label for="secondary_unit_price" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Secondary Unit Price</label>

                                        </div>
                                    
                                    </div>
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useForm } from "@inertiajs/vue3";

defineProps({
    items: Object,
    total_cash: Number,
    total_upi: Number,
    total_cheque: Number,
    total_netbanking: Number,
    allItems: Object,
    salesDetails: Array,
});
// console.log(items);

const form = useForm({
    date1: '',
    date2: '',
});

const submit = () => {
    form.post(route("dashboard.payment"));
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="pt-5">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <div class="grid grid-cols-2 md:grid-cols-2 gap-4">

                                    <div>
                                        <div class="p-4">Stock Expiring</div>
                                        <div class="pt-5 p-4">
                                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3">
                                                                Item
                                                            </th>
                                                            <th scope="col" class="px-6 py-3">
                                                                Stock
                                                            </th> 
                                                            <th scope="col" class="px-6 py-3">
                                                                Expiry Date
                                                            </th>                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="item in items.data" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                                Name: {{ item.name }} <br>
                                                            </th>
                                                            <td class="px-6 py-4">
                                                                Main: {{ item.main_stock }}
                                                                <br>Secondary: {{ item.secondary_stock }}
                                                            </td>
                                                            <td>
                                                                <template v-for="(batch, batchIndex) in item.batches" :key="batchIndex">
                                                                    {{ batch.expiry_date }}
                                                                    <br>
                                                                    Batch No: {{ batch.batch_no }}
                                                                    <br>
                                                                </template>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="m-2 p-2">
                                                    <!-- <Link v-for="item in items.links" :key="item.id" :href="item.url">{{ item.label }}</Link> -->
                                                    <div class="flex">
                                                        <template v-for="item in items.links" :key="items.id" :href="item.url">
                                                            <div v-if="item.url == null" v-html="item.label"
                                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                                            ></div>
                                                            <Link v-else :href="item.url" v-html="item.label"
                                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                                            ></Link>
                                                        </template>
                                                    </div>
                                                    <!-- <Pagination :links="items.links" /> -->
                                                </div>
                                            </div>
                                            <!--  -->
                                        </div>
                                    </div>

                                    <!--  -->
                                    <div>
                                        <form @submit.prevent="submit" class="p-5">
                                            <!-- GRID search -->
                                            <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                                                <div>
                                                    <input type="date" v-model="form.date1" name="date1" id="date1" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                                </div>
                                                <div>
                                                    <input type="date" v-model="form.date2" name="date2" id="date2" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                                </div>
                                                <div>
                                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                                                </div>
                                            </div>
                                        </form>  
                                        <div class="grid grid-cols-2 md:grid-cols-2 gap-4 p-5">

                                            <div class="bg-blue-700 text-white p-7 rounded text-center">
                                                Cash:  {{ total_cash }}
                                            </div>

                                            <div class="bg-orange-500 text-white p-7 rounded text-center">
                                                UPI:  {{ total_upi }}
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 md:grid-cols-2 gap-4 p-5">

                                            <div class="bg-red-700 text-white p-7 rounded text-center">
                                                Net Banking:  {{ total_netbanking }}
                                            </div>

                                            <div class="bg-green-500 text-white p-7 rounded text-center">
                                                Cheque:  {{ total_cheque }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                                    <div>
                                        <div class="p-4">Stock Remaining</div>
                                        <div class="pt-5 p-4">
                                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3">
                                                                Item
                                                            </th>
                                                            <th scope="col" class="px-6 py-3">
                                                                Stock
                                                            </th>                                                          
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="allItem in allItems.data" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                                {{ allItem.name }} <br>
                                                            </th>
                                                            <td class="px-6 py-4">
                                                                Main: {{ allItem.main_stock }}
                                                                <br>Secondary: {{ allItem.secondary_stock }}
                                                            </td>
                                                            
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="m-2 p-2">
                                                    <!-- <Link v-for="item in items.links" :key="item.id" :href="item.url">{{ item.label }}</Link> -->
                                                    <div class="flex">
                                                        <template v-for="allItem in allItems.links" :key="allItems.id" :href="allItem.url">
                                                            <div v-if="allItem.url == null" v-html="allItem.label"
                                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                                            ></div>
                                                            <Link v-else :href="allItem.url" v-html="allItem.label"
                                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                                            ></Link>
                                                        </template>
                                                    </div>
                                                    <!-- <Pagination :links="items.links" /> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div>
                                        <div class="p-4">salesDetails</div>
                                        <div class="pt-5 p-4">
                                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3">
                                                                Item
                                                            </th>
                                                            <!-- <th scope="col" class="px-6 py-3">
                                                                Sale Amt
                                                            </th>  -->
                                                            <th scope="col" class="px-6 py-3">
                                                                Value
                                                            </th>                                                         
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="salesDetail in salesDetails.data" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                                {{ salesDetail.particulars }} <br>
                                                            </th>
                                                            <!-- <td class="px-6 py-4">
                                                                {{ salesDetail.total_amount }}
                                                                
                                                            </td> -->
                                                            <td class="px-6 py-4">
                                                                {{ salesDetail.Amount }}
                                                                
                                                            </td>
                                                            
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="m-2 p-2">
                                                    <!-- <Link v-for="item in items.links" :key="item.id" :href="item.url">{{ item.label }}</Link> -->
                                                    <div class="flex">
                                                        <template v-for="salesDetail in salesDetails.links" :key="salesDetails.id" :href="salesDetail.url">
                                                            <div v-if="salesDetail.url == null" v-html="salesDetail.label"
                                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                                            ></div>
                                                            <Link v-else :href="salesDetail.url" v-html="salesDetail.label"
                                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                                            ></Link>
                                                        </template>
                                                    </div>
                                                    <!-- <Pagination :links="items.links" /> -->
                                                </div>
                                            </div>
                                        </div>
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

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
// import Pagination from '@/Components/Pagination.vue';
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    settlementDetails: {
        type: Object,
        default: () => ({}),
    },
    theSettlement: {
        type: Object,
    },
    theBalance: {
        type: Object,
    }
});


const form = useForm({
    amount: '',
    balance: '',
    mode: '',
    payer: '',
    transaction_id: '',
    recieve_by: '',
    settlement_id: props.theSettlement.id,

});


const submit = () => {
    form.post(route("settlements.details.store"));
    form.reset()
};

// function destroy(id) {
//     if (confirm("Are you sure you want to Delete")) {
//         form.delete(route('settlements.destroy', id));
//     }
// }

</script>

<template>
    <Head title="Settlement" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <div class="grid grid-cols-2 md:grid-cols-2 gap-4 p-5">
                            Grand Total: {{ theSettlement.grand_total }} <br>
                            <p v-if="theBalance && theBalance.balance">{{ theBalance.balance }}</p>
                            <p v-else></p>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-2 gap-4 p-5">
                            <div>
                                <div class="pt-5">
                                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3">
                                                        Name & Details

                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Amount Paid
                                                    </th>

                                                    <th scope="col" class="px-6 py-3">
                                                        Balance
                                                    </th>

                                                    <!-- <th scope="col" class="px-6 py-3">
                                                        Balance
                                                    </th> -->

                                                    
                                                    <!-- <th scope="col" class="px-6 py-3">
                                                        Action
                                                    </th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="settlementDetail in settlementDetails.data" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        Payer: {{ settlementDetail.payer }}
                                                        <br><small>Mode: {{ settlementDetail.mode }}</small>
                                                        <br>Transaction ID: {{ settlementDetail.transaction_id }}
                                                        
                                                    </th>
                                                    
                                                    
                                                    <td class="px-6 py-4">
                                                        Amount : {{ settlementDetail.amount }}
                                                    </td>


                                                    <td class="px-6 py-4">
                                                        Balance: {{ settlementDetail.balance }}
                                                        
                                                    </td>

                                                    <!-- <td class="px-6 py-4">
                                                        Grand Total: {{ settlementDetail.grand_total }}
                                                        
                                                    </td> -->

                                                    <!-- <td class="px-6 py-4">
                                                        <button @click="destroy(settlementDetail.id)" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</button>
                                                    </td> -->
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="m-2 p-2">
                                        
                                            <div class="flex">
                                                <template v-for="settlementDetail in settlementDetails.links" :key="settlementDetails.id" :href="settlementDetails.url">
                                                    <div v-if="settlementDetail.url == null" v-html="settlementDetail.label"
                                                        class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                                    ></div>
                                                    <Link v-else :href="settlementDetail.url" v-html="settlementDetail.label"
                                                        class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                                    ></Link>
                                                </template>
                                            </div>
                                            
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div>
                                <form @submit.prevent="submit" class="p-7">
                                    <label for="quantity" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">ID:</label>
                                    <input type="hidden " v-model="form.settlement_id" name="settlement_id" disabled> <br> <br>

                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" v-model="form.payer" name="payer" id="payer" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <div v-if="form.errors.payer">{{ form.errors.payer }}</div>
                                            <label for="payer" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                                Name of Payer
                                            </label>

                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            
                                            <select id="mode" v-model="form.mode" name="mode" for='mode' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                                                <option value="" disabled selected hidden>Choose Payment Mode</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Upi">UPI</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Net Banking">Net Banking</option>
                                            </select>
                                            <div v-if="form.errors.mode">{{ form.errors.mode }}</div>

                                        </div>
                                    </div>


                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" v-model="form.transaction_id" name="transaction_id" id="transaction_id" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <div v-if="form.errors.transaction_id">{{ form.errors.transaction_id }}</div>
                                            <label for="transaction_id" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                                Transaction ID
                                            </label>

                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" v-model="form.amount" name="amount" id="amount" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <div v-if="form.errors.amount">{{ form.errors.amount }}</div>
                                            <label for="amount" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                                Amount Paid
                                            </label>
                                        </div>
                                    </div>

                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" v-model="form.recieve_by" name="recieve_by" id="recieve_by" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <div v-if="form.errors.recieve_by">{{ form.errors.recieve_by }}</div>
                                            <label for="recieve_by" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                                Recieved By(Employee)
                                            </label>

                                        </div>
                                        
                                    </div>

                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                                </form>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


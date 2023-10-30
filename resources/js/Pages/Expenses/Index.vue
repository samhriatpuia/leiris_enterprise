<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
// import Pagination from '@/Components/Pagination.vue';
import { useForm } from "@inertiajs/vue3";


defineProps({
    expenses: Object,
});

const form = useForm({
   
});

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route('expenses.destroy', id));
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
                        <div>
                            <div class="flow-root ">
                                <p class="float-left text-green-600">
                                    <Link href="/expenses/create" method="get" as="button" type="button" class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">
                                        Create Expense
                                    </Link>
                                </p>
                        
                                
                            </div>

                            
                            


                        </div>
                        <div class="pt-5">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Particular

                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Amount
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                               Date(yyyy-mm-dd)
                                            </th>
                                            
                                            <th scope="col" class="px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="expense in expenses.data" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Particular: {{ expense.particular }} <br>
                                               
                                                
                                            </th>
                                            <td class="px-6 py-4">
                                                Amount: Rs.{{ expense.amount }}
                                                <br>Remark: {{ expense.remarks }}
                                            </td>
                                            <td class="px-6 py-4">
                                                Date: {{ expense.date }}
                                                
                                            </td>
                                            


                                            <td class="px-6 py-4">
                                                <div class="grid grid-cols-2 md:grid-cols-2 gap-1">
                                                    <div>
                                                         <Link :href="route('expenses.edit',expense.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" >Edit</Link>
                                                    </div>
                                                    <div>
                                                        <button @click="destroy(expense.id)" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</button>
                                                    </div>
                                                    <div>
                                                         <!-- <Link :href="route('items.batch',item.id)" class="font-medium text-green-600 dark:text-green-500 hover:underline" >Details</Link> -->
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="m-2 p-2">
                                    <!-- <Link v-for="item in items.links" :key="item.id" :href="item.url">{{ item.label }}</Link> -->
                                    <div class="flex">
                                        <template v-for="expense in expenses.links" :key="expenses.id" :href="expense.url">
                                            <div v-if="expense.url == null" v-html="expense.label"
                                                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                            ></div>
                                            <Link v-else :href="expense.url" v-html="expense.label"
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
    </AuthenticatedLayout>
</template>


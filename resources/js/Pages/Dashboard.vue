<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
    balance: Number,
    users: Array,
});

const form = useForm({
    receiver_id: "",
    amount: "",
});

const submitTransfer = () => {
    form.post(route("transfers.store"), {
        onSuccess: () => form.reset("amount", "receiver_id"),
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                My Wallet
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <div class="text-gray-900 dark:text-gray-100 text-center">
                        <p class="text-lg">Current Balance</p>
                        <h1 class="text-5xl font-bold text-green-500 mt-2">
                            R$ {{ props.balance }}
                        </h1>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <h3
                        class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4"
                    >
                        Make a Transfer
                    </h3>

                    <form @submit.prevent="submitTransfer" class="space-y-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >Send to</label
                            >
                            <select
                                v-model="form.payee_id"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="" disabled>
                                    Select a user...
                                </option>
                                <option
                                    v-for="user in users"
                                    :key="user.id"
                                    :value="user.id"
                                >
                                    {{ user.name }} ({{ user.email }})
                                </option>
                            </select>
                            <div
                                v-if="form.errors.payee_id"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.receiver_id }}
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >Amount (R$)</label
                            >
                            <input
                                type="number"
                                step="0.01"
                                v-model="form.amount"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="0.00"
                            />
                            <div
                                v-if="form.errors.amount"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.amount }}
                            </div>
                        </div>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                        >
                            <span v-if="form.processing">Processing...</span>
                            <span v-else>Transfer Money</span>
                        </button>

                        <div
                            v-if="form.recentlySuccessful"
                            class="text-green-500 text-center font-bold"
                        >
                            Transfer Successful! 🚀
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

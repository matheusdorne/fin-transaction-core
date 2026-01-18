<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

// Props received from DashboardController
const props = defineProps({
    balance: Number,
    users: Array,
    transactions: Array, // <--- The history list
    myWalletId: Number, // <--- Needed to know if I sent or received
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

// Helper function to format dates nicely (e.g., 18/01/2026 15:30)
const formatDate = (dateString) => {
    if (!dateString) return "";
    return new Date(dateString).toLocaleDateString("pt-BR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
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
                                v-model="form.receiver_id"
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
                                v-if="form.errors.receiver_id"
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

                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <h3
                        class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4"
                    >
                        Recent Transactions
                    </h3>

                    <div
                        v-if="transactions.length === 0"
                        class="text-gray-500 dark:text-gray-400 text-center py-4"
                    >
                        No transactions found yet.
                    </div>

                    <ul
                        v-else
                        class="divide-y divide-gray-200 dark:divide-gray-700"
                    >
                        <li
                            v-for="t in transactions"
                            :key="t.id"
                            class="py-4 flex justify-between items-center"
                        >
                            <div>
                                <p
                                    class="text-sm font-medium text-gray-900 dark:text-gray-100"
                                >
                                    <span
                                        v-if="
                                            t.sender_wallet_id ===
                                            props.myWalletId
                                        "
                                    >
                                        Sent to
                                        <strong>{{
                                            t.receiver?.user?.name || "Unknown"
                                        }}</strong>
                                    </span>
                                    <span v-else>
                                        Received from
                                        <strong>{{
                                            t.sender?.user?.name || "Unknown"
                                        }}</strong>
                                    </span>
                                </p>
                                <p
                                    class="text-xs text-gray-500 dark:text-gray-400"
                                >
                                    {{ formatDate(t.created_at) }}
                                </p>
                            </div>

                            <div
                                class="text-lg font-bold"
                                :class="
                                    t.sender_wallet_id === props.myWalletId
                                        ? 'text-red-500'
                                        : 'text-green-500'
                                "
                            >
                                {{
                                    t.sender_wallet_id === props.myWalletId
                                        ? "-"
                                        : "+"
                                }}
                                R$ {{ t.amount }}
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

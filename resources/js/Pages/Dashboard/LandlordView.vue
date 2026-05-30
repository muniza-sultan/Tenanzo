<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    properties: Array,
});

const statusColor = (status) => ({
    pending:  'bg-yellow-100 text-yellow-800',
    approved: 'bg-green-100 text-green-800',
    rejected: 'bg-red-100 text-red-800',
}[status]);
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard — Tenanzo" />

        <div class="py-12">
            <div class="mx-auto max-w-5xl px-4">

                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Your Properties</h1>
                    <Link
                        :href="route('properties.create')"
                        class="text-sm bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
                    >
                        + List property
                    </Link>
                </div>

                <div v-if="properties.length === 0" class="text-gray-500">
                    You haven't listed any properties yet.
                </div>

                <div class="space-y-8">
                    <div v-for="property in properties" :key="property.id">
                        <div class="bg-white rounded-lg border border-gray-200 p-5">
                            <div class="flex justify-between">
                                <div>
                                    <h2 class="text-lg font-medium text-gray-900">{{ property.title }}</h2>
                                    <p class="text-sm text-gray-500">{{ property.address }} &middot; {{ property.bedrooms }} bed &middot; €{{ property.monthly_rent }}/mo</p>
                                </div>
                                <span class="text-sm text-gray-400">{{ property.applications.length }} application(s)</span>
                            </div>

                            <div v-if="property.applications.length > 0" class="mt-4 space-y-4">
                                <div
                                    v-for="app in property.applications"
                                    :key="app.id"
                                    class="border border-gray-100 rounded-lg p-4 bg-gray-50"
                                >
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium text-gray-800">{{ app.tenant.name }}</p>
                                            <p class="text-sm text-gray-500">{{ app.tenant.email }}</p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                Income: €{{ app.monthly_income }}/mo &middot;
                                                Move-in: {{ new Date(app.move_in_date).toLocaleDateString('en-GB') }}
                                            </p>
                                            <p class="text-sm text-gray-600 mt-2">{{ app.message }}</p>
                                        </div>
                                        <span :class="['text-xs font-medium px-2.5 py-1 rounded-full shrink-0 ml-4', statusColor(app.status)]">
                                            {{ app.status }}
                                        </span>
                                    </div>

                                    <div v-if="app.status === 'pending'" class="mt-3 space-y-2">
                                        <textarea
                                            v-model="app._notes"
                                            placeholder="Optional note to tenant..."
                                            rows="2"
                                            class="block w-full text-sm rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                        />
                                        <div class="flex gap-2">
                                            <button
                                                type="button"
                                                @click="useForm({ status: 'approved', landlord_notes: app._notes }).patch(route('applications.updateStatus', app.id))"
                                                class="px-3 py-1.5 text-sm bg-green-600 text-white rounded hover:bg-green-700"
                                            >
                                                Approve
                                            </button>
                                            <button
                                                type="button"
                                                @click="useForm({ status: 'rejected', landlord_notes: app._notes }).patch(route('applications.updateStatus', app.id))"
                                                class="px-3 py-1.5 text-sm bg-red-600 text-white rounded hover:bg-red-700"
                                            >
                                                Reject
                                            </button>
                                        </div>
                                    </div>

                                    <div v-if="app.landlord_notes && app.status !== 'pending'" class="mt-2 text-sm text-gray-600 bg-white rounded p-2 border border-gray-200">
                                        <span class="font-medium">Note:</span> {{ app.landlord_notes }}
                                    </div>
                                </div>
                            </div>

                            <p v-else class="mt-3 text-sm text-gray-400">No applications yet.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
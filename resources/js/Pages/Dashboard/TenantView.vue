<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    applications: Array,
});

const statusColor = (status) => ({
    pending:  'bg-yellow-100 text-yellow-800',
    approved: 'bg-green-100 text-green-800',
    rejected: 'bg-red-100 text-red-800',
}[status]);
</script>

<template>
    <AuthenticatedLayout>
        <Head title="My Applications" />

        <div class="py-12">
            <div class="mx-auto max-w-4xl px-4">
                <h1 class="text-2xl font-semibold text-gray-800 mb-6">My Applications</h1>

                <div v-if="applications.length === 0" class="text-gray-500">
                    You haven't applied for any properties yet.
                </div>

                <div class="space-y-4">
                    <div
                        v-for="app in applications"
                        :key="app.id"
                        class="bg-white rounded-lg border border-gray-200 p-5"
                    >
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="font-medium text-gray-900">{{ app.property.title }}</h2>
                                <p class="text-sm text-gray-500">{{ app.property.address }}</p>
                                <p class="text-sm text-gray-500 mt-1">Move-in: {{ new Date(app.move_in_date).toLocaleDateString('en-GB') }}</p>
                            </div>
                            <span :class="['text-xs font-medium px-2.5 py-1 rounded-full', statusColor(app.status)]">
                                {{ app.status }}
                            </span>
                        </div>
                        <div v-if="app.landlord_notes" class="mt-3 text-sm text-gray-600 bg-gray-50 rounded p-3">
                            <span class="font-medium">Landlord note:</span> {{ app.landlord_notes }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
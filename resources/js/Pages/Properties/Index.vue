<script setup>
import { Link, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { usePage } from '@inertiajs/vue3';

defineProps({
    properties: Array,
});

const { props } = usePage();
const user = props.auth.user;
</script>

<template>
    <component :is="user ? AuthenticatedLayout : GuestLayout">
        <Head title="Properties" />

        <div class="py-12">
            <div class="mx-auto max-w-5xl px-4">
                <h1 class="text-2xl font-semibold text-gray-800 mb-6">Available Properties</h1>

                <div v-if="properties.length === 0" class="text-gray-500">
                    No properties listed yet.
                </div>

                <div class="grid gap-4">
                    <div
                        v-for="property in properties"
                        :key="property.id"
                        class="bg-white rounded-lg border border-gray-200 p-5 flex justify-between items-start"
                    >
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">{{ property.title }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ property.address }}</p>
                            <p class="text-sm text-gray-500">{{ property.bedrooms }} bed &middot; €{{ property.monthly_rent }}/mo</p>
                            <p class="text-sm text-gray-600 mt-2 max-w-xl">{{ property.description }}</p>
                        </div>
                        <Link
                            :href="route('properties.show', property.id)"
                            class="ml-4 shrink-0 text-sm text-indigo-600 hover:underline"
                        >
                            View →
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </component>
</template>
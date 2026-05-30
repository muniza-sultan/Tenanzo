
<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    title: '',
    address: '',
    monthly_rent: '',
    bedrooms: '',
    description: '',
});

const submit = () => {
    form.post(route('properties.store'));
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="List a Property" />

        <div class="py-12">
            <div class="mx-auto max-w-xl px-4">
                <h1 class="text-2xl font-semibold text-gray-800 mb-6">List a property</h1>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <InputLabel for="title" value="Title" />
                            <TextInput
                                id="title"
                                v-model="form.title"
                                class="mt-1 block w-full"
                                placeholder="Modern 2-bed in Schwabing"
                            />
                            <InputError :message="form.errors.title" class="mt-1" />
                        </div>

                        <div>
                            <InputLabel for="address" value="Address" />
                            <TextInput
                                id="address"
                                v-model="form.address"
                                class="mt-1 block w-full"
                                placeholder="Leopoldstraße 45, Munich"
                            />
                            <InputError :message="form.errors.address" class="mt-1" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="monthly_rent" value="Monthly rent (€)" />
                                <TextInput
                                    id="monthly_rent"
                                    type="number"
                                    v-model="form.monthly_rent"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.monthly_rent" class="mt-1" />
                            </div>
                            <div>
                                <InputLabel for="bedrooms" value="Bedrooms" />
                                <TextInput
                                    id="bedrooms"
                                    type="number"
                                    v-model="form.bedrooms"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.bedrooms" class="mt-1" />
                            </div>
                        </div>

                        <div>
                            <InputLabel for="description" value="Description" />
                            <textarea
                                id="description"
                                v-model="form.description"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                placeholder="Describe the property..."
                            />
                            <InputError :message="form.errors.description" class="mt-1" />
                        </div>

                        <PrimaryButton :disabled="form.processing">
                            List property
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 
<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    property: Object,
    alreadyApplied: Boolean,
});

const { props: pageProps } = usePage();
const user = pageProps.auth.user;

const form = useForm({
    message: '',
    monthly_income: '',
    move_in_date: '',
});

const submit = () => {
    form.post(route('applications.store', props.property.id));
};
</script>

<template>
    <component :is="user ? AuthenticatedLayout : GuestLayout">
        <Head :title="property.title" />

        <div class="py-12">
            <div class="mx-auto max-w-2xl px-4">
                <Link :href="route('home')" class="text-sm text-gray-500 hover:underline">← Back to listings</Link>

                <div class="mt-4 bg-white rounded-lg border border-gray-200 p-6">
                    <h1 class="text-2xl font-semibold text-gray-900">{{ property.title }}</h1>
                    <p class="text-gray-500 mt-1">{{ property.address }}</p>
                    <p class="text-gray-500">{{ property.bedrooms }} bed &middot; €{{ property.monthly_rent }}/mo</p>
                    <p class="text-gray-700 mt-4">{{ property.description }}</p>
                </div>

                <div class="mt-6 bg-white rounded-lg border border-gray-200 p-6">
                    <div v-if="!user">
                        <p class="text-gray-600">
                            <Link :href="route('login')" class="text-indigo-600 hover:underline">Log in</Link>
                            to apply for this property.
                        </p>
                    </div>

                    <div v-else-if="user.role === 'landlord'">
                        <p class="text-gray-500 text-sm">Landlords cannot apply for properties.</p>
                    </div>

                    <div v-else-if="alreadyApplied">
                        <p class="text-green-600 font-medium">✓ You have already applied for this property.</p>
                    </div>

                    <form v-else @submit.prevent="submit" class="space-y-4">
                        <h2 class="text-lg font-medium text-gray-800">Apply for this property</h2>

                        <div>
                            <InputLabel for="message" value="Cover message" />
                            <textarea
                                id="message"
                                v-model="form.message"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                placeholder="Tell the landlord a bit about yourself..."
                            />
                            <InputError :message="form.errors.message" class="mt-1" />
                        </div>

                        <div>
                            <InputLabel for="monthly_income" value="Monthly income (€)" />
                            <TextInput
                                id="monthly_income"
                                type="number"
                                v-model="form.monthly_income"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.monthly_income" class="mt-1" />
                        </div>

                        <div>
                            <InputLabel for="move_in_date" value="Desired move-in date" />
                            <TextInput
                                id="move_in_date"
                                type="date"
                                v-model="form.move_in_date"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.move_in_date" class="mt-1" />
                        </div>

                        <PrimaryButton :disabled="form.processing">
                            Submit application
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </component>
</template>
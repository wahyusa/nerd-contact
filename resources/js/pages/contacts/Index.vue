<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Contacts',
        href: '/contact',
    },
];

// Props from the backend (you'll get these from your controller)
defineProps({
    contacts: Object,
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <!-- Stats Cards -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <!-- Total Contacts -->
                <div class="relative aspect-video overflow-hidden rounded-xl border border-gray-300 bg-blue-50">
                    <div class="flex h-full flex-col justify-center p-6">
                        <div class="text-3xl font-bold text-blue-600">??</div>
                        <div class="mt-1 text-sm text-gray-700">Total Contacts</div>
                    </div>
                </div>

                <!-- Favorites -->
                <div class="relative aspect-video overflow-hidden rounded-xl border border-gray-300 bg-yellow-50">
                    <div class="flex h-full flex-col justify-center p-6">
                        <div class="text-3xl font-bold text-yellow-600">??</div>
                        <div class="mt-1 text-sm text-gray-700">Favorites</div>
                    </div>
                </div>

                <!-- Recent -->
                <div class="relative aspect-video overflow-hidden rounded-xl border border-gray-300 bg-green-50">
                    <div class="flex h-full flex-col justify-center p-6">
                        <div class="text-3xl font-bold text-green-600">??</div>
                        <div class="mt-1 text-sm text-gray-700">Recent</div>
                    </div>
                </div>
            </div>

            <!-- Main Contact Area -->
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-gray-300 bg-white md:min-h-min">
                <!-- Simple Contact Dashboard -->
                <div class="p-6">
                    <h1 class="mb-6 text-2xl font-bold text-gray-800">My Contacts</h1>

                    <!-- Simple Stats -->
                    <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 p-4">
                        <p class="text-lg text-gray-800">📱 You have ?? contacts</p>
                        <p class="mt-1 text-sm text-gray-600">⭐ ?? favorites</p>
                    </div>

                    <!-- Simple Contact List -->
                    <div v-if="contacts?.data && contacts.data.length > 0">
                        <h2 class="mb-4 text-xl font-semibold text-gray-800">Recent Contacts</h2>
                        <div class="space-y-3">
                            <div
                                v-for="contact in contacts.data"
                                :key="contact.id"
                                class="rounded-lg border border-gray-200 bg-white p-4 transition-all hover:border-gray-300 hover:shadow-md"
                            >
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ contact.full_name }}</h3>
                                        <p class="text-sm text-gray-600">{{ contact.email }}</p>
                                        <p v-if="contact.age" class="text-xs text-gray-500">Age: {{ contact.age }}</p>
                                        <!-- Tags -->
                                        <div v-if="contact.tags && contact.tags.length" class="mt-2">
                                            <span
                                                v-for="tag in contact.tags.slice(0, 3)"
                                                :key="tag"
                                                class="mr-1 inline-block rounded bg-blue-100 px-2 py-1 text-xs text-blue-700"
                                            >
                                                {{ tag }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span v-if="contact.is_favorite" class="text-lg text-yellow-500">⭐</span>
                                        <div v-if="contact.zodiac" class="text-sm text-gray-600">
                                            {{ contact.zodiac.symbol }} {{ contact.zodiac.name }}
                                        </div>
                                        <!-- Actions -->
                                        <div class="mt-2 space-x-2">
                                            <a
                                                :href="`/contacts/${contact.id}`"
                                                class="rounded bg-gray-100 px-2 py-1 text-xs text-gray-700 hover:bg-gray-200"
                                            >
                                                View
                                            </a>
                                            <a
                                                :href="`/contacts/${contact.id}/edit`"
                                                class="rounded bg-blue-100 px-2 py-1 text-xs text-blue-700 hover:bg-blue-200"
                                            >
                                                Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-else class="py-12 text-center">
                        <div class="mb-4 text-4xl">👥</div>
                        <p class="mb-4 text-lg text-gray-500">No contacts yet</p>
                        <p class="mb-6 text-sm text-gray-400">Start building your contact list</p>
                        <a
                            href="/contacts/create"
                            class="rounded-lg bg-blue-500 px-6 py-3 font-medium text-white transition-colors hover:bg-blue-600"
                        >
                            Add Your First Contact
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

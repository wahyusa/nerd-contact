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
const props = defineProps({
  contacts: Object,
  contactStats: Object,
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <!-- Stats Cards -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <!-- Total Contacts -->
                <div class="relative aspect-video overflow-hidden rounded-xl border border-gray-300 bg-blue-50">
                    <div class="p-6 h-full flex flex-col justify-center">
                        <div class="text-3xl font-bold text-blue-600">
                            {{ contactStats?.total_contacts || 0 }}
                        </div>
                        <div class="text-sm text-gray-700 mt-1">
                            Total Contacts
                        </div>
                    </div>
                </div>

                <!-- Favorites -->
                <div class="relative aspect-video overflow-hidden rounded-xl border border-gray-300 bg-yellow-50">
                    <div class="p-6 h-full flex flex-col justify-center">
                        <div class="text-3xl font-bold text-yellow-600">
                            {{ contactStats?.favorites || 0 }}
                        </div>
                        <div class="text-sm text-gray-700 mt-1">
                            Favorites
                        </div>
                    </div>
                </div>

                <!-- Recent -->
                <div class="relative aspect-video overflow-hidden rounded-xl border border-gray-300 bg-green-50">
                    <div class="p-6 h-full flex flex-col justify-center">
                        <div class="text-3xl font-bold text-green-600">
                            {{ contacts?.data?.length || 0 }}
                        </div>
                        <div class="text-sm text-gray-700 mt-1">
                            Recent
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Contact Area -->
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-gray-300 md:min-h-min bg-white">
                <!-- Simple Contact Dashboard -->
                <div class="p-6">
                    <h1 class="text-2xl font-bold mb-6 text-gray-800">My Contacts</h1>
                    
                    <!-- Simple Stats -->
                    <div class="bg-blue-50 p-4 rounded-lg mb-6 border border-blue-200">
                        <p class="text-lg text-gray-800">
                            📱 You have <strong>{{ contactStats?.total_contacts || 0 }}</strong> contacts
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            ⭐ {{ contactStats?.favorites || 0 }} favorites
                        </p>
                    </div>

                    <!-- Simple Contact List -->
                    <div v-if="contacts?.data && contacts.data.length > 0">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800">Recent Contacts</h2>
                        <div class="space-y-3">
                            <div 
                                v-for="contact in contacts.data" 
                                :key="contact.id"
                                class="bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md hover:border-gray-300 transition-all"
                            >
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ contact.full_name }}</h3>
                                        <p class="text-sm text-gray-600">{{ contact.email }}</p>
                                        <p v-if="contact.age" class="text-xs text-gray-500">
                                            Age: {{ contact.age }}
                                        </p>
                                        <!-- Tags -->
                                        <div v-if="contact.tags && contact.tags.length" class="mt-2">
                                            <span 
                                                v-for="tag in contact.tags.slice(0, 3)" 
                                                :key="tag"
                                                class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded mr-1"
                                            >
                                                {{ tag }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span v-if="contact.is_favorite" class="text-yellow-500 text-lg">⭐</span>
                                        <div v-if="contact.zodiac" class="text-sm text-gray-600">
                                            {{ contact.zodiac.symbol }} {{ contact.zodiac.name }}
                                        </div>
                                        <!-- Actions -->
                                        <div class="mt-2 space-x-2">
                                            <a 
                                                :href="`/contacts/${contact.id}`" 
                                                class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200"
                                            >
                                                View
                                            </a>
                                            <a 
                                                :href="`/contacts/${contact.id}/edit`" 
                                                class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded hover:bg-blue-200"
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
                    <div v-else class="text-center py-12">
                        <div class="text-4xl mb-4">👥</div>
                        <p class="text-gray-500 mb-4 text-lg">No contacts yet</p>
                        <p class="text-gray-400 text-sm mb-6">Start building your contact list</p>
                        <a 
                            href="/contacts/create" 
                            class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors font-medium"
                        >
                            Add Your First Contact
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
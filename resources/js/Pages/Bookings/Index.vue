<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'


const props = defineProps({
    bookings: Array
})


const bookingList = ref([...props.bookings])


const form = ref({
    customer_name: '',
    yacht_name: '',
    start_date: '',
    end_date: '',
    price: 0
})


const successMessage = ref('')
const errorMessage = ref('')

watch([() => form.value.start_date, () => form.value.end_date], () => {
    if (form.value.start_date && form.value.end_date) {
        const start = new Date(form.value.start_date)
        const end = new Date(form.value.end_date)
        const diffDays = Math.ceil((end - start) / (1000*60*60*24)) + 1
        form.value.price = diffDays > 0 ? diffDays * 50 : 0
    } else {
        form.value.price = 0
    }
})

const submit = async () => {
    successMessage.value = ''
    errorMessage.value = ''

    try {
        const res = await axios.post('/bookings', form.value)
        bookingList.value.push(res.data)

        form.value.customer_name = ''
        form.value.yacht_name = ''
        form.value.start_date = ''
        form.value.end_date = ''
        form.value.price = 0

        successMessage.value = 'Booking created successfully!'
        setTimeout(() => successMessage.value = '', 3000)
    } catch (err) {
        errorMessage.value = 'Failed to create booking!'
        setTimeout(() => errorMessage.value = '', 3000)
    }
}
</script>

<template>

    <div class="min-h-screen bg-red-100 flex items-center justify-center">
        <h1 class="text-4xl font-bold text-red-500">Hello Tailwind!</h1>
    </div>
    <div class="max-w-5xl mx-auto py-12 px-6 bg-gray-50 min-h-screen">
        <h1 class="color-red text-4xl font-bold text-center text-gray-800 mb-10">📅 Yacht Bookings</h1>

        <transition name="fade">
            <div v-if="successMessage" class="mb-4 p-4 rounded-xl bg-green-50 border border-green-300 text-green-800 text-center shadow-sm">
                {{ successMessage }}
            </div>
        </transition>

        <transition name="fade">
            <div v-if="errorMessage" class="mb-4 p-4 rounded-xl bg-red-50 border border-red-300 text-red-800 text-center shadow-sm">
                {{ errorMessage }}
            </div>
        </transition>

        <div class="overflow-x-auto mb-10">
            <table class="min-w-full bg-white rounded-xl shadow-md overflow-hidden">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-gray-600 font-medium">Customer</th>
                    <th class="px-6 py-3 text-left text-gray-600 font-medium">Yacht</th>
                    <th class="px-6 py-3 text-center text-gray-600 font-medium">Start Date</th>
                    <th class="px-6 py-3 text-center text-gray-600 font-medium">End Date</th>
                    <th class="px-6 py-3 text-right text-gray-600 font-medium">Price ($)</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                <tr v-for="booking in bookingList" :key="booking.id" class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-gray-700">{{ booking.customer_name }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ booking.yacht_name }}</td>
                    <td class="px-6 py-4 text-center text-gray-700">{{ booking.start_date }}</td>
                    <td class="px-6 py-4 text-center text-gray-700">{{ booking.end_date }}</td>
                    <td class="px-6 py-4 text-right text-gray-700 font-semibold">${{ booking.price }}</td>
                </tr>
                <tr v-if="!bookingList.length">
                    <td colspan="5" class="px-6 py-4 text-center text-gray-400">No bookings yet</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add a New Booking</h2>
            <form @submit.prevent="submit" class="grid gap-4">
                <input v-model="form.customer_name" type="text" placeholder="Customer Name"
                       class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"/>
                <input v-model="form.yacht_name" type="text" placeholder="Yacht Name"
                       class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"/>
                <div class="grid grid-cols-2 gap-4">
                    <input v-model="form.start_date" type="date"
                           class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"/>
                    <input v-model="form.end_date" type="date"
                           class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"/>
                </div>

                <div class="text-right font-semibold text-gray-700 text-lg">Price: ${{ form.price }}</div>

                <button type="submit"
                        class="bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 transition-colors font-medium shadow-md">
                    Save Booking
                </button>
            </form>
        </div>
    </div>
</template>

<style>

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>

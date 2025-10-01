<x-layout>
    <x-slot:heading>
        صفحة المواعيد
    </x-slot:heading>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 dark:bg-gray-600 shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-right font-semibold">المعرّف</th>
                            <th class="px-4 py-3 text-right font-semibold">اسم المريض</th>
                            <th class="px-4 py-3 text-right font-semibold">اسم الطبيب</th>
                            <th class="px-4 py-3 text-right font-semibold">التاريخ</th>
                            <th class="px-4 py-3 text-right font-semibold">النوع</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                        @foreach ($appointments as $appointment)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                                    {{ $appointment->id }}</td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                                    {{ $appointment->patient->fName }}
                                    {{ $appointment->patient->father_name }} {{ $appointment->patient->lName }}
                                </td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                                    {{ $appointment->doctor->fName }}
                                    {{ $appointment->doctor->lName }}
                                </td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                                    {{ $appointment->date }}</td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                                    {{ $appointment->is_follow_up ? 'موعد للمراجعة' : 'موعد جديد' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>

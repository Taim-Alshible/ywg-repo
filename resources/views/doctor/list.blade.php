<x-layout>
    <x-slot:heading>
        صفحة الأطباء
    </x-slot:heading>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 dark:bg-gray-600 shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-right font-semibold">المعرّف</th>
                            <th class="px-4 py-3 text-right font-semibold">الاسم الأول</th>
                            <th class="px-4 py-3 text-right font-semibold">اسم العائلة</th>
                            <th class="px-4 py-3 text-right font-semibold">رقم الهاتف</th>
                            <th class="px-4 py-3 text-right font-semibold">الاختصاص</th>
                            <th class="px-4 py-3 text-right font-semibold">الموقع</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                        @foreach ($doctors as $doctor)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">{{ $doctor->id }}
                                </td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">{{ $doctor->fName }}
                                </td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">{{ $doctor->lName }}
                                </td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">{{ $doctor->phone }}
                                </td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                                    {{ $doctor->specialty }}</td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                                    {{ $doctor->location }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>

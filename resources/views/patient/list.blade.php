<x-layout>
    <x-slot:heading>
        صفحة المرضى
    </x-slot:heading>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 dark:bg-gray-600 shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-right font-semibold">المعرّف</th>
                            <th class="px-4 py-3 text-right font-semibold">اسم المريض</th>
                            <th class="px-4 py-3 text-right font-semibold">رقم التواصل</th>
                            <th class="px-4 py-3 text-right font-semibold">العمر</th>
                            <th class="px-4 py-3 text-right font-semibold">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                        @foreach ($patients as $patient)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">{{ $patient->id }}
                                </td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                                    {{ $patient->fName }} {{ $patient->father_name }} {{ $patient->lName }}</td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                                    {{ $patient->phone }}</td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">{{ $patient->age }}
                                </td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700 space-x-2">
                                    <a href="{{ route('patient.show', $patient->id) }}"
                                        class="px-3 py-1 bg-teal-500 text-white rounded-md hover:bg-teal-600">
                                        تفاصيل
                                    </a>
                                    <form style="display:inline;" method="POST"
                                        action="{{ route('patient.destroy', $patient->id) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this patient?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-0.5 bg-rose-500 text-white rounded-md hover:bg-rose-600">
                                            حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>

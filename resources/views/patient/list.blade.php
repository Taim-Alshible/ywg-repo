<x-layout>
    <x-slot:heading>
        صفحة المرضى
    </x-slot:heading>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <form method="GET" action="{{ route('patient.search') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <label for="search" class="sr-only">بحث عن مريض</label>
                <div class="flex flex-1 flex-col gap-2 sm:flex-row sm:items-center">
                    <div class="flex flex-1 items-stretch rounded-md border border-teal-500 shadow-sm overflow-hidden">
                        <span class="flex items-center px-4 py-2 bg-teal-500 text-white font-semibold dark:bg-teal-600">بحث عن مريض</span>
                        <input id="search" name="search" type="text" value="{{ old('search', $searchTerm ?? '') }}"
                            placeholder="أدخل اسم المريض أو رقم الهاتف"
                            class="flex-1 px-3 py-2 border-0 bg-white text-gray-900 focus:ring-0 focus:outline-none dark:bg-gray-700 dark:text-gray-100" />
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                            class="px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            بحث
                        </button>
                        @if (!empty($searchTerm))
                            <a href="{{ route('patient.list') }}"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 dark:bg-gray-600 dark:text-gray-100 dark:hover:bg-gray-500">
                                إلغاء
                            </a>
                        @endif
                    </div>
                </div>
            </form>
            <div class="flex justify-end">
                <a href="{{ route('patient.pdf', array_filter(['search' => $searchTerm])) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3v12" />
                        <path d="M8 11l4 4 4-4" />
                        <path d="M4 19h16" />
                    </svg>
                    تحميل PDF
                </a>
            </div>
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
                        @forelse ($patients as $patient)
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
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-600 dark:text-gray-300">
                                    @if (!empty($searchTerm))
                                        لا توجد نتائج مطابقة لعبارة البحث المدخلة.
                                    @else
                                        لا توجد سجلات مرضى حالياً.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>

<x-layout>
    <x-slot:heading>
        صفحة الفحوصات
    </x-slot:heading>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 dark:bg-gray-600 shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-right font-semibold">المعرف</th>
                            <th class="px-4 py-3 text-right font-semibold">اسم المريض</th>
                            <th class="px-4 py-3 text-right font-semibold">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                        @foreach ($examinations as $examination)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                                    {{ $examination->id }}</td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                                    {{ $examination->patient->fName }}
                                    {{ $examination->patient->father_name }} {{ $examination->patient->lName }}
                                </td>
                                <td class="px-4 py-2 border-t border-gray-200 dark:border-gray-700 space-x-2">
                                    <a href="{{ route('examination.show', $examination->id) }}"
                                        class="px-3 py-1 bg-teal-500 text-white rounded-md hover:bg-teal-600">
                                        تفاصيل
                                    </a>
                                    <form style="display:inline;" method="POST"
                                        action="{{ route('examination.destroy', $examination->id) }}"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا الفحص؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-rose-500 text-white rounded-md hover:bg-rose-600">
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

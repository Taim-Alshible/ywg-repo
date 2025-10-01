<x-layout>
    <x-slot:heading>
        إضافة فحص طبي
    </x-slot:heading>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc text-red-600 dark:text-red-400 pr-5" dir="rtl">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('examination.store', $patient) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                    <div class="space-y-2 text-right" dir="rtl">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                            المريض: {{ $patient->fName }} {{ $patient->father_name }} {{ $patient->lName }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300">
                            املأ التفاصيل الخاصة بالفحص الطبي الجديد.
                        </p>
                    </div>

                    <div class="text-right" dir="rtl">
                        <label for="specialty" class="block font-medium text-gray-700 dark:text-gray-300">
                            التخصص
                        </label>
                        <input type="text" id="specialty" name="specialty"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                            value="{{ old('specialty') }}" required>
                    </div>

                    <div class="text-right" dir="rtl">
                        <label for="image" class="block font-medium text-gray-700 dark:text-gray-300">
                            صورة الفحص الطبي
                        </label>
                        <input type="file" id="image" name="image"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100" required>
                    </div>

                    <div class="flex items-center space-x-2 justify-end" dir="rtl">
                        <label for="delivered" class="text-gray-700 dark:text-gray-300">تم التسليم</label>
                        <input type="checkbox" id="delivered" name="delivered" value="1"
                            class="rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600"
                            {{ old('delivered') ? 'checked' : '' }}>
                    </div>

                    <div class="flex justify-end space-x-2 pt-4" dir="rtl">
                        <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600">
                            حفظ النتيجة
                        </button>

                        <a href="{{ route('patient.show', $patient) }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            إلغاء
                        </a>
                    </div>
                </form>

             
                </div>
            </div>
        </div>
    </div>
</x-layout>

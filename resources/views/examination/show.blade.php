<x-layout>
    <x-slot:heading>
        Examination Details
    </x-slot:heading>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6">

                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4 border-b-2 pb-2">
                    Medical Test for {{ $examination->patient->fName }} {{ $examination->patient->father_name }}
                    {{ $examination->patient->lName }}
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 text-gray-700 dark:text-gray-200">
                    <div class="space-y-4">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                            <span class="font-semibold">Specialty:</span>
                            <p>{{ $examination->specialty ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                            <span class="font-semibold">Delivered:</span>
                            <p class="{{ $examination->delivered ? 'text-green-500' : 'text-red-500' }}">
                                {{ $examination->delivered ? 'Yes' : 'No' }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <div
                            class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm h-full flex flex-col justify-center">
                            <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-100">Medical Image</h3>
                            @if ($examination->image)
                                <img src="{{ asset('storage/' . $examination->image) }}" alt="Medical Test Image"
                                    class="rounded-lg shadow-md w-full max-h-80 object-contain">
                            @else
                                <p class="text-gray-500">No image available.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Analyses Section --}}
                <div class="mt-8 border-t-2 pt-4">
                    <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-100">Patient Analyses</h3>
                    @if ($examination->analyses->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($examination->analyses as $analysis)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm flex flex-col h-full">
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="font-semibold text-lg text-gray-800 dark:text-gray-100">
                                                {{ $analysis->name }}
                                            </span>
                                            <span class="text-gray-600 dark:text-gray-300">
                                                Cost: {{ $analysis->cost }}
                                            </span>
                                        </div>

                                        @if ($analysis->file)
                                            <img src="{{ asset('storage/' . $analysis->file) }}" alt="Analysis File"
                                                class="rounded-md shadow-sm w-full mt-2">
                                        @else
                                            <p class="text-gray-500 text-sm mt-2">No file available for this analysis.
                                            </p>
                                        @endif

                                        @if ($analysis->note)
                                            <p class="text-gray-600 dark:text-gray-300 mt-2">
                                                <span class="font-semibold">Note:</span> {{ $analysis->note }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No analyses found for this examination.</p>
                    @endif
                </div>
                {{-- radiology section --}}
                <div class="mt-8 border-t-2 pt-4">
                    <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-100">Patient Radiologies</h3>
                    @if ($examination->radiologies->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($examination->radiologies as $radiology)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm flex flex-col h-full">
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="font-semibold text-lg text-gray-800 dark:text-gray-100">
                                                {{ $radiology->radiology_name }}
                                            </span>
                                            <span class="text-gray-600 dark:text-gray-300">
                                                Cost: {{ $radiology->radiology_cost }}
                                            </span>
                                        </div>

                                        @if ($radiology->radiology_file)
                                            <img src="{{ asset('storage/' . $radiology->radiology_file) }}"
                                                alt="Analysis File" class="rounded-md shadow-sm w-full mt-2">
                                        @else
                                            <p class="text-gray-500 text-sm mt-2">No file available for this analysis.
                                            </p>
                                        @endif

                                        @if ($radiology->radiology_note)
                                            <p class="text-gray-600 dark:text-gray-300 mt-2">
                                                <span class="font-semibold">Note:</span>
                                                {{ $radiology->radiology_note }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No radiologies found for this examination.</p>
                    @endif
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('examination.list') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Back
                    </a>
                </div>
                <div x-data="{ open: false }" class="mt-6">
                    <button @click="open = true"
                        class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600">
                        إضافة تحليل
                    </button>

                    <div x-show="open" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">

                        <div @click.away="open = false"
                            class="bg-white dark:bg-gray-800 shadow-lg rounded-lg w-full max-w-2xl p-6 relative">

                            <button @click="open = false"
                                class="absolute top-2 left-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                ✖
                            </button>

                            <form action="{{ route('analysis.store', $examination) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <input type="hidden" name="examination_id" value="{{ $examination->id }}">

                                <div class="text-right" dir="rtl">
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                                        إضافة تحليل جديد
                                    </h2>
                                    <p class="text-gray-600 dark:text-gray-300">املأ تفاصيل التحليل للمريض.</p>
                                </div>

                                <div class="text-right" dir="rtl">
                                    <label for="name" class="block font-medium text-gray-700 dark:text-gray-300">
                                        اسم التحليل
                                    </label>
                                    <input type="text" id="name" name="name"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        value="{{ old('name') }}" required>
                                </div>

                                <div class="text-right" dir="rtl">
                                    <label for="file" class="block font-medium text-gray-700 dark:text-gray-300">
                                        ملف التحليل الطبي
                                    </label>
                                    <input type="file" id="file" name="file"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                                </div>

                                <div class="text-right" dir="rtl">
                                    <label for="cost" class="block font-medium text-gray-700 dark:text-gray-300">
                                        تكلفة التحليل
                                    </label>
                                    <input type="text" id="cost" name="cost"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        value="{{ old('cost') }}" required>
                                </div>

                                <div class="text-right" dir="rtl">
                                    <label for="note" class="block font-medium text-gray-700 dark:text-gray-300">
                                        ملاحظة
                                    </label>
                                    <input type="text" id="note" name="note"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        value="{{ old('note') }}">
                                </div>

                                <div class="flex justify-end space-x-2 pt-4" dir="rtl">
                                    <button type="submit"
                                        class="px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600">
                                        حفظ التحليل
                                    </button>
                                    <button type="button" @click="open = false"
                                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                        إلغاء
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div x-data="{ openRadiology: false }" class="mt-6">
                    <button @click="openRadiology = true"
                        class="px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-600">
                        إضافة صور اشعة
                    </button>

                    <div x-show="openRadiology" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">

                        <div @click.away="openRadiology = false"
                            class="bg-white dark:bg-gray-800 shadow-lg rounded-lg w-full max-w-2xl p-6 relative">

                            <button @click="openRadiology = false"
                                class="absolute top-2 left-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                ✖
                            </button>

                            <form action="{{ route('radiology.store', $examination) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <input type="hidden" name="examination_id" value="{{ $examination->id }}">

                                <div class="text-right" dir="rtl">
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                                        إضافة صور اشعة جديدة
                                    </h2>
                                    <p class="text-gray-600 dark:text-gray-300">املأ تفاصيل صور الأشعة للمريض.</p>
                                </div>

                                <div class="text-right" dir="rtl">
                                    <label for="radiology_name"
                                        class="block font-medium text-gray-700 dark:text-gray-300">
                                        اسم الأشعة
                                    </label>
                                    <input type="text" id="radiology_name" name="radiology_name"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        value="{{ old('radiology_name') }}" required>
                                </div>

                                <div class="text-right" dir="rtl">
                                    <label for="radiology_file"
                                        class="block font-medium text-gray-700 dark:text-gray-300">
                                        ملف صور الأشعة
                                    </label>
                                    <input type="file" id="radiology_file" name="radiology_file"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                </div>

                                <div class="text-right" dir="rtl">
                                    <label for="radiology_cost"
                                        class="block font-medium text-gray-700 dark:text-gray-300">
                                        تكلفة الأشعة
                                    </label>
                                    <input type="text" id="radiology_cost" name="radiology_cost"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        value="{{ old('radiology_cost') }}" required>
                                </div>


                                <div class="text-right" dir="rtl">
                                    <label for="radiology_note"
                                        class="block font-medium text-gray-700 dark:text-gray-300">
                                        ملاحظة
                                    </label>
                                    <input type="text" id="radiology_note" name="radiology_note"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        value="{{ old('radiology_note') }}">
                                </div>

                                <div class="flex justify-end space-x-2 pt-4" dir="rtl">
                                    <button type="submit"
                                        class="px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600">
                                        حفظ صور الأشعة
                                    </button>
                                    <button type="button" @click="openRadiology = false"
                                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                        إلغاء
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-layout>

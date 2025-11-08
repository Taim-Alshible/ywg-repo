<x-layout>
    <x-slot:heading>
        تفاصيل الفحص الطبي
    </x-slot:heading>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- تم تغيير 'bg-white' إلى 'bg-gray-200' ليماثل لون اليد الرمادية الفاتحة --}}
            <div class="bg-gray-200 dark:bg-gray-800 shadow-md rounded-2xl p-6" dir="rtl">

                {{-- تم تحديث لون التكلفة الإجمالية إلى الفيروزي (teal) --}}
                <div class="flex justify-between items-start border-b-2 pb-2 mb-4">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                        فحص طبي للمريض: {{ $examination->patient->fName }}
                        {{ $examination->patient->father_name }}
                        {{ $examination->patient->lName }}
                    </h2>
                    {{-- Total Cost --}}
                    <div class="text-left">
                        {{-- 'text-indigo-600' تم استبداله بـ 'text-teal-600' --}}
                        <span class="font-semibold text-xl text-teal-600 dark:text-teal-400">
                            التكلفة الإجمالية:

                            {{ $examination->cost + $examination->analyses->sum('cost') + $examination->radiologies->sum('radiology_cost') }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 text-gray-700 dark:text-gray-200">
                    <div class="space-y-4">
                        {{-- تم تغيير 'bg-gray-50' إلى 'bg-gray-100' لتقليل التباين قليلًا --}}
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                            <span class="font-semibold">التخصص:</span>
                            <p>{{ $examination->specialty ?? 'غير محدد' }}</p>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                            <span class="font-semibold">تكلفة الفحص :
                                {{ $examination->cost }}</span>
                        </div>
                    </div>

                    <div>
                        <div
                            class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl shadow-sm h-full flex flex-col justify-center">
                            <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-100">صورة الفحص</h3>
                            @if ($examination->image)
                                <img src="{{ asset('storage/' . $examination->image) }}" alt="صورة الفحص الطبي"
                                    class="rounded-lg shadow-md w-full max-h-80 object-contain">
                            @else
                                <p class="text-gray-500">لا توجد صورة متاحة.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Analyses Section --}}
                <div class="mt-8 border-t-2 pt-4">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">نتائج
                        تحاليل المريض</h3>
                    @if ($examination->analyses->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($examination->analyses as $analysis)
                                {{-- تم تغيير 'bg-gray-50' إلى 'bg-gray-100' --}}
                                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl shadow-sm flex flex-col h-full">
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="font-semibold text-lg text-gray-800 dark:text-gray-100">
                                                {{ $analysis->name }}
                                            </span>
                                            <span class="text-gray-600 dark:text-gray-300">
                                                التكلفة:
                                                {{ $analysis->cost }}
                                            </span>
                                        </div>

                                        @if ($analysis->file)
                                            <img src="{{ asset('storage/' . $analysis->file) }}" alt="ملف التحليل"
                                                class="rounded-md shadow-sm w-full mt-2">
                                        @else
                                            <p class="text-gray-500 text-sm mt-2">لا يوجد ملف متاح لهذا التحليل.
                                            </p>
                                        @endif

                                        @if ($analysis->note)
                                            <p class="text-gray-600 dark:text-gray-300 mt-2">
                                                <span class="font-semibold">ملاحظة:</span> {{ $analysis->note }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">لم يتم العثور على تحاليل لهذا الفحص.</p>

                    @endif
                </div>

                {{-- radiology section --}}
                <div class="mt-8 border-t-2 pt-4">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">صور
                        الأشعة للمريض</h3>
                    @if ($examination->radiologies->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($examination->radiologies as $radiology)
                                {{-- تم تغيير 'bg-gray-50' إلى 'bg-gray-100' --}}
                                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl shadow-sm flex flex-col h-full">
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="font-semibold text-lg text-gray-800 dark:text-gray-100">

                                                {{ $radiology->radiology_name }}
                                            </span>
                                            <span class="text-gray-600 dark:text-gray-300">
                                                التكلفة:
                                                {{ $radiology->radiology_cost }}
                                            </span>
                                        </div>

                                        @if ($radiology->radiology_file)
                                            <img src="{{ asset('storage/' . $radiology->radiology_file) }}"
                                                alt="ملف الأشعة" class="rounded-md shadow-sm w-full mt-2">
                                        @else
                                            <p class="text-gray-500 text-sm mt-2">لا يوجد ملف متاح لهذه الأشعة.
                                            </p>
                                        @endif

                                        @if ($radiology->radiology_note)
                                            <p class="text-gray-600 dark:text-gray-300 mt-2">
                                                <span class="font-semibold">ملاحظة:</span>

                                                {{ $radiology->radiology_note }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">لم يتم العثور على صور أشعة لهذا الفحص.</p>

                    @endif
                </div>

                <div class="mt-6 flex justify-start space-x-4 space-x-reverse">
                    <div class="mt-6 flex justify-start">
                        {{-- العودة بلون رمادي ثابت --}}
                        <a href="{{ route('examination.list') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                            العودة
                        </a>
                    </div>

                    <div x-data="{ open: false }" class="mt-6">
                        {{-- تم تغيير 'bg-indigo-500' إلى 'bg-teal-500' للون الفيروزي --}}
                        <button @click="open = true"
                            class="px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600">
                            إضافة تحليل
                        </button>

                        <div x-show="open" x-cloak
                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">

                            <div @click.away="open = false"
                                class="bg-white dark:bg-gray-800 shadow-lg rounded-lg w-full max-w-2xl p-6 relative"
                                dir="rtl">

                                <button @click="open = false"
                                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                    ✖
                                </button>

                                <form action="{{ route('analysis.store', $examination) }}" method="POST"
                                    enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="examination_id" value="{{ $examination->id }}">

                                    <div class="text-right">
                                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                                            إضافة تحليل جديد
                                        </h2>
                                        <p class="text-gray-600 dark:text-gray-300">املأ تفاصيل التحليل للمريض.</p>
                                    </div>

                                    <div class="text-right">
                                        <label for="name"
                                            class="block font-medium text-gray-700 dark:text-gray-300">
                                            اسم التحليل
                                        </label>
                                        <input type="text" id="name" name="name"
                                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                            value="{{ old('name') }}" required>
                                    </div>

                                    <div class="text-right">
                                        <label for="file"
                                            class="block font-medium text-gray-700 dark:text-gray-300">
                                            ملف التحليل الطبي (صورة)
                                        </label>
                                        <input type="file" id="file" name="file"
                                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                                    </div>

                                    <div class="text-right">
                                        <label for="cost"
                                            class="block font-medium text-gray-700 dark:text-gray-300">
                                            تكلفة التحليل
                                        </label>
                                        <input type="text" id="cost" name="cost"
                                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                            value="{{ old('cost') }}" required>
                                    </div>

                                    <div class="text-right">
                                        <label for="note"
                                            class="block font-medium text-gray-700 dark:text-gray-300">
                                            ملاحظة
                                        </label>
                                        <input type="text" id="note" name="note"
                                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                            value="{{ old('note') }}">
                                    </div>

                                    <div class="flex justify-start space-x-2 space-x-reverse pt-4">
                                        {{-- تم تغيير 'bg-teal-500' إلى لون مختلف لتمييزه عن زر الفتح (اخترنا اللون الأخضر للحفظ) --}}
                                        <button type="submit"
                                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
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
                        {{-- تم تغيير 'bg-purple-500' إلى 'bg-teal-500' للون الفيروزي --}}
                        <button @click="openRadiology = true"
                            class="px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600">
                            إضافة صور أشعة
                        </button>

                        <div x-show="openRadiology" x-cloak
                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">

                            <div @click.away="openRadiology = false"
                                class="bg-white dark:bg-gray-800 shadow-lg rounded-lg w-full max-w-2xl p-6 relative"
                                dir="rtl">

                                <button @click="openRadiology = false"
                                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                    ✖
                                </button>

                                <form action="{{ route('radiology.store', $examination) }}" method="POST"
                                    enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="examination_id" value="{{ $examination->id }}">

                                    <div class="text-right">
                                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                                            إضافة صور أشعة جديدة
                                        </h2>
                                        <p class="text-gray-600 dark:text-gray-300">املأ تفاصيل صور الأشعة للمريض.</p>
                                    </div>

                                    <div class="text-right">
                                        <label for="radiology_name"
                                            class="block font-medium text-gray-700 dark:text-gray-300">
                                            اسم الأشعة
                                        </label>
                                        <input type="text" id="radiology_name" name="radiology_name"
                                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                            value="{{ old('radiology_name') }}" required>
                                    </div>

                                    <div class="text-right">
                                        <label for="radiology_file"
                                            class="block font-medium text-gray-700 dark:text-gray-300">
                                            ملف صور الأشعة (صورة)
                                        </label>
                                        <input type="file" id="radiology_file" name="radiology_file"
                                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                            required>
                                    </div>

                                    <div class="text-right">
                                        <label for="radiology_cost"
                                            class="block font-medium text-gray-700 dark:text-gray-300">
                                            تكلفة الأشعة
                                        </label>
                                        <input type="text" id="radiology_cost" name="radiology_cost"
                                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                            value="{{ old('radiology_cost') }}" required>
                                    </div>

                                    <div class="text-right">
                                        <label for="radiology_note"
                                            class="block font-medium text-gray-700 dark:text-gray-300">
                                            ملاحظة
                                        </label>
                                        <input type="text" id="radiology_note" name="radiology_note"
                                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                            value="{{ old('radiology_note') }}">
                                    </div>

                                    <div class="flex justify-start space-x-2 space-x-reverse pt-4">
                                        {{-- تم تغيير 'bg-teal-500' إلى لون مختلف لتمييزه عن زر الفتح (اخترنا اللون الأخضر للحفظ) --}}
                                        <button type="submit"
                                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                            حفظ صور الأشعة
                                        </button>
                                        <button type="button" @click="openRadiology = false"
                                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                            إلغاء
                                        </button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout>

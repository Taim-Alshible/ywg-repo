<x-layout>
    <x-slot:heading>
        تفاصيل المستفيد
    </x-slot:heading>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">
                    {{ $beneficiary->fName }} {{ $beneficiary->father_name }} {{ $beneficiary->lName }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-200">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                        <span class="font-semibold">📞 الهاتف:</span>
                        <p>{{ $beneficiary->phone ?? 'غير متوفر' }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                        <span class="font-semibold">📍 الرقم الوطني:</span>
                        <p>{{ $beneficiary->nationalNum ?? 'غير متوفر' }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                        <span class="font-semibold">العمر:</span>
                        <p>{{ $beneficiary->nationalNum ?? 'غير متوفر' }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                        <span class="font-semibold">📍 العنوان:</span>
                        <p>{{ $beneficiary->location ?? 'غير متوفر' }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                        <span class="font-semibold">👥 عدد أفراد الأسرة:</span>
                        <p>{{ $beneficiary->numOfPeople }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                        <span class="font-semibold">📍 القياس:</span>
                        <p>{{ $beneficiary->size ?? 'غير متوفر' }}</p>
                    </div>
                </div>

                <h3 class="text-xl font-semibold mt-6 mb-2 text-gray-800 dark:text-gray-100">أفراد الأسرة</h3>
                @if ($beneficiary->beneficiary_families->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($beneficiary->beneficiary_families as $member)
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl shadow">
                                <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $member->fName }}
                                    {{ $member->father_name }} {{ $member->lName }}</span>
                                <p class="text-gray-600 dark:text-gray-200">العمر: {{ $member->age }}</p>
                                <p class="text-gray-600 dark:text-gray-200">القياس: {{ $member->size }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">لا يوجد أفراد مسجلون في الأسرة.</p>
                @endif

                <h3 class="text-xl font-semibold mt-6 mb-2 text-gray-800 dark:text-gray-100">الاحتياجات</h3>
                @if ($beneficiary->needs->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($beneficiary->needs as $need)
                            @php
                                $priorityColor = match ($need->priority) {
                                    'high' => 'bg-rose-100 dark:bg-rose-700',
                                    'medium' => 'bg-yellow-100 dark:bg-yellow-700',
                                    default => 'bg-green-100 dark:bg-green-700',
                                };
                            @endphp
                            <div class="{{ $priorityColor }} p-4 rounded-xl shadow">
                                <span
                                    class="font-semibold text-gray-800 dark:text-gray-100">{{ $need->description }}</span>
                                <p class="text-gray-600 dark:text-gray-200">الأولوية:
                                    @if ($need->priority == 'high')
                                        عالية
                                    @elseif ($need->priority == 'medium')
                                        متوسطة
                                    @else
                                        عادية
                                    @endif
                                </p>
                                <p class="text-gray-600 dark:text-gray-200">الكمية:
                                    {{ $need->quantity ?? 'غير محددة' }}</p>
                                <p class="text-gray-600 dark:text-gray-200">الحالة:
                                    @if ($need->delivered)
                                        تم توفيرها
                                    @else
                                        قيد الانتظار
                                    @endif
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">لا يوجد احتياجات مسجلة لهذا المستفيد.</p>
                @endif

                <div class="mt-6 flex space-x-3" dir="rtl" x-data="{ addFamilyMember: false, addNeed: false }">
                    <button @click="addFamilyMember = true"
                        class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600">
                        ➕ إضافة فرد أسرة
                    </button>
                    <button @click="addNeed = true"
                        class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600">
                        ➕ إضافة احتياج
                    </button>
                    <a href="{{ route('beneficiary.list') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        عودة
                    </a>

                    {{-- نموذج إضافة فرد أسرة --}}
                    <div x-show="addFamilyMember" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg w-full max-w-md">
                            <h3 class="text-xl font-semibold mb-4">إضافة فرد أسرة</h3>
                            <form action="{{ route('family.store', $beneficiary) }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="beneficiary_id" value="{{ $beneficiary->id }}">
                                <div>
                                    <label class="block font-medium">الاسم الأول</label>
                                    <input type="text" name="fName"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                </div>
                                <div>
                                    <label class="block font-medium"> اسم الأب</label>
                                    <input type="text" name="father_name"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                </div>
                                <div>
                                    <label class="block font-medium">اسم العائلة</label>
                                    <input type="text" name="lName"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                </div>
                                <div>
                                    <label class="block font-medium">العمر</label>
                                    <input type="number" name="age"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                                </div>
                                <div>
                                    <label class="block font-medium">القياس</label>
                                    <input type="text" name="size"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" @click="addFamilyMember = false"
                                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                                        إلغاء
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600">
                                        حفظ
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div x-show="addNeed" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg w-full max-w-md">
                            <h3 class="text-xl font-semibold mb-4">إضافة احتياج</h3>
                            <form action="{{ route('need.store', $beneficiary) }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="beneficiary_id" value="{{ $beneficiary->id }}">

                                {{--  هذا هو الحقل المحدث  --}}
                                <div>
                                    <label class="block font-medium">اسم الاحتياج</label>
                                    <select name="description"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                        <option value="" disabled selected>اختر احتياجًا...</option>
                                        @foreach ($needsList as $needOption)
                                            <option value="{{ $needOption->need_name }}">{{ $needOption->need_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block font-medium">الأولوية</label>
                                    <select name="priority"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                                        <option value="low">عادية</option>
                                        <option value="medium">متوسطة</option>
                                        <option value="high">عالية</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-medium">الحالة</label>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_fulfilled" value="1" id="is_fulfilled"
                                            class="rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500 mr-2">
                                        <label for="is_fulfilled" class="font-medium">تم توفيره</label>
                                    </div>
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" @click="addNeed = false"
                                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                                        إلغاء
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600">
                                        حفظ
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

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
                        <span class="font-semibold">🎂 العمر:</span>
                        <p>{{ $beneficiary->age ?? 'غير متوفر' }}</p>
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
                        <span class="font-semibold">📏 القياس:</span>
                        <p>{{ $beneficiary->size ?? 'غير متوفر' }}</p>
                    </div>
                </div>

                <div class="mt-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm"
                    x-data="{
                        delivered: {{ json_encode((bool) $beneficiary->delivered) }},
                        togglingDelivered: false,
                        toggleDelivered() {
                            if (this.togglingDelivered) {
                                return;
                            }

                            this.togglingDelivered = true;

                            fetch('{{ route('api.beneficiary.toggle-delivered', $beneficiary) }}', {
                                method: 'PATCH',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({})
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.delivered !== undefined) {
                                        this.delivered = !!data.delivered;
                                    } else {
                                        console.error('API response error:', data);
                                    }
                                })
                                .catch(err => {
                                    console.error('Fetch error:', err);
                                })
                                .finally(() => {
                                    this.togglingDelivered = false;
                                });
                        }
                    }">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-gray-800 dark:text-gray-100">تم التسليم للمستفيد</span>
                        <label class="inline-flex items-center space-x-2">
                            <input type="checkbox"
                                :checked="delivered"
                                :disabled="togglingDelivered"
                                @click.prevent="toggleDelivered()"
                                class="rounded border-gray-400 dark:border-gray-500 dark:bg-gray-700 focus:ring-cyan-500">
                            <span x-text="delivered ? 'تم التسليم' : 'لم يتم التسليم'"></span>
                        </label>
                    </div>
                </div>

                <div class="mt-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm"
                    x-data="{
                        checked: {{ json_encode((bool) $beneficiary->checked) }},
                        toggling: false,
                        toggle() {
                            if (this.toggling) {
                                return;
                            }

                            this.toggling = true;

                            fetch('{{ route('api.beneficiary.toggle-checked', $beneficiary) }}', {
                                method: 'PATCH',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({})
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.checked !== undefined) {
                                        this.checked = !!data.checked;
                                    } else {
                                        console.error('API response error:', data);
                                    }
                                })
                                .catch(err => {
                                    console.error('Fetch error:', err);
                                })
                                .finally(() => {
                                    this.toggling = false;
                                });
                        }
                    }">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-gray-800 dark:text-gray-100">حالة التحقق</span>
                        <label class="inline-flex items-center space-x-2">
                            <input type="checkbox"
                                :checked="checked"
                                :disabled="toggling"
                                @click.prevent="toggle()"
                                class="rounded border-gray-400 dark:border-gray-500 dark:bg-gray-700 focus:ring-cyan-500">
                            <span x-text="checked ? 'تم التحقق' : 'غير متحقق'"></span>
                        </label>
                    </div>
                </div>

                <h3 class="text-xl font-semibold mt-6 mb-2 text-gray-800 dark:text-gray-100">أفراد الأسرة</h3>
                @if ($beneficiary->beneficiary_families->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($beneficiary->beneficiary_families as $member)
                            <div class="bg-cyan-100 dark:bg-cyan-700 p-4 rounded-xl shadow flex flex-col gap-2">
                                <span class="font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $member->fName }} {{ $member->father_name }} {{ $member->lName }}
                                </span>
                                <p class="text-gray-600 dark:text-gray-200">العمر: {{ $member->age ?? 'غير محدد' }}</p>
                                <p class="text-gray-600 dark:text-gray-200">القياس: {{ $member->size ?? 'غير محدد' }}</p>
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
                                $priorityValue = $need->pivot->priority ?? 'low';
                                $priorityKey = trim($priorityValue);
                                $priorityColor = match ($priorityKey) {
                                    'high' => 'bg-rose-100 dark:bg-rose-700',
                                    'medium' => 'bg-yellow-100 dark:bg-yellow-700',
                                    default => 'bg-cyan-100 dark:bg-cyan-700',
                                };
                            @endphp
                            <div class="{{ $priorityColor }} p-4 rounded-xl shadow flex flex-col justify-between">
                                <div>
                                    <span class="font-semibold text-gray-800 dark:text-gray-100 block">{{ $need->name }}</span>
                                    <p class="text-gray-600 dark:text-gray-200">الكمية: {{ $need->pivot->quantity ?? 'غير محددة' }}</p>
                                    <p class="text-gray-600 dark:text-gray-200">الأولوية:
                                        @if ($priorityKey === 'high')
                                            عالية
                                        @elseif ($priorityKey === 'medium')
                                            متوسطة
                                        @else
                                            عادية
                                        @endif
                                    </p>
                                </div>

                                <div x-data="() => ({
                                    delivered: {{ $need->pivot->delivered ? 'true' : 'false' }},
                                    toggling: false,
                                    toggle() {
                                        if (this.toggling) {
                                            return;
                                        }

                                        this.toggling = true;

                                        fetch('{{ route('api.need.toggle-delivered', [$beneficiary, $need]) }}', {
                                            method: 'PATCH',
                                            headers: {
                                                'Accept': 'application/json',
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'X-Requested-With': 'XMLHttpRequest'
                                            },
                                            body: JSON.stringify({})
                                        })
                                            .then(res => res.json())
                                            .then(data => {
                                                if (data.delivered !== undefined) {
                                                    this.delivered = !!data.delivered;
                                                } else {
                                                    console.error('API response error:', data.error);
                                                }
                                            })
                                            .catch(err => console.error('Fetch error:', err))
                                            .finally(() => {
                                                this.toggling = false;
                                            });
                                    }
                                })" class="mt-4 flex justify-end">
                                    <button type="button" @click.prevent="toggle()"
                                        :class="{ 'bg-teal-500': delivered, 'bg-rose-500': !delivered }"
                                        class="px-3 py-1 rounded-lg font-medium text-white">
                                        <span x-text="delivered ? 'تم التسليم' : 'لم يتم التسليم'"></span>
                                    </button>
                                </div>
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
                                    <select name="need_id" {{-- 👈 يجب أن يكون need_id وليس description --}}
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                        <option value="" disabled selected>اختر احتياجًا...</option>
                                        @foreach ($needsList as $needOption)
                                            <option value="{{ $needOption->id }}"> {{-- 👈 يجب إرسال ID الاحتياج وليس الاسم --}}
                                                {{ $needOption->name }}
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
                                {{-- <div>
                                    <label class="block font-medium">الحالة</label>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_fulfilled" value="1" id="is_fulfilled"
                                            class="rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500 mr-2">
                                        <label for="is_fulfilled" class="font-medium">تم توفيره</label>
                                    </div>
                                </div> --}}
                                <div>
                                    <label class="block font-medium">الكمية</label>
                                    <textarea name="quantity" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"></textarea>
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
    </div>
</x-layout>

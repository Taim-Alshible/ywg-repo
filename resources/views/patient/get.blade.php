<x-layout>
    <x-slot:heading>
        تفاصيل المريض
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
                    {{ $patient->fName }} {{ $patient->father_name }} {{ $patient->lName }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-200">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                        <span class="font-semibold">📞 الهاتف:</span>
                        <p>{{ $patient->phone ?? 'غير متوفر' }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                        <span class="font-semibold">📍 الموقع:</span>
                        <p>{{ $patient->location ?? 'غير متوفر' }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                        <span class="font-semibold">🎂 العمر:</span>
                        <p>{{ $patient->age ?? 'غير متوفر' }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                        <span class="font-semibold">👨‍⚕️ يحتاج طبيب:</span>
                        <p>{{ $patient->needDoctor ? 'نعم' : 'لا' }}</p>
                    </div>
                    @if ($patient->needDoctor)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow-sm md:col-span-2">
                            <span class="font-semibold">🏥 التخصص:</span>
                            <p>{{ $patient->specialty ?? 'غير محدد' }}</p>
                        </div>
                    @endif
                </div>

                <h3 class="text-xl font-semibold mt-6 mb-2 text-gray-800 dark:text-gray-100">الأدوية</h3>
                @if ($patient->medicines->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($patient->medicines->sortByDesc('priority') as $medicine)
                            @php
                                $priorityColor = match ($medicine->priority) {
                                    'high' => 'bg-rose-100 dark:bg-rose-700',
                                    'medium' => 'bg-yellow-100 dark:bg-yellow-700',
                                    default => 'bg-cyan-100 dark:bg-cyan-700',
                                };
                            @endphp
                            <div class="{{ $priorityColor }} p-4 rounded-xl shadow flex flex-col justify-between">
                                <div>
                                    <span
                                        class="font-semibold text-gray-800 dark:text-gray-100">{{ $medicine->name }}</span>
                                    <p class="text-gray-600 dark:text-gray-200">({{ $medicine->titer ?? 'بدون جرعة' }})
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-200">الكمية:
                                        {{ $medicine->quantity ?? 'غير متوفرة' }}</p>
                                    <p class="text-gray-600 dark:text-gray-200">الأولوية:
                                        @if ($medicine->priority == 'high')
                                            مرتفعة
                                        @elseif ($medicine->priority == 'medium')
                                            متوسطة
                                        @else
                                            منخفضة
                                        @endif
                                    </p>
                                </div>
                                <div x-data="{ delivered: {{ $medicine->delivered ? 'true' : 'false' }} }" class="mt-2 flex justify-between items-center">
                                    <span
                                        @click="
                                        fetch('{{ route('api.medicine.toggle-delivered', $medicine) }}', {
                                            method: 'PATCH',
                                            headers: {
                                                'Accept': 'application/json',
                                                'Content-Type': 'application/json'
                                            }
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                            if (data.delivered !== undefined) {
                                                delivered = data.delivered;
                                            } else {
                                                console.error('API response error:', data.error);
                                            }
                                        })
                                        .catch(err => console.error('Fetch error:', err))
                                    "
                                        :class="{ 'bg-teal-500': delivered, 'bg-rose-500': !delivered }"
                                        class="cursor-pointer px-2 py-1 rounded-lg font-medium text-white">
                                        <span x-text="delivered ? 'تم التسليم' : 'لم يتم التسليم'"></span>
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">لا يوجد أدوية لهذا المريض.</p>
                @endif

                <h3 class="text-xl font-semibold mt-6 mb-2 text-gray-800 dark:text-gray-100">المواعيد</h3>
                @if ($patient->appointments->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($patient->appointments as $appointment)
                            <div class="bg-cyan-100 dark:bg-cyan-700 p-4 rounded-xl shadow">
                                <span class="font-semibold text-gray-800 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y h:i A') }}
                                </span>
                                <p class="text-gray-600 dark:text-gray-200">
                                    الطبيب: {{ $appointment->doctor->fName }} {{ $appointment->doctor->lName }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-200">
                                    الاختصاص: {{ $appointment->doctor->specialty }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-200">
                                    الحالة: {{ $appointment->is_follow_up ? 'موعد للمراجعة' : 'موعد جديد' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">لا يوجد مواعيد لهذا المريض.</p>
                @endif

                <div class="mt-6 flex space-x-3" x-data="{ addMedicine: false, addAppointment: false }">
                    <button @click="addMedicine = true"
                        class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600">
                        ➕ إضافة دواء
                    </button>
                    @if ($patient->needDoctor)
                        <button @click="addAppointment = true"
                            class="px-4 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600">
                            📅 إضافة موعد
                        </button>
                    @endif
                    <a href="{{ route('examination.create', $patient) }}"
                        class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600">
                        ➕ إضافة فحص طبي
                    </a>
                    <a href="{{ route('patient.list') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        عودة
                    </a>

                    {{-- نموذج إضافة دواء --}}
                    <div x-show="addMedicine" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg w-full max-w-md">
                            <h3 class="text-xl font-semibold mb-4">إضافة دواء</h3>
                            <form action="{{ route('medicine.store', $patient) }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                <div>
                                    <label class="block font-medium">اسم الدواء</label>
                                    <input type="text" name="name"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                </div>
                                <div>
                                    <label class="block font-medium">العيار</label>
                                    <input type="text" name="titer"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                </div>
                                <div>
                                    <label class="block font-medium">الكمية</label>
                                    <textarea name="quantity" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"></textarea>
                                </div>
                                <div>
                                    <label class="block font-medium">الأولوية</label>
                                    <select name="priority"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                                        <option value="low">منخفضة</option>
                                        <option value="medium">متوسطة</option>
                                        <option value="high">مرتفعة</option>
                                    </select>
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" @click="addMedicine = false"
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

                    {{-- نموذج إضافة موعد --}}
                    <div x-show="addAppointment" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg w-full max-w-md">
                            <h3 class="text-xl font-semibold mb-4">إضافة موعد</h3>
                            <form action="{{ route('appointment.store', $patient) }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                <div>
                                    <label class="block font-medium">التاريخ</label>
                                    <input type="date" name="date"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                </div>
                                <div>
                                    <label class="block font-medium">الوقت</label>
                                    <input type="time" name="time"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_follow_up" value="1" id="is_follow_up"
                                            class="rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-cyan-500 mr-2">
                                        <label for="is_follow_up" class="font-medium">هل هو موعد للمراجعة؟</label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block font-medium">اختر الطبيب</label>
                                    <select name="doctor_id"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">
                                                {{ $doctor->fName }} - {{ $doctor->lName }} - {{ $doctor->location }}
                                                - ({{ $doctor->specialty }}) - {{ $doctor->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" @click="addAppointment = false"
                                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                                        إلغاء
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600">
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

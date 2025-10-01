<x-layout>
    <x-slot:heading>
        صفحة إضافة مستفيد
    </x-slot:heading>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 dark:bg-gray-600 shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc text-rose-600 dark:text-rose-400 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('beneficiary.store') }}" method="POST"
                    class="space-y-4 text-gray-800 dark:text-white">
                    @csrf

                    <div>
                        <label class="block font-medium">الاسم الأول</label>
                        <input type="text" name="fName"
                            class="w-full rounded-md border-gray-400 dark:border-gray-500 bg-white dark:bg-gray-700 dark:text-gray-100 focus:border-cyan-500 focus:ring-cyan-500"
                            value="{{ old('fName') }}">
                    </div>

                    <div>
                        <label class="block font-medium">اسم الأب</label>
                        <input type="text" name="father_name"
                            class="w-full rounded-md border-gray-400 dark:border-gray-500 bg-white dark:bg-gray-700 dark:text-gray-100 focus:border-cyan-500 focus:ring-cyan-500"
                            value="{{ old('father_name') }}">
                    </div>

                    <div>
                        <label class="block font-medium">اسم العائلة</label>
                        <input type="text" name="lName"
                            class="w-full rounded-md border-gray-400 dark:border-gray-500 bg-white dark:bg-gray-700 dark:text-gray-100 focus:border-cyan-500 focus:ring-cyan-500"
                            value="{{ old('lName') }}">
                    </div>

                    <div>
                        <label class="block font-medium">رقم الهاتف</label>
                        <input type="text" name="phone"
                            class="w-full rounded-md border-gray-400 dark:border-gray-500 bg-white dark:bg-gray-700 dark:text-gray-100 focus:border-cyan-500 focus:ring-cyan-500"
                            value="{{ old('phone') }}">
                    </div>

                    <div>
                        <label class="block font-medium">الرقم الوطني</label>
                        <input type="text" name="nationalNum"
                            class="w-full rounded-md border-gray-400 dark:border-gray-500 bg-white dark:bg-gray-700 dark:text-gray-100 focus:border-cyan-500 focus:ring-cyan-500"
                            value="{{ old('nationalNum') }}">
                    </div>

                    <div>
                        <label class="block font-medium">العمر</label>
                        <input type="number" name="age"
                            class="w-full rounded-md border-gray-400 dark:border-gray-500 bg-white dark:bg-gray-700 dark:text-gray-100 focus:border-cyan-500 focus:ring-cyan-500"
                            value="{{ old('age') }}">
                    </div>

                    <div>
                        <label class="block font-medium">الموقع</label>
                        <input type="text" name="location"
                            class="w-full rounded-md border-gray-400 dark:border-gray-500 bg-white dark:bg-gray-700 dark:text-gray-100 focus:border-cyan-500 focus:ring-cyan-500"
                            value="{{ old('location') }}">
                    </div>

                    <div>
                        <label class="block font-medium">عدد الأفراد</label>
                        <input type="number" name="numOfPeople"
                            class="w-full rounded-md border-gray-400 dark:border-gray-500 bg-white dark:bg-gray-700 dark:text-gray-100 focus:border-cyan-500 focus:ring-cyan-500"
                            value="{{ old('numOfPeople') }}">
                    </div>

                    <div>
                        <label class="block font-medium">الحجم</label>
                        <input type="text" name="size"
                            class="w-full rounded-md border-gray-400 dark:border-gray-500 bg-white dark:bg-gray-700 dark:text-gray-100 focus:border-cyan-500 focus:ring-cyan-500"
                            value="{{ old('size') }}">
                    </div>

                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="delivered" value="1"
                            class="rounded border-gray-400 dark:border-gray-500 dark:bg-gray-700 focus:ring-cyan-500"
                            {{ old('delivered') ? 'checked' : '' }}>
                        <label>تم التسليم</label>
                    </div>

                    <div>
                        <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600">
                            حفظ
                        </button>
                        <a href="{{ route('beneficiary.list') }}"
                            class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            إلغاء
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-layout>

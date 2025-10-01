<x-layout>
    <x-slot:heading>
        Create Patient Page
    </x-slot:heading>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                <!-- Errors -->
                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc text-red-600 dark:text-red-400 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('patient.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium">First Name</label>
                        <input type="text" name="fName"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                            value="{{ old('fName') }}">
                    </div>

                    <div>
                        <label class="block font-medium">Father Name</label>
                        <input type="text" name="father_name"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                            value="{{ old('father_name') }}">
                    </div>

                    <div>
                        <label class="block font-medium">Last Name</label>
                        <input type="text" name="lName"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                            value="{{ old('lName') }}">
                    </div>

                    <div>
                        <label class="block font-medium">Phone</label>
                        <input type="text" name="phone"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                            value="{{ old('phone') }}">
                    </div>

                    <div>
                        <label class="block font-medium">Location</label>
                        <input type="text" name="location"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                            value="{{ old('location') }}">
                    </div>
                    <div>
                        <label class="block font-medium">Age</label>
                        <input type="number" name="age"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                            value="{{ old('age') }}">
                    </div>
                    <div>
                        <label class="block font-medium">Need Doctor</label>
                        <input type="checkbox" name="needDoctor" value="1"
                            class="rounded border-gray-300 dark:bg-gray-700" {{ old('needDoctor') ? 'checked' : '' }}>
                        <label>Need Doctor</label>
                    </div>
                    <div>
                        <label class="block font-medium">specialty</label>
                        <input type="text" name="specialty"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                            value="{{ old('specialty') }}">
                    </div>

                    <div>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Save
                        </button>
                        <a href="{{ route('patient.list') }}"
                            class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-layout>

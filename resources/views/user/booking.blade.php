@extends('design.header')

@section('content')
    <div class="flex items-center justify-center min-h-screen">
        <div
            class="flex flex-col lg:flex-row gap-6 bg-white dark:bg-gray-800 shadow-lg border border-gray-300 rounded-lg p-6 sm:p-8 w-full max-w-5xl">
            <!-- Room Details and Picture -->
            <div class="w-full lg:w-1/2">
                <h3 class="mb-4 text-lg font-medium leading-none text-gray-900 dark:text-white">Room Details</h3>
                <div class="mb-4">
                    <img src="{{ asset('images/lake-sebu.jpg') }}" alt="Room Image" class="w-full rounded-lg">
                </div>
                <div>
                    <p class="text-gray-900 dark:text-white mb-2">Room Name: {{ $room->name }}</p>
                    <p class="text-gray-900 dark:text-white mb-2">Desription: {{ $room->description }}</p>
                    <p class="text-gray-900 dark:text-white mb-2">Room Price: ₱{{ $room->price }}</p>

                </div>
            </div>
            <!-- Form and Stepper -->
            <div class="w-full lg:w-1/2">
                <!-- Stepper -->




                <div
                    class="p-4 bg-gray-50 justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <form id="first-step-form" action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        <div class="mt-4">
                            <label for="name" class="block text-gray-700">Name</label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name', auth()->user()->name) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div class="mt-4">
                            <label for="email" class="block text-gray-700">Email</label>
                            <input type="text" id="email" name="email"
                                value="{{ old('email', auth()->user()->email) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div class="mt-4">
                            <label for="contactNo" class="block text-gray-700">Contact Number</label>
                            <input type="text" id="contact_no" name="contact_no"
                                value="{{ old('contact_no', auth()->user()->userInfo->contactNo ?? '') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div class="mt-4">
                            <label for="visitor" class="block text-gray-700">Number of Visitors</label>
                            <input type="text" id="number_of_visitors" name="number_of_visitors"
                                value="{{ old('number_of_visitors') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div id="date-range-picker"
                            class="flex flex-col sm:flex-row items-center mt-4 space-y-4 sm:space-y-0 sm:space-x-4">
                            <div class="relative w-full sm:w-auto flex-1">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 mt-5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <label for="datepicker-range-start" class="block text-gray-700 dark:text-gray-400">Check-In
                                    Date</label>
                                <input id="datepicker-range-start" name="check_in_date" type="text"
                                    value="{{ old('check_in_date') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Select Check-In date">
                            </div>
                            <div class="relative w-full sm:w-auto flex-1 mt-2 sm:mt-0">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 mt-5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <label for="datepicker-range-end" class="block text-gray-700 dark:text-gray-400">Check-Out
                                    Date</label>
                                <input id="datepicker-range-end" name="check_out_date" type="text"
                                    value="{{ old('check_out_date') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Select Check-Out date">
                            </div>
                        </div>

                        <!-- End First Content -->

                        <!-- Second Content -->

                        <div class="mb-4">
                            <label for="payment" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Payment
                                Amount</label>
                            <input type="number" name="payment" id="payment"
                                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="image"class="block text-lg font-medium text-gray-700 dark:text-gray-300">Proof of
                                Payment</label>
                            <input type="file" class="filepond" name="image" multiple credits="false" />
                        </div>
                        <div class="flex justify-center items-center space-x-5">
                            <button type="submit"
                                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                                Submit
                            </button>
                            <a href="{{ url()->previous() }}" type="button"
                                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-white text-gray-700 hover:bg-red-700 hover:text-white disabled:opacity-50 disabled:pointer-events-none">
                                Cancel
                            </a>
                        </div>
                </div>
                </form>
            </div>
        </div>

    </div>
    </div>
@endsection

@extends('design.header')
@section('content')
    @include('design.navbar')


    <div class="md:mt-20 md:mx-[13%] mx-5 mt-20 flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
        <!-- Info Sidebar -->
        <div class="w-full space-y-4 md:w-1/4 hidden md:block">
            <!-- Photo Sidebar -->
            <div class="rounded-md p-4 flex flex-col items-center justify-center bg-white border shadow-md">
                <div class="w-20 h-20 border-4 border-gray-200 rounded-full">
                    <img src="{{ $user->userInfo && $user->userInfo->profilePath ? asset('storage/images/' . $user->userInfo->profilePath) : asset('images/default-avatar.png') }}"
                        alt="Profile Photo" class="rounded-full w-full h-full object-cover">
                </div>
                <div class="mt-2">
                    <p class="text-lg font-semibold text-center">{{ $user->name }}</p>
                </div>
            </div>

            <div class="rounded-md bg-white border border-gray-300 shadow-3 p-4">
                <div class="flex justify-between items-center">
                    <p class="text-lg">Details</p>
                    <div class="relative inline-block text-left" x-data="{ open: false }">
                        <button @click="open = !open" class="rounded px-2 py-2 text-black">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-4 space-y-2">
                    <p><i class="fas fa-envelope mr-2"></i>Email: {{ $user->email }}</p>
                    <p><i class="fas fa-phone mr-2"></i>Contact No: {{ $user->userInfo->contactNo ?? '' }}</p>
                    <p><i class="fas fa-map-marker-alt mr-2"></i>Address: {{ $user->userInfo->address ?? '' }}</p>
                    <p><i class="fas fa-info-circle mr-2"></i>Description: {{ $user->userInfo->description ?? '' }}</p>
                </div>
            </div>
        </div>

        <div class="w-full space-y-4 md:flex-1">
            <!-- Stepper -->
            <div
                class="flex items-center rounded-md justify-between bg-white border border-gray-200 shadow-md p-4 space-x-5 md:space-x-32">
                <a href="#" class="nav-link text-gray-600 text-lg font-semibold flex flex-col items-center relative"
                    id="step1" onclick="showStep('step1')">
                    <i class="fas fa-clock"></i>
                    <span class="md:inline">Pending</span>
                    @if ($pendingCount > 0)
                        <span
                            class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $pendingCount }}</span>
                    @endif
                </a>
                <a href="#" class="nav-link text-gray-600 text-lg font-semibold flex flex-col items-center relative"
                    id="step2" onclick="showStep('step2')">
                    <i class="fas fa-check md:hidden"></i>
                    <span class="md:inline">Accept</span>
                    @if ($acceptCount > 0)
                        <span
                            class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $acceptCount }}</span>
                    @endif
                </a>
                <a href="#" class="nav-link text-gray-600 text-lg font-semibold flex flex-col items-center relative"
                    id="step3" onclick="showStep('step3')">
                    <i class="fas fa-star md:hidden"></i>
                    <span class="md:inline">Review</span>
                    @if ($reviewCount > 0)
                        <span
                            class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $reviewCount }}</span>
                    @endif
                </a>
                <a href="#" class="nav-link text-gray-600 text-lg font-semibold flex flex-col items-center relative"
                    id="step4" onclick="showStep('step4')">
                    <i class="fas fa-times md:hidden"></i>
                    <span class="md:inline">Cancel</span>
                    @if ($cancelCount > 0)
                        <span
                            class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cancelCount }}</span>
                    @endif
                </a>
            </div>




            <!-- Stepper Content -->
            <div class="rounded-md">

                {{-- Pending booking --}}
                <div id="step1-content"class=" step-content">
                    @php
                        $hasPendingBookings = false;
                    @endphp

                    @foreach ($bookings as $booking)
                        @if ($booking->status == 'Pending')
                            @php
                                $hasPendingBookings = true;
                            @endphp
                            <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 mb-4">
                                <div class="flex justify-between items-center mb-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="bg-gray-200 p-1 rounded-full w-14 h-14">
                                            <img src="{{ $booking->resort && $booking->resort->userInfo && $booking->resort->userInfo->profilePath ? asset('storage/images/' . $booking->resort->userInfo->profilePath) : asset('images/default-avatar.jpg') }}"
                                                alt="Hotel Logo" class="rounded-full w-full h-full object-cover">
                                        </div>
                                        <div>

                                            <div class="flex items-center space-x-2">
                                                <button class="text-black py-1 px-3 font-semibold text-lg rounded-md">
                                                    {{ $booking->resort ? $booking->resort->name : 'Unknown Resort' }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 text-green-600">
                                        @if ($booking->resort)
                                            <a href="{{ route('resort.profiles', $booking->resort->name) }}"
                                                class="bg-gray-100 text-black py-1 px-3 rounded-md border">
                                                View Resort
                                            </a>
                                        @else
                                            <span class="bg-gray-100 text-black py-1 px-3 rounded-md border">
                                                View Resort
                                            </span>
                                        @endif
                                        <p></p>
                                        <span class="text-red-600"></span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between space-x-4 mb-4">
                                    <div class="flex items-center">
                                        @if ($booking->room->images->isNotEmpty())
                                            <img src="{{ asset('storage/images/' . $booking->room->images->first()->path) }}"
                                                alt="Room Image" class="rounded-md w-20 h-20 object-cover">
                                        @else
                                            <img src="https://via.placeholder.com/80" alt="Room Image"
                                                class="rounded-md w-20 h-20 object-cover">
                                        @endif
                                        <div class="ml-4">
                                            <p class="font-semibold">{{ $booking->room->name }}</p>
                                            <p class="text-gray-600">{{ $booking->room->description }}</p>
                                        </div>
                                    </div>
                                    <div
                                        class="ml-auto text-black bg-orange-300 px-2 rounded-full text-lg font-semibold mt-4 md:mt-0 md:ml-4">
                                        <p>{{ $booking->status }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-black text-lg font-semibold">
                                        <p>₱{{ $booking->room->price }}</p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <button class="flex flex-col items-center justify-center rounded-md p-2">
                                            <svg width="25px" height="25px" viewBox="0 0 32 32" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd" sketch:type="MSPage">
                                                    <g id="Icon-Set" sketch:type="MSLayerGroup"
                                                        transform="translate(-204.000000, -255.000000)" fill="#000000">
                                                        <path
                                                            d="M228,267 C226.896,267 226,267.896 226,269 C226,270.104 226.896,271 228,271 C229.104,271 230,270.104 230,269 C230,267.896 229.104,267 228,267 L228,267 Z M220,281 C218.832,281 217.704,280.864 216.62,280.633 L211.912,283.463 L211.975,278.824 C208.366,276.654 206,273.066 206,269 C206,262.373 212.268,257 220,257 C227.732,257 234,262.373 234,269 C234,275.628 227.732,281 220,281 L220,281 Z M220,255 C211.164,255 204,261.269 204,269 C204,273.419 206.345,277.354 210,279.919 L210,287 L217.009,282.747 C217.979,282.907 218.977,283 220,283 C228.836,283 236,276.732 236,269 C236,261.269 228.836,255 220,255 L220,255 Z M212,267 C210.896,267 210,267.896 210,269 C210,270.104 210.896,271 212,271 C213.104,271 214,270.104 214,269 C214,267.896 213.104,267 212,267 L212,267 Z M220,267 C218.896,267 218,267.896 218,269 C218,270.104 218.896,271 220,271 C221.104,271 222,270.104 222,269 C222,267.896 221.104,267 220,267 L220,267 Z"
                                                            id="comment-3" sketch:type="MSShapeGroup"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <div class="text-xs">
                                                Contact Resort
                                            </div>
                                        </button>
                                        <form action="{{ route('booking.cancel', $booking->id) }}" method="POST">
                                            @csrf
                                            <button type="button"data-modal-target="cancel-modal"
                                                data-modal-toggle="cancel-modal"
                                                class="bg-gray-200 hover:bg-red-500 text-black hover:text-white py-2 px-4 rounded-md">
                                                Cancel
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- Cancel Modal --}}
                        <div id="cancel-modal" tabindex="-1"
                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-lg max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">Cancel Booking</h3>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="cancel-modal">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <form action="{{ route('booking.cancel', $booking->id) }}" method="POST">
                                        @csrf
                                        <div class="p-4 md:p-5 space-y-4">
                                            <label for="reason"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason
                                                for Cancellation</label>
                                            <textarea id="reason" name="reason" rows="4"
                                                class="block w-full p-2.5 mt-1 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Enter your reason for cancellation..."></textarea>
                                        </div>
                                        <!-- Modal footer -->
                                        <div
                                            class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                            <button data-modal-hide="cancel-modal" type="submit"
                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I
                                                accept</button>
                                            <button data-modal-hide="cancel-modal" type="button"
                                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if (!$hasPendingBookings)
                        <div class="flex items-center justify-center">
                            <h2 class="text-lg">No booking Yet</h2>
                        </div>
                    @endif
                </div>


                {{-- Accept booking --}}
                <div id="step2-content"class=" step-content">
                    @php
                        $hasPendingBookings = false;
                    @endphp

                    @foreach ($bookings as $booking)
                        @if ($booking->status == 'Accept')
                            @php
                                $hasPendingBookings = true;
                            @endphp
                            <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 mb-4">
                                <div class="flex justify-between items-center mb-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="bg-gray-200 p-1 rounded-full w-14 h-14">
                                            <img src="{{ $booking->resort && $booking->resort->userInfo && $booking->resort->userInfo->profilePath ? asset('storage/images/' . $booking->resort->userInfo->profilePath) : asset('images/default-avatar.jpg') }}"
                                                alt="Hotel Logo" class="rounded-full w-full h-full object-cover">
                                        </div>
                                        <div>

                                            <div class="flex items-center space-x-2">
                                                <button class="text-black py-1 px-3 font-semibold text-lg rounded-md">
                                                    {{ $booking->resort ? $booking->resort->name : 'Unknown Resort' }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 text-green-600">
                                        @if ($booking->resort)
                                            <a href="{{ route('resort.profiles', $booking->resort->name) }}"
                                                class="bg-gray-100 text-black py-1 px-3 rounded-md border">
                                                View Resort
                                            </a>
                                        @else
                                            <span class="bg-gray-100 text-black py-1 px-3 rounded-md border">
                                                View Resort
                                            </span>
                                        @endif
                                        <p></p>
                                        <span class="text-red-600"></span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between space-x-4 mb-4">
                                    <div class="flex items-center">
                                        @if ($booking->room->images->isNotEmpty())
                                            <img src="{{ asset('storage/images/' . $booking->room->images->first()->path) }}"
                                                alt="Room Image" class="rounded-md w-20 h-20 object-cover">
                                        @else
                                            <img src="https://via.placeholder.com/80" alt="Room Image"
                                                class="rounded-md w-20 h-20 object-cover">
                                        @endif
                                        <div class="ml-4">
                                            <p class="font-semibold">{{ $booking->room->name }}</p>
                                            <p class="text-gray-600">{{ $booking->room->description }}</p>
                                        </div>
                                    </div>
                                    <div
                                        class="ml-auto text-black bg-green-300 px-2 rounded-full text-lg font-semibold mt-4 md:mt-0 md:ml-4">
                                        <p>{{ $booking->status }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-black text-lg font-semibold">
                                        <p>₱{{ $booking->room->price }}</p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <button class="flex flex-col items-center justify-center rounded-md p-2">
                                            <svg width="25px" height="25px" viewBox="0 0 32 32" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd" sketch:type="MSPage">
                                                    <g id="Icon-Set" sketch:type="MSLayerGroup"
                                                        transform="translate(-204.000000, -255.000000)" fill="#000000">
                                                        <path
                                                            d="M228,267 C226.896,267 226,267.896 226,269 C226,270.104 226.896,271 228,271 C229.104,271 230,270.104 230,269 C230,267.896 229.104,267 228,267 L228,267 Z M220,281 C218.832,281 217.704,280.864 216.62,280.633 L211.912,283.463 L211.975,278.824 C208.366,276.654 206,273.066 206,269 C206,262.373 212.268,257 220,257 C227.732,257 234,262.373 234,269 C234,275.628 227.732,281 220,281 L220,281 Z M220,255 C211.164,255 204,261.269 204,269 C204,273.419 206.345,277.354 210,279.919 L210,287 L217.009,282.747 C217.979,282.907 218.977,283 220,283 C228.836,283 236,276.732 236,269 C236,261.269 228.836,255 220,255 L220,255 Z M212,267 C210.896,267 210,267.896 210,269 C210,270.104 210.896,271 212,271 C213.104,271 214,270.104 214,269 C214,267.896 213.104,267 212,267 L212,267 Z M220,267 C218.896,267 218,267.896 218,269 C218,270.104 218.896,271 220,271 C221.104,271 222,270.104 222,269 C222,267.896 221.104,267 220,267 L220,267 Z"
                                                            id="comment-3" sketch:type="MSShapeGroup"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <div class="text-xs">
                                                Contact Resort
                                            </div>
                                        </button>
                                        <form action="{{ route('booking.cancel', $booking->id) }}" method="POST">
                                            @csrf
                                            <button type="button"data-modal-target="cancel-modal"
                                                data-modal-toggle="cancel-modal"
                                                class="bg-gray-200 hover:bg-red-500 text-black hover:text-white py-2 px-4 rounded-md">
                                                Cancel
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- Cancel Modal --}}
                        <div id="cancel-modal" tabindex="-1"
                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-lg max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">Cancel Booking</h3>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="cancel-modal">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <form action="{{ route('booking.cancel', $booking->id) }}" method="POST">
                                        @csrf
                                        <div class="p-4 md:p-5 space-y-4">
                                            <label for="reason"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason
                                                for Cancellation</label>
                                            <textarea id="reason" name="reason" rows="4"
                                                class="block w-full p-2.5 mt-1 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Enter your reason for cancellation..."></textarea>
                                        </div>
                                        <!-- Modal footer -->
                                        <div
                                            class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                            <button data-modal-hide="cancel-modal" type="submit"
                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I
                                                accept</button>
                                            <button data-modal-hide="cancel-modal" type="button"
                                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if (!$hasPendingBookings)
                        <div class="flex items-center justify-center">
                            <h2 class="text-lg">No booking Yet</h2>
                        </div>
                    @endif
                </div>
                {{-- Check out  --}}
                <div id="step3-content" class="step-content">
                    @php
                        $hasPendingBookings = false;
                    @endphp

                    @foreach ($bookings as $booking)
                        @if ($booking->status == 'Check Out')
                            @php
                                $hasPendingBookings = true;
                                $userReview = $booking->room->reviews->where('user_id', $user->id)->first();
                            @endphp
                            <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 mb-4">
                                <div class="flex justify-between items-center mb-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="bg-gray-200 p-1 rounded-full w-14 h-14">
                                            <img src="{{ $booking->resort && $booking->resort->userInfo && $booking->resort->userInfo->profilePath ? asset('storage/images/' . $booking->resort->userInfo->profilePath) : asset('images/default-avatar.jpg') }}"
                                                alt="Hotel Logo" class="rounded-full w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <div class="flex items-center space-x-2">
                                                <button class="text-black py-1 px-3 font-semibold text-lg rounded-md">
                                                    {{ $booking->resort ? $booking->resort->name : 'Unknown Resort' }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 text-green-600">
                                        @if ($booking->resort)
                                            <a href="{{ route('resort.profiles', $booking->resort->name) }}"
                                                class="bg-gray-100 text-black py-1 px-3 rounded-md border">
                                                View Resort
                                            </a>
                                        @else
                                            <span class="bg-gray-100 text-black py-1 px-3 rounded-md border">
                                                View Resort
                                            </span>
                                        @endif
                                        <p></p>
                                        <span class="text-red-600"></span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between space-x-4 mb-4">
                                    <div class="flex items-center">
                                        @if ($booking->room->images->isNotEmpty())
                                            <img src="{{ asset('storage/images/' . $booking->room->images->first()->path) }}"
                                                alt="Room Image" class="rounded-md w-20 h-20 object-cover">
                                        @else
                                            <img src="https://via.placeholder.com/80" alt="Room Image"
                                                class="rounded-md w-20 h-20 object-cover">
                                        @endif
                                        <div class="ml-4">
                                            <p class="font-semibold">{{ $booking->room->name }}</p>
                                            <p class="text-gray-600">{{ $booking->room->description }}</p>
                                        </div>
                                    </div>
                                    <div
                                        class="ml-auto text-black bg-yellow-300 px-2 rounded-full text-lg font-semibold mt-4 md:mt-0 md:ml-4">
                                        <p>Review</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-black text-lg font-semibold">
                                        <p>₱{{ $booking->room->price }}</p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <button class="flex flex-col items-center justify-center rounded-md p-2">
                                            <svg width="25px" height="25px" viewBox="0 0 32 32" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd" sketch:type="MSPage">
                                                    <g id="Icon-Set" sketch:type="MSLayerGroup"
                                                        transform="translate(-204.000000, -255.000000)" fill="#000000">
                                                        <path
                                                            d="M228,267 C226.896,267 226,267.896 226,269 C226,270.104 226.896,271 228,271 C229.104,271 230,270.104 230,269 C230,267.896 229.104,267 228,267 L228,267 Z M220,281 C218.832,281 217.704,280.864 216.62,280.633 L211.912,283.463 L211.975,278.824 C208.366,276.654 206,273.066 206,269 C206,262.373 212.268,257 220,257 C227.732,257 234,262.373 234,269 C234,275.628 227.732,281 220,281 L220,281 Z M220,255 C211.164,255 204,261.269 204,269 C204,273.419 206.345,277.354 210,279.919 L210,287 L217.009,282.747 C217.979,282.907 218.977,283 220,283 C228.836,283 236,276.732 236,269 C236,261.269 228.836,255 220,255 L220,255 Z M212,267 C210.896,267 210,267.896 210,269 C210,270.104 210.896,271 212,271 C213.104,271 214,270.104 214,269 C214,267.896 213.104,267 212,267 L212,267 Z M220,267 C218.896,267 218,267.896 218,269 C218,270.104 218.896,271 220,271 C221.104,271 222,270.104 222,269 C222,267.896 221.104,267 220,267 L220,267 Z"
                                                            id="comment-3" sketch:type="MSShapeGroup"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <div class="text-xs">
                                                Contact Resort
                                            </div>
                                        </button>

                                        @if ($userReviews[$booking->id])
                                            <span class="bg-green-100 text-green-600 py-2 px-4 rounded-md">Thank you for
                                                your feedback</span>
                                        @else
                                            <button type="button"
                                                data-modal-target="review-modal-{{ $booking->room->id }}"
                                                data-modal-toggle="review-modal-{{ $booking->room->id }}"
                                                class="bg-gray-200 hover:bg-blue-500 text-black hover:text-white py-2 px-4 rounded-md">
                                                Review
                                            </button>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Review Modal --}}
                        @if (!$userReviews[$booking->id])
                            <div id="review-modal-{{ $booking->room->id }}" tabindex="-1"
                                class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-lg max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-medium text-gray-900 dark:text-white">Review Room</h3>
                                            <button type="button"
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="review-modal-{{ $booking->room->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5">
                                            <form action="{{ route('reviews.store', $booking->room->id) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                                <input type="hidden" name="room_id" value="{{ $booking->room->id }}">
                                                <input type="hidden" name="resort_id" value="{{ $booking->room->user_id }}">
                                                <div class="form-group mb-4">
                                                    <label for="review"
                                                        class="block text-sm font-medium text-gray-700 mb-4">Feedback:</label>
                                                    <textarea name="review" id="review"
                                                        class="form-control p-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                        required></textarea>
                                                </div>
                                                <div x-data="{ rating: 0 }" class="form-group mb-4">
                                                    <label for="rating"
                                                        class="block text-sm font-medium text-gray-700">Rating:</label>
                                                    <div class="flex justify-center items-center space-x-4">
                                                        <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                                                            <i :class="{
                                                                'fas fa-star text-yellow-500': rating >= star,
                                                                'far fa-star text-gray-400': rating < star
                                                            }"
                                                                class="cursor-pointer text-2xl"
                                                                @click="rating = star"></i>
                                                        </template>
                                                    </div>
                                                    <input type="hidden" name="rating" x-model="rating" required>
                                                </div>
                                                <button type="submit"
                                                    class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if (!$hasPendingBookings)
                        <div class="flex items-center justify-center">
                            <h2 class="text-lg">No booking Yet</h2>
                        </div>
                    @endif
                </div>

                {{-- Cancel  --}}
                <div id="step4-content"class=" step-content">
                    @php
                        $hasPendingBookings = false;
                    @endphp

                    @foreach ($bookings as $booking)
                        @if ($booking->status == 'Cancel')
                            @php
                                $hasPendingBookings = true;
                            @endphp
                            <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 mb-4">
                                <div class="flex justify-between items-center mb-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="bg-gray-200 p-1 rounded-full w-14 h-14">
                                            <img src="{{ $booking->resort && $booking->resort->userInfo && $booking->resort->userInfo->profilePath ? asset('storage/images/' . $booking->resort->userInfo->profilePath) : asset('images/default-avatar.jpg') }}"
                                                alt="Hotel Logo" class="rounded-full w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <div class="flex items-center space-x-2">
                                                <button class="text-black py-1 px-3 font-semibold text-lg rounded-md">
                                                    {{ $booking->resort ? $booking->resort->name : 'Unknown Resort' }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 text-green-600">
                                        @if ($booking->resort)
                                            <a href="{{ route('resort.profiles', $booking->resort->name) }}"
                                                class="bg-gray-100 text-black py-1 px-3 rounded-md border">
                                                View Resort
                                            </a>
                                        @else
                                            <span class="bg-gray-100 text-black py-1 px-3 rounded-md border">
                                                View Resort
                                            </span>
                                        @endif
                                        <p></p>
                                        <span class="text-red-600"></span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between space-x-4 mb-4">
                                    <div class="flex items-center">
                                        @if ($booking->room->images->isNotEmpty())
                                            <img src="{{ asset('storage/images/' . $booking->room->images->first()->path) }}"
                                                alt="Room Image" class="rounded-md w-20 h-20 object-cover">
                                        @else
                                            <img src="https://via.placeholder.com/80" alt="Room Image"
                                                class="rounded-md w-20 h-20 object-cover">
                                        @endif
                                        <div class="ml-4">
                                            <p class="font-semibold">{{ $booking->room->name }}</p>
                                            <p class="text-gray-600">{{ $booking->room->description }}</p>
                                        </div>
                                    </div>
                                    <div
                                        class="ml-auto text-black bg-red-500 px-2 rounded-full text-lg font-semibold mt-4 md:mt-0 md:ml-4">
                                        <p>Cancel</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-black text-lg font-semibold">
                                        <p>₱{{ $booking->room->price }}</p>
                                    </div>
                                    <div class="flex items-center space-x-4">

                                        <button class="flex flex-col items-center justify-center rounded-md p-2">
                                            <svg width="25px" height="25px" viewBox="0 0 32 32" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd" sketch:type="MSPage">
                                                    <g id="Icon-Set" sketch:type="MSLayerGroup"
                                                        transform="translate(-204.000000, -255.000000)" fill="#000000">
                                                        <path
                                                            d="M228,267 C226.896,267 226,267.896 226,269 C226,270.104 226.896,271 228,271 C229.104,271 230,270.104 230,269 C230,267.896 229.104,267 228,267 L228,267 Z M220,281 C218.832,281 217.704,280.864 216.62,280.633 L211.912,283.463 L211.975,278.824 C208.366,276.654 206,273.066 206,269 C206,262.373 212.268,257 220,257 C227.732,257 234,262.373 234,269 C234,275.628 227.732,281 220,281 L220,281 Z M220,255 C211.164,255 204,261.269 204,269 C204,273.419 206.345,277.354 210,279.919 L210,287 L217.009,282.747 C217.979,282.907 218.977,283 220,283 C228.836,283 236,276.732 236,269 C236,261.269 228.836,255 220,255 L220,255 Z M212,267 C210.896,267 210,267.896 210,269 C210,270.104 210.896,271 212,271 C213.104,271 214,270.104 214,269 C214,267.896 213.104,267 212,267 L212,267 Z M220,267 C218.896,267 218,267.896 218,269 C218,270.104 218.896,271 220,271 C221.104,271 222,270.104 222,269 C222,267.896 221.104,267 220,267 L220,267 Z"
                                                            id="comment-3" sketch:type="MSShapeGroup"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <div class="text-xs">
                                                Contact Resort
                                            </div>
                                        </button>

                                        {{-- <button type="button" data-modal-target="review-modal-{{ $booking->room->id }}"
                                            data-modal-toggle="review-modal-{{ $booking->room->id }}"
                                            class="bg-gray-200 hover:bg-red-500 text-black hover:text-white py-2 px-4 rounded-md">
                                            Delete
                                        </button> --}}

                                    </div>
                                </div>
                            </div>
                        @endif


                        {{-- Review Modal --}}
                        <div id="review-modal-{{ $booking->room->id }}" tabindex="-1"
                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-lg max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">Review Room</h3>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="review-modal-{{ $booking->room->id }}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5">
                                        <hr>

                                        <h2 class="text-lg font-semibold">Add a Review</h2>
                                        <form action="{{ route('reviews.store', $booking->room->id) }}" method="POST"
                                            class="mt-4">
                                            @csrf
                                            <div class="form-group mb-4">
                                                <label for="review"
                                                    class="block text-sm font-medium text-gray-700 mb-4">Review:</label>
                                                <textarea name="review" id="review"
                                                    class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    required></textarea>
                                            </div>
                                            <div x-data="{ rating: 0 }" class="form-group mb-4">
                                                <label for="rating"
                                                    class="block text-sm font-medium text-gray-700">Rating:</label>
                                                <div class="flex">
                                                    <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                                                        <i :class="{
                                                            'fas fa-star text-yellow-500': rating >=
                                                                star,
                                                            'far fa-star text-gray-400': rating < star
                                                        }"
                                                            class="cursor-pointer text-2xl" @click="rating = star">
                                                        </i>
                                                    </template>
                                                </div>
                                                <input type="hidden" name="rating" x-model="rating" required>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if (!$hasPendingBookings)
                        <div class="flex items-center justify-center">
                            <h2 class="text-lg">No booking Yet</h2>
                        </div>
                    @endif
                </div>
            </div>
        </div>


    </div>



    <script>
        function showStep(stepId) {
            const steps = ['step1', 'step2', 'step3', 'step4'];
            steps.forEach(step => {
                document.getElementById(step + '-content').classList.add('hidden');
                document.getElementById(step).classList.remove('text-blue-700', 'border-b-2', 'border-blue-700',
                    'bg-gray');
            });
            document.getElementById(stepId + '-content').classList.remove('hidden');
            document.getElementById(stepId).classList.add('text-blue-700', 'border-b-2', 'border-blue-700');

            // Save the current step in localStorage
            localStorage.setItem('currentStep', stepId);
        }

        // Initialize with the step visible based on localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const currentStep = localStorage.getItem('currentStep') || 'step1';
            showStep(currentStep);
        });
    </script>
@endsection

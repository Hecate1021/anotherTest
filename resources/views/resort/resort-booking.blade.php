@extends('design.header')


@section('content')
    @include('design.navbar')
    @include('design.sidebar')

    <div class="p-4 sm:ml-64 mt-10">
        <div class="p-4 rounded-lg dark:border-gray-700">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="flex rounded h-12 dark:bg-gray-800">
                    <p class="text-2xl text-black dark:text-gray-500">Booking</p>
                </div>
                <div class="flex rounded h-12 dark:bg-gray-800 justify-end">

                    <form id="status-filter-form" action="{{ route('resort.booking') }}" method="GET"
                        class="flex items-center">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Filter by Status:</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                onchange="this.form.submit()">
                                <option value="">All</option>
                                <option value="Accept" {{ request('status') == 'Accept' ? 'selected' : '' }}>Accept</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="Cancel" {{ request('status') == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                                <option value="Check Out" {{ request('status') == 'Check Out' ? 'selected' : '' }}>Check Out
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="items_per_page" class="block text-sm font-medium text-gray-700">Items per
                                page:</label>
                            <select name="items_per_page" id="items_per_page"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                onchange="this.form.submit()">
                                <option value="10" {{ $itemsPerPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ $itemsPerPage == 20 ? 'selected' : '' }}>20</option>
                                <option value="30" {{ $itemsPerPage == 30 ? 'selected' : '' }}>30</option>
                                <option value="40" {{ $itemsPerPage == 40 ? 'selected' : '' }}>40</option>
                                <option value="50" {{ $itemsPerPage == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="flex items-center justify-center mb-4 rounded bg-gray-50 dark:bg-gray-800 ">
                <div class="w-full ">
                    <!-- Booking Table -->
                    <table class="w-full table-auto" id="booking-table">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                <th class="w-1/12 py-2 px-2 text-left font-bold uppercase text-xs">Room Name</th>
                                <th class="w-1/12 py-2 text-left font-bold uppercase text-xs">Name</th>
                                <th class="w-1/12 py-2 text-left font-bold uppercase text-xs">Phone</th>
                                <th class="w-1/12 py-2 text-left font-bold uppercase text-xs">Status</th>
                                <th class="w-1/12 py-2 text-left font-bold uppercase text-xs">Check In</th>
                                <th class="w-1/12 py-2 text-left font-bold uppercase text-xs">Check Out</th>
                                <th class="w-1/12 py-2 px-2 text-left font-bold uppercase text-xs">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            @foreach ($bookings as $booking)
                                <tr class="border-b border-gray-200 dark:border-gray-700"
                                    data-payment="{{ $booking->payment }}" data-room-price="{{ $booking->room->price }}">
                                    <td class="py-2 px-2 text-black dark:text-gray-300">{{ $booking->room->name }}</td>
                                    <td class="py-2 text-black dark:text-gray-300">{{ $booking->name }}</td>
                                    <td class="py-2 text-black dark:text-gray-300">{{ $booking->contact_no }}</td>
                                    <td class="py-2 text-black dark:text-gray-300">
                                        <span
                                            class="{{ $booking->status == 'Accept' ? 'bg-green-500' : ($booking->status == 'Pending' ? 'bg-orange-500' : ($booking->status == 'Cancel' ? 'bg-red-500' : ($booking->status == 'Check Out' ? 'bg-yellow-500' : ''))) }} rounded-full p-1 text-sm text-white">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                    <td class="py-2 text-black dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M-d-Y') }}</td>
                                    <td class="py-2 text-black dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M-d-Y') }}</td>
                                    <td class="py-2 text-black dark:text-gray-300 flex items-center space-x-4">
                                        <div class="relative" data-twe-dropdown-ref>
                                            <div class="relative" data-twe-dropdown-ref>
                                                <button
                                                    class="flex items-center rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300   active:bg-primary-600  motion-reduce:transition-none "
                                                    type="button" id="dropdownMenuButton1ds" data-twe-dropdown-toggle-ref
                                                    aria-expanded="false" data-twe-ripple-init
                                                    data-twe-ripple-color="light">
                                                    Action
                                                    <span class="ms-2 w-2 [&>svg]:h-5 [&>svg]:w-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                </button>
                                                <ul class="z-[1000] relative  float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-base shadow-lg data-[twe-dropdown-show]:block dark:bg-surface-dark"
                                                    aria-labelledby="dropdownMenuButton1ds" data-twe-dropdown-menu-ref>
                                                    <li>
                                                        <a href="{{ route('bookings.show', $booking->id) }}"
                                                            class="block w-full text-left px-4 py-2 text-base text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                            Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        @if ($booking->status == 'Accept')
                                                        <button
                                                        class="block w-full text-left px-4 py-2 text-base text-gray-700 bg-gray-100 dark:text-gray-200 dark:bg-gray-700 cursor-not-allowed opacity-50"
                                                        data-modal-target="accept{{ $booking->id }}" data-modal-toggle="accept{{ $booking->id }}" disabled>
                                                        Accept
                                                    </button>
                                                        @else
                                                        <button type="button"
                                                        class="block w-full text-left px-4 py-2 text-base text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                                                        data-modal-target="accept{{ $booking->id }}" data-modal-toggle="accept{{ $booking->id }}">
                                                        Accept
                                                    </button>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        @if ($booking->status == 'Check Out')
                                                            <button
                                                                class="block w-full text-left px-4 py-2 text-base text-gray-700 bg-gray-100 dark:text-gray-200 dark:bg-gray-700 cursor-not-allowed opacity-50"
                                                                disabled>
                                                                Check Out
                                                            </button>
                                                        @else
                                                            <a href="{{ route('bookings.checkout', $booking->id) }}"
                                                                class="block w-full text-left px-4 py-2 text-base text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                                Check Out
                                                            </a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div
                        class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <span class="flex items-center col-span-3">
                            Showing {{ $bookings->firstItem() }}-{{ $bookings->lastItem() }} of {{ $bookings->total() }}
                        </span>
                        <span class="col-span-2"></span>
                        <!-- Pagination -->
                        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                            {{ $bookings->links('vendor.pagination.tailwind') }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@foreach ($bookings as $booking)

<div id="accept{{ $booking->id }}" tabindex="-1"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">Booking Details
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="accept{{ $booking->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <form action="{{ route('booking.accept', $booking->id) }}" method="POST"
                    enctype="multipart/form-data" class="w-full max-w-2xl mx-auto">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-6">
                        <!-- Room Name -->
                            <label for="room_name"
                                class="block text-lg font-medium text-gray-700 dark:text-gray-300">Room
                                Name</label>
                            <input type="text" value="{{ $booking->room->name }}" name="room_name"
                                id="room_name"
                                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                readonly>
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name"
                                class="block text-lg font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" value="{{ $booking->name }}" name="name" id="name"
                                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                readonly>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email"
                                class="block text-lg font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" value="{{ $booking->email }}" name="email" id="email"
                                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                readonly>
                        </div>

                        <!-- Contact Number -->
                        <div>
                            <label for="contact_no"
                                class="block text-lg font-medium text-gray-700 dark:text-gray-300">Contact
                                Number</label>
                            <input type="text" value="{{ $booking->contact_no }}" name="contact_no"
                                id="contact_no"
                                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                readonly>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="check_in_date"
                                    class="block text-lg font-medium text-gray-700 dark:text-gray-300">Check
                                    in
                                    date</label>
                                <input type="text"
                                    value="{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M-d-Y') }}"
                                    name="check_in_date" id="check_in_date"
                                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                    readonly>
                            </div>
                            <div>
                                <label for="check_out_date"
                                    class="block text-lg font-medium text-gray-700 dark:text-gray-300">Check
                                    out
                                    date</label>
                                <input type="text"
                                    value="{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M-d-Y') }}"
                                    name="check_out_date" id="check_out_date"
                                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                    readonly>
                            </div>
                        </div>
                        <!-- Payment Amount -->
                        <div data-group-id="3">
                            <div>
                                <label for="payment-3"
                                    class="block text-lg font-medium text-gray-700 dark:text-gray-300">Payment
                                    Amount</label>
                                <input type="number" value="{{ $booking->payment }}" name="payment-3"
                                    id="payment-3"
                                    class="payment mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                    readonly>
                            </div>
                        <!-- Payment Picture -->
                        <div class="mb-4">
                            <button type="button" data-twe-toggle="modal" data-twe-target="#exampleModalCenter"
                                data-twe-ripple-init data-twe-ripple-color="light">
                                <label for="payment_picture"
                                    class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Payment
                                    Picture</label>
                                <img src="{{ $booking->paymentRecord && $booking->paymentRecord->payment_path ? asset('storage/' . $booking->paymentRecord->payment_path) : asset('images/lake-sebu.jpg') }}"
                                    alt="No Payment Screenshot"
                                    class="w-40 h-40 rounded-lg shadow-md object-cover border border-gray-200 dark:border-gray-700">
                            </button>
                        </div>
                    </div>
                    <!-- Buttons -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <button type="button" data-modal-hide="accept{{ $booking->id }}"
                            class="px-6 py-3 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Cancel</button>
                        <button type="submit"
                            class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Accept</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Image Modal -->
    <div data-twe-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
        <div data-twe-modal-dialog-ref
            class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
            <div
                class="pointer-events-auto m-5 relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none dark:bg-surface-dark">
                <img src="{{ $booking->paymentRecord && $booking->paymentRecord->payment_path ? asset('storage/' . $booking->paymentRecord->payment_path) : asset('images/lake-sebu.jpg') }}"
                    alt="No Payment Screenshot"
                    class=" w-full h-[450px] sm:h-[400px] md:h-[500px] lg:h-[600px] xl:h-[700px] rounded-lg shadow-md object-cover border border-gray-200 dark:border-gray-700">
            </div>
        </div>
    </div>
@endforeach
@endsection

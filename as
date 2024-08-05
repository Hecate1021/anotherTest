                                   <!--check out modal -->
<div id="check-out{{ $booking->room->id }}" tabindex="-1"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">Check Out
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="check-out{{ $booking->room->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <form action="{{ route('bookings.checkOut', $booking->id) }}" method="POST"
                    enctype="multipart/form-data" class="w-full max-w-2xl mx-auto">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-6">
                        <!-- Room Name -->
                        <input type="text" value="{{$booking->id}}">
                            <label for="room_name"
                                class="block text-lg font-medium text-gray-700 dark:text-gray-300">Room
                                Name</label>
                            <input type="text" value="{{ $booking->room->name }}" name="room_name"
                                id="room_name"
                                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                required>
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name"
                                class="block text-lg font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" value="{{ $booking->name }}" name="name" id="name"
                                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email"
                                class="block text-lg font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" value="{{ $booking->email }}" name="email" id="email"
                                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                required>
                        </div>

                        <!-- Contact Number -->
                        <div>
                            <label for="contact_no"
                                class="block text-lg font-medium text-gray-700 dark:text-gray-300">Contact
                                Number</label>
                            <input type="text" value="{{ $booking->contact_no }}" name="contact_no"
                                id="contact_no"
                                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                required>
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
                                    required>
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
                                    required>
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
                                    required>
                            </div>

                            <!-- Room Price (Hidden) -->
                            <input type="hidden" value="{{ $booking->room->price }}" id="room-price-3"
                                class="room-price">

                            <!-- Remaining Balance -->
                            <div class="mt-4">
                                <label for="remaining-balance"
                                    class="block text-lg font-medium text-gray-700 dark:text-gray-300">Remaining
                                    Balance</label>
                                <input type="number" name="remaining_balance" id="remaining-balance"
                                    class="remaining-balance mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                    required>
                            </div>

                            <!-- Final Payment (Hidden) -->
                            <input type="hidden" name="final_payment" id="final-payment" class="final-payment">
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
                        <button type="button" data-modal-hide="check-out{{ $booking->room->id }}"
                            class="px-6 py-3 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Cancel</button>
                        <button type="submit"
                            class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
   <!-- Image Modal -->
   <div data-twe-modal-init
   class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
   id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
   aria-modal="true" role="dialog">
   <div data-twe-modal-dialog-ref
       class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
       <div
           class="pointer-events-auto m-5 relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none dark:bg-surface-dark">
           <img id="modalImage" src="" alt="No Payment Screenshot"
               class="w-full h-[450px] sm:h-[400px] md:h-[500px] lg:h-[600px] xl:h-[700px] rounded-lg shadow-md object-cover border border-gray-200 dark:border-gray-700">
       </div>
   </div>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateRemainingBalance(group) {
                const paymentInput = group.querySelector('.payment');
                const roomPriceInput = group.querySelector('.room-price');
                const remainingBalanceInput = group.querySelector('.remaining-balance');
                const finalPaymentInput = group.querySelector('.final-payment');

                const payment = parseFloat(paymentInput.value) || 0;
                const roomPrice = parseFloat(roomPriceInput.value) || 0;
                const remainingBalance = roomPrice - payment;

                remainingBalanceInput.value = remainingBalance.toFixed(2);
                updateFinalPayment(group);
            }

            function updateFinalPayment(group) {
                const paymentInput = group.querySelector('.payment');
                const remainingBalanceInput = group.querySelector('.remaining-balance');
                const finalPaymentInput = group.querySelector('.final-payment');

                const payment = parseFloat(paymentInput.value) || 0;
                const remainingBalance = parseFloat(remainingBalanceInput.value) || 0;
                const finalPayment = payment + remainingBalance;

                finalPaymentInput.value = finalPayment.toFixed(2);
            }

            document.querySelectorAll('[data-group-id]').forEach(group => {
                const paymentInput = group.querySelector('.payment');
                const remainingBalanceInput = group.querySelector('.remaining-balance');

                paymentInput.addEventListener('input', () => updateRemainingBalance(group));
                remainingBalanceInput.addEventListener('input', () => updateFinalPayment(group));

                // Initialize remaining balance and final payment on page load
                updateRemainingBalance(group);
            });
        });
    </script>

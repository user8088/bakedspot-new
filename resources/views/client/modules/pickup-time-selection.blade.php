@extends('client.layouts.main')

@section('page')
<section class="pickup-time-selection py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="heading-black mb-4">Select Pickup Time</h1>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="date-selector mb-4">
                            <label for="pickup-date" class="form-label fw-bold">Pickup Date</label>
                            <input type="date" id="pickup-date" class="form-control"
                                min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="time-slots-container">
                            <label class="form-label fw-bold">Available Time Slots</label>
                            <div id="time-slots-list" class="d-flex flex-wrap gap-2">
                                <div class="spinner-border text-pink" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-muted ms-2 mb-0">Loading available time slots...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mt-3 mb-4 d-none" id="info-message">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            <p class="mb-0">Time slots less than 30 minutes from now are not available for selection.</p>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('get-packmenupage') }}" class="btn btn-outline-dark me-2">Back</a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .time-slot-option {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px 15px;
        cursor: pointer;
        transition: all 0.2s ease;
        background-color: white;
    }

    .time-slot-option:hover {
        background-color: #f8f8f8;
        border-color: #ccc;
    }

    .time-slot-option.selected {
        background-color: #FFE6EB;
        border-color: #FFB9CD;
        color: #FF6B6B;
        font-weight: 500;
    }

    .time-slot-option.unavailable {
        background-color: #f8f8f8;
        color: #aaa;
        cursor: not-allowed;
        border-color: #eee;
    }

    .text-pink {
        color: #FFB9CD !important;
    }

    .spinner-border.text-pink {
        border-color: #FFB9CD;
        border-right-color: transparent;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const dateInput = $('#pickup-date');
        const timeSlotsContainer = $('#time-slots-list');

        // Function to load time slots
        function loadTimeSlots(date) {
            timeSlotsContainer.html(`
                <div class="spinner-border text-pink" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted ms-2 mb-0">Loading available time slots...</p>
            `);

            $.ajax({
                url: '{{ route("pickup.time_slots") }}',
                method: 'GET',
                data: { date: date },
                success: function(response) {
                    if (response.length === 0) {
                        timeSlotsContainer.html(`<p class="text-muted">No time slots available for this date.</p>`);

                        // If it's today, show the info message about 30-minute buffer
                        const today = new Date();
                        const selectedDate = new Date(date);
                        if (selectedDate.setHours(0,0,0,0) === today.setHours(0,0,0,0)) {
                            $('#info-message').removeClass('d-none');
                        } else {
                            $('#info-message').addClass('d-none');
                        }

                        return;
                    }

                    // Hide info message if we have slots
                    $('#info-message').addClass('d-none');

                    // Build time slots HTML
                    let html = '';
                    response.forEach(slot => {
                        html += `
                            <div class="time-slot-option"
                                data-time="${slot.value}"
                                data-label="${slot.label}"
                                data-date="${date}">
                                ${slot.label}
                            </div>
                        `;
                    });

                    timeSlotsContainer.html(html);

                    // Activate time slot selection
                    $('.time-slot-option').click(function() {
                        if ($(this).hasClass('unavailable')) return;

                        $('.time-slot-option').removeClass('selected');
                        $(this).addClass('selected');

                        // Save selected time slot
                        const timeSlot = $(this).data('time');
                        const timeSlotLabel = $(this).data('label');
                        const pickupDate = $(this).data('date');

                        saveTimeSlot(pickupDate, timeSlot, timeSlotLabel);
                    });
                },
                error: function(error) {
                    console.error('Error loading time slots:', error);
                    timeSlotsContainer.html(`<p class="text-danger">Failed to load time slots. Please try again.</p>`);
                }
            });
        }

        // Function to save selected time slot
        function saveTimeSlot(date, timeSlot, timeSlotLabel) {
            $.ajax({
                url: '{{ route("pickup.select_timeslot") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    date: date,
                    time_slot: timeSlot,
                    time_slot_label: timeSlotLabel
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        const successMessage = $(`
                            <div class="alert alert-success mt-3">
                                Time slot selected successfully!
                                <a href="{{ route('checkout.show') }}" class="alert-link">Proceed to checkout</a> or
                                <a href="{{ route('get-packmenupage') }}" class="alert-link">continue shopping</a>.
                            </div>
                        `);

                        if ($('.alert-success').length) {
                            $('.alert-success').remove();
                        }

                        timeSlotsContainer.after(successMessage);
                    }
                },
                error: function(error) {
                    console.error('Error saving time slot:', error);

                    const errorMessage = $(`
                        <div class="alert alert-danger mt-3">
                            Failed to save time slot. Please try again.
                        </div>
                    `);

                    if ($('.alert-danger').length) {
                        $('.alert-danger').remove();
                    }

                    timeSlotsContainer.after(errorMessage);
                }
            });
        }

        // Load time slots for the current date on page load
        loadTimeSlots(dateInput.val());

        // Load time slots when date changes
        dateInput.change(function() {
            loadTimeSlots($(this).val());
        });
    });
</script>
@endsection

@extends('client.layouts.main')
@section('page')
<section class="packs-menu">
    <div class="container py-4">
        <!-- Minimal horizontal navigation bar similar to Crumbl Cookies -->
        @php
        $orderType = Session::get('order_type', 'delivery');
        @endphp

        @if($orderType == 'delivery')
        <div class="crumbl-style-nav mb-4">
            <div class="location-selector" id="sector-dropdown">
                <div class="location-display pickup-badge" id="selected-sector-display">
                    <i class="fas fa-map-marker-alt" style="color: #000;"></i>
                    <span class="sector-placeholder">Select delivery area</span>
                    <span class="sector-name" style="display: none;"></span>
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </div>
                <div class="location-options" style="display: none;">
                    <div class="search-container">
                        <input type="text" id="sector-search" class="form-control form-control-sm" placeholder="Search your area...">
                    </div>
                    <div id="sectors-list">
                        @foreach($sectors as $sector)
                        <div class="location-option" data-id="{{ $sector->id }}" data-name="{{ $sector->sector_name }}" data-charges="{{ $sector->delivery_charges }}">
                            <div class="option-details">
                                <div class="option-name">{{ $sector->sector_name }}</div>
                                <div class="option-charges">PKR {{ $sector->delivery_charges }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="no-results" class="no-results" style="display: none;">
                        <p>It seems we don't deliver to your area yet.</p>
                        <small>We're expanding! Check back soon or contact us for updates.</small>
                    </div>
                </div>
            </div>
            <div id="sector-feedback" class="mt-2"></div>
        </div>
        @elseif($orderType == 'pickup')
        <div class="pickup-indicator mb-4">
            <div class="pickup-badge">
                <i class="fas fa-store me-2"></i> <a href="{{route('pickup.time_selection')}}" style="color: #000;">Select Pickup Time</a>
            </div>
        </div>
        @endif

        <div class="d-none d-md-block">
        <h1 class="heading-black">Brownie Packs</h1>
        <div class="row pt-3">
            <!-- First Card -->
            <div class="col-md-6">
                <a href="{{route('get-packfourpage')}}">
                <div class="card border-0">
                    <img src="{{asset('images/pk-4.png')}}" class="card-img-top" alt="Delicious Dessert">
                    <div class="card-body">
                        <h1 class="card-title heading-black-small">Pack of Four</h1>
                        <p class="card-text">PKR 1000</p>
                    </div>
                </div>
                </a>
            </div>
            <!-- Second Card -->
            <div class="col-md-6">
                <a href="{{route('get-packeightpage')}}">
                    <div class="card border-0">
                        <img src="{{asset('images/pk-8.png')}}" class="card-img-top" alt="Delicious Dessert">
                        <div class="card-body">
                            <h1 class="card-title heading-black-small">Pack of Eight</h1>
                            <p class="card-text">PKR 3000</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

        <div class="d-block d-md-none">
        <h1 class="heading-black-smaller">Brownie Packs</h1>
        <!-- First Row -->
        <a style="color: #000" href="{{route('get-packfourpage')}}">
        <div class="row pt-3 pb-3 border-bottom">
            <div class="col-6 col-sm-6">
                <img src="{{asset('images/pk-4.png')}}" class="img-fluid" alt="Delicious Dessert">
            </div>
            <div class="col-6 col-sm-6 pt-3">
                <h1 class="heading-black-smaller">Pack of 4</h1>
                <p >PKR 1000</p>
            </div>
        </div>
        </a>
        <!-- Second Row -->
        <a style="color: #000" href="{{route('get-packeightpage')}}">
        <div class="row pt-3 pb-3 border-bottom">
            <div class="col-6 col-sm-6">
                <img src="{{asset('images/pk-4.png')}}" class="img-fluid" alt="Delicious Dessert">
            </div>
            <div class="col-6 col-sm-6 pt-3">
                <h1 class="heading-black-smaller" >Pack of 8</h1>
                <p >PKR 2000</p>
            </div>
        </div>
        </a>
    </div>
    </div>

    <!-- Hidden input for the actual form submission -->
    <input type="hidden" id="sector_id" name="sector_id">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sectorDropdown = document.getElementById('sector-dropdown');
        const selectedDisplay = document.getElementById('selected-sector-display');
        const options = document.querySelector('.location-options');
        const sectorIdInput = document.getElementById('sector_id');
        const feedbackDiv = document.getElementById('sector-feedback');
        const sectorNameDisplay = selectedDisplay.querySelector('.sector-name');
        const sectorPlaceholder = selectedDisplay.querySelector('.sector-placeholder');

        // Check if jQuery is loaded
        if (typeof $ === 'undefined') {
            console.error('jQuery is not loaded. Please make sure jQuery is included before this script.');
            return;
        }

        // Toggle dropdown when clicking on the selected option
        selectedDisplay.addEventListener('click', function() {
            options.style.display = options.style.display === 'none' ? 'block' : 'none';
            selectedDisplay.classList.toggle('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!sectorDropdown.contains(e.target)) {
                options.style.display = 'none';
                selectedDisplay.classList.remove('active');
            }
        });

        // Load previously selected sector from session if available
        $.get('/cart', function(response) {
            if (response.selected_sector && response.selected_sector.id) {
                // Update the hidden input
                sectorIdInput.value = response.selected_sector.id;

                // Update the displayed text
                sectorPlaceholder.style.display = 'none';
                sectorNameDisplay.textContent = response.selected_sector.name;
                sectorNameDisplay.style.display = 'inline';

                // Add 'selected' class for styling
                selectedDisplay.classList.add('has-selection');

                // Show feedback briefly
                showFeedback('Delivery area selected', 'success');
            }
        });

        // Handle option selection
        document.querySelectorAll('.location-option').forEach(option => {
            option.addEventListener('click', function() {
                const sectorId = this.getAttribute('data-id');
                const sectorName = this.getAttribute('data-name');
                const sectorCharges = this.getAttribute('data-charges');

                // Update the hidden input
                sectorIdInput.value = sectorId;

                // Update the displayed text
                sectorPlaceholder.style.display = 'none';
                sectorNameDisplay.textContent = sectorName;
                sectorNameDisplay.style.display = 'inline';

                // Add 'selected' class for styling
                selectedDisplay.classList.add('has-selection');

                // Close the dropdown
                options.style.display = 'none';
                selectedDisplay.classList.remove('active');

                // Save selection to server session
                $.ajax({
                    url: '{{ route("save.sector") }}',
                    type: 'POST',
                    data: {
                        sector_id: sectorId,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        showFeedback('Saving your selection...', 'info');
                    },
                    success: function(response) {
                        showFeedback('Delivery area selected', 'success');
                    },
                    error: function(xhr) {
                        showFeedback('Error selecting delivery area. Please try again.', 'danger');
                        console.error('Error:', xhr);
                    }
                });
            });
        });

        // Add search functionality
        const searchInput = document.getElementById('sector-search');
        const sectorsList = document.getElementById('sectors-list');
        const noResults = document.getElementById('no-results');

        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const options = sectorsList.querySelectorAll('.location-option');
            let hasResults = false;

            options.forEach(option => {
                const sectorName = option.getAttribute('data-name').toLowerCase();
                if (sectorName.includes(searchTerm)) {
                    option.style.display = 'block';
                    hasResults = true;
                } else {
                    option.style.display = 'none';
                }
            });

            // Show or hide the no results message
            if (hasResults) {
                noResults.style.display = 'none';
            } else {
                noResults.style.display = 'block';
            }
        });

        // Clear search when opening dropdown
        selectedDisplay.addEventListener('click', function() {
            if (options.style.display === 'none') {
                searchInput.value = '';
                const allOptions = sectorsList.querySelectorAll('.location-option');
                allOptions.forEach(opt => opt.style.display = 'block');
                noResults.style.display = 'none';
            }
        });

        // Helper function to show feedback
        function showFeedback(message, type) {
            if (feedbackDiv) {
                feedbackDiv.innerHTML = `<div class="alert alert-${type} py-2 small">${message}</div>`;

                // Clear success/info messages after 3 seconds
                if (['success', 'info'].includes(type)) {
                    setTimeout(() => {
                        feedbackDiv.innerHTML = '';
                    }, 3000);
                }
            }
        }
    });
    </script>

    <style>
    /* Crumbl-style navigation and selector */
    .crumbl-style-nav {
        display: flex;
        align-items: center;
        background-color: white;
        padding: 12px 0;
        position: relative;
    }

    .location-selector {
        position: relative;
        cursor: pointer;
        user-select: none;
    }

    .location-display {
        display: flex;
        align-items: center;
        font-weight: 500;
        padding: 8px 12px;
        border-radius: 4px;
        transition: all 0.2s ease;
    }



    .location-display.active {
        background-color: #f0f0f0;
    }

    .location-display i.fa-map-marker-alt {
        color: #ff6b6b;
        margin-right: 8px;
        font-size: 16px;
    }

    .arrow-icon {
        margin-left: 8px;
        font-size: 12px;
        color: #777;
        transition: transform 0.2s ease;
    }

    .location-display.active .arrow-icon {
        transform: rotate(180deg);
    }

    .sector-placeholder, .sector-name {
        font-size: 15px;
        color: #333;
    }

    .location-options {
        position: absolute;
        top: 100%;
        left: 0;
        width: 260px;
        max-height: 280px;
        overflow-y: auto;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 100;
        margin-top: 8px;
        padding: 8px 0;
    }

    .location-option {
        padding: 12px 16px;
        cursor: pointer;
        transition: background 0.2s;
    }



    .option-details {
        display: flex;
        flex-direction: column;
    }

    .option-name {
        font-weight: 500;
        color: #333;
    }

    .option-charges {
        font-size: 13px;
        color: #777;
        margin-top: 2px;
    }

    /* For mobile devices */
    @media (max-width: 768px) {
        .location-options {
            width: 100%;
            position: fixed;
            left: 0;
            max-height: 60vh;
            border-radius: 12px 12px 0 0;
            bottom: 0;
            top: unset;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            margin-top: 0;
        }

        .location-option {
            padding: 14px 20px;
        }
    }

    .search-container {
        padding: 8px 12px;
        position: sticky;
        top: 0;
        background: white;
        z-index: 2;
        border-bottom: 1px solid #f0f0f0;
    }

    #sector-search {
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 8px 12px;
        width: 100%;
        font-size: 14px;
    }

    #sector-search:focus {
        border-color: #FFB9CD;
        box-shadow: 0 0 0 2px rgba(255, 185, 205, 0.25);
        outline: none;
    }

    .no-results {
        padding: 16px;
        text-align: center;
        color: #777;
    }

    .no-results p {
        margin-bottom: 4px;
        font-weight: 500;
    }

    .no-results small {
        display: block;
        color: #999;
    }

    /* Pickup badge styling */
    .pickup-indicator {
        display: flex;
        justify-content: flex-start;
        padding: 12px 0;
    }

    .pickup-badge {
        display: inline-flex;
        align-items: center;
        background-color: #FFB9CD;
        color: #000;
        font-weight: 500;
        padding: 8px 15px;
        border-radius: 50px;
        font-size: 15px;
    }
    </style>
</section>
@endsection

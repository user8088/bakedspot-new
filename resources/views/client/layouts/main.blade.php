<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Baked Spot</title>
    @include('client.partials.header')
    @include('client.partials.navbar')
</head>
<body>
    @yield('page')

    <!-- Toast Container for Notifications -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/lenis@1.1.20/dist/lenis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Function to show toast notifications
        function showToast(message, type = 'success') {
            // Support both custom style and Bootstrap toasts
            const useCustomStyle = true; // Set to false to use Bootstrap toasts

            if (useCustomStyle) {
                // Custom toast
                const toast = $(`
                    <div class="custom-toast ${type}">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                        <span>${message}</span>
                    </div>
                `);

                $('.toast-container').append(toast);

                // Remove toast after 3 seconds
                setTimeout(() => {
                    toast.css('animation', 'slideOut 0.3s ease-out');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            } else {
                // Bootstrap toast
                const toastId = 'toast-' + Date.now();
                const toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'danger' ? 'fa-exclamation-circle' : 'fa-info-circle'} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
                `;

                $('.toast-container').append(toastHtml);

                const toastElement = document.getElementById(toastId);
                const toast = new bootstrap.Toast(toastElement, {
                    delay: 4000,
                    animation: true
                });

                toast.show();

                // Remove toast from DOM after it's hidden
                toastElement.addEventListener('hidden.bs.toast', function() {
                    toastElement.remove();
                });
            }
        }

        // Display flash messages as toasts when page loads
        $(document).ready(function() {
            @if(session('success'))
                showToast("{{ session('success') }}", "success");
            @endif

            @if(session('error'))
                showToast("{{ session('error') }}", "danger");
            @endif

            @if(session('info'))
                showToast("{{ session('info') }}", "info");
            @endif

            @if(session('warning'))
                showToast("{{ session('warning') }}", "warning");
            @endif
        });
    </script>

    <!-- Toast styling -->
    <style>
        .toast-container {
            z-index: 1050;
        }

        .toast {
            opacity: 1;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .toast-body {
            font-size: 14px;
            padding: 12px 15px;
        }

        /* Custom toast styling */
        .custom-toast {
            position: relative;
            padding: 12px 15px;
            margin-bottom: 10px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            color: #333;
            display: flex;
            align-items: center;
            animation: slideIn 0.3s ease-out;
            max-width: 350px;
        }

        .custom-toast.success {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
        }

        .custom-toast.error {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
        }

        .custom-toast i {
            margin-right: 10px;
            font-size: 18px;
        }

        .custom-toast.success i {
            color: #28a745;
        }

        .custom-toast.error i {
            color: #dc3545;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* For mobile devices */
        @media (max-width: 768px) {
            .toast-container {
                bottom: 70px !important;
            }
        }

        /* Cart button animation */
        .pulse-animation {
            animation: pulse 0.7s ease-in-out;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</body>
</html>

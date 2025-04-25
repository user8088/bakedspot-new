@include('admin.partials.header')
<body>
    <div class="dashboard-wrapper">
        <div class="dashboard-content">
            @include('admin.partials.navbar')
            <div class="container-fluid px-0 px-md-5 px-lg-5">
                <div class="row">
                    @include("admin.partials.sidebar")
                    @yield('page')
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container for Notifications -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    <script>
        // Function to show toast notifications
        function showToast(message, type = 'success') {
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

            document.querySelector('.toast-container').innerHTML += toastHtml;

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

        // Display flash messages as toasts when page loads
        document.addEventListener('DOMContentLoaded', function() {
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

    <!-- Add some basic toast styling -->
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

        /* For mobile devices */
        @media (max-width: 768px) {
            .toast-container {
                bottom: 70px !important;
            }
        }
    </style>
</body>
@include('admin.partials.footer')

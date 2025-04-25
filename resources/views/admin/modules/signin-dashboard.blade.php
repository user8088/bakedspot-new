<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Dashboard Login</title>
</head>
<body>
    <section class="dashboard-login d-flex align-items-center justify-content-center pb-5">
        <div class="container pt-5 pb-5">
            <div class="row pb-5">
                <div class="col-lg-5">
                    <form action="{{ route('login-admin') }}" method="POST" class="admin-signin p-5">
                        @csrf
                        <h1 class="heading-black text-center">Panel Login</h1>
                        <p class="text-center pb-5 border-bottom">
                            Enter admin credentials to login & manage your website.
                        </p>

                        <div class="mb-3 mt-5">
                            <label for="adminEmail" class="form-label">Admin Email</label>
                            <input type="email" class="form-control" id="adminEmail" name="email" required>
                        </div>

                        <div class="mb-5">
                            <label for="adminPassword" class="form-label">Admin Password</label>
                            <input type="password" class="form-control" id="adminPassword" name="password" required>
                        </div>

                        <div class="text-center pb-5 border-bottom">
                            <button type="submit" class="btn btn-main px-5 py-3">Login to Admin Panel</button>
                        </div>

                        <p class="light-text text-center pt-3">
                            In case you encounter bugs/issues in the website, you can raise a ticket with the developer at Trello.
                            Check out the dashboard tutorial here.
                        </p>
                    </form>
                </div>
                <div class="col-lg-6 admin-signin-img">

                </div>
            </div>
        </div>
    </section>

    <!-- Toast Container for Notifications -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/lenis@1.1.20/dist/lenis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>

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
            @if(session('error'))
                showToast("{{ session('error') }}", "danger");
            @endif

            @if(session('success'))
                showToast("{{ session('success') }}", "success");
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
</html>

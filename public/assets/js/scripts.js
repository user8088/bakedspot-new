// Lenis / GSAP Scroll
document.addEventListener("DOMContentLoaded", () => {
    gsap.registerPlugin(ScrollTrigger);
    const lenis = new Lenis();
    lenis.on("scroll", ScrollTrigger.update);
    gsap.ticker.add((time) => {
      lenis.raf(time * 1000);
    });
    gsap.ticker.lagSmoothing(0);
});

// Set initial state when page loads
document.addEventListener("DOMContentLoaded", function() {
    const cartBtn = document.getElementById("cartBtn");
    const orderBtn = document.querySelector(".btn-order");

    if (window.location.pathname === '/') {
        // On home page, show order button by default
        if (orderBtn) {
            orderBtn.classList.remove("d-none");
        }
        if (cartBtn) {
            cartBtn.classList.add("d-none");
        }
    } else {
        // On other pages, show cart button if it exists
        if (cartBtn) {
            cartBtn.classList.remove("d-none");
        }
    }
});

document.addEventListener("scroll", function () {
    const orderBtn = document.querySelector(".btn-order");
    const navbar = document.querySelector(".navbar");
    const cartBtn = document.getElementById("cartBtn");

    // Only apply scroll behavior on home page
    if (window.location.pathname === '/') {
        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
            if (orderBtn) orderBtn.classList.add("show");
            if (cartBtn) cartBtn.classList.remove("d-none");
        } else {
            navbar.classList.remove("scrolled");
            if (orderBtn) orderBtn.classList.remove("show");
            if (cartBtn) cartBtn.classList.add("d-none");
        }
    }
});

// Function to animate cart button and open cart
function animateCartButton() {
    const cartBtn = document.getElementById("cartBtn");
    if (cartBtn) {
        // Add animation class
        cartBtn.classList.add("cart-button-animate");

        // Remove animation class after animation completes
        setTimeout(() => {
            cartBtn.classList.remove("cart-button-animate");
        }, 1000);

        // Open the cart offcanvas
        const cartOffcanvas = new bootstrap.Offcanvas(document.getElementById('cartOffcanvas'));
        cartOffcanvas.show();
    }
}

// Add CSS for the animation
const style = document.createElement('style');
style.textContent = `
    @keyframes cartButtonShake {
        0% { transform: scale(1); }
        10% { transform: scale(1.1); }
        20% { transform: scale(1); }
        30% { transform: scale(1.1); }
        40% { transform: scale(1); }
        50% { transform: scale(1.1); }
        60% { transform: scale(1); }
        70% { transform: scale(1.1); }
        80% { transform: scale(1); }
        90% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .cart-button-animate {
        animation: cartButtonShake 1s ease-in-out;
    }
`;
document.head.appendChild(style);


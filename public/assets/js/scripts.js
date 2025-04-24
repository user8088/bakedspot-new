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

document.addEventListener("scroll", function () {
    const orderBtn = document.querySelector(".btn-order");
    const navbar = document.querySelector(".navbar");
    if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
        orderBtn.classList.add("show");
    } else {
        navbar.classList.remove("scrolled");
        orderBtn.classList.remove("show");
    }
});


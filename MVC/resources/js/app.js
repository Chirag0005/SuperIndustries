import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// Expose gsap globally for Blade templates
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

document.addEventListener("DOMContentLoaded", (event) => {
    // General Reveal Animation
    const reveals = document.querySelectorAll(".gsap-reveal");
    
    reveals.forEach((elem) => {
        gsap.to(elem, {
            scrollTrigger: {
                trigger: elem,
                start: "top 85%", // when top of element hits 85% of viewport
            },
            y: 0,
            opacity: 1,
            duration: 1.2,
            ease: "power3.out"
        });
    });
});

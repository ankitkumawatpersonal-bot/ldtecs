import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // TITLE 1
    // ==========================================

    gsap.from('#title1', {
        y: -90,
        opacity: 0,
        duration: 1.5,
        delay: 0.5,
        ease: 'power3.out'
    });


    // ==========================================
    // TITLE 2
    // ==========================================

    gsap.from('#title2', {
        y: -100,
        opacity: 0,
        duration: 1.5,
        delay: 1.5,
        ease: 'power3.out'
    });


    // ==========================================
    // PAGE 2
    // ==========================================

    gsap.from('#page2', {
        y: -100,
        opacity: 0,
        duration: 1.5,
        delay: 1.5,
        ease: 'power3.out'
    });


    // ==========================================
    // PRODUCT IMAGES
    // ==========================================

    const images = document.querySelectorAll('#zoomImage');

    images.forEach((image) => {

        // ------------------------------------------
        // SCROLL: Image left side animation
        // ------------------------------------------

        gsap.from(image, {
            x: -300,
            opacity: 0,
            scale: 0.8,
            duration: 1.5,
            ease: 'power3.out',

            scrollTrigger: {
                trigger: image,
                start: 'top 80%',
                toggleActions: 'play none none reverse'
            }
        });


        // ------------------------------------------
        // MOUSE ENTER: Zoom
        // ------------------------------------------

        image.addEventListener('mouseenter', () => {

            gsap.to(image, {
                scale: 1.05,
                duration: 0.5,
                ease: 'power2.out'
            });

        });


        // ------------------------------------------
        // MOUSE LEAVE: Normal
        // ------------------------------------------

        image.addEventListener('mouseleave', () => {

            gsap.to(image, {
                scale: 1,
                duration: 0.5,
                ease: 'power2.out'
            });

        });

    });


    // ==========================================
    // TITLE 3 - SCROLL ANIMATION
    // ==========================================

    gsap.from('#title3', {

        y: 100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '#title3',
            start: 'top 80%',
            toggleActions: 'play none none reverse'
        }

    });


    // ==========================================
    // DIEM - SCROLL ANIMATION
    // ==========================================

    gsap.from('#diem', {

        y: 100,
        opacity: 0,
        duration: 1.5,
        delay: 0.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '#diem',
            start: 'top 80%',
            toggleActions: 'play none none reverse'
        }

    });


    // ==========================================
    // PRODUCT CARDS
    // ==========================================

    gsap.from('.box1', {

        y: 120,
        opacity: 0,
        scale: 0.85,
        duration: 1.2,
        stagger: 0.3,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '.box1',
            start: 'top 80%',
            toggleActions: 'play none none reverse'
        }

    });


    // ==========================================
    // CARD HOVER
    // ==========================================

    document.querySelectorAll('.box1').forEach((card) => {

        card.addEventListener('mouseenter', () => {

            gsap.to(card, {
                y: -12,
                duration: 0.3,
                ease: 'power2.out'
            });

        });


        card.addEventListener('mouseleave', () => {

            gsap.to(card, {
                y: 0,
                duration: 0.3,
                ease: 'power2.out'
            });

        });

    });

});
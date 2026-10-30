document.addEventListener('DOMContentLoaded', () => {
    if (typeof gsap === 'undefined') {
        console.error('GSAP library load nahi hui.');
        return;
    }

    if (typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
    }


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
    // TITLE 3 - SCROLL ANIMATION
    // ==========================================

    gsap.from('#our-products', {

        y: 100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '#our-products',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('#zoomImage',{
        x:100,
        opacity:0,
        duration:1.5,
        ease:'power3.out',

        scrollTrigger: {
            trigger: '#our-products',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }
    })
    
    gsap.from('#zoomLite',{
        y:-100,
        opacity:0,
        duration:1.5,
        ease:'power3.out',

        scrollTrigger: {
            trigger: '#our-products',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }
    })
    
    gsap.from('#zoomNano',{
        x:150,
        opacity:0,
        duration:1.5,
        ease:'power3.out',

        scrollTrigger: {
            trigger: '#our-products',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }
    })

    gsap.from('.diem', {
        y: 100,
        opacity: 0,
        duration: 1.5,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '#our-products',
            start: 'top 50%',
            end:'bottom 50%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('.page5', {

        y: 100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '.page5',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('#services', {
        y: 100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '#services',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('.section-heading', {
        x: -100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '.section-heading',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('.card-content', {
        x: 100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '.card-content',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('#software', {
        x: -100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '.card-content',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('#design', {
        x: -100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '.card-content',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('.footer', {
        y: 100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '.footer',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('.footer-cta', {
        scale: 0,
        opacity: 0,
        duration: 1.2,
        ease: "back.out(3)",

        scrollTrigger: {
            trigger: '.footer',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('#footer-column', {
        x: 100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '.footer',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('#quick-links', {
        y: 100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '.footer',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('#contect', {
        x: 100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '.footer',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('.footer-bottom', {
        y: 100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '.footer',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

});


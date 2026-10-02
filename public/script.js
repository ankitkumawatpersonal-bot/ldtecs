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
    // IMAGE
    // ==========================================

    
    // const image = document.querySelector('#zoomImage');

    // if (image) {

    //     // ------------------------------------------
    //     // SCROLL: Image left side animation
    //     // ------------------------------------------

    //     gsap.from(image, {
    //         x: -300,
    //         opacity: 0,
    //         duration: 2,
    //         ease: 'power3.out',

    //         scrollTrigger: {
    //             trigger: image,
    //             start: 'top 80%',
    //             toggleActions: 'play none none reverse'
    //         }
    //     });


    //     // ------------------------------------------
    //     // MOUSE ENTER: Light Zoom
    //     // ------------------------------------------

    //     image.addEventListener('mouseenter', () => {

    //         gsap.to(image, {
    //             scale: 1.05,
    //             duration: 0.5,
    //             ease: 'power2.out'
    //         });

    //     });


    //     // ------------------------------------------
    //     // MOUSE LEAVE: Normal
    //     // ------------------------------------------

    //     image.addEventListener('mouseleave', () => {

    //         gsap.to(image, {
    //             scale: 1,
    //             duration: 0.5,
    //             ease: 'power2.out'
    //         });

    //     });

    // }


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

});


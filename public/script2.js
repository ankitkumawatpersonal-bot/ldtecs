gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', () => {

    gsap.from('#soft',{
        y:-100,
        opacity:0,
        duration:1.3,
        ease:'Power1.out'
    });

    gsap.from('#product-card1',{
        x:-100,
        opacity:0,
        duration:1.3,
        ease:'Power1.out'
    });

    gsap.from('#card1',{
        x:100,
        opacity:0,
        duration:1.3,
        ease:'Power1.out'
    });

    gsap.from('#description',{
        x:100,
        opacity:0,
        duration:1.3,
        ease:'Power1.out'
    });

    gsap.from('#desc',{
        x:-100,
        opacity:0,
        duration:1.3,
        ease:'Power1.out'
    });

    gsap.from('#heading1',{
        x: 100,
        opacity:0,
        duration:1.2,
        delay:0,
        ease:'power1.out',

        scrollTrigger:{
            trigger:'#heading1',
            start:'top 90%',
            toggleActions: 'play none none reverse'
        }
    });

    gsap.from('#head',{
        x: -100,
        opacity:0,
        duration:1.2,
        delay:0,
        ease:'power1.out',

        scrollTrigger:{
            trigger:'#head',
            start:'top 90%',
            toggleActions: 'play none none reverse'
        }
    });

    gsap.from('#product1',{
        y:100,
        opacity:0,
        duration:1.2,
        delay:0,
        ease:'power1.out',

        scrollTrigger:{
            trigger:'#product1',
            start:'top 90%',
            toggleActions: 'play none none reverse'
        }
    });

    gsap.from('#product',{
        y:100,
        opacity:0,
        duration:1.2,
        delay:0,
        ease:'power1.out',

        scrollTrigger:{
            trigger:'#product',
            start:'top 90%',
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
        ease: "back.out(2)",

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

    /* =================================
        ABOUT
    ====================================*/

    gsap.from('#build', {
        x: 100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '#build',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('#product-cont', {
        x: -100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '#product-cont',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('.clients-section', {
        y: 100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '.clients-section',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('#our', {
        x: -100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '#our',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('#diamond', {
        y: 100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '#our',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });

    gsap.from('#icon', {
        y: 100,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out',

        scrollTrigger: {
            trigger: '#icon',
            start: 'top 70%',
            toggleActions: 'play none none reverse'
        }

    });
});

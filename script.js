    const burger = document.getElementById('burger-menu');
    const navLinks = document.getElementById('nav-links');
    burger.addEventListener('click', () => {
        navLinks.classList.toggle('nav-active');
        burger.classList.toggle('toggle');
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            navLinks.classList.remove('nav-active');
            burger.classList.remove('toggle');
        }
    });

    new Swiper('.services.swiper', {
        loop: true,
        spaceBetween: 30,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            dynamicBullets: true,
        },
        navigation: {
            nextEl: '.service-nav-next',
            prevEl: '.service-nav-prev',
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });

    new Swiper('.projets.swiper', {
        loop: true,
        spaceBetween: 30,
        pauseOnMouseEnter: true,
        effect:'coverflow',
        grabCursor: true,
        centeredSlide:true,
        coverflowEffect:{
            rotate:50,
            stretch:0,
            depth:100,
            modifier:1,
            slideShadows:true,
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            dynamicBullets: true,
        },
        navigation: {
            nextEl: '.projet-nav-next',
            prevEl: '.projet-nav-prev',
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });

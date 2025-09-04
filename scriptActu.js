const swiper = new Swiper('.swiper', {
  loop: true,
  spaceBetween: 30,
  effect: 'coverflow',
  coverflowEffect: {
    rotate: 50,
    stretch: 0,
    depth: 150,
    modifier: 1,
    slideShadows: true,
  },
  autoplay: {
    delay: 2000,
    disableOnInteraction: false,
    pauseOnMouseEnter: true
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
    dynamicBullets: true
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
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
    }
  }
});
document.querySelectorAll('.triangle-btn').forEach((btn, i) => {
  btn.addEventListener('click', function() {
    btn.classList.toggle('active');
    const sectionHeader = btn.closest('.section-header');
    sectionHeader.classList.toggle('active');
    const collapsible = sectionHeader.nextElementSibling;
    collapsible.classList.toggle('active');
  });
});
document.querySelectorAll('.clickableText').forEach((btn, i) => {
  btn.addEventListener('click', function() {
    btn.classList.toggle('active');
    const collapsible = btn.closest('.section-header').nextElementSibling;
    collapsible.classList.toggle('active');
  });
});
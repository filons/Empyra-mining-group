    const burger = document.getElementById('burger-menu');
    const navLinks = document.getElementById('nav-links');
    burger.addEventListener('click', () => {
        navLinks.classList.toggle('nav-active');
        burger.classList.toggle('toggle');
    });
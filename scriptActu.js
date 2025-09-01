document.addEventListener('DOMContentLoaded', () => {
    const track = document.querySelector(".carousel-track");
    const items = document.querySelectorAll(".carousel-item");
    const totalItems = items.length;
    let index = totalItems; // Start at the first cloned item

    // Clone all items and append them to the beginning of the track
    for (let i = totalItems - 1; i >= 0; i--) {
        const clonedItem = items[i].cloneNode(true);
        track.prepend(clonedItem);
    }
    
    // Clone all items and append them to the end of the track (already there)
    // The original code already does this, so we just need to ensure it's there.
    items.forEach(item => {
        const clonedItem = item.cloneNode(true);
        track.appendChild(clonedItem);
    });

    const allItems = document.querySelectorAll(".carousel-item");

    function updateCarousel() {
        const itemWidth = allItems[0].offsetWidth + 40; 
        const viewportCenter = window.innerWidth / 2;
        
        const offset = -(index * itemWidth) + (viewportCenter - itemWidth / 2);

        track.style.transform = `translateX(${offset}px)`;

        // Update the 'active' class
        allItems.forEach((item, i) => {
            item.classList.remove('active');
            if (i === index) {
                item.classList.add('active');
            }
        });
    }

    // Function to handle the infinite loop
    function handleInfiniteLoop() {
        if (index >= totalItems * 2) {
            track.style.transition = 'none'; // Temporarily disable transition
            index = totalItems;
            const newOffset = -(index * (allItems[0].offsetWidth + 40)) + (window.innerWidth / 2 - (allItems[0].offsetWidth + 40) / 2);
            track.style.transform = `translateX(${newOffset}px)`;
            // Force a reflow before re-enabling transition
            track.offsetHeight;
        track.style.transition = ''; // Re-enable transition
        } else if (index < totalItems) {
       track.style.transition = 'none'; // Temporarily disable transition
            index = totalItems + (totalItems - 1);
            const newOffset = -(index * (allItems[0].offsetWidth + 40)) + (window.innerWidth / 2 - (allItems[0].offsetWidth + 40) / 2);
            track.style.transform = `translateX(${newOffset}px)`;
            // Force a reflow
            track.offsetHeight;
            track.style.transition = ''; // Re-enable transition
        }
    }

    let autoSlide = setInterval(() => {
        index++;
        updateCarousel();
        handleInfiniteLoop();
    }, 3000);

    // Stop on hover
    const carouselContainer = document.querySelector(".carousel-container");
    carouselContainer.addEventListener('mouseenter', () => {
        clearInterval(autoSlide);
    });

    // Resume on mouse leave
    carouselContainer.addEventListener('mouseleave', () => {
        autoSlide = setInterval(() => {
            index++;
            updateCarousel();
            handleInfiniteLoop();
        }, 3000);
    });

    window.addEventListener('resize', updateCarousel);

    updateCarousel();
});
document.addEventListener("DOMContentLoaded", () => {
  const milestoneGroups = document.querySelectorAll(".milestone-group");
  const indicators = document.querySelectorAll(".indicator");
  let currentIndex = 0;
  let isPaused = false;
  let timeoutId;

  function showNextDiv() {
    if (isPaused) return;

    // Reset all milestoneGroups and indicators to hidden state (off-screen to the right, no transition)
    milestoneGroups.forEach((milestonegroup) => {
      milestonegroup.classList.remove("visible", "exit");
      milestonegroup.classList.add("hidden");
    });
    indicators.forEach((indicator) => {
      indicator.classList.remove("active");
    });

    // Show current milestone group and its indicator
    milestoneGroups[currentIndex].classList.remove("hidden");
    milestoneGroups[currentIndex].classList.add("visible");
    indicators[currentIndex].classList.add("active");

    // If there’s a previous milestone group, move it out to the left
    const prevIndex =
      currentIndex === 0 ? milestoneGroups.length - 1 : currentIndex - 1;
    milestoneGroups[prevIndex].classList.remove("hidden");
    milestoneGroups[prevIndex].classList.add("exit");

    // Update index for next iteration
    currentIndex = (currentIndex + 1) % milestoneGroups.length;

    // Schedule the next slide
    timeoutId = setTimeout(showNextDiv, 2000); // 2-second interval
  }

  // Add hover event listeners to pause/resume animation
  milestoneGroups.forEach((milestonegroup) => {
    milestonegroup.addEventListener("mouseenter", () => {
      if (milestonegroup.classList.contains("visible")) {
        isPaused = true;
        clearTimeout(timeoutId);
      }
    });

    milestonegroup.addEventListener("mouseleave", () => {
      if (isPaused) {
        isPaused = false;
        showNextDiv(); // Resume animation
      }
    });
  });

  // Start the animation
  showNextDiv();

  // const swiper = new Swiper(".swiper", {
  //   // Optional parameters
  //   direction: "vertical",
  //   loop: true,

  //   // If we need pagination
  //   pagination: {
  //     el: ".swiper-pagination",
  //   },

  //   // Navigation arrows
  //   navigation: {
  //     nextEl: ".swiper-button-next",
  //     prevEl: ".swiper-button-prev",
  //   },

  //   // And if we need scrollbar
  //   scrollbar: {
  //     el: ".swiper-scrollbar",
  //   },
  // });
});

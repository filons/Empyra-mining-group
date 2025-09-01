document.addEventListener("DOMContentLoaded", () => {
  // Animate elements after page load
  document.querySelectorAll(".animate-on-load").forEach((el) => {
    el.classList.add("animated");
  });

  // Animate elements when scrolled into view
  const animateOnScroll = () => {
    document.querySelectorAll(".animate-on-scroll").forEach((el) => {
      const rect = el.getBoundingClientRect();
      if (rect.top < window.innerHeight && rect.bottom > 0) {
        el.classList.add("animated");
      }
    });
  };

  window.addEventListener("scroll", animateOnScroll);
  animateOnScroll(); // Initial check in case elements are already in view
});

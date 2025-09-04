document.addEventListener("DOMContentLoaded", () => {
  // Hero section animation on page load
  window.onload = () => {
    const heroContent = document.querySelector(".hero-content");
    heroContent.classList.add("visible");
  };

  // Scroll-based animations for other sections
  const slideElements = document.querySelectorAll(
    ".slide-in-left, .slide-in-right, .slide-in-bottom, .slide-in-top"
  );
  const observer = new IntersectionObserver(
    (entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
          observer.unobserve(entry.target); // Stop observing after animation
        }
      });
    },
    {
      threshold: 0.2, // Trigger when 20% of element is visible
    }
  );

  slideElements.forEach((element) => {
    observer.observe(element);
  });
});

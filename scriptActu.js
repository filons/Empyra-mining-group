// Animation simple des blocs d'actualités à l’apparition
document.addEventListener("DOMContentLoaded", () => {
  const blocks = document.querySelectorAll(".news-block");

  blocks.forEach((block, i) => {
    block.style.opacity = 0;
    block.style.transform = "translateY(30px)";
    setTimeout(() => {
      block.style.transition = "all 0.6s ease";
      block.style.opacity = 1;
      block.style.transform = "translateY(0)";
    }, i * 300); // petit décalage progressif
  });
});

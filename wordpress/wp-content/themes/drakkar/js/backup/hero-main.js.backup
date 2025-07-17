/**
 * Hero Section JavaScript
 * Drakkar Precision Agriculture Theme
 */

(function () {
  "use strict";

  /**
   * Statistics counter animation
   */
  function initStatisticsAnimation() {
    const statItems = document.querySelectorAll(".stat-item");

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const item = entry.target;
            const delay = parseInt(item.getAttribute("data-delay")) || 0;

            setTimeout(() => {
              item.classList.add("animate");

              const numberElement = item.querySelector(".stat-number");
              const targetValue = parseFloat(
                numberElement.getAttribute("data-target")
              );

              if (!isNaN(targetValue)) {
                animateCounter(numberElement, targetValue);
              }
            }, delay);

            observer.unobserve(item);
          }
        });
      },
      { threshold: 0.5, rootMargin: "0px 0px -100px 0px" }
    );

    statItems.forEach((item) => observer.observe(item));
  }

  /**
   * Animate counter numbers
   */
  function animateCounter(element, target) {
    const originalText = element.textContent;
    const duration = 2000;
    const steps = 60;
    const increment = target / steps;
    const stepDuration = duration / steps;
    let current = 0;

    const timer = setInterval(() => {
      current += increment;
      if (current >= target) {
        element.textContent = originalText;
        clearInterval(timer);
      } else {
        const formatted = Math.floor(current);
        if (originalText.includes("M")) {
          element.textContent = "+" + (formatted / 1000000).toFixed(1) + "M";
        } else if (originalText.includes("K")) {
          element.textContent = "+" + (formatted / 1000).toFixed(1) + "K";
        } else {
          element.textContent = "+" + formatted.toLocaleString();
        }
      }
    }, stepDuration);
  }

  /**
   * Video optimization
   */
  function initVideoOptimization() {
    const video = document.querySelector(".hero-video");
    video.setAttribute("playsinline", "");
    video.setAttribute("webkit-playsinline", "");
    video.play().catch(() => {});
  }

  /**
   * Smooth scroll for CTA button
   */
  function initSmoothScroll() {
    const ctaButton = document.querySelector(".hero-cta-button");

    ctaButton.addEventListener("click", function (e) {
      const targetElement = document.getElementById("plataforma");
      if (targetElement) {
        e.preventDefault();
        targetElement.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    });
  }

  /**
   * Initialize all functions
   */
  function init() {
    initStatisticsAnimation();
    initVideoOptimization();
    initSmoothScroll();
  }

  // Initialize when DOM is ready
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();

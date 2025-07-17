/**
 * Drakkar Theme - Consolidated JavaScript
 * Version 2.0 - Refactored with Utility-First Approach
 *
 * Structure:
 * 1. Utility Functions
 * 2. Core Theme Functionality
 * 3. Component Systems
 * 4. Performance Optimizations
 */

(function () {
  'use strict';

  // ============================
  // 1. UTILITY FUNCTIONS
  // ============================

  const DrakkarUtils = {
    // DOM Selectors
    $: function (selector) {
      return document.querySelector(selector);
    },

    $$: function (selector) {
      return document.querySelectorAll(selector);
    },

    // Throttle function for performance
    throttle: function (func, limit) {
      let inThrottle;
      return function () {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
          func.apply(context, args);
          inThrottle = true;
          setTimeout(() => inThrottle = false, limit);
        }
      };
    },

    // Debounce function for performance
    debounce: function (func, wait, immediate) {
      let timeout;
      return function () {
        const context = this, args = arguments;
        const later = function () {
          timeout = null;
          if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
      };
    },

    // Check if element is in viewport
    isInViewport: function (element) {
      const rect = element.getBoundingClientRect();
      return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
      );
    },

    // Get header height dynamically
    getHeaderHeight: function () {
      const header = this.$('.site-header');
      return header ? header.offsetHeight : 80;
    },

    // Smooth scroll to element
    scrollToElement: function (element, offset = 0) {
      if (!element) return;

      const headerHeight = this.getHeaderHeight();
      const targetPosition = element.offsetTop - headerHeight - offset;

      window.scrollTo({
        top: targetPosition,
        behavior: 'smooth'
      });
    },

    // Format number with suffix
    formatNumber: function (num) {
      if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M';
      } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K';
      }
      return Math.floor(num).toLocaleString();
    },

    // Feature detection
    supportsIntersectionObserver: function () {
      return 'IntersectionObserver' in window;
    },

    supportsPassiveEvents: function () {
      let supportsPassive = false;
      try {
        const opts = Object.defineProperty({}, 'passive', {
          get: function () {
            supportsPassive = true;
          }
        });
        window.addEventListener('testPassive', null, opts);
        window.removeEventListener('testPassive', null, opts);
      } catch (e) { }
      return supportsPassive;
    }
  };

  // ============================
  // 2. CORE THEME FUNCTIONALITY
  // ============================

  const DrakkarTheme = {
    init: function () {
      this.setupSmoothScrolling();
      this.setupHeaderEffects();
      this.setupMobileMenu();
      this.setupAccessibility();
      this.setupPerformanceOptimizations();

      // Initialize components if they exist
      if (DrakkarUtils.$('.hero-statistics')) {
        this.initStatisticsAnimation();
      }

      if (DrakkarUtils.$('.hero-video')) {
        this.initVideoOptimization();
      }
    },

    // Smooth scrolling for anchor links
    setupSmoothScrolling: function () {
      const anchorLinks = DrakkarUtils.$$('a[href^="#"]');

      anchorLinks.forEach(link => {
        link.addEventListener('click', (e) => {
          const href = link.getAttribute('href');

          if (href !== '#' && href !== '#0') {
            const target = DrakkarUtils.$(href);

            if (target) {
              e.preventDefault();
              DrakkarUtils.scrollToElement(target);
            }
          }
        });
      });
    },

    // Header scroll effects
    setupHeaderEffects: function () {
      const header = DrakkarUtils.$('.site-header');
      if (!header) return;

      let lastScrollY = window.scrollY;

      const handleScroll = DrakkarUtils.throttle(() => {
        const currentScrollY = window.scrollY;

        if (currentScrollY > 100) {
          header.classList.add('scrolled');
        } else {
          header.classList.remove('scrolled');
        }

        lastScrollY = currentScrollY;
      }, 16);

      const eventOptions = DrakkarUtils.supportsPassiveEvents() ? { passive: true } : false;
      window.addEventListener('scroll', handleScroll, eventOptions);
    },

    // Mobile menu functionality
    setupMobileMenu: function () {
      const menuToggle = DrakkarUtils.$('.menu-toggle');
      const navigation = DrakkarUtils.$('#site-navigation, .main-navigation');

      if (!menuToggle || !navigation) return;

      // Toggle menu
      menuToggle.addEventListener('click', () => {
        navigation.classList.toggle('mobile-menu-open');
        const expanded = navigation.classList.contains('mobile-menu-open');
        menuToggle.setAttribute('aria-expanded', expanded);
      });

      // Close menu when clicking outside
      document.addEventListener('click', (event) => {
        const isClickInsideNav = navigation.contains(event.target);
        const isClickOnToggle = menuToggle.contains(event.target);

        if (!isClickInsideNav && !isClickOnToggle && navigation.classList.contains('mobile-menu-open')) {
          navigation.classList.remove('mobile-menu-open');
          menuToggle.setAttribute('aria-expanded', false);
        }
      });

      // Close menu on window resize
      window.addEventListener('resize', DrakkarUtils.debounce(() => {
        if (window.innerWidth > 768 && navigation.classList.contains('mobile-menu-open')) {
          navigation.classList.remove('mobile-menu-open');
          menuToggle.setAttribute('aria-expanded', false);
        }
      }, 250));

      // Close menu when ESC is pressed
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && navigation.classList.contains('mobile-menu-open')) {
          navigation.classList.remove('mobile-menu-open');
          menuToggle.setAttribute('aria-expanded', false);
          menuToggle.focus();
        }
      });
    },

    // Accessibility improvements
    setupAccessibility: function () {
      // Skip link functionality
      const skipLink = DrakkarUtils.$('.skip-link');
      if (skipLink) {
        skipLink.addEventListener('click', (e) => {
          e.preventDefault();
          const target = DrakkarUtils.$('#main, main, .main-content');
          if (target) {
            target.focus();
            target.scrollIntoView();
          }
        });
      }

      // Focus management for mobile menu
      const menuLinks = DrakkarUtils.$$('.main-navigation a');
      menuLinks.forEach(link => {
        link.addEventListener('focus', () => {
          const navigation = DrakkarUtils.$('.main-navigation');
          if (navigation && !navigation.classList.contains('mobile-menu-open')) {
            navigation.classList.add('mobile-menu-open');
            const menuToggle = DrakkarUtils.$('.menu-toggle');
            if (menuToggle) {
              menuToggle.setAttribute('aria-expanded', true);
            }
          }
        });
      });
    },

    // Performance optimizations
    setupPerformanceOptimizations: function () {
      // Lazy load images
      this.initLazyLoading();

      // Preload critical resources
      this.preloadCriticalResources();
    },

    // ============================
    // 3. COMPONENT SYSTEMS
    // ============================

    // Statistics counter animation
    initStatisticsAnimation: function () {
      const statItems = DrakkarUtils.$$('.stat-item');
      if (!statItems.length || !DrakkarUtils.supportsIntersectionObserver()) return;

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const item = entry.target;
            const delay = parseInt(item.getAttribute('data-delay')) || 0;

            setTimeout(() => {
              item.classList.add('animate');

              const numberElement = item.querySelector('.stat-number');
              const targetValue = parseFloat(numberElement.getAttribute('data-target'));

              if (!isNaN(targetValue)) {
                this.animateCounter(numberElement, targetValue);
              }
            }, delay);

            observer.unobserve(item);
          }
        });
      }, {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
      });

      statItems.forEach(item => observer.observe(item));
    },

    // Counter animation logic
    animateCounter: function (element, target) {
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
          if (originalText.includes('M')) {
            element.textContent = '+' + (formatted / 1000000).toFixed(1) + 'M';
          } else if (originalText.includes('K')) {
            element.textContent = '+' + (formatted / 1000).toFixed(1) + 'K';
          } else {
            element.textContent = '+' + formatted.toLocaleString();
          }
        }
      }, stepDuration);
    },

    // Video optimization
    initVideoOptimization: function () {
      const videos = DrakkarUtils.$$('.hero-video, video');

      videos.forEach(video => {
        // Set attributes for better mobile support
        video.setAttribute('playsinline', '');
        video.setAttribute('webkit-playsinline', '');
        video.setAttribute('muted', '');

        // Try to play the video
        video.play().catch(() => {
          // If autoplay fails, that's okay - some browsers/users don't allow it
          console.log('Video autoplay was prevented');
        });

        // Pause video when not in viewport for performance
        if (DrakkarUtils.supportsIntersectionObserver()) {
          const videoObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
              if (entry.isIntersecting) {
                video.play().catch(() => { });
              } else {
                video.pause();
              }
            });
          }, { threshold: 0.1 });

          videoObserver.observe(video);
        }
      });
    },

    // Lazy loading for images
    initLazyLoading: function () {
      const images = DrakkarUtils.$$('img[data-src], img[loading="lazy"]');

      if (!images.length || !DrakkarUtils.supportsIntersectionObserver()) return;

      const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;

            if (img.dataset.src) {
              img.src = img.dataset.src;
              img.removeAttribute('data-src');
            }

            img.classList.remove('lazy');
            imageObserver.unobserve(img);
          }
        });
      }, {
        rootMargin: '50px 0px'
      });

      images.forEach(img => {
        img.classList.add('lazy');
        imageObserver.observe(img);
      });
    },

    // Preload critical resources
    preloadCriticalResources: function () {
      // This could be expanded based on specific needs
      const criticalImages = DrakkarUtils.$$('[data-preload]');

      criticalImages.forEach(img => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'image';
        link.href = img.src || img.dataset.src;
        document.head.appendChild(link);
      });
    }
  };

  // ============================
  // 4. INITIALIZATION
  // ============================

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      DrakkarTheme.init();
    });
  } else {
    DrakkarTheme.init();
  }

  // Make utilities available globally if needed
  window.DrakkarUtils = DrakkarUtils;
  window.DrakkarTheme = DrakkarTheme;

  // Global function for mobile menu (for onclick handlers if needed)
  window.toggleMobileMenu = function () {
    const navigation = DrakkarUtils.$('.main-navigation');
    const menuToggle = DrakkarUtils.$('.menu-toggle');

    if (navigation) {
      navigation.classList.toggle('mobile-menu-open');
      const expanded = navigation.classList.contains('mobile-menu-open');
      if (menuToggle) {
        menuToggle.setAttribute('aria-expanded', expanded);
      }
    }
  };

})();

# Drakkar WordPress Theme Documentation

**Version:** 1.0
**Description:** Custom WordPress theme for Drakkar Agricultura de Precisão - Brazilian precision agriculture technology company
**Author:** Drakkar Team

---

## Table of Contents

1. [Overview](#overview)
2. [Theme Structure](#theme-structure)
3. [Features](#features)
4. [Template Hierarchy](#template-hierarchy)
5. [Custom Components](#custom-components)
6. [Styling System](#styling-system)
7. [JavaScript Functionality](#javascript-functionality)
8. [Media Management](#media-management)
9. [Customization](#customization)
10. [Performance Optimizations](#performance-optimizations)
11. [Development Guidelines](#development-guidelines)
12. [Usage Examples](#usage-examples)

---

## Overview

The Drakkar theme is a modern, responsive WordPress theme specifically designed for Drakkar Agricultura de Precisão, a Brazilian precision agriculture technology company. The theme features a sophisticated landing page design with data visualization components, video backgrounds, and interactive elements tailored for showcasing agricultural technology solutions.

### Key Characteristics
- **Industry-focused:** Designed specifically for precision agriculture
- **Data-driven:** Features sophisticated data visualization components
- **Mobile-first:** Responsive design optimized for all devices
- **Performance-oriented:** Optimized images, lazy loading, and efficient asset management
- **Accessibility-focused:** WCAG-compliant with proper ARIA labels and focus management

---

## Theme Structure

```
drakkar/
├── style.css                 # Main theme stylesheet with header info
├── index.php                 # Main template fallback
├── front-page.php           # Custom homepage template
├── header.php               # Site header template
├── footer.php               # Site footer template
├── functions.php            # Theme functionality and hooks
├── NAMING-GUIDE.md          # Template naming conventions
├── assets/                  # Static theme assets
│   ├── MEDIA-GUIDE.md      # Media usage guidelines
│   ├── images/             # Theme images and graphics
│   │   ├── backgrounds/    # Background images
│   │   └── logo-drakkar-full.svg # Main logo
│   ├── icons/              # Icon assets
│   └── videos/             # Video files
├── css/                     # Additional stylesheets
│   └── hero-zero.css       # Hero section specific styles
├── js/                      # JavaScript files
│   ├── main.js             # Main theme JavaScript
│   └── hero-main.js        # Hero section functionality
├── inc/                     # Include files
│   ├── media-helpers.php   # Media handling functions
│   └── customizer-media.php # Customizer media settings
└── template-parts/          # Reusable template components
    ├── hero-main.php       # Main hero section
    ├── hero-statistics.php # Statistics display
    ├── hero-expertise.php  # Expertise section
    ├── hero-big-data.php   # Data visualization dashboard
    ├── hero-success-history.php # Success stories
    └── image-responsive.php # Responsive image helper
```

---

## Features

### Core WordPress Features
- ✅ **Custom Logo Support:** Flexible logo system with SVG/PNG fallbacks
- ✅ **Navigation Menus:** Primary navigation with custom walker
- ✅ **Post Thumbnails:** Full featured image support
- ✅ **HTML5 Support:** Modern markup for forms and galleries
- ✅ **Responsive Embeds:** Automatic responsive video/iframe handling
- ✅ **Block Editor Styles:** Gutenberg block styling support
- ✅ **Title Tag Support:** Automatic SEO-friendly title generation

### Custom Features
- 🎥 **Video Background Hero:** Full-screen video with overlay
- 📊 **Data Visualization:** Interactive charts and statistics
- 📱 **Mobile-First Design:** Optimized for mobile devices
- ♿ **Accessibility Ready:** WCAG 2.1 compliant
- 🚀 **Performance Optimized:** Lazy loading, optimized images
- 🎨 **Custom Image Sizes:** Predefined responsive image sizes
- 📞 **WhatsApp Integration:** Floating WhatsApp widget
- 🔧 **Theme Customizer:** Extended media settings

### Technical Features
- **Sticky Header:** Navigation remains accessible on scroll
- **Smooth Scrolling:** Enhanced anchor link navigation
- **Mobile Menu:** Hamburger menu with slide animations
- **Custom Walker:** Enhanced navigation menu output
- **Asset Management:** Organized asset structure with helper functions
- **Media Quality Control:** Configurable JPEG compression
- **Fallback Systems:** Graceful degradation for missing assets

---

## Template Hierarchy

### Primary Templates
- **`front-page.php`** - Homepage template with hero sections
- **`index.php`** - Fallback template for all content types
- **`header.php`** - Site header with navigation and logo
- **`footer.php`** - Site footer with copyright

### Template Parts Organization
Following the naming convention in `NAMING-GUIDE.md`:

#### Hero Components (`hero-*`)
- **`hero-main.php`** - Primary video hero section
- **`hero-statistics.php`** - Animated statistics counters
- **`hero-expertise.php`** - Expertise showcase
- **`hero-big-data.php`** - Data visualization dashboard
- **`hero-success-history.php`** - Success stories section

#### Section Components (`section-*`)
- **`section-analytics.php`** - Analytics presentation
- **`section-agriculture.php`** - Agriculture solutions

#### Utility Components
- **`image-responsive.php`** - Responsive image handler

---

## Custom Components

### Hero Main Section
**File:** `template-parts/hero-main.php`

A full-screen hero section featuring:
- Video background with MP4 support
- Overlay for text readability
- Animated content with CSS classes
- Integrated WhatsApp widget
- Responsive design with mobile optimization

```php
// Usage
get_template_part('template-parts/hero-main');
```

### Statistics Display
**File:** `template-parts/hero-statistics.php`

Animated statistics section with:
- Counter animations on scroll
- Multiple data points
- Staggered animation delays
- Responsive grid layout

Key statistics displayed:
- 1M+ samples collected
- 1,200+ active clients
- 5M+ hectares influenced
- 3,700+ farms served
- 1.5M+ maps generated/year

### Big Data Dashboard
**File:** `template-parts/hero-big-data.php`

Sophisticated data visualization featuring:
- Portuguese-language interface
- Soil analysis data presentation
- Responsive bar chart visualization
- Configurable data through filters
- Sample count display

### Custom Navigation Walker
**Class:** `Drakkar_Walker_Nav_Menu`

Enhanced navigation menu output with:
- Custom CSS classes
- Improved HTML structure
- Accessibility attributes
- Submenu support

---

## Styling System

### Main Stylesheet (`style.css`)
- **Reset & Base Styles:** Modern CSS reset with system fonts
- **Header Styles:** Sticky navigation with scroll effects
- **Logo Handling:** Flexible logo display with text fallback
- **Navigation Styling:** Modern menu with hover effects
- **Mobile Responsiveness:** Comprehensive mobile menu system
- **Accessibility:** Focus styles and skip links

### Hero Styles (`css/hero-zero.css`)
- **Video Background:** Full-screen video container
- **Content Overlay:** Text positioning and animation
- **CTA Buttons:** Modern button styling with hover effects
- **WhatsApp Widget:** Floating chat widget
- **Responsive Design:** Mobile-optimized layouts

### Design Tokens
```css
/* Primary Colors */
--primary-red: #c53e3e;
--primary-red-hover: #b12e2e;
--text-primary: #333;
--text-secondary: #666;

/* Typography */
font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;

/* Spacing */
--header-height: 80px;
--mobile-header-height: 70px;
```

---

## JavaScript Functionality

### Main Script (`js/main.js`)
- **Smooth Scrolling:** Enhanced anchor link navigation
- **Header Effects:** Scroll-based header styling
- **Mobile Menu:** Toggle functionality for responsive menu

### Hero Script (`js/hero-main.js`)
- **Video Background:** Video loading and playback management
- **Animation Triggers:** Scroll-based content animations
- **WhatsApp Widget:** Interactive chat functionality

### Key Functions
```javascript
// Smooth scrolling for anchor links
anchorLinks.forEach(function (link) {
  link.addEventListener("click", function (e) {
    // Smooth scroll implementation
  });
});

// Header scroll effect
window.addEventListener("scroll", function () {
  if (currentScrollY > 100) {
    header.classList.add("scrolled");
  }
});
```

---

## Media Management

### Custom Image Sizes
Defined in `functions.php`:
- **`drakkar-thumbnail`**: 150×150px (cropped)
- **`drakkar-small`**: 300×200px (cropped)
- **`drakkar-medium`**: 600×400px (cropped)
- **`drakkar-large`**: 1200×800px (cropped)
- **`drakkar-hero`**: 1920×1080px (cropped)

### Helper Functions
**File:** `inc/media-helpers.php`

```php
// Get theme asset URL
drakkar_get_asset_url($path)

// Get theme image URL
drakkar_get_image_url($filename)

// Get responsive image HTML
drakkar_get_responsive_image($attachment_id, $size, $attr)

// Get featured image with fallback
drakkar_get_featured_image($post_id, $size, $fallback_image)
```

### Logo System
The theme implements a sophisticated logo fallback system:
1. WordPress custom logo (if set)
2. Theme asset: `logo-drakkar-full.svg`
3. Theme asset: `logo-drakkar-full.png`
4. Legacy: `/wp-content/logos/` directory
5. Text fallback with tagline

### Media Guidelines
From `assets/MEDIA-GUIDE.md`:
- Use responsive images with appropriate sizes
- Enable lazy loading for below-fold content
- Organize assets in logical folders
- Optimize images for web performance

---

## Customization

### Theme Customizer Integration
**File:** `inc/customizer-media.php`

Additional customizer sections:
- **Default Featured Image:** Fallback for posts without featured images
- **Hero Background:** Custom hero section background
- **About Section Image:** About section imagery
- **Lazy Loading:** Enable/disable lazy loading
- **Image Quality:** JPEG compression control (1-100)

### Filters and Hooks
```php
// Customize big data configuration
add_filter('drakkar_hero_big_data_config', function($config) {
    $config['title'] = 'Custom Title';
    return $config;
});

// Adjust image quality
add_filter('drakkar_image_quality', function() {
    return 90; // Higher quality
});
```

### Custom Post Types & Fields
The theme is designed to work with custom fields for:
- Statistics data
- Hero content
- Company information
- Case studies

---

## Performance Optimizations

### Image Optimization
- **Lazy Loading:** Native lazy loading for images
- **Responsive Images:** Multiple size variants
- **Quality Control:** Configurable JPEG compression
- **Format Selection:** SVG preferred for logos and icons

### Asset Management
- **CSS Organization:** Modular stylesheet structure
- **JavaScript Loading:** Footer loading with proper dependencies
- **Version Control:** Theme version-based cache busting
- **Minification Ready:** Structured for build tools

### Loading Strategies
- **Critical CSS:** Inline critical styles in `style.css`
- **Deferred JavaScript:** Non-blocking script loading
- **Preload Hints:** Video and key assets preloading
- **Progressive Enhancement:** Graceful degradation

---

## Development Guidelines

### Naming Conventions
From `NAMING-GUIDE.md`:
- **`hero-*`**: Main page introduction components
- **`section-*`**: Content sections
- **`component-*`**: Reusable UI elements
- **`loop-*`**: Content loops

### Code Standards
- **WordPress Coding Standards:** PSR-12 compatible PHP
- **Security:** Proper escaping and sanitization
- **Accessibility:** WCAG 2.1 AA compliance
- **Performance:** Optimized database queries
- **Documentation:** Comprehensive inline documentation

### File Organization
- **Template Parts:** Logical component separation
- **Asset Structure:** Organized media management
- **Function Organization:** Grouped by functionality
- **CSS Architecture:** Modular stylesheet approach

### Best Practices
```php
// Always escape output
echo esc_html($title);
echo esc_url($link);

// Use proper WordPress functions
get_template_part('template-parts/hero-main');

// Implement fallbacks
if (has_custom_logo()) {
    // Custom logo logic
} else {
    // Fallback logic
}
```

---

## Usage Examples

### Basic Theme Setup
```php
// In functions.php - adding theme support
add_theme_support('custom-logo', array(
    'height' => 100,
    'width' => 300,
    'flex-height' => true,
    'flex-width' => true,
));
```

### Custom Component Usage
```php
// Including hero components in templates
get_template_part('template-parts/hero-main');
get_template_part('template-parts/hero-statistics');
get_template_part('template-parts/hero-big-data');
```

### Media Helper Usage
```php
// Display responsive featured image
echo drakkar_get_featured_image(
    get_the_ID(),
    'drakkar-large',
    'default-featured.jpg'
);

// Get theme asset URL
$background = drakkar_get_image_url('backgrounds/hero-bg.jpg');
```

### Customizer Integration
```php
// Get customizer settings
$hero_bg = get_theme_mod('drakkar_hero_background');
$image_quality = get_theme_mod('drakkar_image_quality', 85);
```

### Navigation Menu
```php
// Custom navigation with walker
wp_nav_menu(array(
    'theme_location' => 'primary',
    'walker' => new Drakkar_Walker_Nav_Menu(),
    'fallback_cb' => 'drakkar_fallback_menu',
));
```

---

## Browser Support

### Target Browsers
- **Chrome/Edge:** Latest 2 versions
- **Firefox:** Latest 2 versions
- **Safari:** Latest 2 versions
- **Mobile Safari:** Latest 2 versions
- **Chrome Mobile:** Latest 2 versions

### Progressive Enhancement
- **CSS Grid:** With flexbox fallbacks
- **Modern JavaScript:** ES6+ with babel transpilation
- **CSS Custom Properties:** With static fallbacks
- **Modern Image Formats:** WebP with JPEG fallbacks

---

## Maintenance & Updates

### Regular Maintenance
- **WordPress Updates:** Test theme compatibility
- **Plugin Conflicts:** Monitor for conflicts
- **Performance Monitoring:** Regular speed tests
- **Accessibility Audits:** Periodic WCAG compliance checks

### Update Procedures
1. **Backup:** Always backup before updates
2. **Staging:** Test on staging environment
3. **Dependencies:** Update included libraries
4. **Testing:** Cross-browser and device testing
5. **Documentation:** Update this documentation

### Troubleshooting
- **Check error logs:** WordPress debug mode
- **Validate markup:** W3C validation
- **Test performance:** PageSpeed Insights
- **Accessibility check:** WAVE web accessibility evaluation

---

## Contact & Support

**Development Team:** Drakkar Team
**Theme Version:** 1.0
**WordPress Compatibility:** 5.0+
**PHP Compatibility:** 7.4+

For technical support or customization requests, please contact the development team with:
- **Issue description**
- **Browser/device information**
- **Screenshots if applicable**
- **Steps to reproduce**

---

*This documentation is maintained alongside the theme development and should be updated with any significant changes or additions to the theme functionality.*

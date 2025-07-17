# Drakkar Theme Documentation

## Overview
Custom WordPress theme for **Drakkar Agricultura de Precisão** - Brazilian precision agriculture technology company.

**Version:** 2.0
**Requirements:** WordPress 5.0+, PHP 7.4+
**Architecture:** Component-based with unified CSS architecture

## Quick Start

### Development Setup
1. Ensure WordPress dev server is running: `php -S localhost:8000 -t wordpress`
2. All styles are unified in `dist/main.css` for optimal performance
3. CSS custom properties provide consistent design system

### Theme Structure
```
drakkar/
├── style.css           # WordPress theme header only
├── functions.php       # Core theme functions
├── front-page.php      # Homepage template
├── header.php          # Site header
├── footer.php          # Site footer
├── index.php           # Default template
├── assets/             # Static assets (images, icons, videos)
├── js/                 # JavaScript files (legacy - backup only)
├── dist/               # Unified CSS and JavaScript files
│   ├── main.css       # Single, consolidated stylesheet
│   └── main.js        # Single, consolidated JavaScript file
├── inc/                # PHP includes
│   ├── new/           # Refactored class-based architecture
│   ├── media-helpers.php
│   └── customizer-media.php
└── template-parts/     # Reusable template components
    ├── components/
    └── hero/          # Hero section variants
```

## Core Features

### 1. Unified CSS & JavaScript Architecture

- **Single Stylesheet:** All styles consolidated in `dist/main.css`
- **Single JavaScript File:** All scripts consolidated in `dist/main.js`
- **CSS Custom Properties:** Complete design system with variables
- **Performance Optimized:** One HTTP request each for styles and scripts
- **Component-based:** Modular organization with clear sections
- **Design System:** Consistent colors, typography, spacing, and shadows

### 2. CSS Structure

The unified `dist/main.css` includes:

```text
1. CSS Custom Properties (Design System)
   - Colors, typography, spacing, borders, shadows
2. Reset & Base Styles
   - Normalize, typography, base elements
3. Layout Components
   - Header, navigation, containers
4. Hero Components
   - Main hero, statistics, video backgrounds
5. UI Components
   - Buttons, WhatsApp widget, forms
6. Footer Components
   - Footer sections, statistics, branding
7. Utilities & Animations
   - Helper classes, keyframes, transitions
8. Responsive Design
   - Mobile-first breakpoints
9. Accessibility & Performance
   - Reduced motion, high contrast support
```

### 3. JavaScript Structure

The unified `dist/main.js` includes:

```text
1. Utility Functions
   - DOM selectors, throttle/debounce, viewport detection
2. Core Theme Functionality
   - Smooth scrolling, header effects, mobile menu
3. Component Systems
   - Statistics animations, lazy loading, video optimization
4. Hero-specific Features
   - Hero animations and interactions
5. Performance Optimizations
   - Intersection Observer, passive events, preloading
6. Accessibility Features
   - Skip links, focus management, keyboard navigation
```

### 4. Image Handling

**Custom Image Sizes:**

- `drakkar-thumbnail`: 150×150px
- `drakkar-medium`: 600×400px
- `drakkar-large`: 1200×800px
- `drakkar-hero`: 1920×1080px

**Helper Functions:**

```php
drakkar_get_image_url('logo.png')           # Theme assets
drakkar_get_featured_image($id, $size)      # WordPress media
drakkar_get_responsive_image($id, $size)    # Responsive images
```

### 5. Theme Support

- Custom logo (300×100px, flexible)
- Post thumbnails
- HTML5 markup
- Responsive embeds
- Block editor styles
- Custom navigation menus

## Template Hierarchy

### Homepage (`front-page.php`)

Modular hero sections:

- `hero-main.php` - Primary hero with video background
- `hero-statistics.php` - Company stats with animations
- `hero-expertise.php` - Services showcase
- `hero-big-data.php` - Technology focus
- `hero-success-history.php` - Case studies

### Components (`template-parts/`)

- Reusable template parts
- Responsive image components
- Hero section variants

## Development Guidelines

### CSS Best Practices

- **Use CSS Custom Properties:** All colors, sizes, and spacing use design system variables
- **Single Source of Truth:** All styles in `dist/main.css`
- **Component Organization:** Styles grouped by component type
- **Responsive Design:** Mobile-first approach with CSS custom properties
- **Performance:** Avoid inline styles, minimize HTTP requests

### Example CSS Custom Properties Usage

```css
.my-component {
    color: var(--color-primary);
    font-size: var(--font-size-lg);
    padding: var(--spacing-lg);
    border-radius: var(--border-radius-md);
    transition: var(--transition-base);
}
```

### PHP Best Practices

- Follow WordPress coding standards
- Use theme helper functions for media
- Leverage class-based architecture in `inc/new/`

### Media Management

- **Theme assets:** `/assets/` directory
- **User content:** WordPress media library
- **Organization:** Use subfolders (logos/, backgrounds/)
- **Performance:** Enable lazy loading, use responsive images

## CSS Design System

### Colors

- `--color-primary`: #c53e3e (Drakkar red)
- `--color-primary-dark`: #b12e2e
- `--color-secondary`: #25d366 (WhatsApp green)
- `--color-text-primary`: #333
- `--color-white`: #ffffff

### Typography

- Font sizes: `--font-size-xs` to `--font-size-7xl`
- Font weights: `--font-weight-normal` to `--font-weight-bold`
- Line heights: `--line-height-tight`, `--line-height-normal`, `--line-height-relaxed`

### Spacing

- Consistent spacing: `--spacing-xs` to `--spacing-4xl`
- Responsive design with consistent units

### Shadows & Effects

- Predefined shadows: `--shadow-sm` to `--shadow-xl`
- Transition speeds: `--transition-fast`, `--transition-base`, `--transition-slow`

## File Locations

### Key Files

- **Main stylesheet:** `dist/main.css` (UNIFIED - contains ALL styles)
- **Main JavaScript:** `dist/main.js` (UNIFIED - contains ALL scripts)
- **Theme functions:** `functions.php`
- **Asset classes:** `inc/new/class-drakkar-assets.php`
- **Component classes:** `inc/new/class-drakkar-components.php`
- **Media helpers:** `inc/media-helpers.php`

### Templates

- **Homepage:** `front-page.php`
- **Default:** `index.php`
- **Components:** `template-parts/`

## Maintenance

### Version 2.0 Changes

- **UNIFIED CSS:** All styles consolidated into single `dist/main.css` file
- **UNIFIED JAVASCRIPT:** All scripts consolidated into single `dist/main.js` file
- **CSS Custom Properties:** Complete design system implementation
- **Performance:** Single HTTP request each for styles and scripts
- **Component-based architecture:** Clear style and script organization
- **Enhanced media handling system**
- **Improved accessibility and responsive design**

### Best Practices

- Test changes with WordPress 5.0+ and PHP 7.4+
- Maintain responsive design principles
- Use semantic HTML5 markup
- Follow WordPress accessibility guidelines
- Optimize images and assets for performance
- Always use CSS custom properties for consistency

### Adding New Styles

1. **Use existing CSS custom properties** when possible
2. **Add new properties to the design system** if needed
3. **Follow the component structure** in `dist/main.css`
4. **Test responsiveness** across all breakpoints
5. **Ensure accessibility compliance**

### Adding New JavaScript

1. **Add functionality to the unified `dist/main.js`** file
2. **Follow the existing structure** (utilities, components, features)
3. **Use the DrakkarUtils and DrakkarTheme** namespaces
4. **Ensure performance** with throttling/debouncing where needed
5. **Test across all browsers and devices**

## Performance Benefits

### Unified CSS & JavaScript Approach

- **Single HTTP Requests:** All styles in one file, all scripts in one file
- **Reduced Latency:** No multiple file downloads
- **Better Caching:** Fewer files to cache and manage
- **Smaller Total Size:** No duplicate code between files
- **Faster Rendering:** Browser processes resources once
- **Improved Mobile Performance:** Critical for slower connections

### Design System Benefits

- **Consistency:** All components use same variables
- **Maintainability:** Change variables to update entire theme
- **Scalability:** Easy to add new components
- **Developer Experience:** Clear, documented system

## Support

For theme-specific issues, refer to the component documentation in `inc/new/` classes and the media guide in `assets/MEDIA-GUIDE.md`. All styles are now consolidated in `dist/main.css` and all JavaScript in `dist/main.js` for easier maintenance and better performance.

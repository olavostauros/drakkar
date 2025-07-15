# Drakkar Theme Documentation

## Overview
Custom WordPress theme for **Drakkar Agricultura de Precisão** - Brazilian precision agriculture technology company.

**Version:** 2.0
**Requirements:** WordPress 5.0+, PHP 7.4+
**Architecture:** Component-based with consolidated assets

## Quick Start

### Development Setup
1. Ensure WordPress dev server is running: `php -S localhost:8000 -t wordpress`
2. Assets are consolidated in `dist/main.css` for performance
3. All custom styles use CSS custom properties for consistency

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
├── css/                # Source CSS files
├── js/                 # JavaScript files
├── dist/               # Compiled/optimized assets
├── inc/                # PHP includes
│   ├── new/           # Refactored class-based architecture
│   ├── media-helpers.php
│   └── customizer-media.php
└── template-parts/     # Reusable template components
    ├── components/
    └── hero/          # Hero section variants
```

## Core Features

### 1. Asset Management
- **Consolidated CSS:** All styles in `dist/main.css`
- **CSS Custom Properties:** Design system variables
- **Performance Optimized:** Single HTTP request for styles
- **Component-based:** Modular organization

### 2. Image Handling
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

### 3. Theme Support
- Custom logo (300×100px, flexible)
- Post thumbnails
- HTML5 markup
- Responsive embeds
- Block editor styles
- Custom navigation menus

## Template Hierarchy

### Homepage (`front-page.php`)
Modular hero sections:
- `hero-main.php` - Primary hero
- `hero-statistics.php` - Company stats
- `hero-expertise.php` - Services showcase
- `hero-big-data.php` - Technology focus
- `hero-success-history.php` - Case studies

### Components (`template-parts/`)
- Reusable template parts
- Responsive image components
- Hero section variants

## Development Guidelines

### CSS Architecture
- Use CSS custom properties defined in the design system
- Component-based styles in `dist/main.css`
- Avoid inline styles - use utility classes

### PHP Best Practices
- Follow WordPress coding standards
- Use theme helper functions for media
- Leverage class-based architecture in `inc/new/`

### Media Management
- **Theme assets:** `/assets/` directory
- **User content:** WordPress media library
- **Organization:** Use subfolders (logos/, backgrounds/)
- **Performance:** Enable lazy loading, use responsive images

## File Locations

### Key Files
- **Main stylesheet:** `dist/main.css`
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
- Complete refactoring with CSS custom properties
- Consolidated assets for better performance
- Component-based architecture
- Enhanced media handling system

### Best Practices
- Test changes with WordPress 5.0+ and PHP 7.4+
- Maintain responsive design principles
- Use semantic HTML5 markup
- Follow WordPress accessibility guidelines
- Optimize images and assets for performance

## Support
For theme-specific issues, refer to the component documentation in `inc/new/` classes and the media guide in `assets/MEDIA-GUIDE.md`.

# WordPress Template Parts - Naming Guide

## Overview

This guide documents the WordPress template part naming conventions used in the Drakkar theme and provides best practices for future development.

## Template Renaming History - COMPLETED ✅

### Files Successfully Renamed

#### ✅ Template Parts Directory Changes
```
OLD NAME                    →  NEW NAME                    STATUS
────────────────────────────────────────────────────────────────────
hero-zero.php              →  hero-main.php               ✅ RENAMED
hero-agriculture.php        →  section-agriculture.php     ✅ RENAMED  
hero-big-data.php          →  section-analytics.php       ✅ RENAMED
statistics.php             →  hero-statistics.php         ✅ RENAMED
image-responsive.php       →  image-responsive.php        ✅ NO CHANGE
```

## WordPress Naming Conventions

### 1. Template Part Types

#### Primary Categories:
- **`hero-*`** → Main introductory sections (usually only ONE per page)
- **`section-*`** → Content sections 
- **`component-*`** → Reusable UI components
- **`widget-*`** → Widget-like elements
- **`loop-*`** → Content loops (posts, products, etc.)

#### Current Structure (WordPress Convention Compliant):
```
template-parts/
├── hero-main.php               # Main hero section (primary/first)
├── section-agriculture.php     # Agriculture content section
├── section-analytics.php       # Big data/analytics section  
├── hero-statistics.php         # Statistics section
└── image-responsive.php        # Responsive image component
```

### 2. Semantic Purpose Over Visual Style

#### ❌ Avoid Visual Hierarchy Names:
```php
hero-big-data.php    // Describes visual hierarchy
hero-secondary.php   // Describes position
section-blue.php     // Describes appearance
```

#### ✅ Use Content-Focused Names:
```php
section-analytics.php    // Describes content purpose
section-about.php        // Describes content type
section-services.php     // Describes business function
```

### 3. Content-First Naming Examples

```php
// Recommended template part names:
hero-main.php              # Primary hero (above the fold)
section-about.php          # About company content
section-services.php       # Services overview
section-portfolio.php      # Work showcase
section-contact.php        # Contact information
section-testimonials.php   # Customer testimonials
component-testimonial.php  # Single testimonial component
component-card.php         # Reusable card component
component-cta.php          # Call-to-action button
loop-posts.php            # Blog posts loop
loop-products.php         # Product listing loop
```

## Implementation Changes Made

### ✅ References Successfully Updated

#### front-page.php
```php
// OLD REFERENCES (REMOVED):
get_template_part('template-parts/hero-zero');
get_template_part('template-parts/statistics'); 
get_template_part('template-parts/hero-big-data');
get_template_part('template-parts/hero-agriculture');

// NEW REFERENCES (UPDATED):
get_template_part('template-parts/hero-main');
get_template_part('template-parts/hero-statistics');
get_template_part('template-parts/section-analytics'); 
get_template_part('template-parts/section-agriculture');
```

#### functions.php
```php
// UPDATED CSS ENQUEUE:
wp_enqueue_style('drakkar-hero-main-css', get_template_directory_uri() . '/css/hero-zero.css', ...);
```

### ✅ Template File Headers
Updated all template part headers with:
- Proper semantic descriptions
- @package Drakkar tags
- Clear purpose explanations

### ✅ CSS Classes Updated

#### section-agriculture.php:
- `hero-agriculture` → `section-agriculture` 
- `hero-background` → `agriculture-background`
- `hero-content` → `agriculture-content`
- `hero-badge` → `agriculture-badge`
- `hero-title` → `agriculture-title`

#### section-analytics.php:
- `hero-big-data` → `section-analytics`
- All related CSS classes updated throughout file

## Usage Guidelines

### How to Use in Templates

#### ✅ Current Implementation:
```php
// Main hero (above the fold)
get_template_part('template-parts/hero-main');

// Content sections
get_template_part('template-parts/section-agriculture');
get_template_part('template-parts/section-analytics');
get_template_part('template-parts/hero-statistics');

// Reusable components
get_template_part('template-parts/image-responsive');
```

### Best Practices

1. **One True Hero** - Use only one `hero-*` template per page
2. **Descriptive Sections** - Name sections by their content purpose
3. **Reusable Components** - Use `component-*` for elements used across multiple templates
4. **Consistent Prefixes** - Stick to established prefixes for similar functionality

## Benefits Achieved

### ✅ WordPress Convention Compliance
1. **Clear Purpose** - Each file name describes its content/function
2. **WordPress Standards** - Follows official WordPress template part conventions
3. **Maintainability** - Easy for developers to understand and modify
4. **Scalability** - Consistent naming allows for easy expansion
5. **SEO/Accessibility** - Better semantic structure for screen readers

### ✅ Developer Benefits
- **Clarity** → Developers immediately understand content purpose
- **Maintainability** → Easier to find and modify specific sections
- **Team Onboarding** → New team members can navigate the codebase
- **Code Organization** → Logical file structure supports project growth

## Future Considerations

### Recommended Additions
Consider adding these template parts as the site grows:
- `section-testimonials.php` - Customer success stories
- `section-services.php` - Service offerings
- `section-contact.php` - Contact information
- `component-cta.php` - Reusable call-to-action button
- `component-social-links.php` - Social media links
- `loop-news.php` - News/blog post loop

### CSS File Consideration
Consider renaming `hero-zero.css` to `hero-main.css` to match the new file naming convention.

## Template Part Structure Reference

```
wp-content/themes/drakkar/template-parts/
├── hero-main.php           # Primary hero section
├── section-agriculture.php # About/company section  
├── section-analytics.php   # Data visualization section
├── hero-statistics.php     # Metrics/achievements section
└── image-responsive.php    # Reusable image component
```

---

**✅ RENAMING COMPLETE - All files and references successfully updated!**

*This guide serves as both documentation of completed work and a reference for future template part development in the Drakkar theme.*

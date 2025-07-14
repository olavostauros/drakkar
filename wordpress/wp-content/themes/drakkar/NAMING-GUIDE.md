# WordPress Template Parts - Naming Guide

## Overview

This guide documents the WordPress template part naming conventions used in the Drakkar theme and provides best practices for future development.

## WordPress Naming Conventions

### Template Part Types

#### Primary Categories:
- **`hero-*`** → Main introductory sections (usually only ONE per page)
- **`section-*`** → Content sections 
- **`component-*`** → Reusable UI components
- **`widget-*`** → Widget-like elements
- **`loop-*`** → Content loops (posts, products, etc.)

#### Current Structure:
```
template-parts/
├── hero-main.php               # Main hero section (primary/first)
├── section-agriculture.php     # Agriculture content section
├── section-analytics.php       # Big data/analytics section  
├── hero-statistics.php         # Statistics section
└── image-responsive.php        # Responsive image component
```

### Semantic Purpose Over Visual Style

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

### Best Practices

1. **One True Hero** - Use only one `hero-*` template per page
2. **Descriptive Sections** - Name sections by their content purpose
3. **Reusable Components** - Use `component-*` for elements used across multiple templates
4. **Consistent Prefixes** - Stick to established prefixes for similar functionality

## Usage in Templates

### Current Implementation:
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

## Benefits

- **Clear Purpose** - Each file name describes its content/function
- **WordPress Standards** - Follows official WordPress template part conventions
- **Maintainability** - Easy for developers to understand and modify
- **Scalability** - Consistent naming allows for easy expansion
- **Team Onboarding** - New team members can navigate the codebase

## Future Considerations

### Recommended Additions:
- `section-testimonials.php` - Customer success stories
- `section-services.php` - Service offerings
- `section-contact.php` - Contact information
- `component-cta.php` - Reusable call-to-action button
- `component-social-links.php` - Social media links
- `loop-news.php` - News/blog post loop

### CSS File Consideration
Consider renaming `hero-zero.css` to `hero-main.css` to match the new file naming convention.

# WordPress Template Parts - Recommended Structure

## Current vs. Recommended Naming

### ❌ Current Structure (Confusing)
```
template-parts/
├── hero-zero.php        # Main hero section
├── hero-agriculture.php # Agriculture section (not really a hero)
├── hero-big-data.php    # Analytics section (not really a hero)
└── statistics.php       # Statistics section
```

### ✅ Updated Structure (WordPress Convention) ✅
```
template-parts/
├── hero-main.php               # Main hero section (primary/first)
├── section-agriculture.php     # Agriculture content section ✅ RENAMED
├── section-analytics.php       # Big data/analytics section ✅ RENAMED  
├── section-statistics.php      # Statistics section ✅ RENAMED
├── image-responsive.php        # Responsive image template
└── hero-zero.php.md            # Documentation file
```

## WordPress Naming Conventions

### 1. **Template Part Types**
- `hero-*` → Main introductory sections (usually only ONE per page)
- `section-*` → Content sections 
- `component-*` → Reusable UI components
- `widget-*` → Widget-like elements
- `loop-*` → Content loops (posts, products, etc.)

### 2. **Semantic Purpose Over Visual Style**
- ❌ `hero-big-data.php` (describes visual hierarchy)
- ✅ `section-analytics.php` (describes content purpose)

### 3. **Content-First Naming**
```php
// Good examples:
section-about.php         # About company content
section-services.php      # Services overview
section-portfolio.php     # Work showcase
section-contact.php       # Contact information
component-testimonial.php # Single testimonial
component-card.php        # Reusable card component
```

## How to Use in Templates

### Current Usage (you might have):
```php
get_template_part('template-parts/hero-zero');
get_template_part('template-parts/hero-agriculture');
get_template_part('template-parts/hero-big-data');
```

### ✅ Updated Usage (Now Implemented):
```php
// Main hero (above the fold)
get_template_part('template-parts/hero-main');

// Content sections
get_template_part('template-parts/section-agriculture');
get_template_part('template-parts/section-analytics');
get_template_part('template-parts/section-statistics');
```

## ✅ Changes Made

1. **Files Renamed:**
   - `hero-zero.php` → `hero-main.php`
   - `hero-agriculture.php` → `section-agriculture.php`
   - `hero-big-data.php` → `section-analytics.php`
   - `statistics.php` → `section-statistics.php`

2. **References Updated:**
   - `front-page.php` - Updated all get_template_part() calls
   - `functions.php` - Updated CSS enqueue references
   - Template headers updated with proper descriptions

3. **CSS Classes Updated:**
   - `hero-agriculture` → `section-agriculture`
   - `hero-big-data` → `section-analytics`
   - Component-specific classes updated for semantic clarity

## Benefits of Proper Naming

1. **Clarity** → Developers immediately understand content purpose
2. **Maintainability** → Easier to find and modify specific sections
3. **Scalability** → New team members can navigate the codebase
4. **SEO** → Better semantic structure for search engines
5. **Accessibility** → Screen readers can better understand page structure

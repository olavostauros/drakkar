# Drakkar Theme Refactoring Plan

**Objective:** Eliminate redundancies, improve maintainability, and optimize performance using CSS, JavaScript, PHP, and WordPress without build tools.

**Date:** July 15, 2025
**Current Version:** 1.0
**Target Version:** 2.0
**Implementation:** WordPress/LAMP Stack

---

## Table of Contents

1. [Executive Summary](#executive-summary)
2. [Implementation Strategy](#implementation-strategy)
3. [Identified Redundancies](#identified-redundancies)
4. [Implementation Phases](#implementation-phases)
5. [File Structure Changes](#file-structure-changes)
6. [Performance Improvements](#performance-improvements)
7. [Testing Strategy](#testing-strategy)
8. [Risk Assessment](#risk-assessment)

---

## Executive Summary

### Technology Stack
- CSS with Custom Properties (no preprocessors)
- Vanilla JavaScript (no frameworks)
- PHP with WordPress functions and custom classes
- Direct file management (no build tools)

### Key Issues
- **CSS Duplication:** 721 lines across multiple files with repeated patterns
- **JavaScript Redundancy:** Fragmented event handlers and DOM manipulation
- **Template Inconsistency:** Inline styles mixed with external stylesheets
- **PHP Function Overlap:** Redundant asset management and image handling
- **Component Structure:** Multiple similar hero sections with duplicate code

### Expected Benefits
- **30-40% reduction** in CSS file size through consolidation
- **25% reduction** in JavaScript file size via utility functions
- **Zero build dependency** - direct file editing and WordPress enqueuing
- **Improved maintainability** through CSS custom properties and PHP classes
- **Better performance** through single-file loading and optimized functions

---

## Implementation Strategy

### 1. CSS Architecture

#### CSS Custom Properties Foundation
```css
/* Consolidated file: dist/main.css */
:root {
    /* Design tokens */
    --color-primary: #c53e3e;
    --color-primary-dark: #b12e2e;
    --spacing-md: 1rem;
    --font-size-4xl: 3rem;
    /* ... design variables */
}

/* Structure: Variables -> Base -> Layout -> Components -> Utilities */
```

### 2. JavaScript Architecture

#### Utility-First Approach
```javascript
/* Single main.js file with IIFE pattern */
(function() {
    'use strict';

    const DrakkarUtils = {
        $: (selector) => document.querySelector(selector),
        $$: (selector) => document.querySelectorAll(selector),
        // ... utility functions
    };

    const DrakkarTheme = {
        init: function() {
            this.setupSmoothScrolling();
            this.setupHeaderEffects();
            // ... feature initialization
        }
    };
})();
```
### 3. PHP Architecture

#### Class-Based Organization
```php
/* New file: inc/class-drakkar-assets.php */
class Drakkar_Assets {
    public static function init() {
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_styles']);
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_scripts']);
    }

    public static function enqueue_styles() {
        wp_enqueue_style('drakkar-main', get_template_directory_uri() . '/dist/main.css', [], '2.0.0');
    }
}
```

### 4. File Organization

```
drakkar/
├── style.css                    # WordPress header only
├── dist/
│   └── main.css                # Single consolidated CSS file
├── js/
│   └── main.js                 # Single consolidated JS file
├── inc/                        # PHP class files
│   ├── class-drakkar-assets.php
│   ├── class-drakkar-components.php
│   └── class-drakkar-performance.php
├── template-parts/             # Cleaned template parts
│   ├── hero-main.php          # Inline styles removed
│   ├── hero-expertise.php     # Inline styles removed
│   └── hero-big-data.php      # Inline styles removed
└── functions.php              # Updated to use new classes
```

---

## Identified Redundancies

### 1. CSS Redundancies

#### Hero Section Patterns
```css
/* REDUNDANT: Repeated across multiple hero components */
.hero-* {
    position: relative;
    min-height: 100vh;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    overflow: hidden;
}
```

**Found in:**
- `template-parts/hero-main.php` (inline styles)
- `template-parts/hero-expertise.php` (inline styles)
- `css/hero-zero.css`

#### Button Styling Patterns
```css
/* REDUNDANT: Similar CTA button styles */
.hero-cta, .hero-cta-button, .cta-button {
    background-color: #c53e3e;
    color: white;
    padding: 16px 32px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}
```

#### Responsive Breakpoints
```css
/* REDUNDANT: Same breakpoints across files */
@media (max-width: 768px) { /* Mobile */ }
@media (max-width: 480px) { /* Small mobile */ }
@media (max-width: 1024px) { /* Tablet */ }
```

#### Color Variables
```css
/* REDUNDANT: Hardcoded colors throughout */
#c53e3e  /* Primary red - used 15+ times */
#333     /* Text primary - used 10+ times */
#666     /* Text secondary - used 8+ times */
#fff     /* White - used 20+ times */
```

### 2. JavaScript Redundancies

#### DOM Selectors
```javascript
// REDUNDANT: Repeated selectors
document.querySelector(".site-header")      // 3 times
document.querySelectorAll('a[href^="#"]')  // 2 times
```

#### Event Handlers
```javascript
// REDUNDANT: Similar scroll event handlers
window.addEventListener("scroll", function () {
    // Header scroll effect
});

// Similar pattern in hero-main.js for animations
```

#### Animation Functions
```javascript
// REDUNDANT: Counter animation logic could be generalized
function animateCounters() {
    // Similar patterns across components
}
```

### 3. PHP Function Redundancies

#### Template Loading
```php
// REDUNDANT: Similar wp_enqueue_* patterns
wp_enqueue_style('drakkar-hero-main', /* ... */);
wp_enqueue_script('drakkar-hero-main', /* ... */);
```

#### Image Handling
```php
// REDUNDANT: Similar image URL generation
drakkar_get_image_url($filename)
drakkar_get_asset_url($path)
// Could be unified into single function
```

#### Escape Functions
```php
// REDUNDANT: Repeated escaping patterns
echo esc_url(/* ... */);
echo esc_html(/* ... */);
echo wp_kses_post(/* ... */);
```

### 4. Template Structure Redundancies

#### Hero Component Boilerplate
```php
// REDUNDANT: Similar structure across hero-*.php files
<?php
/**
 * Hero [Name] Component
 * @package Drakkar
 */

// Similar background image logic
// Similar section wrapper
// Similar content structure
```

#### Inline Styles
- **hero-expertise.php**: 167 lines of CSS inline
- **hero-main.php**: Inline style enqueuing
- **hero-big-data.php**: Mixed inline/external styles

---

## Refactoring Strategy

### 1. CSS Architecture
- Create design system with CSS custom properties for colors, spacing, typography
- Consolidate hero sections into unified `.hero` component with variants
- Unify button styles under `.btn` component with modifiers
- Move all inline styles to consolidated `dist/main.css` file

### 2. JavaScript Modularization
- Create utility functions for DOM manipulation, animations, events
- Consolidate event handlers into single initialization pattern
- Use native APIs (IntersectionObserver, requestAnimationFrame)
- Implement throttling/debouncing for performance

### 3. PHP Organization
- Create asset management class for unified enqueuing
- Build component system for reusable template functions
- Standardize image handling and escaping patterns
- Remove code duplication across template parts
```

---

## Implementation Phases

### Phase 1: Foundation Setup (Day 1-2)
**Priority: HIGH**

#### Tasks:
1. **Create consolidated CSS file**
   ```
   drakkar/
   ├── style.css                    # WordPress header only
   ├── dist/
   │   └── main.css                # Single consolidated CSS file
   ├── inc/                        # PHP classes
   │   ├── class-drakkar-assets.php
   │   └── class-drakkar-components.php
   └── js/
       └── main.js                 # Single consolidated JS file
   ```

2. **Create CSS design system with custom properties**
   - CSS variables for colors, spacing, typography
   - Component-based organization within single file

3. **Setup PHP asset management**
   - WordPress enqueuing system
   - Version management for cache busting
   - Conditional loading based on page context

#### Deliverables:
- [ ] `dist/main.css` - CSS file with design system
- [ ] `inc/class-drakkar-assets.php` - Asset management class
- [ ] Updated `functions.php` - Integration with new classes
- [ ] Removed `css/hero-zero.css` - Consolidated into main.css

### Phase 2: CSS Consolidation (Day 3-4)
**Priority: HIGH**

#### Tasks:
1. **Extract and consolidate inline styles**
   - Remove 167 lines of CSS from `hero-expertise.php`
   - Extract inline styles from all template parts
   - Move to consolidated `dist/main.css` file

2. **Implement unified component styles**
   ```css
   .hero {
       /* Base hero styles using CSS custom properties */
       background-size: cover;
       min-height: 100vh;
       /* ... */
   }

   .hero--main { /* Main hero variant */ }
   .hero--expertise { /* Expertise hero variant */ }
   ```

3. **Standardize button and CTA styles**
   ```css
   .btn {
       /* Base button using CSS variables */
       background-color: var(--color-primary);
       padding: var(--spacing-md) var(--spacing-xl);
       /* ... */
   }
   ```

#### Deliverables:
- [ ] Consolidated hero styles in `dist/main.css`
- [ ] Removed inline styles from all template parts
- [ ] Unified button component styles
- [ ] 30%+ reduction in total CSS lines (721 → 500 lines)

### Phase 3: JavaScript Refactoring (Day 5-6)
**Priority: MEDIUM**
**Technology: Vanilla JavaScript (ES5 + modern features)**

#### Tasks:
1. **Create utility-first JavaScript architecture**
   ```javascript
   // Single js/main.js file
   (function() {
       'use strict';

       const DrakkarUtils = {
           $: function(selector) { return document.querySelector(selector); },
           $$: function(selector) { return document.querySelectorAll(selector); },
           // ... utilities
       };

       const DrakkarTheme = {
           init: function() {
               this.setupSmoothScrolling();
               this.setupHeaderEffects();
               // ...
           }
       };
   })();
   ```

2. **Consolidate existing functionality**
   - Merge `main.js` and `hero-main.js` functionality
   - Implement consistent event handling patterns
   - Add error handling and feature detection

3. **Optimize performance with native APIs**
   - Use `IntersectionObserver` for animations
   - Implement throttling for scroll events
   - Add proper cleanup for event listeners

#### Deliverables:
- [ ] Single `js/main.js` file with all functionality
- [ ] Utility-first JavaScript architecture
- [ ] 25%+ reduction in JavaScript file size
- [ ] Improved performance with native APIs

### Phase 4: PHP Optimization (Day 7-8)
**Priority: MEDIUM**
**Technology: Pure PHP + WordPress APIs**

#### Tasks:
1. **Create component system classes**
   ```php
   // inc/class-drakkar-components.php
   class Drakkar_Components {
       public static function hero_section($args = []) {
           // Reusable hero component function
           // Returns clean HTML without inline styles
       }

       public static function cta_button($args = []) {
           // Standardized CTA button
       }
   }
   ```

2. **Implement unified asset management**
   ```php
   // inc/class-drakkar-assets.php
   class Drakkar_Assets {
       public static function enqueue_styles() {
           wp_enqueue_style('drakkar-main', get_template_directory_uri() . '/dist/main.css', [], '2.0.0');
       }
   }
   ```

3. **Refactor template parts**
   - Remove inline styles from all template parts
   - Use component functions for consistent output
   - Implement proper WordPress escaping

#### Deliverables:
- [ ] `inc/class-drakkar-assets.php` - Asset management
- [ ] `inc/class-drakkar-components.php` - Component system
- [ ] Refactored template parts without inline styles
- [ ] Updated `functions.php` with new class integrations

### Phase 5: Template Optimization (Day 9-10)
**Priority: LOW**
**Technology: Pure PHP Templates**

#### Tasks:
1. **Standardize hero components**
   ```php
   // Clean template parts using component system
   <?php
   echo Drakkar_Components::hero_section([
       'type' => 'main',
       'background' => 'hero-main.jpg',
       'title' => 'Main Hero Title',
       'cta' => ['text' => 'Get Started', 'url' => '#contact']
   ]);
   ?>
   ```

2. **Implement performance optimizations**
   - Conditional script loading based on page context
   - Image lazy loading with native `loading="lazy"`
   - CSS critical path optimization

3. **Final testing and optimization**
   - Cross-browser testing
   - Performance measurement
   - Code validation

#### Deliverables:
- [ ] Clean template parts using component system
- [ ] Performance optimizations implemented
- [ ] Complete testing and validation
- [ ] Documentation updates
   .hero__content
   .hero__cta
   .hero__cta--primary
   ```

#### Deliverables:
- [ ] Consolidated main.css file
- [ ] Removed inline styles
- [ ] BEM-compliant class names
- [ ] 30%+ reduction in CSS size

### Phase 3: JavaScript Refactoring (Week 3)
**Priority: MEDIUM**

#### Tasks:
1. **Create utility module**
   - DOM helpers
   - Animation utilities
   - Event utilities

2. **Consolidate main functionality**
   - Merge `main.js` and `hero-main.js`
   - Implement module pattern
   - Add error handling

3. **Optimize performance**
   - Use intersection observer for animations
   - Implement throttling/debouncing
   - Reduce DOM queries

#### Deliverables:
- [ ] Modular JavaScript architecture
- [ ] Consolidated main.js file
- [ ] Performance optimizations
- [ ] 25%+ reduction in JS size

### Phase 4: PHP Optimization (Week 4)
**Priority: MEDIUM**

#### Tasks:
1. **Implement asset manager**
   - Unified enqueuing system
   - Version management
   - Conditional loading

2. **Create component system**
   - Reusable template functions
   - Standardized output
   - Proper escaping

3. **Refactor template parts**
   - Remove code duplication
   - Implement consistent structure
   - Improve documentation

#### Deliverables:
- [ ] Asset management system
- [ ] Component library
- [ ] Refactored template parts
- [ ] Improved code organization

### Phase 5: Template Optimization (Week 5)
**Priority: LOW**

#### Tasks:
1. **Standardize hero components**
   - Create base hero template
   - Implement configuration system
   - Remove redundant files

2. **Optimize media handling**
   - Implement lazy loading
   - Standardize image sizes
   - Improve fallback system

3. **Performance testing**
   - Page speed analysis
   - Bundle size optimization
   - Load time improvements

#### Deliverables:
- [ ] Standardized templates
- [ ] Optimized media handling
- [ ] Performance improvements
- [ ] Documentation updates

---

## File Structure Changes

### Current Structure
```
drakkar/
├── style.css                   # 365 lines
├── css/
│   └── hero-zero.css          # 356 lines
├── js/
│   ├── main.js                # 170 lines
│   └── hero-main.js           # Unknown size
├── template-parts/
│   ├── hero-main.php          # Inline styles
│   ├── hero-expertise.php     # 212 lines (167 CSS)
│   ├── hero-big-data.php      # 429 lines
│   └── [other components]
```

### Proposed Structure
```
drakkar/
├── style.css                   # WordPress header only
├── scss/                       # Source files
│   ├── _variables.scss         # Design tokens
│   ├── _mixins.scss           # Reusable mixins
│   ├── _base.scss             # Reset & base styles
│   ├── _layout.scss           # Grid & layout
│   ├── _components.scss       # UI components
│   ├── _utilities.scss        # Utility classes
│   └── main.scss              # Main compilation file
├── dist/                       # Compiled assets
│   ├── main.css               # ~500 lines (30% reduction)
│   ├── main.min.css           # Minified version
│   └── main.css.map           # Source map
├── js/
│   ├── utils.js               # Utility functions
│   ├── main.js                # ~120 lines (25% reduction)
│   └── components/            # Component-specific JS
├── inc/
│   ├── asset-manager.php      # Asset enqueuing
│   ├── component-system.php   # Template components
│   └── performance.php        # Performance optimizations
├── template-parts/
│   ├── hero/                  # Hero variants
│   │   ├── base.php          # Base hero template
│   │   ├── main.php          # Main hero (data-driven)
│   │   ├── expertise.php     # Expertise hero (data-driven)
│   │   └── config.php        # Hero configurations
│   └── components/            # Reusable components
```

### File Size Improvements
| File Type | Current Size | Target Size | Reduction |
|-----------|-------------|-------------|-----------|
| CSS | ~721 lines | ~500 lines | 30% |
| JavaScript | ~200+ lines | ~150 lines | 25% |
| PHP Templates | Mixed inline | Clean separation | 40% code reuse |

---
---

## Performance Improvements

### 1. Asset Optimization

#### Bundle Size Reduction
- **CSS**: 721 lines → 500 lines (30% reduction)
- **JavaScript**: 200+ lines → 150 lines (25% reduction)
- **HTTP Requests**: Reduce from 4 CSS files to 1

#### Critical CSS Implementation
```php
// New: inc/performance.php
class Drakkar_Performance {

    public static function inline_critical_css() {
        $critical_css = self::get_critical_css();
        if ($critical_css) {
            echo '<style id="critical-css">' . $critical_css . '</style>';
        }
    }

    private static function get_critical_css() {
        // Above-the-fold styles
        return '
            :root { /* Essential variables */ }
            .site-header { /* Header styles */ }
            .hero { /* Hero styles */ }
            /* ... */
        ';
    }
}
```

### 2. Loading Optimization

#### Lazy Loading Implementation
```javascript
// utils.js
const LazyLoader = {
    observeImages() {
        const images = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));
    }
};
```

#### Component-Based Loading
```php
// Load scripts only when components are present
if (has_drakkar_component('statistics')) {
    Drakkar_Asset_Manager::enqueue_script('statistics-counter', 'js/components/statistics.js');
}

if (has_drakkar_component('hero-video')) {
    Drakkar_Asset_Manager::enqueue_script('video-hero', 'js/components/video-hero.js');
}
```

### 3. Caching Strategy

#### Asset Versioning
```php
class Drakkar_Asset_Manager {

    private static function get_asset_version($path) {
        // Use file modification time for cache busting
        $file_path = get_template_directory() . '/' . $path;
        return file_exists($file_path) ? filemtime($file_path) : self::$theme_version;
    }

    public static function enqueue_style($handle, $path, $deps = []) {
        wp_enqueue_style(
            $handle,
            self::get_asset_url($path),
            $deps,
            self::get_asset_version($path)
        );
    }
}
```

---

## Testing Strategy

### 1. Functional Testing

#### Component Testing Checklist
- [ ] **Hero Sections**: All hero variants render correctly
- [ ] **Navigation**: Mobile menu functionality
- [ ] **Animations**: Statistics counters work
- [ ] **Media**: Images load with proper fallbacks
- [ ] **Forms**: Contact forms submit properly
- [ ] **Responsive**: All breakpoints function correctly

#### Cross-Browser Testing
- [ ] Chrome (Latest 2 versions)
- [ ] Firefox (Latest 2 versions)
- [ ] Safari (Latest 2 versions)
- [ ] Edge (Latest 2 versions)
- [ ] Mobile browsers (iOS Safari, Chrome Mobile)

### 2. Performance Testing

#### Metrics to Monitor
| Metric | Current | Target | Tools |
|--------|---------|--------|--------|
| First Contentful Paint | TBD | < 2s | Lighthouse |
| Largest Contentful Paint | TBD | < 3s | Lighthouse |
| Total Bundle Size | TBD | -30% | Bundle Analyzer |
| CSS File Size | 721 lines | 500 lines | File comparison |
| JS File Size | 200+ lines | 150 lines | File comparison |

#### Testing Tools
- **Lighthouse**: Performance auditing
- **WebPageTest**: Load time analysis
- **GTmetrix**: Performance monitoring
- **Chrome DevTools**: Network analysis

### 3. Regression Testing

#### Visual Regression Testing
```bash
# Before/after screenshot comparison
npm install -g backstopjs
backstop init
backstop test
backstop approve
```

#### Automated Testing Script
```php
// tests/theme-functionality.php
class Drakkar_Theme_Tests {

    public function test_hero_components() {
        // Test each hero component renders
        $components = ['main', 'expertise', 'statistics', 'big-data'];
        foreach ($components as $component) {
            $output = get_template_part('template-parts/hero/base', null, ['type' => $component]);
            $this->assertNotEmpty($output);
        }
    }

    public function test_asset_loading() {
        // Test all assets load correctly
        $this->assertTrue(wp_style_is('drakkar-main', 'enqueued'));
        $this->assertTrue(wp_script_is('drakkar-main', 'enqueued'));
    }
}
```

---

## Migration Guide

### 1. Pre-Migration Steps

#### Backup Current Theme
```bash
# Create backup
cp -R wp-content/themes/drakkar wp-content/themes/drakkar-backup-$(date +%Y%m%d)

# Database backup
wp db export drakkar-backup-$(date +%Y%m%d).sql
```

#### Environment Preparation
```bash
# Install build tools
npm install -g sass
npm install -g autoprefixer
npm install -g postcss-cli

# Setup development environment
cd wp-content/themes/drakkar
npm init -y
npm install --save-dev sass autoprefixer postcss
```

### 2. Migration Process

#### Step 1: Setup New Structure
```bash
# Create new directories
mkdir -p scss dist js/components inc/new template-parts/hero template-parts/components

# Move existing files
mv css/hero-zero.css scss/_hero-legacy.scss
mv js/main.js js/main-legacy.js
```

#### Step 2: Migrate CSS
```bash
# Convert CSS to SASS
sass-convert css/hero-zero.css scss/_hero-legacy.scss
sass-convert style.css scss/_style-legacy.scss

# Compile new CSS
sass scss/main.scss dist/main.css
```

#### Step 3: Update Template References
```php
// Update functions.php
// Replace old enqueue calls
wp_enqueue_style('drakkar-style', get_stylesheet_uri());
wp_enqueue_style('drakkar-hero-main-css', $template_uri . '/css/hero-zero.css');

// With new enqueue calls
Drakkar_Asset_Manager::enqueue_style('drakkar-main', 'dist/main.css');
```

### 3. Rollback Plan

#### Quick Rollback
```bash
# Restore from backup
rm -rf wp-content/themes/drakkar
mv wp-content/themes/drakkar-backup-$(date +%Y%m%d) wp-content/themes/drakkar

# Restore database if needed
wp db import drakkar-backup-$(date +%Y%m%d).sql
```

#### Gradual Rollback
```php
// Feature flag system
define('DRAKKAR_USE_LEGACY_CSS', true);

// In functions.php
if (defined('DRAKKAR_USE_LEGACY_CSS') && DRAKKAR_USE_LEGACY_CSS) {
    // Load old assets
    wp_enqueue_style('drakkar-style', get_stylesheet_uri());
    wp_enqueue_style('drakkar-hero-main-css', $template_uri . '/css/hero-zero.css');
} else {
    // Load new assets
    Drakkar_Asset_Manager::enqueue_style('drakkar-main', 'dist/main.css');
}
```

---

## Risk Assessment

### High Risk Items

#### 1. CSS Refactoring Impact
**Risk**: Visual breaks due to CSS consolidation
**Probability**: Medium
**Impact**: High
**Mitigation**:
- Comprehensive visual regression testing
- Gradual rollout with feature flags
- Pixel-perfect comparison tools

#### 2. JavaScript Functionality Changes
**Risk**: Interactive features stop working
**Probability**: Low
**Impact**: High
**Mitigation**:
- Extensive functional testing
- Progressive enhancement approach
- Fallback mechanisms

### Medium Risk Items

#### 3. Template Part Refactoring
**Risk**: Content display issues
**Probability**: Medium
**Impact**: Medium
**Mitigation**:
- Template validation testing
- Content audit before/after
- Staged deployment

#### 4. Asset Loading Changes
**Risk**: Performance regression
**Probability**: Low
**Impact**: Medium
**Mitigation**:
- Performance benchmarking
- Load testing
- CDN fallbacks

### Low Risk Items

#### 5. File Structure Changes
**Risk**: Development workflow disruption
**Probability**: Low
**Impact**: Low
**Mitigation**:
- Clear documentation
- Developer training
- Gradual transition

---

## Success Metrics

### Performance Targets
- [ ] **CSS Size Reduction**: 30% decrease (721 → 500 lines)
- [ ] **JavaScript Size Reduction**: 25% decrease (200+ → 150 lines)
- [ ] **HTTP Requests**: Reduce CSS requests by 75% (4 → 1 file)
- [ ] **Page Load Time**: 20% improvement
- [ ] **Lighthouse Score**: Maintain 90+ performance score

### Code Quality Targets
- [ ] **Code Duplication**: 80% reduction in duplicate CSS
- [ ] **Maintainability**: Consistent coding patterns
- [ ] **Documentation**: 100% coverage of new components
- [ ] **Test Coverage**: 90% functional test coverage

### Development Experience Targets
- [ ] **Build Time**: < 2 seconds for CSS compilation
- [ ] **Developer Onboarding**: Reduce from 2 days to 4 hours
- [ ] **Component Reusability**: 90% of UI components reusable
- [ ] **Bug Reduction**: 50% fewer CSS-related bugs

---

## Timeline Summary

| Phase | Duration | Key Deliverables | Dependencies |
|-------|----------|------------------|--------------|
| **Phase 1** | Day 1-2 | Foundation setup, CSS consolidation | None |
| **Phase 2** | Day 3-4 | CSS consolidation, inline style removal | Phase 1 |
| **Phase 3** | Day 5-6 | JavaScript refactoring, utility functions | Phase 2 |
| **Phase 4** | Day 7-8 | PHP optimization, component classes | Phase 3 |
| **Phase 5** | Day 9-10 | Template optimization, final testing | Phase 4 |

**Total Duration**: 10 days (2 weeks)
**Total Effort**: ~20-25 hours
**Team Size**: 1 developer
**Dependencies**: WordPress, PHP 7.4+, Modern browsers

---

## Success Metrics

### Performance Targets
- [ ] **CSS File Reduction**: 30% decrease (721 → 500 lines)
- [ ] **HTTP Requests**: Reduce CSS files from 4 to 1
- [ ] **JavaScript Consolidation**: 25% size reduction through utilities
- [ ] **Zero Build Time**: Immediate changes, no compilation needed
- [ ] **WordPress Performance**: Maintain/improve Lighthouse scores

### Code Quality Targets
- [ ] **Inline Style Elimination**: Remove all template inline styles
- [ ] **Component Standardization**: Unified hero/button patterns
- [ ] **CSS Custom Property Usage**: 100% design token coverage
- [ ] **JavaScript Error Reduction**: Proper error handling and feature detection
- [ ] **WordPress Standards**: 100% compliance with WP coding standards

### Development Experience Targets
- [ ] **No Build Setup**: Direct file editing workflow
- [ ] **Immediate Feedback**: Real-time changes without compilation
- [ ] **Standard WordPress**: Native wp_enqueue_* functions only
- [ ] **Simple Debugging**: Raw code in browser devtools
- [ ] **Easy Maintenance**: Clear file structure and documentation

---

## Conclusion

This refactoring plan transforms the Drakkar theme using standard web technologies without build complexity:

### Benefits:
1. **Immediate Development**: Edit files, refresh browser - no build step
2. **Standard WordPress**: Uses native WP functions and conventions
3. **Zero Dependencies**: No node_modules, package.json, or build tools
4. **Long-term Stability**: Technologies that won't become obsolete

### Results:
1. **CSS Unification**: Single `dist/main.css` file replacing multiple files
2. **JavaScript Efficiency**: Utility-first approach in single `js/main.js`
3. **PHP Organization**: Class-based components
4. **Template Cleanup**: Removed inline styles, standardized structure
5. **Performance Gains**: Fewer HTTP requests, better caching, cleaner code

---

*Each phase can be completed and tested immediately without waiting for build processes.*

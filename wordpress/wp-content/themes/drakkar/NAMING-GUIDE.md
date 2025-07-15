# Template Parts Naming Guide

## File Prefixes
- **`hero-*`** → Main page introduction (one per page)
- **`section-*`** → Content sections
- **`component-*`** → Reusable UI elements
- **`loop-*`** → Content loops

## Current Structure
```
template-parts/
├── hero-main.php
├── section-agriculture.php
├── section-analytics.php
├── hero-statistics.php
└── image-responsive.php
```

## Rules
- Name by **content purpose**, not visual style
- Use **semantic meaning** over appearance
- One `hero-*` per page maximum
- Stick to established prefixes

### Examples
```php
// ✅ Good
section-analytics.php
component-cta.php

// ❌ Avoid
hero-secondary.php
section-blue.php
```

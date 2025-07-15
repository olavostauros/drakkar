# Media Guide

## Locations
- **WordPress Library** (`/uploads/`) → User content
- **Theme Assets** (`/assets/`) → Static images, icons

## Image Sizes
- `drakkar-thumbnail`: 150x150px
- `drakkar-medium`: 600x400px
- `drakkar-large`: 1200x800px
- `drakkar-hero`: 1920x1080px

## Usage
```php
// Theme assets
$logo_url = drakkar_get_image_url('logo.png');

// WordPress media
echo drakkar_get_featured_image(get_the_ID(), 'drakkar-large', 'fallback.jpg');
echo drakkar_get_responsive_image($id, 'drakkar-medium', ['class' => 'hero']);
```

## Rules
- Use responsive images with fallbacks
- Enable lazy loading below-fold
- Organize in folders (`logos/`, `backgrounds/`)
- Optimize for performance

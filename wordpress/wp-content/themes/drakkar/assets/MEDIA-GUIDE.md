# Drakkar Theme Media Guidelines

## Directory Structure

Your Drakkar theme now has the following media-related structure:

```
drakkar/
├── assets/
│   ├── images/          # Theme-specific images (logos, icons, backgrounds)
│   └── icons/           # SVG icons and small graphics
├── inc/
│   ├── media-helpers.php    # Media utility functions
│   └── customizer-media.php # Media customizer settings
├── template-parts/
│   └── image-responsive.php # Responsive image template
└── functions.php        # Updated with media support
```

## Media Types and Locations

### 1. WordPress Media Library (`wp-content/uploads/`)
- **User uploaded content**: Photos, documents, media files
- **Dynamic content**: Post featured images, gallery images
- **Organized by date**: `/2025/07/` for July 2025

### 2. Theme Assets (`themes/drakkar/assets/`)
- **Static theme images**: Logos, backgrounds, decorative elements
- **Icons and graphics**: SVG icons, UI elements
- **Fallback images**: Default images when content is missing

## Using Media in Your Theme

### 1. Theme Assets (Static Images)

```php
// Get theme image URL
$logo_url = drakkar_get_image_url('logo.png');

// Get theme icon URL
$icon_url = drakkar_get_icon_url('arrow.svg');

// Check if theme image exists
if (drakkar_theme_image_exists('hero-bg.jpg')) {
    $bg_url = drakkar_get_image_url('hero-bg.jpg');
}
```

### 2. WordPress Media Library Images

```php
// Get featured image with fallback
echo drakkar_get_featured_image(get_the_ID(), 'drakkar-large', 'default-post.jpg');

// Get responsive image with attributes
echo drakkar_get_responsive_image($attachment_id, 'drakkar-medium', array(
    'class' => 'my-custom-class',
    'alt' => 'Custom alt text',
    'loading' => 'lazy'
));

// Use template part for complex responsive images
get_template_part('template-parts/image-responsive', null, array(
    'attachment_id' => $attachment_id,
    'size' => 'drakkar-large',
    'class' => 'hero-image',
    'fallback' => 'default-hero.jpg'
));
```

### 3. Custom Image Sizes

The theme includes these custom image sizes:
- `drakkar-thumbnail`: 150x150px (cropped)
- `drakkar-small`: 300x200px (cropped)
- `drakkar-medium`: 600x400px (cropped)
- `drakkar-large`: 1200x800px (cropped)
- `drakkar-hero`: 1920x1080px (cropped)

### 4. Customizer Media Settings

Access via WordPress Admin → Appearance → Customize → Drakkar Media Settings:
- Default featured image
- Hero background image
- About section image
- Lazy loading toggle
- Image quality setting

## Best Practices

### 1. File Organization
```
assets/images/
├── logos/
│   ├── logo-main.svg
│   ├── logo-alt.png
│   └── favicon.ico
├── backgrounds/
│   ├── hero-bg.jpg
│   ├── section-bg.png
│   └── texture.jpg
├── placeholders/
│   ├── default-post.jpg
│   ├── default-avatar.png
│   └── no-image.svg
└── decorative/
    ├── divider.svg
    ├── pattern.png
    └── ornament.svg
```

### 2. Image Guidelines
- Always use responsive images for better performance
- Provide fallbacks for better UX (use theme assets as fallback images)
- Enable lazy loading for below-the-fold images
- Use appropriate image sizes for different contexts

### 3. Performance Optimization
- Use appropriate image sizes for different contexts
- Enable lazy loading for below-the-fold images
- Optimize image quality (default: 85%)
- Use WebP format when possible
- Implement proper caching headers

## Example Usage in Templates

### Post loop with featured image:
```php
<article class="post-item">
    <?php echo drakkar_get_featured_image(get_the_ID(), 'drakkar-medium', 'default-post.jpg'); ?>
    <h2><?php the_title(); ?></h2>
    <div class="content"><?php the_excerpt(); ?></div>
</article>
```

### Hero section with background:
```php
<?php
$hero_bg_id = drakkar_get_media_setting('hero_background');
if ($hero_bg_id) {
    get_template_part('template-parts/image-responsive', null, array(
        'attachment_id' => $hero_bg_id,
        'size' => 'drakkar-hero',
        'class' => 'hero-background'
    ));
}
?>
```

### Site branding with logo:
```php
<div class="site-branding">
    <?php echo drakkar_get_logo(); ?>
</div>
```


## Sponsor Banner Feature

The Sponsor Banner feature allows you to easily add sponsored content banners to your posts and pages. The banner consists of a title (default: "Sponsorisé par"), an image (10:3 ratio recommended), and an optional link.

### Usage Methods

#### 1. Shortcode Usage

You can add a sponsor banner anywhere in your post content using the shortcode:

````
[sponsor_banner title="Sponsorisé par" image="123" link="https://example.com"]
````

Parameters:
- `title`: (optional) The banner title. Default: "Sponsorisé par"
- `image`: (required) Either an image ID from the Media Library or a direct URL
- `link`: (optional) The URL where the banner should link to

Examples:

````
[sponsor_banner image="123"]

[sponsor_banner image="https://example.com/image.jpg"]

[sponsor_banner title="Sponsored by" image="123" link="https://example.com"]
````

#### 2. PHP Function Usage

You can also add the sponsor banner programmatically in your templates:

````php
<?php
$sponsor_data = array(
    'title' => 'Sponsorisé par',
    'image' => 123,  // Image ID or URL
    'link' => 'https://example.com'
);
echo render_sponsor_banner($sponsor_data);
?>
````

#### 3. ACF Integration

The theme includes an ACF field group for posts with the following fields:
- Title (text)
- Banner Image (image)
- Banner Link (url)

To use in templates with ACF:

````php
<?php
$sponsor_data = array(
    'title' => get_field('sponsor_title'),
    'image' => get_field('sponsor_image')['ID'],  // Get image ID
    'link' => get_field('sponsor_link')
);
echo render_sponsor_banner($sponsor_data);
?>
````

### Styling

The sponsor banner comes with pre-defined styles:
- Responsive design
- 10:3 aspect ratio for desktop (adjusts to 10:4 on mobile)
- Hover animation effect
- Centered layout
- Proper spacing

Custom styling can be added by targeting these classes:
- `.sponsor-banner`: Main container
- `.sponsor-title`: Banner title
- `.sponsor-image-wrapper`: Image container
- `.sponsor-image`: The image itself

### Image Requirements

- Recommended aspect ratio: 10:3
- Minimum width: 1200px recommended
- Format: JPG, PNG, or animated GIF
- The image will be displayed using object-fit: cover

### Notes

1. The banner will not display if no image is provided
2. Links automatically open in a new tab with proper security attributes
3. All content is properly escaped for security
4. The feature supports both image IDs from the WordPress Media Library and direct URLs
5. Animated GIFs are supported and will play in the banner

### Troubleshooting

If the banner doesn't appear:
1. Check if the image ID or URL is valid
2. Verify the image exists in the Media Library if using an ID
3. Ensure the image URL is accessible if using a direct URL
4. Check if the shortcode syntax is correct

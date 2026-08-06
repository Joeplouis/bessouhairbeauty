# Bessou Hair Beauty - Complete African Hair Braiding Website

## Overview
A modern, responsive website for Bessou Hair Beauty salon specializing in authentic African hair braiding. Features 15+ braiding styles, online booking, and professional gallery.

## Features
- **15+ Braiding Services** with customizable pricing
- **Responsive Design** - works on all devices
- **Online Booking** with Google Calendar integration
- **Booking Terms System** with $30 deposit policy
- **Professional Gallery** with hover effects
- **Contact Forms** with validation
- **WhatsApp Integration** for quick bookings
- **Admin Panel** for easy updates
- **SEO Optimized** structure

## Services Included
1. Box Braids - $120
2. Fulani Braids - $150
3. Goddess Braids - $100
4. Cornrows - $80
5. Knotless Braids - $140
6. Tribal Braids - $110
7. Feed-in Braids - $90
8. Senegalese Twists - $130
9. Passion Twists - $125
10. Braided Buns - $85
11. Boho Braids - $135
12. Micro Braids - $200
13. Ghana Braids - $95
14. Lemonade Braids - $115
15. Faux Locs - $180

## Booking System
- **$30 Deposit Required** to secure appointment
- **Late Policy**: More than 1 hour late = deposit non-refundable, not deducted from service
- **No-Show Policy**: $30 deposit deducted from future appointment total
- **On-Time**: Deposit deducted from service cost

## File Structure
```
bessouhairbeauty_website/
├── index.html                 # Main website file
├── assets/
│   ├── css/
│   │   └── style.css         # Complete styling
│   ├── js/
│   │   └── script.js         # Interactive features
│   └── images/
│       ├── README.md         # Image guidelines
│       └── gallery/          # Gallery images
└── README.md                 # This file
```

## Quick Setup
1. **Replace Images**: Add your braiding photos to `assets/images/` folder
2. **Update Contact Info**: Modify contact details in the JavaScript
3. **Set Up Booking**: Connect Google Calendar for appointments
4. **Customize Prices**: Update service pricing as needed

## Easy Admin Updates
Use the browser console to update information:

### Update Prices
```javascript
BessouAdmin.updatePrice('box-braids', 150); // Changes box braids to $150
```

### Update Contact Info
```javascript
BessouAdmin.updateContact('phone', '+1 (555) 123-4567');
BessouAdmin.updateContact('address', '456 New Street, City, State 12345');
```

### View Current Settings
```javascript
console.log(BessouAdmin.getPrices()); // Shows all current prices
console.log(BessouAdmin.getContactInfo()); // Shows contact information
```

## Customization Guide

### Colors (CSS Variables)
```css
:root {
    --primary-gold: #d4af37;    /* Main gold color */
    --primary-brown: #8b4513;   /* Main brown color */
    --accent-purple: #6a5acd;   /* Accent color */
}
```

### Adding New Services
1. Add service card HTML in the services grid
2. Add pricing to JavaScript `prices` object
3. Add service option to contact form dropdown

### Google Calendar Integration
1. Create Google Calendar for bookings
2. Replace iframe src in booking section
3. Update booking buttons with your calendar link

## Mobile Features
- Responsive hamburger menu
- Touch-friendly buttons
- Optimized image loading
- Mobile-first design

## SEO Features
- Semantic HTML structure
- Meta tags ready
- Fast loading optimized
- Image alt attributes
- Structured navigation

## Browser Support
- Chrome 70+
- Firefox 65+
- Safari 12+
- Edge 79+
- Mobile browsers

## Installation for WordPress
To add this to your WordPress site:

1. Create a new page template
2. Copy the HTML content (without `<html>`, `<head>`, `<body>` tags)
3. Enqueue the CSS and JS files in your theme's functions.php
4. Upload images to WordPress media library

### WordPress Integration Code
```php
// Add to functions.php
function bessou_enqueue_assets() {
    wp_enqueue_style('bessou-style', get_template_directory_uri() . '/assets/css/bessou-style.css');
    wp_enqueue_script('bessou-script', get_template_directory_uri() . '/assets/js/bessou-script.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'bessou_enqueue_assets');
```

## Performance Optimization
- Optimized images (WebP recommended)
- Minified CSS and JS
- Lazy loading for images
- Efficient animations
- Fast loading fonts

## Maintenance
- Update service photos regularly
- Check booking calendar integration
- Update pricing seasonally
- Monitor contact form submissions
- Backup regularly

## Support
For technical support or customization requests, contact the development team.

## License
This theme is custom-built for Bessou Hair Beauty. All rights reserved.

---
*Built with modern web standards for professional African hair braiding salons.*

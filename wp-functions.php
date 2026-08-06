<?php
/**
 * WordPress functions for Bessou Hair Beauty
 * Adds admin interface for managing prices, contact info, and site settings
 */

// Add WordPress hooks for Bessou Hair Beauty customization
add_action('wp_enqueue_scripts', 'bessou_enqueue_styles');
add_action('admin_menu', 'bessou_admin_menu');
add_action('admin_init', 'bessou_admin_init');
add_action('customize_register', 'bessou_customize_register');

/**
 * Enqueue styles and scripts for Bessou Hair Beauty
 */
function bessou_enqueue_styles() {
    wp_enqueue_style('bessou-style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0.0');
    wp_enqueue_script('bessou-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0.0', true);
    
    // Enqueue Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
    
    // Enqueue Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
}

/**
 * Add admin menu for Bessou Hair Beauty settings
 */
function bessou_admin_menu() {
    add_menu_page(
        'Bessou Hair Beauty',
        'Bessou Hair Beauty',
        'manage_options',
        'bessou-settings',
        'bessou_admin_page',
        'dashicons-admin-appearance',
        30
    );
    
    add_submenu_page(
        'bessou-settings',
        'Service Prices',
        'Service Prices',
        'manage_options',
        'bessou-prices',
        'bessou_prices_page'
    );
    
    add_submenu_page(
        'bessou-settings',
        'Contact Information',
        'Contact Info',
        'manage_options',
        'bessou-contact',
        'bessou_contact_page'
    );
    
    add_submenu_page(
        'bessou-settings',
        'Booking Settings',
        'Booking Settings',
        'manage_options',
        'bessou-booking',
        'bessou_booking_page'
    );
}

/**
 * Initialize admin settings
 */
function bessou_admin_init() {
    register_setting('bessou_settings', 'bessou_settings');
    register_setting('bessou_prices', 'bessou_prices');
    register_setting('bessou_contact', 'bessou_contact');
    register_setting('bessou_booking', 'bessou_booking');
}

/**
 * Main admin page
 */
function bessou_admin_page() {
    ?>
    <div class="wrap">
        <h1>Bessou Hair Beauty Settings</h1>
        <div style="background: white; padding: 20px; margin: 20px 0; border-radius: 5px;">
            <h2>Welcome to Bessou Hair Beauty Admin Panel</h2>
            <p>Use the menu options to manage your salon website:</p>
            <ul style="margin-left: 20px;">
                <li><strong>Service Prices:</strong> Update pricing for all braiding services</li>
                <li><strong>Contact Info:</strong> Manage address, phone, email, and hours</li>
                <li><strong>Booking Settings:</strong> Configure Google Calendar and booking terms</li>
            </ul>
            
            <h3>Quick Actions</h3>
            <p>
                <a href="<?php echo admin_url('admin.php?page=bessou-prices'); ?>" class="button button-primary">Manage Prices</a>
                <a href="<?php echo admin_url('admin.php?page=bessou-contact'); ?>" class="button button-secondary">Update Contact</a>
                <a href="<?php echo admin_url('admin.php?page=bessou-booking'); ?>" class="button button-secondary">Booking Settings</a>
            </p>
        </div>
    </div>
    <?php
}

/**
 * Service prices admin page
 */
function bessou_prices_page() {
    if (isset($_POST['submit'])) {
        $services = array(
            'box_braids_price',
            'fulani_braids_price',
            'goddess_braids_price',
            'cornrows_price',
            'knotless_braids_price',
            'tribal_braids_price',
            'feed_in_braids_price',
            'senegalese_twists_price',
            'passion_twists_price',
            'braided_buns_price',
            'boho_braids_price',
            'micro_braids_price',
            'ghana_braids_price',
            'lemonade_braids_price',
            'faux_locs_price'
        );
        
        foreach ($services as $service) {
            if (isset($_POST[$service])) {
                update_option('bessou_' . $service, intval($_POST[$service]));
            }
        }
        
        echo '<div class="notice notice-success"><p>Prices updated successfully!</p></div>';
    }
    
    ?>
    <div class="wrap">
        <h1>Service Prices</h1>
        <form method="post" action="">
            <table class="form-table">
                <?php
                $services = array(
                    'box_braids_price' => array('label' => 'Box Braids', 'default' => 120),
                    'fulani_braids_price' => array('label' => 'Fulani Braids', 'default' => 150),
                    'goddess_braids_price' => array('label' => 'Goddess Braids', 'default' => 100),
                    'cornrows_price' => array('label' => 'Cornrows', 'default' => 80),
                    'knotless_braids_price' => array('label' => 'Knotless Braids', 'default' => 140),
                    'tribal_braids_price' => array('label' => 'Tribal Braids', 'default' => 110),
                    'feed_in_braids_price' => array('label' => 'Feed-in Braids', 'default' => 90),
                    'senegalese_twists_price' => array('label' => 'Senegalese Twists', 'default' => 130),
                    'passion_twists_price' => array('label' => 'Passion Twists', 'default' => 125),
                    'braided_buns_price' => array('label' => 'Braided Buns', 'default' => 85),
                    'boho_braids_price' => array('label' => 'Boho Braids', 'default' => 135),
                    'micro_braids_price' => array('label' => 'Micro Braids', 'default' => 200),
                    'ghana_braids_price' => array('label' => 'Ghana Braids', 'default' => 95),
                    'lemonade_braids_price' => array('label' => 'Lemonade Braids', 'default' => 115),
                    'faux_locs_price' => array('label' => 'Faux Locs', 'default' => 180)
                );
                
                foreach ($services as $key => $service) :
                    $current_price = get_option('bessou_' . $key, $service['default']);
                ?>
                    <tr>
                        <th scope="row"><?php echo $service['label']; ?></th>
                        <td>
                            $<input type="number" name="<?php echo $key; ?>" value="<?php echo $current_price; ?>" min="0" step="5" />
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php submit_button('Update Prices'); ?>
        </form>
    </div>
    <?php
}

/**
 * Contact information admin page
 */
function bessou_contact_page() {
    if (isset($_POST['submit'])) {
        $contact_fields = array('address', 'phone', 'email', 'hours', 'facebook', 'instagram', 'twitter', 'yelp');
        
        foreach ($contact_fields as $field) {
            if (isset($_POST[$field])) {
                update_option('bessou_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
        
        echo '<div class="notice notice-success"><p>Contact information updated successfully!</p></div>';
    }
    
    ?>
    <div class="wrap">
        <h1>Contact Information</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row">Address</th>
                    <td>
                        <textarea name="address" rows="3" cols="50"><?php echo get_option('bessou_address', '123 Beauty Street\nHair City, HC 12345'); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Phone</th>
                    <td>
                        <input type="text" name="phone" value="<?php echo get_option('bessou_phone', '+1 (234) 567-8900'); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">Email</th>
                    <td>
                        <input type="email" name="email" value="<?php echo get_option('bessou_email', 'hello@bessouhairbeauty.com'); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">Business Hours</th>
                    <td>
                        <textarea name="hours" rows="3" cols="50"><?php echo get_option('bessou_hours', 'Monday - Saturday: 9:00 AM - 7:00 PM\nSunday: 10:00 AM - 5:00 PM'); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Facebook URL</th>
                    <td>
                        <input type="url" name="facebook" value="<?php echo get_option('bessou_facebook', ''); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">Instagram URL</th>
                    <td>
                        <input type="url" name="instagram" value="<?php echo get_option('bessou_instagram', ''); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">Twitter URL</th>
                    <td>
                        <input type="url" name="twitter" value="<?php echo get_option('bessou_twitter', ''); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">Yelp URL</th>
                    <td>
                        <input type="url" name="yelp" value="<?php echo get_option('bessou_yelp', ''); ?>" />
                    </td>
                </tr>
            </table>
            <?php submit_button('Update Contact Information'); ?>
        </form>
    </div>
    <?php
}

/**
 * Booking settings admin page
 */
function bessou_booking_page() {
    if (isset($_POST['submit'])) {
        update_option('bessou_booking_url', sanitize_url($_POST['booking_url']));
        update_option('bessou_calendar_embed', wp_kses_post($_POST['calendar_embed']));
        update_option('bessou_deposit_amount', intval($_POST['deposit_amount']));
        
        echo '<div class="notice notice-success"><p>Booking settings updated successfully!</p></div>';
    }
    
    ?>
    <div class="wrap">
        <h1>Booking Settings</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row">Google Calendar Booking URL</th>
                    <td>
                        <input type="url" name="booking_url" value="<?php echo get_option('bessou_booking_url', ''); ?>" style="width: 100%;" />
                        <p class="description">Your Google Calendar booking link</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Calendar Embed Code</th>
                    <td>
                        <textarea name="calendar_embed" rows="5" cols="50" style="width: 100%;"><?php echo get_option('bessou_calendar_embed', ''); ?></textarea>
                        <p class="description">Paste your Google Calendar embed iframe code here</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Deposit Amount</th>
                    <td>
                        $<input type="number" name="deposit_amount" value="<?php echo get_option('bessou_deposit_amount', 30); ?>" min="0" step="5" />
                        <p class="description">Required deposit amount for appointments</p>
                    </td>
                </tr>
            </table>
            <?php submit_button('Update Booking Settings'); ?>
        </form>
        
        <div style="background: #f1f1f1; padding: 15px; margin-top: 20px; border-radius: 5px;">
            <h3>How to Set Up Google Calendar Booking:</h3>
            <ol>
                <li>Go to <a href="https://calendar.google.com" target="_blank">Google Calendar</a></li>
                <li>Create a new calendar for appointments</li>
                <li>Go to Settings > Calendar Settings > Integrate Calendar</li>
                <li>Copy the "Public URL to this calendar" for the booking URL field</li>
                <li>Copy the iframe embed code for the calendar embed field</li>
            </ol>
        </div>
    </div>
    <?php
}

/**
 * Add Customizer settings
 */
function bessou_customize_register($wp_customize) {
    // Add Bessou Hair Beauty section
    $wp_customize->add_section('bessou_settings', array(
        'title' => 'Bessou Hair Beauty',
        'description' => 'Customize your salon website',
        'priority' => 120,
    ));
    
    // Hero settings
    $wp_customize->add_setting('bessou_hero_image');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'bessou_hero_image', array(
        'label' => 'Hero Image',
        'section' => 'bessou_settings',
    )));
    
    // Service settings
    $wp_customize->add_setting('bessou_services_title', array('default' => 'Our Braiding Services'));
    $wp_customize->add_control('bessou_services_title', array(
        'label' => 'Services Section Title',
        'section' => 'bessou_settings',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('bessou_services_subtitle', array('default' => 'Professional African hair braiding with 15+ years of experience'));
    $wp_customize->add_control('bessou_services_subtitle', array(
        'label' => 'Services Section Subtitle',
        'section' => 'bessou_settings',
        'type' => 'textarea',
    ));
    
    // Gallery settings
    $wp_customize->add_setting('bessou_gallery_title', array('default' => 'Our Work Gallery'));
    $wp_customize->add_control('bessou_gallery_title', array(
        'label' => 'Gallery Section Title',
        'section' => 'bessou_settings',
        'type' => 'text',
    ));
    
    // About settings
    $wp_customize->add_setting('bessou_about_title', array('default' => 'About Bessou Hair Beauty'));
    $wp_customize->add_control('bessou_about_title', array(
        'label' => 'About Section Title',
        'section' => 'bessou_settings',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('bessou_about_image');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'bessou_about_image', array(
        'label' => 'About Section Image',
        'section' => 'bessou_settings',
    )));
}

/**
 * Helper function to get service price with fallback
 */
function get_bessou_service_price($service_key, $default_price) {
    return get_option('bessou_' . $service_key . '_price', $default_price);
}

/**
 * Helper function to get contact information
 */
function get_bessou_contact($field, $default = '') {
    return get_option('bessou_' . $field, $default);
}

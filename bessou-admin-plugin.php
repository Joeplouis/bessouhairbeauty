<?php
/*
Plugin Name: Bessou Hair Beauty Admin
Description: Admin plugin for managing Bessou Hair Beauty salon website
Version: 1.0.0
Author: AI Assistant
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class BessouHairBeautyAdmin {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'init_settings'));
        add_action('wp_ajax_bessou_update_price', array($this, 'update_service_price'));
        add_action('wp_ajax_bessou_update_contact', array($this, 'update_contact_info'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'Bessou Hair Beauty',
            'Bessou Salon',
            'manage_options',
            'bessou-admin',
            array($this, 'admin_dashboard'),
            'dashicons-admin-appearance',
            30
        );
        
        add_submenu_page(
            'bessou-admin',
            'Service Prices',
            'Prices',
            'manage_options',
            'bessou-prices',
            array($this, 'prices_page')
        );
        
        add_submenu_page(
            'bessou-admin',
            'Contact Info',
            'Contact',
            'manage_options',
            'bessou-contact',
            array($this, 'contact_page')
        );
        
        add_submenu_page(
            'bessou-admin',
            'Booking Settings',
            'Booking',
            'manage_options',
            'bessou-booking',
            array($this, 'booking_page')
        );
    }
    
    public function init_settings() {
        register_setting('bessou_settings', 'bessou_services');
        register_setting('bessou_settings', 'bessou_contact');
        register_setting('bessou_settings', 'bessou_booking');
    }
    
    public function enqueue_admin_scripts($hook) {
        if (strpos($hook, 'bessou') !== false) {
            wp_enqueue_script('jquery');
            wp_enqueue_script('bessou-admin', plugin_dir_url(__FILE__) . 'assets/admin.js', array('jquery'), '1.0.0', true);
            wp_localize_script('bessou-admin', 'bessou_ajax', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('bessou_nonce')
            ));
        }
    }
    
    public function admin_dashboard() {
        ?>
        <div class="wrap">
            <h1>Bessou Hair Beauty Salon Management</h1>
            
            <div class="bessou-dashboard">
                <div class="dashboard-card">
                    <h2>Quick Stats</h2>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <h3>15</h3>
                            <p>Braiding Services</p>
                        </div>
                        <div class="stat-item">
                            <h3><?php echo get_option('bessou_total_bookings', 0); ?></h3>
                            <p>Total Bookings</p>
                        </div>
                        <div class="stat-item">
                            <h3>$<?php echo get_option('bessou_deposit_amount', 30); ?></h3>
                            <p>Deposit Amount</p>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <h2>Quick Actions</h2>
                    <div class="action-buttons">
                        <a href="<?php echo admin_url('admin.php?page=bessou-prices'); ?>" class="button button-primary button-large">
                            <span class="dashicons dashicons-money-alt"></span>
                            Update Prices
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=bessou-contact'); ?>" class="button button-secondary button-large">
                            <span class="dashicons dashicons-email-alt"></span>
                            Update Contact
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=bessou-booking'); ?>" class="button button-secondary button-large">
                            <span class="dashicons dashicons-calendar-alt"></span>
                            Booking Settings
                        </a>
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <h2>Recent Activity</h2>
                    <div class="activity-list">
                        <div class="activity-item">
                            <span class="dashicons dashicons-admin-generic"></span>
                            <div>
                                <strong>System Status:</strong> All systems operational
                                <span class="activity-time">Just now</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <span class="dashicons dashicons-yes-alt"></span>
                            <div>
                                <strong>Website Ready:</strong> Bessou Hair Beauty site is live
                                <span class="activity-time">Today</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
        .bessou-dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .dashboard-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .dashboard-card h2 {
            margin-top: 0;
            color: #d4af37;
            border-bottom: 2px solid #d4af37;
            padding-bottom: 10px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 15px;
        }
        
        .stat-item {
            text-align: center;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 6px;
        }
        
        .stat-item h3 {
            margin: 0;
            font-size: 24px;
            color: #8b4513;
        }
        
        .stat-item p {
            margin: 5px 0 0;
            color: #666;
        }
        
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .action-buttons .button {
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
            padding: 12px 20px;
        }
        
        .activity-list {
            margin-top: 15px;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-item .dashicons {
            color: #d4af37;
        }
        
        .activity-time {
            font-size: 12px;
            color: #999;
            display: block;
            margin-top: 2px;
        }
        </style>
        <?php
    }
    
    public function prices_page() {
        if (isset($_POST['submit'])) {
            $this->save_service_prices();
        }
        
        $services = $this->get_all_services();
        ?>
        <div class="wrap">
            <h1>Service Prices Management</h1>
            
            <div class="prices-container">
                <form method="post" action="" class="prices-form">
                    <?php wp_nonce_field('bessou_prices_nonce'); ?>
                    
                    <div class="services-grid">
                        <?php foreach ($services as $key => $service) : ?>
                            <div class="service-price-card">
                                <div class="service-image">
                                    <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/' . $service['image']; ?>" 
                                         alt="<?php echo $service['name']; ?>" 
                                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2Q0YWYzNyIvPjx0ZXh0IHg9IjUwIiB5PSI1NSIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjEyIiBmaWxsPSIjOGI0NTEzIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5JbWFnZTwvdGV4dD48L3N2Zz4='" />
                                </div>
                                <div class="service-details">
                                    <h3><?php echo $service['name']; ?></h3>
                                    <p><?php echo $service['description']; ?></p>
                                    <div class="price-input-group">
                                        <label for="<?php echo $key; ?>_price">Starting Price:</label>
                                        <div class="price-input">
                                            <span class="currency">$</span>
                                            <input type="number" 
                                                   id="<?php echo $key; ?>_price" 
                                                   name="<?php echo $key; ?>_price" 
                                                   value="<?php echo get_option('bessou_' . $key . '_price', $service['default_price']); ?>" 
                                                   min="0" 
                                                   step="5" 
                                                   class="price-field" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="form-actions">
                        <?php submit_button('Update All Prices', 'primary', 'submit', false, array('class' => 'button-large')); ?>
                        <button type="button" id="reset-prices" class="button button-secondary button-large">Reset to Defaults</button>
                    </div>
                </form>
            </div>
        </div>
        
        <style>
        .prices-container {
            margin-top: 20px;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .service-price-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .service-price-card:hover {
            transform: translateY(-2px);
        }
        
        .service-image {
            height: 120px;
            overflow: hidden;
        }
        
        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .service-details {
            padding: 20px;
        }
        
        .service-details h3 {
            margin: 0 0 10px;
            color: #d4af37;
            font-size: 18px;
        }
        
        .service-details p {
            margin: 0 0 15px;
            color: #666;
            line-height: 1.5;
        }
        
        .price-input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #8b4513;
        }
        
        .price-input {
            display: flex;
            align-items: center;
            border: 2px solid #ddd;
            border-radius: 6px;
            overflow: hidden;
        }
        
        .price-input:focus-within {
            border-color: #d4af37;
        }
        
        .currency {
            background: #f5f5f5;
            padding: 10px 12px;
            font-weight: bold;
            color: #8b4513;
        }
        
        .price-field {
            border: none;
            padding: 10px 12px;
            flex: 1;
            font-size: 16px;
            outline: none;
        }
        
        .form-actions {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .form-actions .button {
            margin: 0 10px;
        }
        </style>
        
        <script>
        document.getElementById('reset-prices').addEventListener('click', function() {
            if (confirm('Are you sure you want to reset all prices to their default values?')) {
                // Reset all price fields to their default values
                const services = <?php echo json_encode($services); ?>;
                Object.keys(services).forEach(key => {
                    const field = document.getElementById(key + '_price');
                    if (field) {
                        field.value = services[key].default_price;
                    }
                });
            }
        });
        </script>
        <?php
    }
    
    public function contact_page() {
        if (isset($_POST['submit'])) {
            $this->save_contact_info();
        }
        
        ?>
        <div class="wrap">
            <h1>Contact Information Management</h1>
            
            <div class="contact-container">
                <form method="post" action="" class="contact-form">
                    <?php wp_nonce_field('bessou_contact_nonce'); ?>
                    
                    <div class="form-grid">
                        <div class="form-section">
                            <h2>Business Information</h2>
                            
                            <div class="form-group">
                                <label for="business_name">Business Name</label>
                                <input type="text" id="business_name" name="business_name" 
                                       value="<?php echo get_option('bessou_business_name', 'Bessou Hair Beauty'); ?>" />
                            </div>
                            
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" name="address" rows="3"><?php echo get_option('bessou_address', '123 Beauty Street\nHair City, HC 12345'); ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="<?php echo get_option('bessou_phone', '+1 (234) 567-8900'); ?>" />
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" 
                                       value="<?php echo get_option('bessou_email', 'hello@bessouhairbeauty.com'); ?>" />
                            </div>
                            
                            <div class="form-group">
                                <label for="hours">Business Hours</label>
                                <textarea id="hours" name="hours" rows="4"><?php echo get_option('bessou_hours', 'Monday - Saturday: 9:00 AM - 7:00 PM\nSunday: 10:00 AM - 5:00 PM'); ?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h2>Social Media Links</h2>
                            
                            <div class="form-group">
                                <label for="facebook">
                                    <span class="dashicons dashicons-facebook-alt"></span>
                                    Facebook URL
                                </label>
                                <input type="url" id="facebook" name="facebook" 
                                       value="<?php echo get_option('bessou_facebook', ''); ?>" 
                                       placeholder="https://facebook.com/yourpage" />
                            </div>
                            
                            <div class="form-group">
                                <label for="instagram">
                                    <span class="dashicons dashicons-instagram"></span>
                                    Instagram URL
                                </label>
                                <input type="url" id="instagram" name="instagram" 
                                       value="<?php echo get_option('bessou_instagram', ''); ?>" 
                                       placeholder="https://instagram.com/yourprofile" />
                            </div>
                            
                            <div class="form-group">
                                <label for="twitter">
                                    <span class="dashicons dashicons-twitter"></span>
                                    Twitter URL
                                </label>
                                <input type="url" id="twitter" name="twitter" 
                                       value="<?php echo get_option('bessou_twitter', ''); ?>" 
                                       placeholder="https://twitter.com/yourprofile" />
                            </div>
                            
                            <div class="form-group">
                                <label for="yelp">
                                    <span class="dashicons dashicons-star-filled"></span>
                                    Yelp URL
                                </label>
                                <input type="url" id="yelp" name="yelp" 
                                       value="<?php echo get_option('bessou_yelp', ''); ?>" 
                                       placeholder="https://yelp.com/biz/your-business" />
                            </div>
                            
                            <div class="form-group">
                                <label for="whatsapp">
                                    <span class="dashicons dashicons-smartphone"></span>
                                    WhatsApp Number
                                </label>
                                <input type="tel" id="whatsapp" name="whatsapp" 
                                       value="<?php echo get_option('bessou_whatsapp', ''); ?>" 
                                       placeholder="+1234567890" />
                                <p class="description">Enter phone number for WhatsApp bookings (without + or spaces)</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <?php submit_button('Update Contact Information', 'primary', 'submit', false, array('class' => 'button-large')); ?>
                    </div>
                </form>
            </div>
        </div>
        
        <style>
        .contact-container {
            margin-top: 20px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .form-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .form-section h2 {
            margin: 0 0 20px;
            color: #d4af37;
            border-bottom: 2px solid #d4af37;
            padding-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #8b4513;
        }
        
        .form-group label .dashicons {
            margin-right: 5px;
            color: #d4af37;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #d4af37;
            outline: none;
        }
        
        .form-group .description {
            margin: 5px 0 0;
            font-size: 12px;
            color: #666;
            font-style: italic;
        }
        
        .form-actions {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
        </style>
        <?php
    }
    
    public function booking_page() {
        if (isset($_POST['submit'])) {
            $this->save_booking_settings();
        }
        
        ?>
        <div class="wrap">
            <h1>Booking Settings Management</h1>
            
            <div class="booking-container">
                <form method="post" action="" class="booking-form">
                    <?php wp_nonce_field('bessou_booking_nonce'); ?>
                    
                    <div class="settings-grid">
                        <div class="settings-section">
                            <h2>Booking Configuration</h2>
                            
                            <div class="form-group">
                                <label for="deposit_amount">Deposit Amount ($)</label>
                                <input type="number" id="deposit_amount" name="deposit_amount" 
                                       value="<?php echo get_option('bessou_deposit_amount', 30); ?>" 
                                       min="0" step="5" />
                                <p class="description">Required deposit for appointments</p>
                            </div>
                            
                            <div class="form-group">
                                <label for="booking_url">Google Calendar Booking URL</label>
                                <input type="url" id="booking_url" name="booking_url" 
                                       value="<?php echo get_option('bessou_booking_url', ''); ?>" 
                                       placeholder="https://calendar.google.com/..." />
                                <p class="description">Direct link to your Google Calendar booking page</p>
                            </div>
                            
                            <div class="form-group">
                                <label for="calendar_embed">Calendar Embed Code</label>
                                <textarea id="calendar_embed" name="calendar_embed" rows="6" 
                                          placeholder="<iframe src=&quot;https://calendar.google.com/calendar/embed...&quot;></iframe>"><?php echo get_option('bessou_calendar_embed', ''); ?></textarea>
                                <p class="description">Paste your Google Calendar iframe embed code</p>
                            </div>
                        </div>
                        
                        <div class="settings-section">
                            <h2>Booking Policies</h2>
                            
                            <div class="policy-item">
                                <div class="policy-icon">
                                    <span class="dashicons dashicons-money-alt"></span>
                                </div>
                                <div class="policy-content">
                                    <h4>Deposit Required</h4>
                                    <p>A $<span id="deposit-display"><?php echo get_option('bessou_deposit_amount', 30); ?></span> deposit is required to secure appointments</p>
                                </div>
                            </div>
                            
                            <div class="policy-item">
                                <div class="policy-icon">
                                    <span class="dashicons dashicons-clock"></span>
                                </div>
                                <div class="policy-content">
                                    <h4>Late Policy</h4>
                                    <p>If you're more than 1 hour late, deposit is non-refundable</p>
                                </div>
                            </div>
                            
                            <div class="policy-item">
                                <div class="policy-icon">
                                    <span class="dashicons dashicons-calendar-alt"></span>
                                </div>
                                <div class="policy-content">
                                    <h4>No-Show Policy</h4>
                                    <p>Deposit will be deducted from future appointments</p>
                                </div>
                            </div>
                            
                            <div class="policy-item success">
                                <div class="policy-icon">
                                    <span class="dashicons dashicons-yes-alt"></span>
                                </div>
                                <div class="policy-content">
                                    <h4>On-Time Benefit</h4>
                                    <p>Deposit deducted from service cost when you arrive on time</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <?php submit_button('Update Booking Settings', 'primary', 'submit', false, array('class' => 'button-large')); ?>
                    </div>
                </form>
                
                <div class="help-section">
                    <h2>Setup Instructions</h2>
                    <div class="help-content">
                        <h3>Google Calendar Setup</h3>
                        <ol>
                            <li>Go to <a href="https://calendar.google.com" target="_blank">Google Calendar</a></li>
                            <li>Create a new calendar for appointments</li>
                            <li>Go to Calendar Settings → Integrate Calendar</li>
                            <li>Copy the public URL for the booking URL field</li>
                            <li>Copy the iframe embed code for the calendar embed field</li>
                        </ol>
                        
                        <h3>Payment Integration</h3>
                        <p>Consider integrating with payment processors like:</p>
                        <ul>
                            <li><strong>PayPal:</strong> Easy online payments</li>
                            <li><strong>Square:</strong> In-person and online payments</li>
                            <li><strong>Stripe:</strong> Advanced payment processing</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
        .booking-container {
            margin-top: 20px;
        }
        
        .settings-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .settings-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .settings-section h2 {
            margin: 0 0 20px;
            color: #d4af37;
            border-bottom: 2px solid #d4af37;
            padding-bottom: 10px;
        }
        
        .policy-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 15px;
            margin-bottom: 15px;
            background: #f9f9f9;
            border-radius: 6px;
            border-left: 4px solid #d4af37;
        }
        
        .policy-item.success {
            border-left-color: #28a745;
        }
        
        .policy-icon {
            flex-shrink: 0;
        }
        
        .policy-icon .dashicons {
            font-size: 20px;
            color: #d4af37;
        }
        
        .policy-item.success .policy-icon .dashicons {
            color: #28a745;
        }
        
        .policy-content h4 {
            margin: 0 0 5px;
            color: #8b4513;
        }
        
        .policy-content p {
            margin: 0;
            color: #666;
            line-height: 1.4;
        }
        
        .help-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        
        .help-section h2 {
            margin: 0 0 20px;
            color: #d4af37;
            border-bottom: 2px solid #d4af37;
            padding-bottom: 10px;
        }
        
        .help-content h3 {
            color: #8b4513;
            margin: 20px 0 10px;
        }
        
        .help-content ol, .help-content ul {
            padding-left: 25px;
        }
        
        .help-content li {
            margin-bottom: 5px;
            line-height: 1.5;
        }
        
        @media (max-width: 768px) {
            .settings-grid {
                grid-template-columns: 1fr;
            }
        }
        </style>
        
        <script>
        // Update deposit display in real-time
        document.getElementById('deposit_amount').addEventListener('input', function() {
            document.getElementById('deposit-display').textContent = this.value;
        });
        </script>
        <?php
    }
    
    private function get_all_services() {
        return array(
            'box_braids' => array(
                'name' => 'Box Braids',
                'description' => 'Classic protective style perfect for all occasions',
                'default_price' => 120,
                'image' => 'box-braids.jpg'
            ),
            'fulani_braids' => array(
                'name' => 'Fulani Braids',
                'description' => 'Traditional style with modern flair and decorative beads',
                'default_price' => 150,
                'image' => 'fulani-braids.jpg'
            ),
            'goddess_braids' => array(
                'name' => 'Goddess Braids',
                'description' => 'Chunky, elegant braids for a bold statement look',
                'default_price' => 100,
                'image' => 'goddess-braids.jpg'
            ),
            'cornrows' => array(
                'name' => 'Cornrows',
                'description' => 'Intricate patterns braided close to the scalp',
                'default_price' => 80,
                'image' => 'cornrows.jpg'
            ),
            'knotless_braids' => array(
                'name' => 'Knotless Braids',
                'description' => 'Gentle technique for sensitive scalps',
                'default_price' => 140,
                'image' => 'knotless-braids.jpg'
            ),
            'tribal_braids' => array(
                'name' => 'Tribal Braids',
                'description' => 'Cultural patterns celebrating African heritage',
                'default_price' => 110,
                'image' => 'tribal-braids.jpg'
            ),
            'feed_in_braids' => array(
                'name' => 'Feed-in Braids',
                'description' => 'Natural-looking braids that grow from your hairline',
                'default_price' => 90,
                'image' => 'feed-in-braids.jpg'
            ),
            'senegalese_twists' => array(
                'name' => 'Senegalese Twists',
                'description' => 'Smooth, rope-like twists for a sleek look',
                'default_price' => 130,
                'image' => 'senegalese-twists.jpg'
            ),
            'passion_twists' => array(
                'name' => 'Passion Twists',
                'description' => 'Textured twists with a bohemian vibe',
                'default_price' => 125,
                'image' => 'passion-twists.jpg'
            ),
            'braided_buns' => array(
                'name' => 'Braided Buns',
                'description' => 'Elegant updo styles for special occasions',
                'default_price' => 85,
                'image' => 'braided-buns.jpg'
            ),
            'boho_braids' => array(
                'name' => 'Boho Braids',
                'description' => 'Free-spirited style with loose, textured ends',
                'default_price' => 135,
                'image' => 'boho-braids.jpg'
            ),
            'micro_braids' => array(
                'name' => 'Micro Braids',
                'description' => 'Tiny, intricate braids for a detailed look',
                'default_price' => 200,
                'image' => 'micro-braids.jpg'
            ),
            'ghana_braids' => array(
                'name' => 'Ghana Braids',
                'description' => 'Classic West African style with straight-back patterns',
                'default_price' => 95,
                'image' => 'ghana-braids.jpg'
            ),
            'lemonade_braids' => array(
                'name' => 'Lemonade Braids',
                'description' => 'Side-swept braids inspired by modern trends',
                'default_price' => 115,
                'image' => 'lemonade-braids.jpg'
            ),
            'faux_locs' => array(
                'name' => 'Faux Locs',
                'description' => 'Temporary locs without the commitment',
                'default_price' => 180,
                'image' => 'faux-locs.jpg'
            )
        );
    }
    
    private function save_service_prices() {
        if (!wp_verify_nonce($_POST['_wpnonce'], 'bessou_prices_nonce')) {
            return;
        }
        
        $services = $this->get_all_services();
        foreach ($services as $key => $service) {
            $price_key = $key . '_price';
            if (isset($_POST[$price_key])) {
                update_option('bessou_' . $price_key, intval($_POST[$price_key]));
            }
        }
        
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success"><p>Service prices updated successfully!</p></div>';
        });
    }
    
    private function save_contact_info() {
        if (!wp_verify_nonce($_POST['_wpnonce'], 'bessou_contact_nonce')) {
            return;
        }
        
        $fields = array('business_name', 'address', 'phone', 'email', 'hours', 'facebook', 'instagram', 'twitter', 'yelp', 'whatsapp');
        
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_option('bessou_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
        
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success"><p>Contact information updated successfully!</p></div>';
        });
    }
    
    private function save_booking_settings() {
        if (!wp_verify_nonce($_POST['_wpnonce'], 'bessou_booking_nonce')) {
            return;
        }
        
        update_option('bessou_deposit_amount', intval($_POST['deposit_amount']));
        update_option('bessou_booking_url', sanitize_url($_POST['booking_url']));
        update_option('bessou_calendar_embed', wp_kses_post($_POST['calendar_embed']));
        
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success"><p>Booking settings updated successfully!</p></div>';
        });
    }
}

// Initialize the plugin
new BessouHairBeautyAdmin();

<?php
/*
Template Name: Bessou Hair Beauty
Description: Custom WordPress template for African hair braiding salon
Version: 1.0
*/

get_header(); ?>

<main class="main-content bessou-hair-beauty">
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Experience the Art of African Hair Braiding</h1>
            <p>Authentic braiding styles rooted in tradition, crafted with modern elegance</p>
            <div class="hero-buttons">
                <a href="#booking" class="btn-primary">Book Appointment</a>
                <a href="#services" class="btn-secondary">View Services</a>
            </div>
        </div>
        <div class="hero-image">
            <?php
            $hero_image = get_theme_mod('bessou_hero_image', get_template_directory_uri() . '/assets/images/hero-braids.jpg');
            ?>
            <img src="<?php echo esc_url($hero_image); ?>" alt="Beautiful African Braids" />
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <div class="section-header">
                <h2><?php echo get_theme_mod('bessou_services_title', 'Our Braiding Services'); ?></h2>
                <p><?php echo get_theme_mod('bessou_services_subtitle', 'Professional African hair braiding with 15+ years of experience'); ?></p>
            </div>
            
            <div class="services-grid">
                <?php
                $services = array(
                    array(
                        'name' => 'Box Braids',
                        'description' => 'Classic protective style perfect for all occasions',
                        'price' => get_option('bessou_box_braids_price', 120),
                        'image' => 'box-braids.jpg'
                    ),
                    array(
                        'name' => 'Fulani Braids',
                        'description' => 'Traditional style with modern flair and decorative beads',
                        'price' => get_option('bessou_fulani_braids_price', 150),
                        'image' => 'fulani-braids.jpg'
                    ),
                    array(
                        'name' => 'Goddess Braids',
                        'description' => 'Chunky, elegant braids for a bold statement look',
                        'price' => get_option('bessou_goddess_braids_price', 100),
                        'image' => 'goddess-braids.jpg'
                    ),
                    array(
                        'name' => 'Cornrows',
                        'description' => 'Intricate patterns braided close to the scalp',
                        'price' => get_option('bessou_cornrows_price', 80),
                        'image' => 'cornrows.jpg'
                    ),
                    array(
                        'name' => 'Knotless Braids',
                        'description' => 'Gentle technique for sensitive scalps',
                        'price' => get_option('bessou_knotless_braids_price', 140),
                        'image' => 'knotless-braids.jpg'
                    ),
                    array(
                        'name' => 'Tribal Braids',
                        'description' => 'Cultural patterns celebrating African heritage',
                        'price' => get_option('bessou_tribal_braids_price', 110),
                        'image' => 'tribal-braids.jpg'
                    ),
                    array(
                        'name' => 'Feed-in Braids',
                        'description' => 'Natural-looking braids that grow from your hairline',
                        'price' => get_option('bessou_feed_in_braids_price', 90),
                        'image' => 'feed-in-braids.jpg'
                    ),
                    array(
                        'name' => 'Senegalese Twists',
                        'description' => 'Smooth, rope-like twists for a sleek look',
                        'price' => get_option('bessou_senegalese_twists_price', 130),
                        'image' => 'senegalese-twists.jpg'
                    ),
                    array(
                        'name' => 'Passion Twists',
                        'description' => 'Textured twists with a bohemian vibe',
                        'price' => get_option('bessou_passion_twists_price', 125),
                        'image' => 'passion-twists.jpg'
                    ),
                    array(
                        'name' => 'Braided Buns',
                        'description' => 'Elegant updo styles for special occasions',
                        'price' => get_option('bessou_braided_buns_price', 85),
                        'image' => 'braided-buns.jpg'
                    ),
                    array(
                        'name' => 'Boho Braids',
                        'description' => 'Free-spirited style with loose, textured ends',
                        'price' => get_option('bessou_boho_braids_price', 135),
                        'image' => 'boho-braids.jpg'
                    ),
                    array(
                        'name' => 'Micro Braids',
                        'description' => 'Tiny, intricate braids for a detailed look',
                        'price' => get_option('bessou_micro_braids_price', 200),
                        'image' => 'micro-braids.jpg'
                    ),
                    array(
                        'name' => 'Ghana Braids',
                        'description' => 'Classic West African style with straight-back patterns',
                        'price' => get_option('bessou_ghana_braids_price', 95),
                        'image' => 'ghana-braids.jpg'
                    ),
                    array(
                        'name' => 'Lemonade Braids',
                        'description' => 'Side-swept braids inspired by modern trends',
                        'price' => get_option('bessou_lemonade_braids_price', 115),
                        'image' => 'lemonade-braids.jpg'
                    ),
                    array(
                        'name' => 'Faux Locs',
                        'description' => 'Temporary locs without the commitment',
                        'price' => get_option('bessou_faux_locs_price', 180),
                        'image' => 'faux-locs.jpg'
                    )
                );

                foreach ($services as $service) : ?>
                    <div class="service-card">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $service['image']; ?>" alt="<?php echo $service['name']; ?>">
                        <div class="service-content">
                            <h3><?php echo $service['name']; ?></h3>
                            <p><?php echo $service['description']; ?></p>
                            <div class="price-range">
                                <span class="price-label">Starting from:</span>
                                <span class="price">$<?php echo $service['price']; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery" id="gallery">
        <div class="container">
            <div class="section-header">
                <h2><?php echo get_theme_mod('bessou_gallery_title', 'Our Work Gallery'); ?></h2>
                <p><?php echo get_theme_mod('bessou_gallery_subtitle', 'See our stunning transformations and artistic braiding styles'); ?></p>
            </div>
            
            <div class="gallery-grid">
                <?php
                // Get gallery images from WordPress media library or use defaults
                $gallery_images = array(
                    array('title' => 'Box Braids', 'desc' => 'Long protective style', 'image' => 'gallery-1.jpg'),
                    array('title' => 'Fulani Braids', 'desc' => 'Traditional with modern touch', 'image' => 'gallery-2.jpg'),
                    array('title' => 'Goddess Braids', 'desc' => 'Bold and elegant', 'image' => 'gallery-3.jpg'),
                    array('title' => 'Cornrows', 'desc' => 'Intricate patterns', 'image' => 'gallery-4.jpg'),
                    array('title' => 'Knotless Braids', 'desc' => 'Gentle and natural', 'image' => 'gallery-5.jpg'),
                    array('title' => 'Tribal Braids', 'desc' => 'Cultural heritage', 'image' => 'gallery-6.jpg')
                );

                foreach ($gallery_images as $item) : ?>
                    <div class="gallery-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gallery/<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>">
                        <div class="gallery-overlay">
                            <h4><?php echo $item['title']; ?></h4>
                            <p><?php echo $item['desc']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2><?php echo get_theme_mod('bessou_about_title', 'About Bessou Hair Beauty'); ?></h2>
                    <p><?php echo get_theme_mod('bessou_about_text1', 'Welcome to Bessou Hair Beauty, where tradition meets artistry. With over 15 years of experience in authentic African hair braiding, we celebrate the rich cultural heritage of braided hairstyles while embracing modern techniques and trends.'); ?></p>
                    
                    <p><?php echo get_theme_mod('bessou_about_text2', 'Our master braiders are skilled in traditional West African techniques, bringing you authentic styles that protect your natural hair while showcasing your unique beauty. Each braid is woven with care, precision, and respect for the cultural significance of these timeless styles.'); ?></p>
                    
                    <div class="about-features">
                        <div class="feature">
                            <i class="fas fa-award"></i>
                            <h4>15+ Years Experience</h4>
                            <p>Master braiders with extensive training</p>
                        </div>
                        
                        <div class="feature">
                            <i class="fas fa-heart"></i>
                            <h4>Cultural Heritage</h4>
                            <p>Authentic African braiding traditions</p>
                        </div>
                        
                        <div class="feature">
                            <i class="fas fa-shield-alt"></i>
                            <h4>Hair Protection</h4>
                            <p>Gentle techniques that protect your natural hair</p>
                        </div>
                    </div>
                </div>
                
                <div class="about-image">
                    <?php
                    $about_image = get_theme_mod('bessou_about_image', get_template_directory_uri() . '/assets/images/about-us.jpg');
                    ?>
                    <img src="<?php echo esc_url($about_image); ?>" alt="Our braiding salon">
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section class="booking" id="booking">
        <div class="container">
            <div class="section-header">
                <h2><?php echo get_theme_mod('bessou_booking_title', 'Book Your Appointment'); ?></h2>
                <p><?php echo get_theme_mod('bessou_booking_subtitle', 'Schedule your braiding session and experience the art of African hair styling'); ?></p>
            </div>
            
            <div class="booking-content">
                <div class="booking-info">
                    <h3>Booking Terms & Conditions</h3>
                    <div class="booking-terms">
                        <div class="term-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <div>
                                <h4>$30 Deposit Required</h4>
                                <p>A $30 deposit is required to secure your appointment</p>
                            </div>
                        </div>
                        
                        <div class="term-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h4>Late Policy</h4>
                                <p>If you're more than 1 hour late, your deposit is non-refundable and not deducted from the service price</p>
                            </div>
                        </div>
                        
                        <div class="term-item">
                            <i class="fas fa-calendar-times"></i>
                            <div>
                                <h4>No-Show Policy</h4>
                                <p>If you don't show up, the $30 deposit will be deducted from your total service price for future appointments</p>
                            </div>
                        </div>
                        
                        <div class="term-item">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h4>On-Time Arrival</h4>
                                <p>Arrive on time and your deposit will be deducted from your total service cost</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="booking-calendar">
                    <h3>Select Your Appointment Time</h3>
                    <div id="google-calendar-embed">
                        <?php
                        $calendar_embed = get_option('bessou_calendar_embed', '');
                        if ($calendar_embed) {
                            echo wp_kses_post($calendar_embed);
                        } else {
                            echo '<p>Calendar booking coming soon. Please call to schedule.</p>';
                        }
                        ?>
                    </div>
                    
                    <div class="booking-buttons">
                        <a href="<?php echo get_option('bessou_booking_url', '#'); ?>" class="btn-primary" target="_blank">
                            <i class="fas fa-calendar-plus"></i>
                            Book Now on Google Calendar
                        </a>
                        <a href="tel:<?php echo get_option('bessou_phone', '+1234567890'); ?>" class="btn-secondary">
                            <i class="fas fa-phone"></i>
                            Call to Book
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="section-header">
                <h2><?php echo get_theme_mod('bessou_contact_title', 'Contact Us'); ?></h2>
                <p><?php echo get_theme_mod('bessou_contact_subtitle', 'Get in touch to schedule your appointment or ask questions'); ?></p>
            </div>
            
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Location</h4>
                            <p><?php echo get_option('bessou_address', '123 Beauty Street<br>Hair City, HC 12345'); ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h4>Phone</h4>
                            <p><?php echo get_option('bessou_phone', '+1 (234) 567-8900'); ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>Email</h4>
                            <p><?php echo get_option('bessou_email', 'hello@bessouhairbeauty.com'); ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h4>Hours</h4>
                            <p><?php echo get_option('bessou_hours', 'Monday - Saturday: 9:00 AM - 7:00 PM<br>Sunday: 10:00 AM - 5:00 PM'); ?></p>
                        </div>
                    </div>
                    
                    <div class="social-links">
                        <?php if ($facebook = get_option('bessou_facebook')) : ?>
                            <a href="<?php echo esc_url($facebook); ?>" class="social-link"><i class="fab fa-facebook"></i></a>
                        <?php endif; ?>
                        <?php if ($instagram = get_option('bessou_instagram')) : ?>
                            <a href="<?php echo esc_url($instagram); ?>" class="social-link"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if ($twitter = get_option('bessou_twitter')) : ?>
                            <a href="<?php echo esc_url($twitter); ?>" class="social-link"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>
                        <?php if ($yelp = get_option('bessou_yelp')) : ?>
                            <a href="<?php echo esc_url($yelp); ?>" class="social-link"><i class="fab fa-yelp"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="contact-form">
                    <?php echo do_shortcode('[contact-form-7 id="bessou-contact" title="Bessou Contact Form"]'); ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>

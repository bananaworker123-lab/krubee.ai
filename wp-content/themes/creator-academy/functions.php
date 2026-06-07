<?php
defined('ABSPATH') || exit;

/* ─── Theme Setup ─────────────────────────────────────────── */
function ca_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');

    add_image_size('ca-card',  480, 300, true);
    add_image_size('ca-hero',  800, 600, true);
    add_image_size('ca-thumb', 120, 120, true);

    register_nav_menus([
        'primary' => __('Primary Menu', 'creator-academy'),
        'footer'  => __('Footer Menu',  'creator-academy'),
    ]);

    load_theme_textdomain('creator-academy', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'ca_setup');

/* ─── Enqueue ─────────────────────────────────────────────── */
function ca_scripts() {
    wp_enqueue_style('ca-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Sarabun:wght@400;500;600;700;800&display=swap',
        [], null);
    wp_enqueue_style('ca-main',
        get_template_directory_uri() . '/assets/css/main.css',
        ['ca-google-fonts'], '1.0.0');
    wp_enqueue_script('ca-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [], '1.0.0', true);
    wp_localize_script('ca-main', 'caData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('ca_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'ca_scripts');

/* ─── Custom Post Types ───────────────────────────────────── */
function ca_register_post_types() {

    // Freebies
    register_post_type('freebie', [
        'labels' => [
            'name'               => __('Freebies', 'creator-academy'),
            'singular_name'      => __('Freebie', 'creator-academy'),
            'add_new_item'       => __('Add New Freebie', 'creator-academy'),
            'edit_item'          => __('Edit Freebie', 'creator-academy'),
            'view_item'          => __('View Freebie', 'creator-academy'),
            'search_items'       => __('Search Freebies', 'creator-academy'),
            'not_found'          => __('No freebies found.', 'creator-academy'),
            'menu_name'          => __('Freebies', 'creator-academy'),
        ],
        'public'            => true,
        'has_archive'       => true,
        'rewrite'           => ['slug' => 'freebies'],
        'supports'          => ['title','editor','thumbnail','excerpt','custom-fields'],
        'menu_icon'         => 'dashicons-gift',
        'show_in_rest'      => true,
    ]);

    // Digital Products (Shop)
    register_post_type('digital_product', [
        'labels' => [
            'name'               => __('Products', 'creator-academy'),
            'singular_name'      => __('Product', 'creator-academy'),
            'add_new_item'       => __('Add New Product', 'creator-academy'),
            'edit_item'          => __('Edit Product', 'creator-academy'),
            'view_item'          => __('View Product', 'creator-academy'),
            'search_items'       => __('Search Products', 'creator-academy'),
            'not_found'          => __('No products found.', 'creator-academy'),
            'menu_name'          => __('Shop', 'creator-academy'),
        ],
        'public'            => true,
        'has_archive'       => true,
        'rewrite'           => ['slug' => 'shop'],
        'supports'          => ['title','editor','thumbnail','excerpt','custom-fields'],
        'menu_icon'         => 'dashicons-store',
        'show_in_rest'      => true,
    ]);
}
add_action('init', 'ca_register_post_types');

/* ─── Taxonomies ──────────────────────────────────────────── */
function ca_register_taxonomies() {
    $shared = [
        'hierarchical'      => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
    ];

    register_taxonomy('freebie_category', 'freebie', array_merge($shared, [
        'labels' => ['name' => 'Freebie Categories', 'singular_name' => 'Freebie Category'],
        'rewrite' => ['slug' => 'freebie-category'],
    ]));

    register_taxonomy('product_category', 'digital_product', array_merge($shared, [
        'labels' => ['name' => 'Product Categories', 'singular_name' => 'Product Category'],
        'rewrite' => ['slug' => 'product-category'],
    ]));

    register_taxonomy('product_tag', 'digital_product', [
        'hierarchical' => false,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'labels' => ['name' => 'Product Tags', 'singular_name' => 'Product Tag'],
        'rewrite' => ['slug' => 'product-tag'],
    ]);
}
add_action('init', 'ca_register_taxonomies');

/* ─── Meta Boxes ──────────────────────────────────────────── */
function ca_add_meta_boxes() {
    add_meta_box('ca_freebie_meta',   __('Freebie Details', 'creator-academy'),   'ca_freebie_meta_cb',  'freebie',          'normal', 'high');
    add_meta_box('ca_product_meta',   __('Product Details', 'creator-academy'),   'ca_product_meta_cb',  'digital_product',  'normal', 'high');
    add_meta_box('ca_featured_meta',  __('Featured on Homepage', 'creator-academy'), 'ca_featured_meta_cb', ['freebie','digital_product','post'], 'side', 'low');
}
add_action('add_meta_boxes', 'ca_add_meta_boxes');

function ca_freebie_meta_cb($post) {
    wp_nonce_field('ca_freebie_nonce', 'ca_freebie_nonce');
    $dl    = get_post_meta($post->ID, '_ca_download_url',  true);
    $type  = get_post_meta($post->ID, '_ca_file_type',     true);
    $badge = get_post_meta($post->ID, '_ca_badge',         true);
    ?>
    <table class="form-table ca-meta-table">
        <tr>
            <th><label for="ca_download_url"><?php _e('Download URL / Link', 'creator-academy'); ?></label></th>
            <td><input type="url" id="ca_download_url" name="ca_download_url" value="<?php echo esc_attr($dl); ?>" class="widefat" placeholder="https://…" /></td>
        </tr>
        <tr>
            <th><label for="ca_file_type"><?php _e('File Type', 'creator-academy'); ?></label></th>
            <td>
                <select id="ca_file_type" name="ca_file_type">
                    <?php foreach (['PDF','Canva Template','PNG','ZIP','Notion Template','Google Sheets','Other'] as $t): ?>
                        <option value="<?php echo esc_attr($t); ?>" <?php selected($type, $t); ?>><?php echo esc_html($t); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="ca_badge"><?php _e('Badge Label', 'creator-academy'); ?></label></th>
            <td><input type="text" id="ca_badge" name="ca_badge" value="<?php echo esc_attr($badge); ?>" class="regular-text" placeholder="e.g. NEW, HOT, Free" /></td>
        </tr>
    </table>
    <?php
}

function ca_product_meta_cb($post) {
    wp_nonce_field('ca_product_nonce', 'ca_product_nonce');
    $price    = get_post_meta($post->ID, '_ca_price',          true);
    $original = get_post_meta($post->ID, '_ca_original_price', true);
    $file_url = get_post_meta($post->ID, '_ca_file_url',       true);
    $ext_url  = get_post_meta($post->ID, '_ca_external_url',   true);
    $rating   = get_post_meta($post->ID, '_ca_rating',         true);
    $reviews  = get_post_meta($post->ID, '_ca_review_count',   true);
    $badge    = get_post_meta($post->ID, '_ca_badge',          true);
    $file_type = get_post_meta($post->ID, '_ca_file_type',     true);
    ?>
    <table class="form-table ca-meta-table">
        <tr>
            <th><label for="ca_price"><?php _e('Price (฿)', 'creator-academy'); ?></label></th>
            <td><input type="number" id="ca_price" name="ca_price" value="<?php echo esc_attr($price); ?>" class="small-text" min="0" step="1" /></td>
        </tr>
        <tr>
            <th><label for="ca_original_price"><?php _e('Original Price (฿)', 'creator-academy'); ?></label></th>
            <td><input type="number" id="ca_original_price" name="ca_original_price" value="<?php echo esc_attr($original); ?>" class="small-text" min="0" step="1" /><p class="description">Leave blank if no discount.</p></td>
        </tr>
        <tr>
            <th><label for="ca_external_url"><?php _e('Buy / Checkout URL', 'creator-academy'); ?></label></th>
            <td><input type="url" id="ca_external_url" name="ca_external_url" value="<?php echo esc_attr($ext_url); ?>" class="widefat" placeholder="Gumroad, Payhip, Stripe, etc." /></td>
        </tr>
        <tr>
            <th><label for="ca_file_url"><?php _e('Preview / Demo URL', 'creator-academy'); ?></label></th>
            <td><input type="url" id="ca_file_url" name="ca_file_url" value="<?php echo esc_attr($file_url); ?>" class="widefat" /></td>
        </tr>
        <tr>
            <th><label for="ca_file_type"><?php _e('Product Type', 'creator-academy'); ?></label></th>
            <td>
                <select id="ca_file_type" name="ca_file_type">
                    <?php foreach (['E-book','Template','Canva Template','Notion Template','Course','Bundle','Printable','Other'] as $t): ?>
                        <option value="<?php echo esc_attr($t); ?>" <?php selected($file_type, $t); ?>><?php echo esc_html($t); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="ca_rating"><?php _e('Star Rating (1–5)', 'creator-academy'); ?></label></th>
            <td><input type="number" id="ca_rating" name="ca_rating" value="<?php echo esc_attr($rating ?: '5'); ?>" class="small-text" min="1" max="5" step="0.1" /></td>
        </tr>
        <tr>
            <th><label for="ca_review_count"><?php _e('Review Count', 'creator-academy'); ?></label></th>
            <td><input type="number" id="ca_review_count" name="ca_review_count" value="<?php echo esc_attr($reviews); ?>" class="small-text" min="0" /></td>
        </tr>
        <tr>
            <th><label for="ca_badge"><?php _e('Badge Label', 'creator-academy'); ?></label></th>
            <td><input type="text" id="ca_badge" name="ca_badge" value="<?php echo esc_attr($badge); ?>" class="regular-text" placeholder="e.g. BEST SELLER, NEW" /></td>
        </tr>
    </table>
    <?php
}

function ca_featured_meta_cb($post) {
    wp_nonce_field('ca_featured_nonce', 'ca_featured_nonce');
    $featured = get_post_meta($post->ID, '_ca_featured', true);
    $order    = get_post_meta($post->ID, '_ca_homepage_order', true);
    ?>
    <p>
        <label>
            <input type="checkbox" name="ca_featured" value="1" <?php checked($featured, '1'); ?> />
            <?php _e('Show on homepage', 'creator-academy'); ?>
        </label>
    </p>
    <p>
        <label for="ca_homepage_order"><?php _e('Homepage order (lower = first)', 'creator-academy'); ?></label><br>
        <input type="number" id="ca_homepage_order" name="ca_homepage_order" value="<?php echo esc_attr($order ?: 10); ?>" class="small-text" min="0" />
    </p>
    <?php
}

/* ─── Save Meta ───────────────────────────────────────────── */
function ca_save_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['ca_freebie_nonce']) && wp_verify_nonce($_POST['ca_freebie_nonce'], 'ca_freebie_nonce')) {
        update_post_meta($post_id, '_ca_download_url', esc_url_raw($_POST['ca_download_url'] ?? ''));
        update_post_meta($post_id, '_ca_file_type',    sanitize_text_field($_POST['ca_file_type'] ?? ''));
        update_post_meta($post_id, '_ca_badge',        sanitize_text_field($_POST['ca_badge'] ?? ''));
    }

    if (isset($_POST['ca_product_nonce']) && wp_verify_nonce($_POST['ca_product_nonce'], 'ca_product_nonce')) {
        update_post_meta($post_id, '_ca_price',          absint($_POST['ca_price'] ?? 0));
        update_post_meta($post_id, '_ca_original_price', absint($_POST['ca_original_price'] ?? 0));
        update_post_meta($post_id, '_ca_external_url',   esc_url_raw($_POST['ca_external_url'] ?? ''));
        update_post_meta($post_id, '_ca_file_url',       esc_url_raw($_POST['ca_file_url'] ?? ''));
        update_post_meta($post_id, '_ca_file_type',      sanitize_text_field($_POST['ca_file_type'] ?? ''));
        update_post_meta($post_id, '_ca_rating',         (float)($_POST['ca_rating'] ?? 5));
        update_post_meta($post_id, '_ca_review_count',   absint($_POST['ca_review_count'] ?? 0));
        update_post_meta($post_id, '_ca_badge',          sanitize_text_field($_POST['ca_badge'] ?? ''));
    }

    if (isset($_POST['ca_featured_nonce']) && wp_verify_nonce($_POST['ca_featured_nonce'], 'ca_featured_nonce')) {
        update_post_meta($post_id, '_ca_featured',       isset($_POST['ca_featured']) ? '1' : '0');
        update_post_meta($post_id, '_ca_homepage_order', absint($_POST['ca_homepage_order'] ?? 10));
    }
}
add_action('save_post', 'ca_save_meta');

/* ─── Customizer ──────────────────────────────────────────── */
function ca_customizer($wp_customize) {

    // Hero Panel
    $wp_customize->add_panel('ca_hero', ['title' => __('Hero Section', 'creator-academy'), 'priority' => 30]);

    $wp_customize->add_section('ca_hero_content', ['title' => __('Hero Content', 'creator-academy'), 'panel' => 'ca_hero']);

    $fields = [
        'ca_hero_tagline'       => ['default' => 'AI + DIGITAL PRODUCT HUB',          'label' => 'Tagline (small top text)'],
        'ca_hero_headline_1'    => ['default' => 'สร้างรายได้จาก',                    'label' => 'Headline Line 1'],
        'ca_hero_headline_2'    => ['default' => 'Digital Product',                    'label' => 'Headline Line 2 (accent)'],
        'ca_hero_headline_3'    => ['default' => 'ด้วย AI',                            'label' => 'Headline Line 3'],
        'ca_hero_subtext'       => ['default' => 'รวม Prompt พร้อมใช้ Template คอร์สเรียน และไอเดียสินค้าครบจบในที่เดียว',  'label' => 'Subtext'],
        'ca_hero_cta_primary'   => ['default' => 'ดาวน์โหลดฟรี',                     'label' => 'Primary CTA Text'],
        'ca_hero_cta_primary_url'  => ['default' => '/freebies',                        'label' => 'Primary CTA URL'],
        'ca_hero_cta_secondary' => ['default' => 'เริ่มเรียนเลย',                     'label' => 'Secondary CTA Text'],
        'ca_hero_cta_secondary_url'=> ['default' => '/shop',                             'label' => 'Secondary CTA URL'],
        'ca_hero_social_proof'  => ['default' => 'Join 25,000+ creators',              'label' => 'Social Proof Text'],
        'ca_hero_stat_amount'   => ['default' => '฿128,540',                           'label' => 'Stat: Amount'],
        'ca_hero_stat_label'    => ['default' => 'Etsy Sales this month',              'label' => 'Stat: Label'],
    ];

    foreach ($fields as $id => $args) {
        $wp_customize->add_setting($id, ['default' => $args['default'], 'sanitize_callback' => 'wp_kses_post', 'transport' => 'refresh']);
        $wp_customize->add_control($id, ['label' => __($args['label'], 'creator-academy'), 'section' => 'ca_hero_content', 'type' => 'text']);
    }

    // Hero Image
    $wp_customize->add_setting('ca_hero_image', ['default' => '', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'ca_hero_image', [
        'label'     => __('Hero Image', 'creator-academy'),
        'section'   => 'ca_hero_content',
        'mime_type' => 'image',
    ]));

    // Newsletter Section
    $wp_customize->add_section('ca_newsletter', ['title' => __('Newsletter Section', 'creator-academy'), 'priority' => 50]);
    $wp_customize->add_setting('ca_newsletter_headline', ['default' => 'รับของฟรี & เคล็ดลับสร้างรายได้', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('ca_newsletter_headline', ['label' => 'Newsletter Headline', 'section' => 'ca_newsletter', 'type' => 'text']);
    $wp_customize->add_setting('ca_newsletter_subtext', ['default' => 'อัปเดต Prompt ใหม่ ไอเดียสินค้า และเทคนิคขายดี ส่งให้คุณทุกสัปดาห์', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('ca_newsletter_subtext', ['label' => 'Newsletter Subtext', 'section' => 'ca_newsletter', 'type' => 'textarea']);
    $wp_customize->add_setting('ca_newsletter_form_id', ['default' => '', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('ca_newsletter_form_id', ['label' => 'Contact Form 7 Shortcode (paste full [contact-form-7 ...])', 'section' => 'ca_newsletter', 'type' => 'textarea']);

    // Site Identity extras
    $wp_customize->add_section('ca_site_identity_extra', ['title' => __('Site Tagline / Footer', 'creator-academy'), 'priority' => 25]);
    $wp_customize->add_setting('ca_site_description', ['default' => 'แหล่งรวมความรู้และเครื่องมือสำหรับสร้างรายได้จาก Digital Product', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('ca_site_description', ['label' => 'Footer Site Description', 'section' => 'ca_site_identity_extra', 'type' => 'textarea']);
    $wp_customize->add_setting('ca_social_facebook', ['default' => '#', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('ca_social_facebook', ['label' => 'Facebook URL', 'section' => 'ca_site_identity_extra']);
    $wp_customize->add_setting('ca_social_instagram', ['default' => '#', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('ca_social_instagram', ['label' => 'Instagram URL', 'section' => 'ca_site_identity_extra']);
    $wp_customize->add_setting('ca_social_youtube', ['default' => '#', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('ca_social_youtube', ['label' => 'YouTube URL', 'section' => 'ca_site_identity_extra']);
    $wp_customize->add_setting('ca_social_tiktok', ['default' => '#', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('ca_social_tiktok', ['label' => 'TikTok URL', 'section' => 'ca_site_identity_extra']);
}
add_action('customize_register', 'ca_customizer');

/* ─── Widget Areas ────────────────────────────────────────── */
function ca_widgets() {
    register_sidebar(['name' => __('Blog Sidebar', 'creator-academy'), 'id' => 'blog-sidebar',   'before_widget' => '<div class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>']);
    register_sidebar(['name' => __('Footer Col 1', 'creator-academy'), 'id' => 'footer-1',       'before_widget' => '<div class="widget">', 'after_widget' => '</div>', 'before_title' => '<h4 class="footer-widget-title">', 'after_title' => '</h4>']);
    register_sidebar(['name' => __('Footer Col 2', 'creator-academy'), 'id' => 'footer-2',       'before_widget' => '<div class="widget">', 'after_widget' => '</div>', 'before_title' => '<h4 class="footer-widget-title">', 'after_title' => '</h4>']);
}
add_action('widgets_init', 'ca_widgets');

/* ─── Helper Functions ────────────────────────────────────── */
function ca_star_rating(float $rating, int $count = 0): string {
    $full  = floor($rating);
    $half  = ($rating - $full) >= 0.5 ? 1 : 0;
    $empty = 5 - $full - $half;
    $html  = '<div class="ca-stars" aria-label="' . esc_attr($rating . ' out of 5') . '">';
    $html .= str_repeat('<span class="star full">★</span>', (int)$full);
    if ($half) $html .= '<span class="star half">★</span>';
    $html .= str_repeat('<span class="star empty">☆</span>', (int)$empty);
    if ($count) $html .= ' <span class="star-count">(' . number_format($count) . ')</span>';
    $html .= '</div>';
    return $html;
}

function ca_price_display(int $price, int $original = 0): string {
    if (!$price) return '<span class="ca-price free">' . __('Free', 'creator-academy') . '</span>';
    $html = '<span class="ca-price">฿' . number_format($price) . '</span>';
    if ($original && $original > $price) {
        $html = '<span class="ca-price-original">฿' . number_format($original) . '</span> ' . $html;
    }
    return $html;
}

function ca_get_featured_posts(string $post_type, int $limit = 4): WP_Query {
    return new WP_Query([
        'post_type'      => $post_type,
        'posts_per_page' => $limit,
        'meta_query'     => [['key' => '_ca_featured', 'value' => '1']],
        'meta_key'       => '_ca_homepage_order',
        'orderby'        => 'meta_value_num',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ]);
}

/* ─── Contact Form (no plugin fallback) ──────────────────── */
function ca_handle_contact() {
    if (!wp_verify_nonce($_POST['ca_contact_nonce'] ?? '', 'ca_contact')) {
        wp_die('Security check failed.');
    }
    $name    = sanitize_text_field($_POST['contact_name']    ?? '');
    $email   = sanitize_email($_POST['contact_email']        ?? '');
    $subject = sanitize_text_field($_POST['contact_subject'] ?? '');
    $message = sanitize_textarea_field($_POST['contact_message'] ?? '');

    if (!is_email($email)) {
        wp_safe_redirect(add_query_arg('ca_msg', 'error', wp_get_referer()));
        exit;
    }

    $to      = get_option('admin_email');
    $headers = ["Content-Type: text/html; charset=UTF-8", "Reply-To: $name <$email>"];
    $body    = "<p><strong>From:</strong> $name ($email)</p><p><strong>Subject:</strong> $subject</p><p><strong>Message:</strong></p><p>" . nl2br(esc_html($message)) . "</p>";

    wp_mail($to, "Contact Form: $subject", $body, $headers);

    wp_safe_redirect(add_query_arg('ca_msg', 'sent', wp_get_referer()));
    exit;
}
add_action('admin_post_nopriv_ca_contact', 'ca_handle_contact');
add_action('admin_post_ca_contact',        'ca_handle_contact');

/* ─── Admin Columns ───────────────────────────────────────── */
function ca_product_columns($cols) {
    return array_merge(array_slice($cols, 0, 2, true), [
        'ca_price'    => __('Price', 'creator-academy'),
        'ca_rating'   => __('Rating', 'creator-academy'),
        'ca_featured' => __('Featured', 'creator-academy'),
    ], array_slice($cols, 2, null, true));
}
add_filter('manage_digital_product_posts_columns', 'ca_product_columns');

function ca_product_column_data($col, $post_id) {
    if ($col === 'ca_price')    echo '฿' . number_format((int)get_post_meta($post_id, '_ca_price', true));
    if ($col === 'ca_rating')   echo esc_html(get_post_meta($post_id, '_ca_rating', true));
    if ($col === 'ca_featured') echo get_post_meta($post_id, '_ca_featured', true) === '1' ? '⭐' : '—';
}
add_action('manage_digital_product_posts_custom_column', 'ca_product_column_data', 10, 2);

/* ─── Flush Rewrite on Activation ────────────────────────── */
function ca_flush_rewrite() { flush_rewrite_rules(); }
add_action('after_switch_theme', 'ca_flush_rewrite');

/* ─── Admin Stylesheet ────────────────────────────────────── */
function ca_admin_css() {
    echo '<style>
    .ca-meta-table th { width: 200px; }
    .ca-meta-table input[type="url"] { width: 100%; }
    </style>';
}
add_action('admin_head', 'ca_admin_css');

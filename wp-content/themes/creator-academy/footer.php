</main><!-- #main -->

<!-- Newsletter CTA -->
<?php if (!is_page('contact')): ?>
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-inner">
            <div class="newsletter-content">
                <div class="newsletter-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <div>
                    <h2><?php echo esc_html(get_theme_mod('ca_newsletter_headline', 'รับของฟรี & เคล็ดลับสร้างรายได้')); ?></h2>
                    <p><?php echo esc_html(get_theme_mod('ca_newsletter_subtext', 'อัปเดต Prompt ใหม่ ไอเดียสินค้า และเทคนิคขายดี ส่งให้คุณทุกสัปดาห์')); ?></p>
                </div>
            </div>
            <div class="newsletter-form">
                <?php $shortcode = get_theme_mod('ca_newsletter_form_id', ''); ?>
                <?php if ($shortcode): ?>
                    <?php echo do_shortcode($shortcode); ?>
                <?php else: ?>
                    <form class="ca-newsletter-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                        <input type="hidden" name="action" value="ca_newsletter_subscribe">
                        <?php wp_nonce_field('ca_newsletter', 'ca_nl_nonce'); ?>
                        <div class="nl-input-group">
                            <input type="email" name="nl_email" placeholder="<?php _e('Your email address', 'creator-academy'); ?>" required />
                            <button type="submit" class="btn btn-accent"><?php _e('สมัครฟรี', 'creator-academy'); ?></button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Footer -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">

            <!-- Brand Column -->
            <div class="footer-brand">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo-text">
                        <span class="logo-icon">📚</span>
                        <span class="logo-text">
                            <strong>Creator</strong>
                            <span class="accent">Academy</span>
                        </span>
                    </a>
                <?php endif; ?>
                <p class="footer-desc"><?php echo esc_html(get_theme_mod('ca_site_description', 'แหล่งรวมความรู้และเครื่องมือสำหรับสร้างรายได้จาก Digital Product')); ?></p>
                <div class="social-links">
                    <?php foreach ([
                        'facebook'  => ['ca_social_facebook',  '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>'],
                        'instagram' => ['ca_social_instagram', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>'],
                        'youtube'   => ['ca_social_youtube',   '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-1.96C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.4 19.54C5.12 20 12 20 12 20s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="white"/></svg>'],
                        'tiktok'    => ['ca_social_tiktok',    '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.2 8.2 0 0 0 4.82 1.56V6.8a4.85 4.85 0 0 1-1.05-.11z"/></svg>'],
                    ] as $key => [$setting, $icon]):
                        $url = get_theme_mod($setting, '#');
                        if ($url && $url !== '#'): ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="social-link <?php echo $key; ?>" aria-label="<?php echo ucfirst($key); ?>">
                                <?php echo $icon; ?>
                            </a>
                        <?php endif;
                    endforeach; ?>
                </div>
            </div>

            <!-- Explore -->
            <div class="footer-col">
                <h4><?php _e('EXPLORE', 'creator-academy'); ?></h4>
                <ul>
                    <li><a href="<?php echo home_url('/freebies'); ?>"><?php _e('Freebies', 'creator-academy'); ?></a></li>
                    <li><a href="<?php echo home_url('/shop'); ?>"><?php _e('Shop', 'creator-academy'); ?></a></li>
                    <li><a href="<?php echo home_url('/blog'); ?>"><?php _e('Blog', 'creator-academy'); ?></a></li>
                    <li><a href="<?php echo home_url('/about'); ?>"><?php _e('About', 'creator-academy'); ?></a></li>
                </ul>
            </div>

            <!-- Shop -->
            <div class="footer-col">
                <h4><?php _e('SHOP', 'creator-academy'); ?></h4>
                <?php
                $shop_items = new WP_Query(['post_type' => 'digital_product', 'posts_per_page' => 5, 'post_status' => 'publish']);
                if ($shop_items->have_posts()): ?>
                    <ul>
                        <?php while ($shop_items->have_posts()): $shop_items->the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </ul>
                <?php else: ?>
                    <ul>
                        <li><a href="<?php echo home_url('/shop'); ?>"><?php _e('All Products', 'creator-academy'); ?></a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Newsletter -->
            <div class="footer-col footer-newsletter">
                <h4><?php _e('NEWSLETTER', 'creator-academy'); ?></h4>
                <p><?php _e('รับเคล็ดลับและของฟรีก่อนใคร', 'creator-academy'); ?></p>
                <form class="footer-nl-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                    <input type="hidden" name="action" value="ca_newsletter_subscribe">
                    <?php wp_nonce_field('ca_newsletter', 'ca_nl_nonce'); ?>
                    <input type="email" name="nl_email" placeholder="<?php _e('Your email address', 'creator-academy'); ?>" required />
                    <button type="submit" class="btn btn-primary btn-sm"><?php _e('Subscribe', 'creator-academy'); ?></button>
                </form>
            </div>

        </div><!-- .footer-grid -->

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'creator-academy'); ?></p>
            <div class="footer-bottom-links">
                <a href="<?php echo home_url('/privacy-policy'); ?>"><?php _e('Privacy Policy', 'creator-academy'); ?></a>
                <a href="<?php echo home_url('/terms'); ?>"><?php _e('Terms of Service', 'creator-academy'); ?></a>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

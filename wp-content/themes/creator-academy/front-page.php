<?php get_header(); ?>

<!-- ── Hero ──────────────────────────────────────────────── -->
<section class="hero">
    <div class="container hero-inner">
        <div class="hero-text">
            <span class="hero-tagline"><?php echo esc_html(get_theme_mod('ca_hero_tagline', 'AI + DIGITAL PRODUCT HUB')); ?></span>
            <h1 class="hero-headline">
                <?php echo esc_html(get_theme_mod('ca_hero_headline_1', 'สร้างรายได้จาก')); ?><br>
                <span class="accent"><?php echo esc_html(get_theme_mod('ca_hero_headline_2', 'Digital Product')); ?></span><br>
                <?php echo esc_html(get_theme_mod('ca_hero_headline_3', 'ด้วย AI')); ?>
            </h1>
            <p class="hero-subtext"><?php echo wp_kses_post(get_theme_mod('ca_hero_subtext', 'รวม Prompt พร้อมใช้ Template คอร์สเรียน และไอเดียสินค้าครบจบในที่เดียว สำหรับคนอยากมีรายได้เสริมบนโลกออนไลน์')); ?></p>
            <div class="hero-cta-group">
                <a href="<?php echo esc_url(get_theme_mod('ca_hero_cta_primary_url', home_url('/freebies'))); ?>" class="btn btn-dark btn-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    <?php echo esc_html(get_theme_mod('ca_hero_cta_primary', 'ดาวน์โหลดฟรี')); ?>
                </a>
                <a href="<?php echo esc_url(get_theme_mod('ca_hero_cta_secondary_url', home_url('/shop'))); ?>" class="btn btn-accent btn-lg">
                    <?php echo esc_html(get_theme_mod('ca_hero_cta_secondary', 'เริ่มต้นเลย')); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
            <div class="hero-social-proof">
                <div class="proof-avatars">
                    <span class="avatar-stack">
                        <span class="avatar">👩</span>
                        <span class="avatar">👨</span>
                        <span class="avatar">👩</span>
                        <span class="avatar">👨</span>
                    </span>
                </div>
                <div>
                    <p class="proof-label"><?php echo esc_html(get_theme_mod('ca_hero_social_proof', 'Join 25,000+ creators')); ?></p>
                    <div class="proof-stars">
                        <span class="stars">★★★★★</span>
                        <span class="review-text">4.9 (320 reviews)</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <?php
            $hero_img_id = get_theme_mod('ca_hero_image', 0);
            if ($hero_img_id): ?>
                <div class="hero-image-wrap">
                    <?php echo wp_get_attachment_image($hero_img_id, 'ca-hero', false, ['class' => 'hero-img', 'alt' => get_bloginfo('name')]); ?>
                </div>
            <?php else: ?>
                <div class="hero-image-placeholder">
                    <div class="placeholder-circle"></div>
                </div>
            <?php endif; ?>

            <!-- Floating Stat Card -->
            <div class="float-card float-card--stat">
                <div class="float-card__label">Etsy Sales</div>
                <div class="float-card__value"><?php echo esc_html(get_theme_mod('ca_hero_stat_amount', '฿128,540')); ?></div>
                <div class="float-card__sub">
                    <span class="trend-up">↑ 28%</span>
                    <span><?php echo esc_html(get_theme_mod('ca_hero_stat_label', 'this month')); ?></span>
                </div>
                <div class="float-card__chart">
                    <svg viewBox="0 0 80 30" fill="none"><polyline points="0,25 15,20 30,22 45,10 60,8 80,2" stroke="#0ABFA3" stroke-width="2" fill="none"/></svg>
                </div>
            </div>

            <!-- Floating Prompt Card -->
            <div class="float-card float-card--prompt">
                <div class="float-card__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                </div>
                <div>
                    <div class="float-card__label">AI Prompt</div>
                    <div class="float-card__text">Create a coloring book page, cute animals, kawaii style...</div>
                </div>
            </div>

            <!-- Floating New Product Card -->
            <div class="float-card float-card--product">
                <div class="float-card__label">New Product</div>
                <div class="float-card__product-thumb">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
                <div class="float-card__label">Coloring Book</div>
            </div>
        </div>
    </div>
</section>

<!-- ── Feature Columns ────────────────────────────────────── -->
<section class="features-section">
    <div class="container">
        <div class="features-grid">

            <div class="feature-card feature-card--teal">
                <div class="feature-icon">🎁</div>
                <div class="feature-body">
                    <h3><?php _e('Free Resources', 'creator-academy'); ?></h3>
                    <p class="feature-sub"><?php _e('ของฟรีเพื่อเริ่มต้นสร้างรายได้', 'creator-academy'); ?></p>
                    <ul class="feature-list">
                        <li><?php _e('Prompt พร้อมใช้', 'creator-academy'); ?></li>
                        <li><?php _e('Canva Template', 'creator-academy'); ?></li>
                        <li><?php _e('Checklist & Guide', 'creator-academy'); ?></li>
                        <li><?php _e('E-book ฟรี', 'creator-academy'); ?></li>
                    </ul>
                    <a href="<?php echo home_url('/freebies'); ?>" class="feature-link"><?php _e('ดูของฟรีทั้งหมด', 'creator-academy'); ?> →</a>
                </div>
            </div>

            <div class="feature-card feature-card--blue">
                <div class="feature-icon">🤖</div>
                <div class="feature-body">
                    <h3><?php _e('AI Prompt Library', 'creator-academy'); ?></h3>
                    <p class="feature-sub"><?php _e('คลัง Prompt สำหรับทุกงาน', 'creator-academy'); ?></p>
                    <ul class="feature-list">
                        <li><?php _e('Prompt สำหรับ Etsy', 'creator-academy'); ?></li>
                        <li><?php _e('Prompt สำหรับ Coloring Book', 'creator-academy'); ?></li>
                        <li><?php _e('Prompt สำหรับ SEO & Marketing', 'creator-academy'); ?></li>
                        <li><?php _e('Prompt สำหรับคอนเทนต์', 'creator-academy'); ?></li>
                    </ul>
                    <a href="<?php echo home_url('/shop'); ?>" class="feature-link"><?php _e('เข้าดู Prompt ทั้งหมด', 'creator-academy'); ?> →</a>
                </div>
            </div>

            <div class="feature-card feature-card--orange">
                <div class="feature-icon">💰</div>
                <div class="feature-body">
                    <h3><?php _e('Online Income', 'creator-academy'); ?> <span class="accent"><?php _e('Academy', 'creator-academy'); ?></span></h3>
                    <p class="feature-sub"><?php _e('คอร์สเรียน สอนทำรายได้ออนไลน์', 'creator-academy'); ?></p>
                    <ul class="feature-list">
                        <li><?php _e('Etsy Mastery', 'creator-academy'); ?></li>
                        <li><?php _e('AI Creator Course', 'creator-academy'); ?></li>
                        <li><?php _e('Digital Product Design', 'creator-academy'); ?></li>
                        <li><?php _e('Passive Income Strategy', 'creator-academy'); ?></li>
                    </ul>
                    <a href="<?php echo home_url('/shop'); ?>" class="feature-link"><?php _e('ดูคอร์สทั้งหมด', 'creator-academy'); ?> →</a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ── Category Icons ─────────────────────────────────────── -->
<section class="categories-section">
    <div class="container">
        <div class="section-header">
            <h2><?php _e('ไอเดีย Digital Product ยอดนิยม', 'creator-academy'); ?></h2>
            <a href="<?php echo home_url('/shop'); ?>" class="see-all"><?php _e('ดูทั้งหมด', 'creator-academy'); ?> →</a>
        </div>
        <div class="category-grid">
            <?php
            $cats = [
                ['icon' => '📚', 'label' => 'Coloring Book',   'url' => home_url('/shop?product_category=coloring-book')],
                ['icon' => '📅', 'label' => 'Planner',          'url' => home_url('/shop?product_category=planner')],
                ['icon' => '📝', 'label' => 'Worksheet',        'url' => home_url('/shop?product_category=worksheet')],
                ['icon' => '🎨', 'label' => 'Canva Template',   'url' => home_url('/shop?product_category=canva-template')],
                ['icon' => '📖', 'label' => 'KDP Books',        'url' => home_url('/shop?product_category=kdp-books')],
                ['icon' => '🛒', 'label' => 'Etsy Best Seller', 'url' => home_url('/shop?product_category=etsy')],
                ['icon' => '🖨️', 'label' => 'Print on Demand', 'url' => home_url('/shop?product_category=pod')],
                ['icon' => '📱', 'label' => 'Social Media',     'url' => home_url('/shop?product_category=social-media')],
            ];
            foreach ($cats as $cat): ?>
                <a href="<?php echo esc_url($cat['url']); ?>" class="category-chip">
                    <span class="category-chip__icon"><?php echo $cat['icon']; ?></span>
                    <span class="category-chip__label"><?php echo esc_html($cat['label']); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── Featured Freebies ──────────────────────────────────── -->
<?php
$featured_freebies = ca_get_featured_posts('freebie', 3);
if ($featured_freebies->have_posts()): ?>
<section class="content-section">
    <div class="container">
        <div class="section-header">
            <h2><?php _e('ของฟรีแนะนำ', 'creator-academy'); ?></h2>
            <a href="<?php echo home_url('/freebies'); ?>" class="see-all"><?php _e('ดูทั้งหมด', 'creator-academy'); ?> →</a>
        </div>
        <div class="cards-grid cards-grid--3">
            <?php while ($featured_freebies->have_posts()): $featured_freebies->the_post();
                get_template_part('template-parts/freebie-card');
            endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ── Featured Products ──────────────────────────────────── -->
<?php
$featured_products = ca_get_featured_posts('digital_product', 4);
if ($featured_products->have_posts()): ?>
<section class="content-section content-section--alt">
    <div class="container">
        <div class="section-header">
            <h2><?php _e('คอร์สเรียนแนะนำ', 'creator-academy'); ?></h2>
            <a href="<?php echo home_url('/shop'); ?>" class="see-all"><?php _e('ดูคอร์สทั้งหมด', 'creator-academy'); ?> →</a>
        </div>
        <div class="cards-grid cards-grid--4">
            <?php while ($featured_products->have_posts()): $featured_products->the_post();
                get_template_part('template-parts/product-card');
            endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ── Latest Blog Posts ──────────────────────────────────── -->
<?php
$latest_posts = new WP_Query(['post_type' => 'post', 'posts_per_page' => 3, 'post_status' => 'publish']);
if ($latest_posts->have_posts()): ?>
<section class="content-section">
    <div class="container">
        <div class="section-header">
            <h2><?php _e('บทความล่าสุด', 'creator-academy'); ?></h2>
            <a href="<?php echo home_url('/blog'); ?>" class="see-all"><?php _e('อ่านทั้งหมด', 'creator-academy'); ?> →</a>
        </div>
        <div class="cards-grid cards-grid--3">
            <?php while ($latest_posts->have_posts()): $latest_posts->the_post();
                get_template_part('template-parts/post-card');
            endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ── Testimonials ───────────────────────────────────────── -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header">
            <h2><?php _e('เสียงจากผู้เรียน', 'creator-academy'); ?></h2>
        </div>
        <div class="testimonials-grid">
            <?php
            $testimonials = [
                ['quote' => 'จากคนที่ไม่รู้เลย ตอนนี้มียอดขายใน Etsy ทุกเดือน รายได้เสริมเพิ่มมาก!', 'name' => 'คุณนัก', 'role' => 'Etsy Seller'],
                ['quote' => 'คอร์สสอนเข้าใจง่าย ทำตามได้จริง AI ช่วยให้ทำงานวันนี้ขายได้เลย!', 'name' => 'คุณแมว', 'role' => 'Digital Product Creator'],
                ['quote' => 'เริ่มจากฟรีบนเว็บไซต์นี้เลยค่ะ ตอนนี้มีรายได้เสริม 20,000+/เดือนแล้ว', 'name' => 'คุณหน', 'role' => 'Passive Income Learner'],
            ];
            foreach ($testimonials as $t): ?>
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-quote">"<?php echo esc_html($t['quote']); ?>"</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar"><?php echo mb_substr($t['name'], -1); ?></div>
                        <div>
                            <strong><?php echo esc_html($t['name']); ?></strong>
                            <span><?php echo esc_html($t['role']); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>

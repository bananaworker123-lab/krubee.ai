<?php get_header(); the_post();
$price    = (int)   get_post_meta(get_the_ID(), '_ca_price',          true);
$original = (int)   get_post_meta(get_the_ID(), '_ca_original_price', true);
$rating   = (float) get_post_meta(get_the_ID(), '_ca_rating',         true) ?: 5;
$reviews  = (int)   get_post_meta(get_the_ID(), '_ca_review_count',   true);
$ext_url  = get_post_meta(get_the_ID(), '_ca_external_url',           true);
$file_url = get_post_meta(get_the_ID(), '_ca_file_url',               true);
$filetype = get_post_meta(get_the_ID(), '_ca_file_type',              true);
$badge    = get_post_meta(get_the_ID(), '_ca_badge',                  true);
?>

<div class="single-page">
    <div class="container">
        <div class="single-layout single-layout--product">

            <!-- Product Image -->
            <div class="product-gallery">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('ca-hero', ['class' => 'product-main-img']); ?>
                <?php else: ?>
                    <div class="product-img-placeholder"><span>📦</span></div>
                <?php endif; ?>
                <?php if ($file_url): ?>
                    <a href="<?php echo esc_url($file_url); ?>" class="product-preview-link" target="_blank" rel="noopener noreferrer">
                        <?php _e('👁 ดูตัวอย่าง', 'creator-academy'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <div class="product-breadcrumb">
                    <a href="<?php echo get_post_type_archive_link('digital_product'); ?>" class="breadcrumb-link">← <?php _e('Shop', 'creator-academy'); ?></a>
                    <?php if ($filetype): ?><span class="ca-card__type"><?php echo esc_html($filetype); ?></span><?php endif; ?>
                    <?php if ($badge): ?><span class="ca-card__badge<?php echo ($badge === 'BEST SELLER') ? ' ca-card__badge--gold' : ''; ?>"><?php echo esc_html($badge); ?></span><?php endif; ?>
                </div>

                <h1><?php the_title(); ?></h1>

                <div class="product-rating">
                    <?php echo ca_star_rating($rating, $reviews); ?>
                </div>

                <div class="product-price-block">
                    <?php echo ca_price_display($price, $original); ?>
                    <?php if ($original && $original > $price): ?>
                        <span class="discount-badge">-<?php echo round((1 - $price/$original) * 100); ?>%</span>
                    <?php endif; ?>
                </div>

                <?php if (has_excerpt()): ?>
                    <p class="product-excerpt"><?php the_excerpt(); ?></p>
                <?php endif; ?>

                <div class="product-cta">
                    <?php if ($ext_url): ?>
                        <a href="<?php echo esc_url($ext_url); ?>" class="btn btn-accent btn-lg btn-block" target="_blank" rel="noopener noreferrer">
                            <?php _e('ซื้อเลย', 'creator-academy'); ?> — <?php echo ca_price_display($price); ?>
                        </a>
                    <?php else: ?>
                        <button class="btn btn-accent btn-lg btn-block" disabled><?php _e('เร็วๆ นี้', 'creator-academy'); ?></button>
                    <?php endif; ?>
                </div>

                <div class="product-features">
                    <div class="product-feature"><span>✅</span> <?php _e('Digital Download ทันที', 'creator-academy'); ?></div>
                    <div class="product-feature"><span>✅</span> <?php _e('ใช้งานได้ตลอดชีพ', 'creator-academy'); ?></div>
                    <div class="product-feature"><span>✅</span> <?php printf(__('ประเภท: %s', 'creator-academy'), esc_html($filetype ?: 'Digital')); ?></div>
                </div>
            </div>

        </div>

        <!-- Product Content -->
        <div class="product-description">
            <h2><?php _e('รายละเอียด', 'creator-academy'); ?></h2>
            <div class="entry-content"><?php the_content(); ?></div>
        </div>

        <!-- Related Products -->
        <?php
        $related = new WP_Query(['post_type' => 'digital_product', 'posts_per_page' => 4, 'post__not_in' => [get_the_ID()], 'post_status' => 'publish', 'orderby' => 'rand']);
        if ($related->have_posts()): ?>
            <div class="related-section">
                <h2><?php _e('สินค้าที่เกี่ยวข้อง', 'creator-academy'); ?></h2>
                <div class="cards-grid cards-grid--4">
                    <?php while ($related->have_posts()): $related->the_post();
                        get_template_part('template-parts/product-card');
                    endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>

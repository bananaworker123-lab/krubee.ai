<?php get_header(); ?>

<div class="page-hero page-hero--dark">
    <div class="container">
        <span class="page-hero__label">🛍️ SHOP</span>
        <h1><?php _e('Shop', 'creator-academy'); ?></h1>
        <p><?php _e('Digital Products — Template, E-book, Canva Design และอีกมากมาย', 'creator-academy'); ?></p>
    </div>
</div>

<div class="archive-page">
    <div class="container">

        <!-- Category Filter -->
        <?php
        $prod_cats = get_terms(['taxonomy' => 'product_category', 'hide_empty' => true]);
        if ($prod_cats && !is_wp_error($prod_cats)): ?>
            <div class="filter-bar">
                <a href="<?php echo get_post_type_archive_link('digital_product'); ?>" class="filter-btn <?php echo !is_tax('product_category') ? 'active' : ''; ?>">
                    <?php _e('ทั้งหมด', 'creator-academy'); ?>
                </a>
                <?php foreach ($prod_cats as $cat): ?>
                    <a href="<?php echo get_term_link($cat); ?>" class="filter-btn <?php echo is_tax('product_category', $cat->term_id) ? 'active' : ''; ?>">
                        <?php echo esc_html($cat->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Sort Bar -->
        <div class="sort-bar">
            <span class="sort-label"><?php _e('เรียงตาม:', 'creator-academy'); ?></span>
            <a href="?orderby=date&order=DESC"    class="sort-link <?php echo (!isset($_GET['orderby']) || $_GET['orderby'] === 'date') ? 'active' : ''; ?>"><?php _e('ใหม่สุด', 'creator-academy'); ?></a>
            <a href="?orderby=title&order=ASC"    class="sort-link <?php echo (isset($_GET['orderby']) && $_GET['orderby'] === 'title') ? 'active' : ''; ?>"><?php _e('A–Z', 'creator-academy'); ?></a>
            <a href="?orderby=featured&order=ASC" class="sort-link <?php echo (isset($_GET['orderby']) && $_GET['orderby'] === 'featured') ? 'active' : ''; ?>"><?php _e('แนะนำ', 'creator-academy'); ?></a>
        </div>

        <?php if (have_posts()): ?>
            <div class="cards-grid cards-grid--4">
                <?php while (have_posts()): the_post();
                    get_template_part('template-parts/product-card');
                endwhile; ?>
            </div>
            <div class="pagination">
                <?php echo paginate_links(['prev_text' => '← ก่อนหน้า', 'next_text' => 'ถัดไป →']); ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <span class="no-results__icon">🛍️</span>
                <h2><?php _e('ยังไม่มีสินค้าในขณะนี้', 'creator-academy'); ?></h2>
                <a href="<?php echo home_url('/'); ?>" class="btn btn-accent"><?php _e('กลับหน้าหลัก', 'creator-academy'); ?></a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>

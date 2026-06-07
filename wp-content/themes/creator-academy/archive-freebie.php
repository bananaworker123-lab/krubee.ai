<?php get_header(); ?>

<div class="page-hero page-hero--teal">
    <div class="container">
        <span class="page-hero__label">🎁 FREE</span>
        <h1><?php _e('Freebies', 'creator-academy'); ?></h1>
        <p><?php _e('ดาวน์โหลดฟรี — Prompt, Template, Guide และเครื่องมือสร้างรายได้', 'creator-academy'); ?></p>
    </div>
</div>

<div class="archive-page">
    <div class="container">

        <!-- Category Filter -->
        <?php
        $freebie_cats = get_terms(['taxonomy' => 'freebie_category', 'hide_empty' => true]);
        if ($freebie_cats && !is_wp_error($freebie_cats)): ?>
            <div class="filter-bar">
                <a href="<?php echo get_post_type_archive_link('freebie'); ?>" class="filter-btn <?php echo !get_query_var('freebie_category') ? 'active' : ''; ?>">
                    <?php _e('ทั้งหมด', 'creator-academy'); ?>
                </a>
                <?php foreach ($freebie_cats as $cat): ?>
                    <a href="<?php echo get_term_link($cat); ?>" class="filter-btn <?php echo is_tax('freebie_category', $cat->term_id) ? 'active' : ''; ?>">
                        <?php echo esc_html($cat->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (have_posts()): ?>
            <div class="cards-grid cards-grid--3">
                <?php while (have_posts()): the_post();
                    get_template_part('template-parts/freebie-card');
                endwhile; ?>
            </div>
            <div class="pagination">
                <?php echo paginate_links(['prev_text' => '← ก่อนหน้า', 'next_text' => 'ถัดไป →']); ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <span class="no-results__icon">🎁</span>
                <h2><?php _e('ยังไม่มี Freebie ในขณะนี้', 'creator-academy'); ?></h2>
                <p><?php _e('กลับมาเร็วๆ นี้ หรือสมัครรับ Newsletter เพื่อรับแจ้งเตือน', 'creator-academy'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>

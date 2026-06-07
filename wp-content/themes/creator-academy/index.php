<?php get_header(); ?>

<div class="archive-page">
    <div class="container">
        <?php if (is_home()): ?>
            <div class="page-hero page-hero--simple">
                <h1><?php _e('บทความ', 'creator-academy'); ?></h1>
            </div>
        <?php elseif (is_archive()): ?>
            <div class="page-hero page-hero--simple">
                <?php the_archive_title('<h1>', '</h1>'); ?>
                <?php the_archive_description('<p class="archive-desc">', '</p>'); ?>
            </div>
        <?php elseif (is_search()): ?>
            <div class="page-hero page-hero--simple">
                <h1><?php printf(__('ผลการค้นหา: "%s"', 'creator-academy'), get_search_query()); ?></h1>
            </div>
        <?php endif; ?>

        <?php if (have_posts()): ?>
            <div class="cards-grid cards-grid--3">
                <?php while (have_posts()): the_post();
                    get_template_part('template-parts/post-card');
                endwhile; ?>
            </div>
            <div class="pagination">
                <?php echo paginate_links(['prev_text' => '← ก่อนหน้า', 'next_text' => 'ถัดไป →']); ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <span class="no-results__icon">🔍</span>
                <h2><?php _e('ไม่พบเนื้อหา', 'creator-academy'); ?></h2>
                <a href="<?php echo home_url('/'); ?>" class="btn btn-accent"><?php _e('กลับหน้าหลัก', 'creator-academy'); ?></a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>

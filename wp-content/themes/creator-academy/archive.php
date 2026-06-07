<?php get_header(); ?>

<div class="archive-page">
    <div class="container">
        <div class="page-hero page-hero--simple">
            <?php the_archive_title('<h1>', '</h1>'); ?>
            <?php the_archive_description('<p class="archive-desc">', '</p>'); ?>
        </div>
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
                <h2><?php _e('ไม่พบเนื้อหา', 'creator-academy'); ?></h2>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>

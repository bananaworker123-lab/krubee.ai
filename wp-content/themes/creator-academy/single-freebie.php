<?php get_header(); the_post();
$dl_url   = get_post_meta(get_the_ID(), '_ca_download_url', true);
$filetype = get_post_meta(get_the_ID(), '_ca_file_type',    true);
$badge    = get_post_meta(get_the_ID(), '_ca_badge',        true);
?>

<div class="single-page">
    <div class="container">
        <div class="single-layout">

            <!-- Main Content -->
            <article class="single-main">
                <div class="single-meta">
                    <a href="<?php echo get_post_type_archive_link('freebie'); ?>" class="breadcrumb-link">← <?php _e('Freebies', 'creator-academy'); ?></a>
                    <?php if ($filetype): ?><span class="ca-card__type"><?php echo esc_html($filetype); ?></span><?php endif; ?>
                    <?php if ($badge): ?><span class="ca-card__badge ca-card__badge--teal"><?php echo esc_html($badge); ?></span><?php endif; ?>
                </div>

                <h1><?php the_title(); ?></h1>

                <?php if (has_post_thumbnail()): ?>
                    <div class="single-thumb">
                        <?php the_post_thumbnail('ca-hero', ['class' => 'single-featured-img']); ?>
                    </div>
                <?php endif; ?>

                <div class="single-content entry-content">
                    <?php the_content(); ?>
                </div>

                <!-- Download CTA -->
                <?php if ($dl_url): ?>
                    <div class="download-cta">
                        <h3><?php _e('ดาวน์โหลดฟรี', 'creator-academy'); ?></h3>
                        <a href="<?php echo esc_url($dl_url); ?>" class="btn btn-teal btn-lg" target="_blank" rel="noopener noreferrer">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            <?php _e('ดาวน์โหลดเลย — ฟรี!', 'creator-academy'); ?>
                        </a>
                        <p class="download-note"><?php printf(__('ไฟล์: %s', 'creator-academy'), esc_html($filetype ?: 'Digital File')); ?></p>
                    </div>
                <?php endif; ?>
            </article>

            <!-- Sidebar -->
            <aside class="single-sidebar">
                <div class="sidebar-card">
                    <h3><?php _e('Freebies อื่นๆ', 'creator-academy'); ?></h3>
                    <?php
                    $related = new WP_Query(['post_type' => 'freebie', 'posts_per_page' => 4, 'post__not_in' => [get_the_ID()], 'post_status' => 'publish']);
                    if ($related->have_posts()): ?>
                        <ul class="sidebar-list">
                            <?php while ($related->have_posts()): $related->the_post(); ?>
                                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </ul>
                    <?php endif; ?>
                    <a href="<?php echo get_post_type_archive_link('freebie'); ?>" class="btn btn-outline btn-sm btn-block"><?php _e('ดูทั้งหมด →', 'creator-academy'); ?></a>
                </div>
            </aside>

        </div>
    </div>
</div>

<?php get_footer(); ?>

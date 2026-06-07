<?php get_header(); the_post(); ?>

<div class="single-page">
    <div class="container">
        <div class="single-layout">
            <article class="single-main">
                <div class="single-meta">
                    <a href="<?php echo home_url('/blog'); ?>" class="breadcrumb-link">← <?php _e('Blog', 'creator-academy'); ?></a>
                    <?php $cats = get_the_category(); if ($cats): ?><span class="ca-card__category"><?php echo esc_html($cats[0]->name); ?></span><?php endif; ?>
                </div>

                <h1><?php the_title(); ?></h1>

                <div class="post-byline">
                    <span><?php echo get_the_date(); ?></span>
                    <span>·</span>
                    <span><?php the_author(); ?></span>
                </div>

                <?php if (has_post_thumbnail()): ?>
                    <div class="single-thumb"><?php the_post_thumbnail('ca-hero', ['class' => 'single-featured-img']); ?></div>
                <?php endif; ?>

                <div class="single-content entry-content">
                    <?php the_content(); ?>
                    <?php wp_link_pages(['before' => '<div class="page-links">', 'after' => '</div>']); ?>
                </div>

                <div class="post-tags">
                    <?php the_tags('<span class="tag-label">' . __('Tags:', 'creator-academy') . '</span> ', ', '); ?>
                </div>
            </article>

            <aside class="single-sidebar">
                <?php if (is_active_sidebar('blog-sidebar')): ?>
                    <?php dynamic_sidebar('blog-sidebar'); ?>
                <?php else: ?>
                    <div class="sidebar-card">
                        <h3><?php _e('บทความล่าสุด', 'creator-academy'); ?></h3>
                        <?php
                        $recent = new WP_Query(['posts_per_page' => 5, 'post__not_in' => [get_the_ID()]]);
                        if ($recent->have_posts()): ?>
                            <ul class="sidebar-list">
                                <?php while ($recent->have_posts()): $recent->the_post(); ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                <?php endwhile; wp_reset_postdata(); ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div class="sidebar-card sidebar-card--cta">
                        <h3><?php _e('รับของฟรี!', 'creator-academy'); ?></h3>
                        <p><?php _e('สมัครรับ Newsletter เพื่อรับ Template ฟรีทุกสัปดาห์', 'creator-academy'); ?></p>
                        <a href="<?php echo home_url('/freebies'); ?>" class="btn btn-teal btn-sm btn-block"><?php _e('ดาวน์โหลดฟรี', 'creator-academy'); ?></a>
                    </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</div>

<?php get_footer(); ?>

<?php
/*
 * Template Name: About
 */
get_header(); the_post(); ?>

<div class="about-page">

    <!-- Hero -->
    <section class="page-hero page-hero--about">
        <div class="container">
            <span class="page-hero__label">👋 About Us</span>
            <h1><?php the_title(); ?></h1>
            <?php if (has_excerpt()): ?>
                <p><?php the_excerpt(); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Story Content -->
    <section class="about-content">
        <div class="container container--narrow">
            <?php if (has_post_thumbnail()): ?>
                <div class="about-image"><?php the_post_thumbnail('ca-hero', ['class' => 'about-featured-img']); ?></div>
            <?php endif; ?>
            <div class="entry-content"><?php the_content(); ?></div>
        </div>
    </section>

    <!-- Stats Row -->
    <section class="about-stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">25,000+</div>
                    <div class="stat-label"><?php _e('Creators', 'creator-academy'); ?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label"><?php _e('Free Resources', 'creator-academy'); ?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.9★</div>
                    <div class="stat-label"><?php _e('Average Rating', 'creator-academy'); ?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">฿128K+</div>
                    <div class="stat-label"><?php _e('Creator Earnings / Month', 'creator-academy'); ?></div>
                </div>
            </div>
        </div>
    </section>

</div>

<?php get_footer(); ?>

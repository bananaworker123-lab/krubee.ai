<?php get_header(); the_post(); ?>

<div class="single-page">
    <div class="container">
        <?php if (!is_front_page()): ?>
            <div class="page-hero page-hero--simple">
                <h1><?php the_title(); ?></h1>
            </div>
        <?php endif; ?>
        <div class="page-content entry-content">
            <?php the_content(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>

<article class="ca-card ca-card--post" id="post-<?php the_ID(); ?>">
    <a href="<?php the_permalink(); ?>" class="ca-card__thumb-link">
        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('ca-card', ['class' => 'ca-card__thumb', 'loading' => 'lazy']); ?>
        <?php else: ?>
            <div class="ca-card__thumb ca-card__thumb--placeholder ca-card__thumb--blog">
                <span>📝</span>
            </div>
        <?php endif; ?>
    </a>
    <div class="ca-card__body">
        <?php $cats = get_the_category(); if ($cats): ?>
            <span class="ca-card__category"><?php echo esc_html($cats[0]->name); ?></span>
        <?php endif; ?>
        <h3 class="ca-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p class="ca-card__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
        <div class="ca-card__footer ca-card__footer--post">
            <time class="ca-card__date" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
            <a href="<?php the_permalink(); ?>" class="card-read-more"><?php _e('อ่านต่อ →', 'creator-academy'); ?></a>
        </div>
    </div>
</article>

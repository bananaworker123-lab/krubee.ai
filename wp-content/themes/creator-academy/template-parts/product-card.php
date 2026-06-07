<?php
$price    = (int) get_post_meta(get_the_ID(), '_ca_price',          true);
$original = (int) get_post_meta(get_the_ID(), '_ca_original_price', true);
$rating   = (float) get_post_meta(get_the_ID(), '_ca_rating',       true) ?: 5;
$reviews  = (int) get_post_meta(get_the_ID(), '_ca_review_count',   true);
$badge    = get_post_meta(get_the_ID(), '_ca_badge',                 true);
$ext_url  = get_post_meta(get_the_ID(), '_ca_external_url',         true);
$filetype = get_post_meta(get_the_ID(), '_ca_file_type',            true);
?>
<article class="ca-card ca-card--product" id="post-<?php the_ID(); ?>">
    <?php if ($badge): ?>
        <span class="ca-card__badge<?php echo ($badge === 'BEST SELLER' || $badge === 'Best Seller') ? ' ca-card__badge--gold' : ''; ?>"><?php echo esc_html($badge); ?></span>
    <?php endif; ?>
    <a href="<?php the_permalink(); ?>" class="ca-card__thumb-link">
        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('ca-card', ['class' => 'ca-card__thumb', 'loading' => 'lazy']); ?>
        <?php else: ?>
            <div class="ca-card__thumb ca-card__thumb--placeholder">
                <span>📦</span>
            </div>
        <?php endif; ?>
    </a>
    <div class="ca-card__body">
        <?php if ($filetype): ?>
            <span class="ca-card__type"><?php echo esc_html($filetype); ?></span>
        <?php endif; ?>
        <h3 class="ca-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php if (has_excerpt()): ?>
            <p class="ca-card__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
        <?php endif; ?>
        <div class="ca-card__meta">
            <?php echo ca_star_rating($rating, $reviews); ?>
        </div>
        <div class="ca-card__footer">
            <div class="ca-card__price">
                <?php echo ca_price_display($price, $original); ?>
            </div>
            <?php if ($ext_url): ?>
                <a href="<?php echo esc_url($ext_url); ?>" class="btn btn-accent btn-sm" target="_blank" rel="noopener noreferrer"><?php _e('ซื้อเลย', 'creator-academy'); ?></a>
            <?php else: ?>
                <a href="<?php the_permalink(); ?>" class="btn btn-accent btn-sm"><?php _e('ดูรายละเอียด', 'creator-academy'); ?></a>
            <?php endif; ?>
        </div>
    </div>
</article>

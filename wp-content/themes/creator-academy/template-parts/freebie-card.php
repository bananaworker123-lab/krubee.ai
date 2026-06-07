<?php
$badge    = get_post_meta(get_the_ID(), '_ca_badge',        true);
$dl_url   = get_post_meta(get_the_ID(), '_ca_download_url', true);
$filetype = get_post_meta(get_the_ID(), '_ca_file_type',    true);
?>
<article class="ca-card ca-card--freebie" id="post-<?php the_ID(); ?>">
    <?php if ($badge): ?>
        <span class="ca-card__badge ca-card__badge--teal"><?php echo esc_html($badge); ?></span>
    <?php endif; ?>
    <a href="<?php the_permalink(); ?>" class="ca-card__thumb-link">
        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('ca-card', ['class' => 'ca-card__thumb', 'loading' => 'lazy']); ?>
        <?php else: ?>
            <div class="ca-card__thumb ca-card__thumb--placeholder">
                <span>🎁</span>
            </div>
        <?php endif; ?>
    </a>
    <div class="ca-card__body">
        <?php if ($filetype): ?>
            <span class="ca-card__type"><?php echo esc_html($filetype); ?></span>
        <?php endif; ?>
        <h3 class="ca-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php if (has_excerpt()): ?>
            <p class="ca-card__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 16); ?></p>
        <?php endif; ?>
        <div class="ca-card__footer">
            <span class="ca-price free">ฟรี</span>
            <?php if ($dl_url): ?>
                <a href="<?php echo esc_url($dl_url); ?>" class="btn btn-teal btn-sm" target="_blank" rel="noopener noreferrer">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    <?php _e('ดาวน์โหลด', 'creator-academy'); ?>
                </a>
            <?php else: ?>
                <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-sm"><?php _e('ดูรายละเอียด', 'creator-academy'); ?></a>
            <?php endif; ?>
        </div>
    </div>
</article>

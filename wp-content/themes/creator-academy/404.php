<?php get_header(); ?>

<div class="single-page">
    <div class="container" style="text-align:center; padding: 100px 20px;">
        <div style="font-size: 6rem; margin-bottom: 20px;">🔍</div>
        <h1 style="font-size: 5rem; font-weight: 900; color: var(--border);">404</h1>
        <h2 style="margin-bottom: 12px;"><?php _e('ไม่พบหน้านี้', 'creator-academy'); ?></h2>
        <p style="margin-bottom: 32px;"><?php _e('หน้าที่คุณกำลังมองหาอาจถูกย้ายหรือลบไปแล้ว', 'creator-academy'); ?></p>
        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
            <a href="<?php echo home_url('/'); ?>" class="btn btn-dark"><?php _e('← กลับหน้าหลัก', 'creator-academy'); ?></a>
            <a href="<?php echo home_url('/freebies'); ?>" class="btn btn-teal"><?php _e('ดูของฟรี', 'creator-academy'); ?></a>
        </div>
    </div>
</div>

<?php get_footer(); ?>

<?php
/*
 * Template Name: Contact
 */
get_header(); the_post();
$sent  = isset($_GET['ca_msg']) && $_GET['ca_msg'] === 'sent';
$error = isset($_GET['ca_msg']) && $_GET['ca_msg'] === 'error';
?>

<div class="contact-page">
    <section class="page-hero page-hero--simple">
        <div class="container">
            <span class="page-hero__label">📬 Contact</span>
            <h1><?php the_title(); ?></h1>
            <p><?php _e('มีคำถามหรืออยากพูดคุย? ส่งข้อความมาหาเราได้เลย', 'creator-academy'); ?></p>
        </div>
    </section>

    <div class="container">
        <div class="contact-layout">

            <!-- Form -->
            <div class="contact-form-wrap">
                <?php if ($sent): ?>
                    <div class="alert alert--success">
                        <strong>✅ <?php _e('ส่งสำเร็จ!', 'creator-academy'); ?></strong>
                        <?php _e('ขอบคุณ เราจะติดต่อกลับภายใน 1-2 วันทำการ', 'creator-academy'); ?>
                    </div>
                <?php elseif ($error): ?>
                    <div class="alert alert--error">
                        <strong>❌ <?php _e('เกิดข้อผิดพลาด', 'creator-academy'); ?></strong>
                        <?php _e('กรุณาตรวจสอบ Email ของคุณแล้วลองอีกครั้ง', 'creator-academy'); ?>
                    </div>
                <?php endif; ?>

                <?php if (have_posts() && get_the_content()): ?>
                    <div class="entry-content"><?php the_content(); ?></div>
                <?php else: ?>
                    <form class="ca-contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" novalidate>
                        <input type="hidden" name="action" value="ca_contact">
                        <?php wp_nonce_field('ca_contact', 'ca_contact_nonce'); ?>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact_name"><?php _e('ชื่อ-นามสกุล *', 'creator-academy'); ?></label>
                                <input type="text" id="contact_name" name="contact_name" required placeholder="คุณ..." />
                            </div>
                            <div class="form-group">
                                <label for="contact_email"><?php _e('Email *', 'creator-academy'); ?></label>
                                <input type="email" id="contact_email" name="contact_email" required placeholder="you@email.com" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_subject"><?php _e('หัวข้อ', 'creator-academy'); ?></label>
                            <input type="text" id="contact_subject" name="contact_subject" placeholder="<?php _e('สอบถามเกี่ยวกับ...', 'creator-academy'); ?>" />
                        </div>

                        <div class="form-group">
                            <label for="contact_message"><?php _e('ข้อความ *', 'creator-academy'); ?></label>
                            <textarea id="contact_message" name="contact_message" rows="6" required placeholder="<?php _e('พิมพ์ข้อความของคุณที่นี่...', 'creator-academy'); ?>"></textarea>
                        </div>

                        <button type="submit" class="btn btn-accent btn-lg"><?php _e('ส่งข้อความ', 'creator-academy'); ?></button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Info -->
            <div class="contact-info">
                <div class="contact-info-card">
                    <h3><?php _e('ติดต่อเรา', 'creator-academy'); ?></h3>
                    <div class="contact-info-item">
                        <span class="contact-info-icon">📧</span>
                        <div>
                            <strong><?php _e('Email', 'creator-academy'); ?></strong>
                            <a href="mailto:<?php echo antispambot(get_option('admin_email')); ?>"><?php echo antispambot(get_option('admin_email')); ?></a>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <span class="contact-info-icon">⏰</span>
                        <div>
                            <strong><?php _e('Response Time', 'creator-academy'); ?></strong>
                            <span><?php _e('1–2 วันทำการ', 'creator-academy'); ?></span>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <span class="contact-info-icon">💬</span>
                        <div>
                            <strong><?php _e('Social Media', 'creator-academy'); ?></strong>
                            <span><?php _e('Facebook / Instagram / TikTok', 'creator-academy'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="contact-info-card contact-info-card--cta">
                    <h3><?php _e('ต้องการรับของฟรี?', 'creator-academy'); ?></h3>
                    <p><?php _e('สมัครรับ Newsletter เพื่อรับ Template ฟรี Prompt พร้อมใช้ และเคล็ดลับสร้างรายได้ทุกสัปดาห์', 'creator-academy'); ?></p>
                    <a href="<?php echo home_url('/freebies'); ?>" class="btn btn-teal btn-sm btn-block"><?php _e('รับของฟรีเลย →', 'creator-academy'); ?></a>
                </div>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); ?>

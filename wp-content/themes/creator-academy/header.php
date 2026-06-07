<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php _e('Skip to content', 'creator-academy'); ?></a>

<header class="site-header" id="site-header">
    <div class="container header-inner">

        <!-- Logo -->
        <div class="site-branding">
            <?php if (has_custom_logo()): ?>
                <?php the_custom_logo(); ?>
            <?php else: ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo-text" rel="home">
                    <span class="logo-icon">📚</span>
                    <span class="logo-text">
                        <strong>Creator</strong>
                        <span class="accent">Academy</span>
                        <small>Digital Product Hub</small>
                    </span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Navigation -->
        <nav class="main-nav" id="main-nav" aria-label="<?php _e('Primary navigation', 'creator-academy'); ?>">
            <?php wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'nav-menu',
                'fallback_cb'    => function() { ?>
                    <ul class="nav-menu">
                        <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                        <li><a href="<?php echo home_url('/freebies'); ?>">Freebies</a></li>
                        <li><a href="<?php echo home_url('/shop'); ?>">Shop</a></li>
                        <li><a href="<?php echo home_url('/blog'); ?>">Blog</a></li>
                        <li><a href="<?php echo home_url('/about'); ?>">About</a></li>
                        <li><a href="<?php echo home_url('/contact'); ?>">Contact</a></li>
                    </ul>
                <?php },
            ]); ?>
        </nav>

        <!-- Header Actions -->
        <div class="header-actions">
            <button class="icon-btn" aria-label="<?php _e('Search', 'creator-academy'); ?>" id="search-toggle">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            </button>
            <a href="<?php echo home_url('/shop'); ?>" class="icon-btn" aria-label="<?php _e('Shop', 'creator-academy'); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </a>
            <a href="<?php echo home_url('/freebies'); ?>" class="btn btn-primary btn-sm">
                <?php _e('ของฟรี', 'creator-academy'); ?>
            </a>
            <button class="hamburger" id="nav-toggle" aria-label="<?php _e('Toggle menu', 'creator-academy'); ?>" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    <!-- Search Bar (hidden by default) -->
    <div class="search-bar" id="search-bar" hidden>
        <div class="container">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" name="s" placeholder="<?php _e('ค้นหา Prompt, Template, คอร์ส...', 'creator-academy'); ?>" value="<?php echo get_search_query(); ?>" autofocus />
                <button type="submit"><?php _e('Search', 'creator-academy'); ?></button>
            </form>
            <button class="search-close" id="search-close" aria-label="Close">✕</button>
        </div>
    </div>
</header>

<main id="main">

#!/bin/sh
# Auto-setup WordPress via WP-CLI
set -e

echo "⏳ Waiting for WordPress to be ready..."
until wp core is-installed --path=/var/www/html --allow-root 2>/dev/null; do
  sleep 3
done

echo "✅ WordPress is installed. Running setup..."

# Activate theme
wp theme activate creator-academy --path=/var/www/html --allow-root

# Create pages
wp post create --post_type=page --post_title="Home"    --post_status=publish --post_name=home    --path=/var/www/html --allow-root
wp post create --post_type=page --post_title="About"   --post_status=publish --post_name=about   --page-template=page-about.php --path=/var/www/html --allow-root
wp post create --post_type=page --post_title="Contact" --post_status=publish --post_name=contact --page-template=page-contact.php --path=/var/www/html --allow-root
wp post create --post_type=page --post_title="Blog"    --post_status=publish --post_name=blog    --path=/var/www/html --allow-root

# Set homepage
HOME_ID=$(wp post list --post_type=page --name=home --field=ID --path=/var/www/html --allow-root)
BLOG_ID=$(wp post list --post_type=page --name=blog --field=ID --path=/var/www/html --allow-root)
wp option update show_on_front page --path=/var/www/html --allow-root
wp option update page_on_front  $HOME_ID --path=/var/www/html --allow-root
wp option update page_for_posts $BLOG_ID --path=/var/www/html --allow-root

# Create nav menu
wp menu create "Primary" --path=/var/www/html --allow-root
wp menu location assign primary primary --path=/var/www/html --allow-root

for slug in home freebies shop blog about contact; do
  ID=$(wp post list --post_type=page --name=$slug --field=ID --path=/var/www/html --allow-root 2>/dev/null || echo "")
  if [ -n "$ID" ]; then
    wp menu item add-post primary $ID --path=/var/www/html --allow-root
  else
    wp menu item add-custom primary "${slug^}" "http://localhost:8080/$slug" --path=/var/www/html --allow-root
  fi
done

# Flush permalinks
wp rewrite structure '/%postname%/' --path=/var/www/html --allow-root
wp rewrite flush --path=/var/www/html --allow-root

# Demo freebie
wp post create \
  --post_type=freebie \
  --post_title="Prompt Pack สำหรับ Etsy — ฟรี!" \
  --post_status=publish \
  --post_excerpt="รวม 50 Prompt AI สำหรับสร้างสินค้า Etsy พร้อมใช้งานทันที ไม่ต้องมีประสบการณ์มาก่อน" \
  --path=/var/www/html --allow-root

FREEBIE_ID=$(wp post list --post_type=freebie --field=ID --number=1 --path=/var/www/html --allow-root)
wp post meta set $FREEBIE_ID _ca_file_type "PDF" --path=/var/www/html --allow-root
wp post meta set $FREEBIE_ID _ca_badge "FREE" --path=/var/www/html --allow-root
wp post meta set $FREEBIE_ID _ca_featured "1" --path=/var/www/html --allow-root
wp post meta set $FREEBIE_ID _ca_homepage_order "1" --path=/var/www/html --allow-root

# Demo product
wp post create \
  --post_type=digital_product \
  --post_title="Etsy Mastery — คอร์สขาย Etsy แบบมืออาชีพ" \
  --post_status=publish \
  --post_excerpt="เรียนรู้การสร้างและขาย Digital Product บน Etsy ตั้งแต่เริ่มต้นจนมีรายได้จริง" \
  --path=/var/www/html --allow-root

PRODUCT_ID=$(wp post list --post_type=digital_product --field=ID --number=1 --path=/var/www/html --allow-root)
wp post meta set $PRODUCT_ID _ca_price "2990" --path=/var/www/html --allow-root
wp post meta set $PRODUCT_ID _ca_original_price "4990" --path=/var/www/html --allow-root
wp post meta set $PRODUCT_ID _ca_rating "4.9" --path=/var/www/html --allow-root
wp post meta set $PRODUCT_ID _ca_review_count "1256" --path=/var/www/html --allow-root
wp post meta set $PRODUCT_ID _ca_badge "BEST SELLER" --path=/var/www/html --allow-root
wp post meta set $PRODUCT_ID _ca_file_type "Course" --path=/var/www/html --allow-root
wp post meta set $PRODUCT_ID _ca_featured "1" --path=/var/www/html --allow-root
wp post meta set $PRODUCT_ID _ca_homepage_order "1" --path=/var/www/html --allow-root

# Demo blog post
wp post create \
  --post_type=post \
  --post_title="วิธีสร้าง Coloring Book ด้วย AI ใน 1 ชั่วโมง" \
  --post_status=publish \
  --post_excerpt="เทคนิคการใช้ Midjourney และ ChatGPT สร้าง Coloring Book ขายบน Etsy พร้อม Prompt ตัวอย่าง" \
  --path=/var/www/html --allow-root

echo ""
echo "🎉 Setup complete!"
echo "   Open: http://localhost:8080"
echo "   Admin: http://localhost:8080/wp-admin"

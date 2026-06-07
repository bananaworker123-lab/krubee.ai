// Direct SQLite setup — faster and more reliable than REST API
import { DatabaseSync } from 'node:sqlite';
import { createHash } from 'node:crypto';
import { homedir } from 'node:os';
import { join } from 'node:path';

const PROJECT_PATH = 'D:\\Krubi\\WebV1\\wp-content\\themes\\creator-academy';
const hash = createHash('sha1').update(PROJECT_PATH).digest('hex');
const dbPath = join(homedir(), `.wp-now/wp-content/creator-academy-${hash}/database/.ht.sqlite`);

console.log(`\n🗄️  Opening: ${dbPath}\n`);

const db = new DatabaseSync(dbPath);

// Helper: upsert wp_options
function setOption(name, value) {
  const existing = db.prepare("SELECT option_id FROM wp_options WHERE option_name = ?").get(name);
  if (existing) {
    db.prepare("UPDATE wp_options SET option_value = ? WHERE option_name = ?").run(value, name);
  } else {
    db.prepare("INSERT INTO wp_options (option_name, option_value, autoload) VALUES (?, ?, 'yes')").run(name, value);
  }
}

function getOption(name) {
  const row = db.prepare("SELECT option_value FROM wp_options WHERE option_name = ?").get(name);
  return row?.option_value ?? null;
}

function insertPost(data) {
  const stmt = db.prepare(`
    INSERT INTO wp_posts (
      post_author, post_date, post_date_gmt, post_content, post_title,
      post_excerpt, post_status, comment_status, ping_status, post_name,
      post_modified, post_modified_gmt, post_parent, menu_order,
      post_type, comment_count
    ) VALUES (1, datetime('now'), datetime('now'), ?, ?, ?, 'publish', 'open', 'closed', ?,
              datetime('now'), datetime('now'), 0, 0, ?, 0)
  `);
  const result = stmt.run(data.content || '', data.title, data.excerpt || '', data.slug, data.post_type || 'post');
  return result.lastInsertRowid;
}

function setMeta(postId, key, value) {
  const existing = db.prepare("SELECT meta_id FROM wp_postmeta WHERE post_id = ? AND meta_key = ?").get(postId, key);
  if (existing) {
    db.prepare("UPDATE wp_postmeta SET meta_value = ? WHERE post_id = ? AND meta_key = ?").run(String(value), postId, key);
  } else {
    db.prepare("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (?, ?, ?)").run(postId, key, String(value));
  }
}

function postExists(slug, type) {
  return db.prepare("SELECT ID FROM wp_posts WHERE post_name = ? AND post_type = ? AND post_status = 'publish'").get(slug, type);
}

// ── 1. Activate Theme ──────────────────────────────────────
console.log('🎨 Activating creator-academy theme...');
setOption('template',   'creator-academy');
setOption('stylesheet', 'creator-academy');
setOption('current_theme', 'Creator Academy');
console.log('   ✅ Theme activated');

// ── 2. Site Settings ───────────────────────────────────────
console.log('\n⚙️  Updating site settings...');
setOption('blogname',        'Creator Academy');
setOption('blogdescription', 'Digital Product Hub — สร้างรายได้ด้วย AI');
setOption('permalink_structure', '/%postname%/');
setOption('rewrite_rules', '');
console.log('   ✅ Site name, description, permalinks set');

// ── 3. Create Pages ────────────────────────────────────────
console.log('\n📄 Creating pages...');

const pageData = [
  { title: 'Home',    slug: 'home',    content: '', template: '' },
  { title: 'Blog',    slug: 'blog',    content: '', template: '' },
  { title: 'About',   slug: 'about',   content: '<p>ยินดีต้อนรับสู่ Creator Academy</p>', template: 'page-about.php' },
  { title: 'Contact', slug: 'contact', content: '', template: 'page-contact.php' },
];

const pageIds = {};
for (const p of pageData) {
  const existing = postExists(p.slug, 'page');
  if (existing) {
    pageIds[p.slug] = existing.ID;
    console.log(`   ↩️  ${p.title} exists (ID ${existing.ID})`);
  } else {
    const id = insertPost({ ...p, post_type: 'page' });
    pageIds[p.slug] = id;
    if (p.template) setMeta(id, '_wp_page_template', p.template);
    console.log(`   ✅ ${p.title} created (ID ${id})`);
  }
}

// ── 4. Set Homepage ────────────────────────────────────────
if (pageIds.home && pageIds.blog) {
  setOption('show_on_front',  'page');
  setOption('page_on_front',  String(pageIds.home));
  setOption('page_for_posts', String(pageIds.blog));
  console.log(`\n🏠 Homepage set (ID ${pageIds.home}), Blog page (ID ${pageIds.blog})`);
}

// ── 5. Demo Freebie ────────────────────────────────────────
console.log('\n🎁 Creating demo Freebie...');
if (!postExists('etsy-prompt-pack', 'freebie')) {
  const id = insertPost({
    title:     'Prompt Pack สำหรับ Etsy — ฟรี!',
    slug:      'etsy-prompt-pack',
    post_type: 'freebie',
    excerpt:   'รวม 50 Prompt AI สำหรับสร้างสินค้า Etsy พร้อมใช้งานทันที',
    content:   '<h2>สิ่งที่คุณจะได้รับ</h2><ul><li>50 Prompt สำหรับสร้างภาพ Coloring Book</li><li>20 Prompt สำหรับ Product Description</li><li>10 Prompt สำหรับ SEO Tags</li></ul><p>ดาวน์โหลดได้ทันที ไม่ต้องสมัครสมาชิก</p>',
  });
  setMeta(id, '_ca_file_type',      'PDF');
  setMeta(id, '_ca_badge',          'FREE');
  setMeta(id, '_ca_featured',       '1');
  setMeta(id, '_ca_homepage_order', '1');
  console.log(`   ✅ Freebie: Prompt Pack (ID ${id})`);
} else { console.log('   ↩️  Freebie exists'); }

if (!postExists('canva-template-pack', 'freebie')) {
  const id = insertPost({
    title: 'Canva Template Pack — ฟรี!', slug: 'canva-template-pack', post_type: 'freebie',
    excerpt: 'Template Canva สำเร็จรูป 20 แบบ สำหรับทำ Social Media ขาย Digital Product',
    content: '<p>Template พร้อมใช้ แก้ไขได้ง่าย เหมาะสำหรับมือใหม่</p>',
  });
  setMeta(id, '_ca_file_type', 'Canva Template');
  setMeta(id, '_ca_badge', 'NEW');
  setMeta(id, '_ca_featured', '1');
  setMeta(id, '_ca_homepage_order', '2');
  console.log(`   ✅ Freebie: Canva Template (ID ${id})`);
}

// ── 6. Demo Products ───────────────────────────────────────
console.log('\n🛍️  Creating demo Products...');
const products = [
  { slug: 'etsy-mastery',         title: 'Etsy Mastery — คอร์สขาย Etsy แบบมืออาชีพ',          excerpt: 'เรียนรู้การสร้างและขาย Digital Product บน Etsy', content: '<h2>คุณจะได้เรียนรู้</h2><ul><li>วิธีเปิดร้าน Etsy</li><li>การใช้ AI สร้างสินค้า</li><li>การทำ SEO บน Etsy</li></ul>', meta: { _ca_price: '2990', _ca_original_price: '4990', _ca_rating: '4.9', _ca_review_count: '1256', _ca_badge: 'BEST SELLER', _ca_file_type: 'Course', _ca_featured: '1', _ca_homepage_order: '1' } },
  { slug: 'ai-creator-starter',   title: 'AI Creator Starter — ใช้ AI สร้างงาน ขายได้ไม่รู้จบ', excerpt: 'ใช้ ChatGPT, Midjourney สร้าง Digital Product ขายออนไลน์',  content: '<p>เรียนรู้เครื่องมือ AI ทั้งหมดที่ต้องใช้</p>', meta: { _ca_price: '2490', _ca_original_price: '0', _ca_rating: '4.8', _ca_review_count: '982',  _ca_badge: 'NEW',        _ca_file_type: 'Course', _ca_featured: '1', _ca_homepage_order: '2' } },
  { slug: 'canva-passive-income',  title: 'Canva Design for Passive Income',                      excerpt: 'ออกแบบง่าย ขายได้ทุกวัน ด้วย Canva Template บน Etsy',     content: '<p>ทำ Canva Template ขายได้จริง</p>',              meta: { _ca_price: '1990', _ca_original_price: '0', _ca_rating: '4.8', _ca_review_count: '754',  _ca_badge: '',           _ca_file_type: 'Course', _ca_featured: '1', _ca_homepage_order: '3' } },
  { slug: 'digital-product-bundle',title: 'Profitable Digital Product Bundle',                    excerpt: 'Bundle ราคาสุดคุ้ม รวมคอร์สและ Template ครบชุด',         content: '<p>ทุกอย่างที่ต้องการในที่เดียว</p>',              meta: { _ca_price: '2490', _ca_original_price: '7470', _ca_rating: '4.8', _ca_review_count: '883', _ca_badge: 'BEST VALUE', _ca_file_type: 'Bundle', _ca_featured: '1', _ca_homepage_order: '4' } },
];

for (const p of products) {
  if (!postExists(p.slug, 'digital_product')) {
    const id = insertPost({ ...p, post_type: 'digital_product' });
    for (const [k, v] of Object.entries(p.meta)) setMeta(id, k, v);
    console.log(`   ✅ ${p.title.slice(0, 45)}`);
  } else { console.log(`   ↩️  ${p.slug} exists`); }
}

// ── 7. Demo Blog Posts ─────────────────────────────────────
console.log('\n📝 Creating demo Blog Posts...');
// Remove hello world
const hw = db.prepare("SELECT ID FROM wp_posts WHERE post_name = 'hello-world' AND post_type = 'post'").get();
if (hw) {
  db.prepare("UPDATE wp_posts SET post_status = 'trash' WHERE ID = ?").run(hw.ID);
  console.log('   🗑️  Removed "Hello world!"');
}

const blogPosts = [
  { slug: 'create-coloring-book-ai', title: 'วิธีสร้าง Coloring Book ด้วย AI ใน 1 ชั่วโมง', excerpt: 'เทคนิคการใช้ Midjourney และ ChatGPT สร้าง Coloring Book ขายบน Etsy พร้อม Prompt ตัวอย่าง', content: '<p>Coloring Book เป็นหนึ่งในสินค้า Digital ที่ขายดีที่สุดบน Etsy ในปี 2024 เราจะมาดูวิธีสร้างด้วย AI กัน</p>' },
  { slug: 'top-10-digital-products-etsy', title: '10 ไอเดีย Digital Product ที่ขายดีบน Etsy', excerpt: 'รวม 10 ประเภทสินค้า Digital ที่มียอดขายสูงสุด พร้อมเคล็ดลับสร้างและขาย', content: '<p>Digital Product เหล่านี้ขายได้ดีตลอดทั้งปี ไม่มีต้นทุนวัตถุดิบ กำไรสูง</p>' },
  { slug: 'start-digital-product-zero-budget', title: 'เริ่มต้นขาย Digital Product ด้วยเงิน 0 บาท', excerpt: 'วิธีสร้างและขาย Digital Product โดยไม่ต้องลงทุนเลย ใช้ Free Tools ทั้งหมด', content: '<p>ไม่ต้องมีเงินทุนก็เริ่มได้ ใช้เครื่องมือฟรีทั้งหมด Canva, ChatGPT Free, Google Drive</p>' },
];

for (const p of blogPosts) {
  if (!postExists(p.slug, 'post')) {
    const id = insertPost(p);
    console.log(`   ✅ Post: ${p.title.slice(0, 40)}`);
  } else { console.log(`   ↩️  ${p.slug} exists`); }
}

// ── 8. Navigation Menu ─────────────────────────────────────
console.log('\n🔗 Setting up navigation menu...');
const menuExists = db.prepare("SELECT term_id FROM wp_terms WHERE slug = 'primary-menu'").get();
if (!menuExists) {
  db.prepare("INSERT INTO wp_terms (name, slug, term_group) VALUES ('Primary', 'primary-menu', 0)").run();
  const menuTermId = db.prepare("SELECT last_insert_rowid() as id").get().id;
  db.prepare("INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count) VALUES (?, 'nav_menu', '', 0, 0)").run(menuTermId);
  const menuTtId = db.prepare("SELECT last_insert_rowid() as id").get().id;
  setOption('nav_menu_locations', `a:1:{s:7:"primary";i:${menuTtId};}`);

  const menuItems = [
    { title: 'Home',     url: '/' },
    { title: 'Freebies', url: '/freebies/' },
    { title: 'Shop',     url: '/shop/' },
    { title: 'Blog',     url: '/blog/' },
    { title: 'About',    url: '/about/' },
    { title: 'Contact',  url: '/contact/' },
  ];

  for (let i = 0; i < menuItems.length; i++) {
    const m = menuItems[i];
    const postId = insertPost({ title: m.title, slug: `menu-${m.title.toLowerCase()}`, post_type: 'nav_menu_item', content: '', excerpt: '' });
    setMeta(postId, '_menu_item_type', 'custom');
    setMeta(postId, '_menu_item_menu_item_parent', '0');
    setMeta(postId, '_menu_item_object_id', String(postId));
    setMeta(postId, '_menu_item_object', 'custom');
    setMeta(postId, '_menu_item_target', '');
    setMeta(postId, '_menu_item_classes', 'a:1:{i:0;s:0:"";}');
    setMeta(postId, '_menu_item_xfn', '');
    setMeta(postId, '_menu_item_url', m.url);
    db.prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (?, ?, ?)").run(postId, menuTtId, i);
    db.prepare("UPDATE wp_term_taxonomy SET count = count + 1 WHERE term_taxonomy_id = ?").run(menuTtId);
  }
  console.log('   ✅ Nav menu created with 6 items');
} else {
  console.log('   ↩️  Menu already exists');
}

db.close();

console.log('\n' + '═'.repeat(52));
console.log('🎉  Setup complete!');
console.log('');
console.log('   🌐  Site:    http://localhost:8080');
console.log('   🔧  Admin:   http://localhost:8080/wp-admin');
console.log('   👤  Login:   admin  /  password');
console.log('═'.repeat(52) + '\n');

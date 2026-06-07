// WordPress REST API setup script — runs once to configure the site
import { Buffer } from 'node:buffer';

const BASE   = 'http://localhost:8080';
const AUTH   = 'Basic ' + Buffer.from('admin:password').toString('base64');
const HEADS  = { 'Content-Type': 'application/json', Authorization: AUTH };

async function api(method, path, body) {
  const res = await fetch(`${BASE}/wp-json/wp/v2${path}`, {
    method, headers: HEADS,
    body: body ? JSON.stringify(body) : undefined,
  });
  const text = await res.text();
  try { return JSON.parse(text); } catch { return text; }
}

async function run() {
  console.log('🚀 Creator Academy — WordPress Setup\n');

  // ── 1. Activate theme ─────────────────────────────────────
  console.log('🎨 Activating creator-academy theme...');
  const themeRes = await fetch(`${BASE}/wp-json/wp/v2/themes/creator-academy`, {
    method: 'POST',
    headers: HEADS,
    body: JSON.stringify({ status: 'active' }),
  });
  const theme = await themeRes.json();
  if (theme.status === 'active' || theme.stylesheet === 'creator-academy') {
    console.log('   ✅ Theme activated');
  } else {
    console.log('   ⚠️  Theme response:', JSON.stringify(theme).slice(0, 120));
  }

  // ── 2. Create pages ───────────────────────────────────────
  console.log('\n📄 Creating pages...');
  const pages = [
    { title: 'Home',    slug: 'home',    template: '' },
    { title: 'Blog',    slug: 'blog',    template: '' },
    { title: 'About',   slug: 'about',   template: 'page-about.php',   content: '<p>ยินดีต้อนรับสู่ Creator Academy — แหล่งรวมความรู้สำหรับสร้างรายได้จาก Digital Product</p>' },
    { title: 'Contact', slug: 'contact', template: 'page-contact.php', content: '' },
  ];

  const pageIds = {};
  for (const p of pages) {
    const existing = await api('GET', `/pages?slug=${p.slug}&per_page=1`);
    if (Array.isArray(existing) && existing.length) {
      pageIds[p.slug] = existing[0].id;
      console.log(`   ↩️  ${p.title} already exists (ID ${pageIds[p.slug]})`);
      continue;
    }
    const created = await api('POST', '/pages', {
      title: p.title, slug: p.slug, status: 'publish',
      content: p.content || '',
      template: p.template || '',
    });
    if (created.id) {
      pageIds[p.slug] = created.id;
      console.log(`   ✅ Created ${p.title} (ID ${created.id})`);
    } else {
      console.log(`   ❌ Failed ${p.title}:`, JSON.stringify(created).slice(0, 100));
    }
  }

  // ── 3. Set Reading settings ───────────────────────────────
  console.log('\n⚙️  Setting homepage & blog page...');
  if (pageIds.home && pageIds.blog) {
    const settingsRes = await api('POST', '/settings', {
      show_on_front:  'page',
      page_on_front:  pageIds.home,
      page_for_posts: pageIds.blog,
    });
    console.log('   ✅ Homepage =>', pageIds.home, '| Blog =>', pageIds.blog);
  }

  // ── 4. Permalinks (set via options via hack) ───────────────
  // Flush is needed — wp-now mu-plugin handles pretty permalinks automatically

  // ── 5. Site title & tagline ──────────────────────────────
  await api('POST', '/settings', {
    title:       'Creator Academy',
    description: 'Digital Product Hub — สร้างรายได้ด้วย AI',
  });
  console.log('   ✅ Site title updated');

  // ── 6. Demo Freebie ───────────────────────────────────────
  console.log('\n🎁 Creating demo Freebie...');
  const freebieCheck = await api('GET', '/freebie?per_page=1');
  if (!Array.isArray(freebieCheck) || !freebieCheck.length) {
    const freebie = await api('POST', '/freebie', {
      title:   'Prompt Pack สำหรับ Etsy — ฟรี!',
      status:  'publish',
      excerpt: 'รวม 50 Prompt AI สำหรับสร้างสินค้า Etsy พร้อมใช้งานทันที ไม่ต้องมีประสบการณ์มาก่อน',
      content: '<h2>สิ่งที่คุณจะได้รับ</h2><ul><li>50 Prompt สำหรับสร้างภาพ Coloring Book</li><li>20 Prompt สำหรับ Product Description</li><li>10 Prompt สำหรับ SEO Tags</li></ul>',
      meta: {
        _ca_file_type:       'PDF',
        _ca_badge:           'FREE',
        _ca_featured:        '1',
        _ca_homepage_order:  '1',
      },
    });
    if (freebie.id) console.log(`   ✅ Freebie created (ID ${freebie.id})`);
    else console.log('   ⚠️  Freebie:', JSON.stringify(freebie).slice(0, 120));
  } else {
    console.log('   ↩️  Freebie already exists');
  }

  // ── 7. Demo Products ──────────────────────────────────────
  console.log('\n🛍️  Creating demo Products...');
  const prodCheck = await api('GET', '/digital_product?per_page=1');
  if (!Array.isArray(prodCheck) || !prodCheck.length) {
    const products = [
      {
        title:   'Etsy Mastery — คอร์สขาย Etsy แบบมืออาชีพ',
        excerpt: 'เรียนรู้การสร้างและขาย Digital Product บน Etsy ตั้งแต่เริ่มต้นจนมีรายได้จริง',
        content: '<h2>คุณจะได้เรียนรู้อะไร</h2><ul><li>วิธีเปิดร้าน Etsy</li><li>การใช้ AI สร้างสินค้า</li><li>การทำ SEO บน Etsy</li><li>การตั้งราคาและทำกำไร</li></ul>',
        meta: { _ca_price: '2990', _ca_original_price: '4990', _ca_rating: '4.9', _ca_review_count: '1256', _ca_badge: 'BEST SELLER', _ca_file_type: 'Course', _ca_featured: '1', _ca_homepage_order: '1' },
      },
      {
        title:   'AI Creator Starter — ใช้ AI สร้างงาน ขายได้ไม่รู้จบ',
        excerpt: 'เรียนรู้การใช้ AI tools สร้าง Digital Product ขายออนไลน์แบบ Passive Income',
        content: '<p>คอร์สที่จะสอนให้คุณใช้ ChatGPT, Midjourney และ Canva สร้างสินค้า Digital ที่ขายได้จริง</p>',
        meta: { _ca_price: '2490', _ca_original_price: '0', _ca_rating: '4.8', _ca_review_count: '982', _ca_badge: 'NEW', _ca_file_type: 'Course', _ca_featured: '1', _ca_homepage_order: '2' },
      },
      {
        title:   'Canva Design for Passive Income',
        excerpt: 'ออกแบบง่าย ขายได้ทุกวัน ด้วย Canva Template ที่ขายบน Etsy',
        content: '<p>คอร์สสอนทำ Canva Template ขาย บน Etsy, Creative Market และ Gumroad</p>',
        meta: { _ca_price: '1990', _ca_original_price: '0', _ca_rating: '4.8', _ca_review_count: '754', _ca_badge: '', _ca_file_type: 'Course', _ca_featured: '1', _ca_homepage_order: '3' },
      },
      {
        title:   'Profitable Digital Product Bundle',
        excerpt: 'สร้างสินค้า Digital ทำรายได้แสน Bundle ราคาสุดคุ้ม',
        content: '<p>รวมคอร์สและ Template ครบชุด เหมาะสำหรับผู้ที่ต้องการเริ่มต้นสร้างรายได้จาก Digital Product</p>',
        meta: { _ca_price: '2490', _ca_original_price: '7470', _ca_rating: '4.8', _ca_review_count: '883', _ca_badge: 'BEST VALUE', _ca_file_type: 'Bundle', _ca_featured: '1', _ca_homepage_order: '4' },
      },
    ];
    for (const p of products) {
      const created = await api('POST', '/digital_product', { ...p, status: 'publish' });
      if (created.id) console.log(`   ✅ Product: ${p.title.slice(0, 40)} (ID ${created.id})`);
      else console.log(`   ⚠️ `, JSON.stringify(created).slice(0, 80));
    }
  } else {
    console.log('   ↩️  Products already exist');
  }

  // ── 8. Demo Blog Posts ────────────────────────────────────
  console.log('\n📝 Creating demo Blog Posts...');
  const postCheck = await api('GET', '/posts?per_page=1&status=publish');
  const hasRealPost = Array.isArray(postCheck) && postCheck.length &&
                      postCheck[0].title.rendered !== 'Hello world!';
  if (!hasRealPost) {
    const posts = [
      { title: 'วิธีสร้าง Coloring Book ด้วย AI ใน 1 ชั่วโมง', excerpt: 'เทคนิคการใช้ Midjourney และ ChatGPT สร้าง Coloring Book ขายบน Etsy พร้อม Prompt ตัวอย่าง' },
      { title: '10 ไอเดีย Digital Product ที่ขายดีบน Etsy 2024', excerpt: 'รวม 10 ประเภทสินค้า Digital ที่มียอดขายสูงสุด พร้อมเคล็ดลับการสร้างและขาย' },
      { title: 'เริ่มต้นขาย Digital Product ด้วยเงิน 0 บาท', excerpt: 'วิธีสร้างและขาย Digital Product โดยไม่ต้องลงทุนเลย ใช้ Free Tools ทั้งหมด' },
    ];
    for (const p of posts) {
      const created = await api('POST', '/posts', { ...p, status: 'publish', content: `<p>${p.excerpt}</p>` });
      if (created.id) console.log(`   ✅ Post: ${p.title.slice(0, 40)}`);
    }
    // Delete hello world
    const helloWorld = await api('GET', '/posts?slug=hello-world');
    if (Array.isArray(helloWorld) && helloWorld.length) {
      await api('DELETE', `/posts/${helloWorld[0].id}?force=true`);
      console.log('   🗑️  Removed "Hello world!" post');
    }
  } else {
    console.log('   ↩️  Blog posts already exist');
  }

  // ── 9. Nav Menu ───────────────────────────────────────────
  console.log('\n🔗 Setting up navigation menu...');
  const menusRes = await fetch(`${BASE}/wp-json/wp/v2/menus`, { headers: HEADS });
  if (menusRes.ok) {
    const menus = await menusRes.json();
    if (!menus.length) {
      await fetch(`${BASE}/wp-json/wp/v2/menus`, {
        method: 'POST', headers: HEADS,
        body: JSON.stringify({ name: 'Primary', locations: ['primary'] }),
      });
    }
    console.log('   ✅ Menu ready');
  } else {
    console.log('   ℹ️  Menu API not available — set up manually in Appearance → Menus');
  }

  console.log('\n' + '═'.repeat(50));
  console.log('✅  Setup complete!');
  console.log('');
  console.log('   🌐  Site:   http://localhost:8080');
  console.log('   🔧  Admin:  http://localhost:8080/wp-admin');
  console.log('   👤  Login:  admin / password');
  console.log('═'.repeat(50));
}

run().catch(e => { console.error('❌ Error:', e.message); process.exit(1); });

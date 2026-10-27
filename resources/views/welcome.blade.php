@verbatim
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Praktikum Komputasi Awan - Deploy ke Azure</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;700;800&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root {
    --paper: #EEF2F7;
    --ink: #0F1E3D;
    --muted: #4A5878;
    --line: #C9D3E3;
    --cobalt: #2B4BFF;
    --live: #0E9F6E;
    --white: #FFFFFF;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  html { scroll-behavior: smooth; }
  body {
    background: var(--paper);
    color: var(--ink);
    font-family: "Instrument Sans", system-ui, -apple-system, "Segoe UI", sans-serif;
    font-size: 17px;
    line-height: 1.6;
  }
  h1, h2, h3 {
    font-family: "Bricolage Grotesque", "Segoe UI", system-ui, sans-serif;
    line-height: 1.1;
    letter-spacing: -0.02em;
  }
  a { color: var(--cobalt); text-underline-offset: 3px; }
  a:focus-visible { outline: 3px solid var(--cobalt); outline-offset: 3px; border-radius: 2px; }
  .wrap { max-width: 1040px; margin: 0 auto; padding: 0 24px; }

  header { padding: 22px 0; border-bottom: 1px solid var(--line); }
  header .wrap { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; }
  .brand { font-weight: 600; }
  .status { display: inline-flex; align-items: center; gap: 8px; font-size: 15px; color: var(--muted); }
  .dot { width: 10px; height: 10px; border-radius: 50%; background: var(--live); animation: pulse 2.4s ease-out infinite; }
  @keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(14,159,110,.5); }
    70% { box-shadow: 0 0 0 10px rgba(14,159,110,0); }
    100% { box-shadow: 0 0 0 0 rgba(14,159,110,0); }
  }

  .hero { padding: 88px 0 64px; }
  .hero h1 { font-size: clamp(2.4rem, 7vw, 4.6rem); font-weight: 800; max-width: 15ch; }
  .hero p { margin-top: 24px; max-width: 56ch; color: var(--muted); font-size: 1.1rem; }
  .cta { display: inline-block; margin-top: 32px; padding: 14px 22px; background: var(--ink); color: var(--white);
         text-decoration: none; font-weight: 600; border-radius: 6px; }
  .cta:hover { background: var(--cobalt); }
  .cta:focus-visible { outline: 3px solid var(--cobalt); outline-offset: 3px; }

  .pipeline { padding: 0 0 80px; }
  .pipeline h2 { font-size: 1.5rem; margin-bottom: 20px; }
  .flow { list-style: none; display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 0; border: 1px solid var(--ink); background: var(--white); }
  .flow li { padding: 22px 20px; border-right: 1px solid var(--line); position: relative; }
  .flow li:last-child { border-right: 0; background: var(--ink); color: var(--white); }
  .flow li:last-child span { color: #AFC0E6; }
  .flow strong { display: block; font-family: "Bricolage Grotesque", sans-serif; font-size: 1.15rem; }
  .flow span { font-size: 0.95rem; color: var(--muted); }

  .work { padding: 72px 0; border-top: 1px solid var(--line); }
  .work h2 { font-size: clamp(1.8rem, 4vw, 2.6rem); max-width: 18ch; margin-bottom: 40px; }
  .work-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 40px; }
  .work h3 { font-size: 1.25rem; margin-bottom: 8px; }
  .work p { color: var(--muted); }
  dl { margin-top: 14px; font-size: 0.95rem; }
  dt { font-weight: 600; margin-top: 8px; }
  dd { color: var(--muted); }

  .about { padding: 72px 0; background: var(--white); border-top: 1px solid var(--line); }
  .about .wrap { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 40px; align-items: start; }
  .about h2 { font-size: 1.8rem; }
  .about p { color: var(--muted); max-width: 52ch; }

  footer { padding: 32px 0 48px; font-size: 0.95rem; color: var(--muted); border-top: 1px solid var(--line); }
  footer .wrap { display: flex; justify-content: space-between; gap: 12px; flex-wrap: wrap; }

  @media (max-width: 640px) {
    .hero { padding: 56px 0 40px; }
    .flow li { border-right: 0; border-bottom: 1px solid var(--line); }
    .flow li:last-child { border-bottom: 0; }
  }
  @media (prefers-reduced-motion: reduce) {
    .dot { animation: none; }
    html { scroll-behavior: auto; }
  }
</style>
</head>
<body>

<header>
  <div class="wrap">
    <span class="brand">Putra</span>
    <span class="status"><span class="dot" aria-hidden="true"></span>Online di Azure App Service</span>
  </div>
</header>

<main>
  <section class="hero">
    <div class="wrap">
      <h1>Dari git push sampai bisa dibuka siapa saja.</h1>
      <p>Halaman ini hasil praktikum Komputasi Awan. Kodenya dikirim lewat GitHub, dibangun otomatis oleh GitHub Actions, lalu dijalankan di Azure App Service tanpa saya mengurus server sendiri.</p>
      <a class="cta" href="#alur">Lihat alurnya</a>
    </div>
  </section>

  <section class="pipeline" id="alur">
    <div class="wrap">
      <h2>Perjalanan satu commit</h2>
      <ol class="flow">
        <li><strong>Kode</strong><span>Ditulis dan di-commit di laptop</span></li>
        <li><strong>GitHub</strong><span>Repository private menyimpan versinya</span></li>
        <li><strong>GitHub Actions</strong><span>Build dan deploy jalan otomatis</span></li>
        <li><strong>Azure App Service</strong><span>Runtime PHP 8.4 di Linux</span></li>
        <li><strong>Halaman ini</strong><span>Bisa dibuka lewat alamat azurewebsites.net</span></li>
      </ol>
    </div>
  </section>

  <section class="work">
    <div class="wrap">
      <h2>Yang saya siapkan di Azure</h2>
      <div class="work-grid">
        <article>
          <h3>App Service Plan</h3>
          <p>Menentukan lokasi, sistem operasi, dan paket harga server.</p>
          <dl>
            <dt>Sistem operasi</dt><dd>Linux</dd>
            <dt>Region</dt><dd>Indonesia Central</dd>
            <dt>Paket</dt><dd>Free F1, 60 menit CPU per hari</dd>
          </dl>
        </article>
        <article>
          <h3>Web App</h3>
          <p>Tempat aplikasi berjalan, lengkap dengan domain bawaan dari Azure.</p>
          <dl>
            <dt>Runtime</dt><dd>PHP 8.4</dd>
            <dt>Framework</dt><dd>Laravel</dd>
            <dt>Web root</dt><dd>Folder public</dd>
          </dl>
        </article>
        <article>
          <h3>Deployment Center</h3>
          <p>Menghubungkan Web App ke repository supaya setiap push langsung ter-deploy.</p>
          <dl>
            <dt>Sumber</dt><dd>GitHub</dd>
            <dt>Metode</dt><dd>GitHub Actions</dd>
            <dt>Riwayat</dt><dd>Tab Actions di repository</dd>
          </dl>
        </article>
      </div>
    </div>
  </section>

  <section class="about">
    <div class="wrap">
      <h2>Deployyy</h2>
      <p>Mata kuliah Komputasi Awan, Semester Ganjil 2026-2027.</p>
    </div>
  </section>
</main>

<footer>
  <div class="wrap">
    <span>Putra, NIM 102062400015</span>
    <a href="https://github.com/huaweicoid12-svg">github.com/huaweicoid12-svg</a>
  </div>
</footer>

</body>
</html>
@endverbatim
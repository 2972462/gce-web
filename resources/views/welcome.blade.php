<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GCE – Grupo Comercial Empresarial | Ciudad del Este, Paraguay</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<style>
  :root {
    --navy: #0a1628;
    --navy2: #112240;
    --blue: #1a3a6b;
    --blue-mid: #1e4d8c;
    --steel: #2e5fa3;
    --accent: #c9a84c;
    --accent2: #e8c56a;
    --light: #f4f6fa;
    --gray: #8896a8;
    --gray2: #cdd5e0;
    --white: #ffffff;
    --text: #1a2340;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  html { scroll-behavior: smooth; }

  body {
    font-family: 'Lato', sans-serif;
    color: var(--text);
    background: var(--white);
    overflow-x: hidden;
  }

  /* ── NAVBAR ── */
  nav {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 1000;
    background: rgba(10,22,40,0.97);
    backdrop-filter: blur(12px);
    padding: 0 5%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 70px;
    border-bottom: 1px solid rgba(201,168,76,0.25);
    transition: all 0.3s;
  }

  .nav-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
  }

  .nav-logo-badge {
    width: 42px; height: 42px;
    background: linear-gradient(135deg, var(--steel), var(--blue-mid));
    border: 2px solid var(--accent);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Montserrat', sans-serif;
    font-weight: 800;
    font-size: 16px;
    color: var(--accent);
    letter-spacing: 1px;
  }

  .nav-logo-text {
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: 13px;
    color: var(--white);
    line-height: 1.3;
    letter-spacing: 0.5px;
  }

  .nav-logo-text span {
    display: block;
    font-weight: 300;
    font-size: 10px;
    color: var(--accent);
    letter-spacing: 2px;
    text-transform: uppercase;
  }

  .nav-links {
    display: flex;
    gap: 32px;
    list-style: none;
  }

  .nav-links a {
    text-decoration: none;
    color: var(--gray2);
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    transition: color 0.2s;
    position: relative;
  }

  .nav-links a::after {
    content: '';
    position: absolute;
    bottom: -4px; left: 0;
    width: 0; height: 2px;
    background: var(--accent);
    transition: width 0.3s;
  }

  .nav-links a:hover { color: var(--accent); }
  .nav-links a:hover::after { width: 100%; }

  .nav-cta {
    background: var(--accent);
    color: var(--navy) !important;
    padding: 9px 20px !important;
    border-radius: 4px;
    font-weight: 700 !important;
    transition: background 0.2s !important;
  }
  .nav-cta:hover { background: var(--accent2) !important; color: var(--navy) !important; }
  .nav-cta::after { display: none !important; }

  /* ── HERO SLIDESHOW ── */
  .hero {
    min-height: 100vh;
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
  }

  /* Slides de fondo */
  .hero-slides {
    position: absolute;
    inset: 0;
    z-index: 0;
  }

  .hero-slide {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 1.2s ease-in-out;
  }

  .hero-slide.active { opacity: 1; }

  /* Overlay oscuro sobre cada foto */
  .hero-slide::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
      105deg,
      rgba(10,22,40,0.88) 0%,
      rgba(10,22,40,0.65) 50%,
      rgba(10,22,40,0.4) 100%
    );
  }

  /* Controles del slideshow */
  .slide-controls {
    position: absolute;
    bottom: 36px;
    left: 8%;
    z-index: 10;
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .slide-dots {
    display: flex;
    gap: 8px;
  }

  .slide-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
    cursor: pointer;
    transition: all 0.3s;
    border: none;
    padding: 0;
  }

  .slide-dot.active {
    background: var(--accent);
    width: 24px;
    border-radius: 4px;
  }

  .slide-arrows {
    display: flex;
    gap: 8px;
    margin-left: 8px;
  }

  .slide-arrow {
    width: 36px; height: 36px;
    border-radius: 50%;
    border: 1.5px solid rgba(255,255,255,0.25);
    background: rgba(10,22,40,0.5);
    color: var(--white);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
    transition: all 0.2s;
    backdrop-filter: blur(4px);
  }

  .slide-arrow:hover {
    border-color: var(--accent);
    background: rgba(201,168,76,0.2);
    color: var(--accent);
  }

  /* Barra de progreso del slide */
  .slide-progress {
    position: absolute;
    bottom: 0; left: 0;
    height: 3px;
    background: var(--accent);
    z-index: 10;
    transition: width 0.1s linear;
  }

  .hero-content {
    position: relative;
    z-index: 2;
    padding: 0 8%;
    max-width: 700px;
    animation: fadeUp 0.8s ease both;
  }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .hero-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(201,168,76,0.12);
    border: 1px solid rgba(201,168,76,0.3);
    color: var(--accent);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    padding: 7px 16px;
    border-radius: 2px;
    margin-bottom: 28px;
  }

  .hero-tag::before {
    content: '';
    width: 6px; height: 6px;
    background: var(--accent);
    border-radius: 50%;
    animation: blink 2s ease-in-out infinite;
  }

  @keyframes blink { 0%,100% { opacity: 1; } 50% { opacity: 0.3; } }

  .hero h1 {
    font-family: 'Montserrat', sans-serif;
    font-size: clamp(2.4rem, 5vw, 4rem);
    font-weight: 800;
    color: var(--white);
    line-height: 1.12;
    margin-bottom: 24px;
    letter-spacing: -1px;
  }

  .hero h1 em {
    font-style: normal;
    color: var(--accent);
  }

  .hero p {
    font-size: 1.1rem;
    color: var(--gray);
    line-height: 1.8;
    margin-bottom: 40px;
    max-width: 540px;
    font-weight: 300;
  }

  .hero-btns {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
  }

  .btn-primary {
    background: var(--accent);
    color: var(--navy);
    padding: 14px 32px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
    letter-spacing: 0.5px;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .btn-primary:hover {
    background: var(--accent2);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(201,168,76,0.3);
  }

  .btn-outline {
    border: 1.5px solid rgba(255,255,255,0.25);
    color: var(--white);
    padding: 14px 32px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    letter-spacing: 0.5px;
    transition: all 0.2s;
  }

  .btn-outline:hover {
    border-color: var(--accent);
    color: var(--accent);
    transform: translateY(-2px);
  }

  .hero-stats {
    display: flex;
    gap: 40px;
    margin-top: 60px;
    padding-top: 40px;
    border-top: 1px solid rgba(255,255,255,0.08);
    animation: fadeUp 0.8s ease 0.3s both;
  }

  .hero-stat-num {
    font-family: 'Montserrat', sans-serif;
    font-size: 2rem;
    font-weight: 800;
    color: var(--accent);
    line-height: 1;
  }

  .hero-stat-label {
    font-size: 12px;
    color: var(--gray);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 4px;
  }

  /* ── STRIP ── */
  .strip {
    background: var(--blue-mid);
    padding: 18px 8%;
    display: flex;
    align-items: center;
    gap: 32px;
    overflow: hidden;
  }

  .strip-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: rgba(255,255,255,0.8);
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.5px;
    white-space: nowrap;
  }

  .strip-dot {
    width: 5px; height: 5px;
    background: var(--accent);
    border-radius: 50%;
  }

  /* ── SECTION COMMONS ── */
  section { padding: 90px 8%; }

  .section-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--steel);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .section-label::before {
    content: '';
    width: 28px; height: 2px;
    background: var(--accent);
  }

  .section-title {
    font-family: 'Montserrat', sans-serif;
    font-size: clamp(1.8rem, 3vw, 2.6rem);
    font-weight: 800;
    color: var(--navy);
    line-height: 1.2;
    margin-bottom: 16px;
    letter-spacing: -0.5px;
  }

  .section-sub {
    font-size: 1.05rem;
    color: var(--gray);
    line-height: 1.8;
    max-width: 560px;
    font-weight: 300;
  }

  /* ── NOSOTROS ── */
  .about {
    background: var(--light);
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
  }

  .about-visual {
    position: relative;
  }

  .about-card {
    background: var(--navy);
    border-radius: 12px;
    padding: 48px 40px;
    position: relative;
    overflow: hidden;
  }

  .about-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--accent), var(--steel));
  }

  .about-card-num {
    font-family: 'Montserrat', sans-serif;
    font-size: 4rem;
    font-weight: 800;
    color: var(--accent);
    opacity: 0.15;
    position: absolute;
    top: 20px; right: 24px;
    line-height: 1;
  }

  .about-pillars {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: 24px;
  }

  .about-pillar {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 8px;
    padding: 20px 18px;
    transition: border-color 0.2s;
  }

  .about-pillar:hover { border-color: rgba(201,168,76,0.3); }

  .about-pillar-icon {
    font-size: 22px;
    margin-bottom: 8px;
  }

  .about-pillar-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: var(--white);
    margin-bottom: 4px;
  }

  .about-pillar-text {
    font-size: 12px;
    color: var(--gray);
    line-height: 1.6;
  }

  /* ── SERVICIOS ── */
  .services { background: var(--white); }

  .services-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 56px;
    flex-wrap: wrap;
    gap: 24px;
  }

  .services-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
  }

  .service-card {
    border: 1px solid var(--gray2);
    border-radius: 12px;
    padding: 40px 32px;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
    background: var(--white);
  }

  .service-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--steel), var(--blue-mid));
    transform: scaleX(0);
    transition: transform 0.3s;
    transform-origin: left;
  }

  .service-card:hover {
    border-color: var(--steel);
    transform: translateY(-6px);
    box-shadow: 0 20px 48px rgba(26,58,107,0.12);
  }

  .service-card:hover::before { transform: scaleX(1); }

  .service-icon {
    width: 56px; height: 56px;
    background: linear-gradient(135deg, var(--blue), var(--steel));
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px;
    margin-bottom: 24px;
    transition: transform 0.3s;
  }

  .service-card:hover .service-icon { transform: scale(1.1) rotate(-3deg); }

  .service-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 12px;
  }

  .service-text {
    font-size: 14px;
    color: var(--gray);
    line-height: 1.8;
    margin-bottom: 24px;
  }

  .service-features {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .service-features li {
    font-size: 13px;
    color: var(--text);
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .service-features li::before {
    content: '';
    width: 6px; height: 6px;
    background: var(--accent);
    border-radius: 50%;
    flex-shrink: 0;
  }

  /* ── LICITACIONES ── */
  .licitaciones {
    background: var(--navy);
    position: relative;
    overflow: hidden;
  }

  .licitaciones::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
      radial-gradient(ellipse 60% 80% at 90% 50%, rgba(30,77,140,0.4) 0%, transparent 60%);
  }

  .licitaciones .section-title { color: var(--white); }
  .licitaciones .section-sub { color: var(--gray); }
  .licitaciones .section-label { color: var(--accent); }

  .licit-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 48px;
    align-items: center;
    position: relative;
    z-index: 2;
  }

  .licit-right { }

  .licit-cards {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .licit-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 10px;
    padding: 22px 24px;
    display: flex;
    gap: 16px;
    align-items: flex-start;
    transition: border-color 0.2s, background 0.2s;
    cursor: default;
  }

  .licit-card:hover {
    border-color: rgba(201,168,76,0.35);
    background: rgba(201,168,76,0.05);
  }

  .licit-card-icon {
    font-size: 24px;
    flex-shrink: 0;
    margin-top: 2px;
  }

  .licit-card-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 14px;
    font-weight: 700;
    color: var(--white);
    margin-bottom: 4px;
  }

  .licit-card-text {
    font-size: 13px;
    color: var(--gray);
    line-height: 1.6;
  }

  .licit-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(201,168,76,0.15);
    border: 1px solid var(--accent);
    color: var(--accent);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1px;
    padding: 8px 16px;
    border-radius: 4px;
    margin-bottom: 32px;
  }

  /* ── POR QUÉ ELEGIRNOS ── */
  .why {
    background: var(--light);
  }

  .why-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    margin-top: 56px;
  }

  .why-card {
    background: var(--white);
    border-radius: 12px;
    padding: 36px 28px;
    text-align: center;
    border: 1px solid var(--gray2);
    transition: all 0.3s;
  }

  .why-card:hover {
    border-color: var(--steel);
    box-shadow: 0 12px 32px rgba(26,58,107,0.1);
    transform: translateY(-4px);
  }

  .why-icon {
    font-size: 2.5rem;
    margin-bottom: 16px;
  }

  .why-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 15px;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 10px;
  }

  .why-text {
    font-size: 13px;
    color: var(--gray);
    line-height: 1.7;
  }

  /* ── CONTACTO ── */
  .contact {
    background: var(--white);
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: start;
  }

  .contact-info-items {
    display: flex;
    flex-direction: column;
    gap: 24px;
    margin-top: 36px;
  }

  .contact-item {
    display: flex;
    gap: 16px;
    align-items: flex-start;
  }

  .contact-item-icon {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, var(--blue), var(--steel));
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
  }

  .contact-item-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--gray);
    margin-bottom: 4px;
  }

  .contact-item-value {
    font-size: 15px;
    color: var(--navy);
    font-weight: 600;
  }

  .contact-form {
    background: var(--light);
    border-radius: 16px;
    padding: 40px;
    border: 1px solid var(--gray2);
  }

  .form-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 24px;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--gray);
    margin-bottom: 8px;
  }

  .form-group input,
  .form-group select,
  .form-group textarea {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid var(--gray2);
    border-radius: 6px;
    font-family: 'Lato', sans-serif;
    font-size: 14px;
    color: var(--text);
    background: var(--white);
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
  }

  .form-group input:focus,
  .form-group select:focus,
  .form-group textarea:focus {
    border-color: var(--steel);
    box-shadow: 0 0 0 3px rgba(46,95,163,0.1);
  }

  .form-group textarea { resize: vertical; min-height: 120px; }

  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }

  .form-submit {
    width: 100%;
    background: var(--navy);
    color: var(--white);
    padding: 14px;
    border: none;
    border-radius: 6px;
    font-family: 'Montserrat', sans-serif;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s;
    margin-top: 8px;
  }

  .form-submit:hover {
    background: var(--blue-mid);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(10,22,40,0.25);
  }

  /* ── FOOTER ── */
  footer {
    background: var(--navy);
    padding: 56px 8% 32px;
    border-top: 1px solid rgba(255,255,255,0.06);
  }

  .footer-top {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 48px;
    padding-bottom: 40px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    margin-bottom: 32px;
  }

  .footer-brand p {
    color: var(--gray);
    font-size: 13px;
    line-height: 1.8;
    margin-top: 16px;
    max-width: 280px;
  }

  .footer-col-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 12px;
    font-weight: 700;
    color: var(--white);
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 20px;
  }

  .footer-links {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .footer-links a {
    text-decoration: none;
    color: var(--gray);
    font-size: 13px;
    transition: color 0.2s;
  }

  .footer-links a:hover { color: var(--accent); }

  .footer-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
  }

  .footer-copy {
    color: var(--gray);
    font-size: 12px;
  }

  .footer-copy a { color: var(--accent); text-decoration: none; }

  .footer-legal {
    display: flex;
    gap: 20px;
  }

  .footer-legal a {
    color: var(--gray);
    font-size: 12px;
    text-decoration: none;
    transition: color 0.2s;
  }

  .footer-legal a:hover { color: var(--accent); }

  /* ── RESPONSIVE ── */
  @media (max-width: 900px) {
    .about, .contact {
      grid-template-columns: 1fr;
    }
    .services-grid { grid-template-columns: 1fr; }
    .why-grid { grid-template-columns: 1fr 1fr; }
    .licit-grid { grid-template-columns: 1fr; }
    .footer-top { grid-template-columns: 1fr 1fr; }
    .nav-links { display: none; }
    .hero-stats { gap: 24px; }
    .form-row { grid-template-columns: 1fr; }
  }

  @media (max-width: 600px) {
    section { padding: 64px 6%; }
    .why-grid { grid-template-columns: 1fr; }
    .footer-top { grid-template-columns: 1fr; }
    .about-pillars { grid-template-columns: 1fr; }
  }
</style>
</head>
<body>

<!-- NAVBAR -->
<nav>
  <a href="#inicio" class="nav-logo">
    <div class="nav-logo-badge">GCE</div>
    <div class="nav-logo-text">
      Grupo Comercial Empresarial
      <span>Ciudad del Este · Paraguay</span>
    </div>
  </a>
  <ul class="nav-links">
    <li><a href="#nosotros">Nosotros</a></li>
    <li><a href="#servicios">Servicios</a></li>
    <li><a href="#licitaciones">Licitaciones</a></li>
    <li><a href="#contacto" class="nav-cta">Contacto</a></li>
  </ul>
</nav>

<section class="hero" id="inicio">

  <div class="hero-slides" id="heroSlides"></div>
  <div class="slide-progress" id="slideProgress"></div>

  <div class="hero-content">
    <div class="hero-tag">Proveedor del Estado Paraguayo</div>
    <h1>Soluciones <em>tecnológicas</em> para empresas e instituciones</h1>
    <p>Integramos tecnología, distribución y desarrollo de software para impulsar la eficiencia de organizaciones públicas y privadas en el Paraguay.</p>
    <div class="hero-btns">
      <a href="#servicios" class="btn-primary">Ver nuestros servicios →</a>
      <a href="#contacto" class="btn-outline">Solicitar cotización</a>
    </div>
    <div class="hero-stats">
      <div>
        <div class="hero-stat-num">3+</div>
        <div class="hero-stat-label">Rubros de servicio</div>
      </div>
      <div>
        <div class="hero-stat-num">PY</div>
        <div class="hero-stat-label">Proveedor registrado DNCP</div>
      </div>
      <div>
        <div class="hero-stat-num">CDE</div>
        <div class="hero-stat-label">Alto Paraná, Paraguay</div>
      </div>
    </div>
  </div>

  <div class="slide-controls">
    <div class="slide-dots" id="slideDots"></div>
    <div class="slide-arrows">
      <button class="slide-arrow" id="prevSlide">&#8592;</button>
      <button class="slide-arrow" id="nextSlide">&#8594;</button>
    </div>
  </div>

</section>

<!-- STRIP -->
<div class="strip">
  <div class="strip-item">🔒 Sistemas CCTV y Videovigilancia</div>
  <div class="strip-dot"></div>
  <div class="strip-item">💻 Desarrollo de Software a Medida</div>
  <div class="strip-dot"></div>
  <div class="strip-item">🖨️ Insumos y Equipos para Oficina</div>
  <div class="strip-dot"></div>
  <div class="strip-item">📋 Proveedor habilitado DNCP</div>
  <div class="strip-dot"></div>
  <div class="strip-item">📍 Ciudad del Este, Alto Paraná</div>
</div>

<!-- NOSOTROS -->
<section class="about" id="nosotros">
  <div class="about-text">
    <div class="section-label">Quiénes somos</div>
    <h2 class="section-title">Compromiso con la tecnología y el desarrollo empresarial</h2>
    <p class="section-sub" style="margin-bottom: 28px;">GCE – Grupo Comercial Empresarial es una empresa paraguaya con base en Ciudad del Este, especializada en la provisión de soluciones tecnológicas, desarrollo de software y suministros para instituciones públicas y privadas.</p>
    <p class="section-sub">Nos distinguimos por nuestra capacidad de participar activamente en procesos de contratación pública, cumpliendo con todos los requisitos del sistema de la Dirección Nacional de Contrataciones Públicas (DNCP) de Paraguay.</p>
  </div>

  <div class="about-visual">
    <div class="about-card">
      <div class="about-card-num">GCE</div>
      <div class="section-label" style="color: var(--accent); margin-bottom: 20px;">Nuestros valores</div>
      <div class="about-pillars">
        <div class="about-pillar">
          <div class="about-pillar-icon">🎯</div>
          <div class="about-pillar-title">Precisión</div>
          <div class="about-pillar-text">Soluciones adaptadas a cada necesidad específica</div>
        </div>
        <div class="about-pillar">
          <div class="about-pillar-icon">🤝</div>
          <div class="about-pillar-title">Confianza</div>
          <div class="about-pillar-text">Transparencia en cada proceso y contratación</div>
        </div>
        <div class="about-pillar">
          <div class="about-pillar-icon">⚡</div>
          <div class="about-pillar-title">Agilidad</div>
          <div class="about-pillar-text">Respuesta rápida y entrega en tiempo y forma</div>
        </div>
        <div class="about-pillar">
          <div class="about-pillar-icon">📈</div>
          <div class="about-pillar-title">Crecimiento</div>
          <div class="about-pillar-text">Acompañamos la evolución de nuestros clientes</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SERVICIOS -->
<section class="services" id="servicios">
  <div class="services-header">
    <div>
      <div class="section-label">Nuestros servicios</div>
      <h2 class="section-title">Lo que ofrecemos</h2>
    </div>
    <p class="section-sub" style="max-width: 360px;">Soluciones integrales para instituciones públicas, municipios, empresas y comercios del Paraguay.</p>
  </div>

  <div class="services-grid">
    <div class="service-card">
      <div class="service-icon">🎥</div>
      <div class="service-title">Sistemas CCTV y Videovigilancia</div>
      <p class="service-text">Diseño, suministro e instalación de sistemas de vigilancia y seguridad electrónica para instituciones públicas y privadas.</p>
      <ul class="service-features">
        <li>Cámaras IP y analógicas HD/4K</li>
        <li>NVR/DVR y almacenamiento en nube</li>
        <li>Monitoreo remoto 24/7</li>
        <li>Control de acceso biométrico</li>
        <li>Instalación y mantenimiento</li>
      </ul>
    </div>

    <div class="service-card">
      <div class="service-icon">💻</div>
      <div class="service-title">Desarrollo de Software a Medida</div>
      <p class="service-text">Sistemas de gestión, aplicaciones web y soluciones informáticas diseñadas para los requerimientos específicos del sector público y privado.</p>
      <ul class="service-features">
        <li>Sistemas de gestión municipal</li>
        <li>Aplicaciones web y móvil</li>
        <li>Integración con SIFEN / e-Kuatia</li>
        <li>Bases de datos y reportes</li>
        <li>Soporte técnico especializado</li>
      </ul>
    </div>

    <div class="service-card">
      <div class="service-icon">🖨️</div>
      <div class="service-title">Insumos y Equipos para Oficina</div>
      <p class="service-text">Provisión de insumos, consumibles y equipamiento de oficina para instituciones y empresas a través de procesos de licitación.</p>
      <ul class="service-features">
        <li>Cartuchos, tóners y consumibles</li>
        <li>Impresoras y equipos multifunción</li>
        <li>Material de oficina y papelería</li>
        <li>Equipos de cómputo y periféricos</li>
        <li>Entrega con factura electrónica SIFEN</li>
      </ul>
    </div>
  </div>
</section>

<!-- LICITACIONES -->
<section class="licitaciones" id="licitaciones">
  <div class="licit-grid">
    <div>
      <div class="licit-badge">⚖️ Contrataciones Públicas</div>
      <div class="section-label">Para organismos del Estado</div>
      <h2 class="section-title">Proveedor habilitado ante la DNCP</h2>
      <p class="section-sub" style="margin-bottom: 32px;">GCE participa activamente en procesos de licitación pública, concursos de ofertas y contrataciones directas a través del Sistema de Información de Proveedores del Estado (SIPE) de Paraguay.</p>
      <a href="https://www.contrataciones.gov.py" target="_blank" class="btn-primary">Consultar en DNCP →</a>
    </div>

    <div class="licit-right">
      <div class="licit-cards">
        <div class="licit-card">
          <div class="licit-card-icon">📄</div>
          <div>
            <div class="licit-card-title">Licitación Pública Nacional (LPN)</div>
            <div class="licit-card-text">Participamos en llamados nacionales para provisión de bienes y servicios tecnológicos.</div>
          </div>
        </div>
        <div class="licit-card">
          <div class="licit-card-icon">🔖</div>
          <div>
            <div class="licit-card-title">Menor Cuantía Nacional (MCN)</div>
            <div class="licit-card-text">Disponibles para contrataciones directas e inmediatas de menor escala.</div>
          </div>
        </div>
        <div class="licit-card">
          <div class="licit-card-icon">📦</div>
          <div>
            <div class="licit-card-title">Catálogo Electrónico / Tienda Virtual</div>
            <div class="licit-card-text">Productos disponibles para adquisición directa por organismos públicos.</div>
          </div>
        </div>
        <div class="licit-card">
          <div class="licit-card-icon">🧾</div>
          <div>
            <div class="licit-card-title">Facturación Electrónica SIFEN</div>
            <div class="licit-card-text">Emisión de facturas electrónicas conforme a la normativa de la SET.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- POR QUÉ ELEGIRNOS -->
<section class="why">
  <div style="text-align:center; max-width:600px; margin: 0 auto 0;">
    <div class="section-label" style="justify-content: center;">Por qué elegirnos</div>
    <h2 class="section-title">Ventajas que nos diferencian</h2>
  </div>

  <div class="why-grid">
    <div class="why-card">
      <div class="why-icon">🏛️</div>
      <div class="why-title">Experiencia institucional</div>
      <p class="why-text">Conocimiento profundo de los procesos de contratación pública en Paraguay y sus requisitos normativos.</p>
    </div>
    <div class="why-card">
      <div class="why-icon">🛡️</div>
      <div class="why-title">Registro limpio</div>
      <p class="why-text">Sin antecedentes de inhabilitación. Empresa registrada y habilitada ante la DNCP y la DNIT.</p>
    </div>
    <div class="why-card">
      <div class="why-icon">📍</div>
      <div class="why-title">Presencia regional</div>
      <p class="why-text">Basados en Ciudad del Este, con capacidad de atención en toda la región de Alto Paraná y el país.</p>
    </div>
    <div class="why-card">
      <div class="why-icon">🔧</div>
      <div class="why-title">Soporte postventa</div>
      <p class="why-text">Acompañamiento técnico y servicio de mantenimiento después de cada entrega o implementación.</p>
    </div>
  </div>
</section>

<!-- CONTACTO -->
<section class="contact" id="contacto">
  <div>
    <div class="section-label">Hablemos</div>
    <h2 class="section-title">Contacto</h2>
    <p class="section-sub">Para cotizaciones, consultas sobre licitaciones o propuestas de trabajo, no dude en comunicarse con nosotros.</p>

    <div class="contact-info-items">
      <div class="contact-item">
        <div class="contact-item-icon">📍</div>
        <div>
          <div class="contact-item-label">Dirección</div>
          <div class="contact-item-value">Ciudad del Este, Alto Paraná, Paraguay</div>
        </div>
      </div>
      <div class="contact-item">
        <div class="contact-item-icon">📧</div>
        <div>
          <div class="contact-item-label">Correo electrónico</div>
          <div class="contact-item-value"><a href="mailto:info@gce.com.py" style="color: inherit; text-decoration: none;">info@gce.com.py</a></div>
        </div>
      </div>
      <div class="contact-item">
        <div class="contact-item-icon">🕒</div>
        <div>
          <div class="contact-item-label">Horario de atención</div>
          <div class="contact-item-value">Lun – Sab: 7:00 – 17:00</div>
        </div>
      </div>
      <div class="contact-item">
        <div class="contact-item-icon">🌐</div>
        <div>
          <div class="contact-item-label">Sitio web</div>
          <div class="contact-item-value"><a href="https://www.gce.com.py" style="color: inherit; text-decoration: none;">www.gce.com.py</a></div>
        </div>
      </div>
    </div>
  </div>

  <div class="contact-form">
    <div class="form-title">Enviar consulta</div>
    <form action="https://formsubmit.co/corporativogce@gmail.com" method="POST">
      <input type="hidden" name="_subject" value="Nueva consulta desde gce.com.py">
      <input type="hidden" name="_captcha" value="true">
      <input type="text" name="_honey" style="display:none">
      <input type="hidden" name="_template" value="table">
      <input type="hidden" name="_next" value="https://gce.com.py/?enviado=1">

      <div class="form-row">
        <div class="form-group">
          <label>Nombre</label>
          <input type="text" name="nombre" placeholder="Su nombre completo" required>
        </div>
        <div class="form-group">
          <label>Institución / Empresa</label>
          <input type="text" name="empresa" placeholder="Nombre de la organización">
        </div>
      </div>
      <div class="form-group">
        <label>Correo electrónico</label>
        <input type="email" name="email" placeholder="correo@institución.com" required>
      </div>
      <div class="form-group">
        <label>Tipo de consulta</label>
        <select name="tipo_consulta">
          <option value="">Seleccionar...</option>
          <option>Cotización – CCTV y Videovigilancia</option>
          <option>Cotización – Desarrollo de Software</option>
          <option>Cotización – Insumos de Oficina</option>
          <option>Consulta sobre licitaciones</option>
          <option>Soporte técnico</option>
          <option>Otro</option>
        </select>
      </div>
      <div class="form-group">
        <label>Mensaje</label>
        <textarea name="mensaje" placeholder="Describa su necesidad o consulta..." required></textarea>
      </div>

      <div class="g-recaptcha" data-sitekey="6Lfv14UsAAAAAMyy5ERbsmgShEbT0tvKMHdnebgf" style="margin-bottom: 16px;"></div>

      <button type="submit" class="form-submit">Enviar consulta</button>
    </form>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-top">
    <div class="footer-brand">
      <div class="nav-logo" style="text-decoration:none; display:flex; align-items:center; gap:12px; margin-bottom:4px;">
        <div class="nav-logo-badge">GCE</div>
        <div class="nav-logo-text">
          Grupo Comercial Empresarial
          <span>Ciudad del Este · Paraguay</span>
        </div>
      </div>
      <p>Empresa paraguaya especializada en soluciones tecnológicas, desarrollo de software, CCTV y provisión de insumos para el sector público y privado.</p>
    </div>

    <div>
      <div class="footer-col-title">Servicios</div>
      <ul class="footer-links">
        <li><a href="#servicios">Sistemas CCTV</a></li>
        <li><a href="#servicios">Desarrollo de Software</a></li>
        <li><a href="#servicios">Insumos de Oficina</a></li>
        <li><a href="#licitaciones">Licitaciones Públicas</a></li>
      </ul>
    </div>

    <div>
      <div class="footer-col-title">Empresa</div>
      <ul class="footer-links">
        <li><a href="#nosotros">Quiénes somos</a></li>
        <li><a href="#licitaciones">Contrataciones DNCP</a></li>
        <li><a href="#contacto">Contacto</a></li>
      </ul>
    </div>

    <div>
      <div class="footer-col-title">Normativa</div>
      <ul class="footer-links">
        <li><a href="https://www.contrataciones.gov.py" target="_blank">Portal DNCP</a></li>
        <li><a href="https://www.set.gov.py" target="_blank">DNIT Paraguay</a></li>
        <li><a href="https://ekuatia.set.gov.py" target="_blank">SIFEN / e-Kuatia</a></li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="footer-copy">
      &copy; {{ now()->year }} <a href="#">GCE – Grupo Comercial Empresarial</a>. Todos los derechos reservados. Ciudad del Este, Paraguay.
    </div>
    <div class="footer-legal">
      <a href="#">Política de privacidad</a>
      <a href="#">Términos de uso</a>
    </div>
  </div>
</footer>

<script>
  const SLIDES_CONFIG = [
    {
      url: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1600&q=80',
      label: 'Sistemas CCTV y Videovigilancia'
    },
    {
      url: 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=1600&q=80',
      label: 'Desarrollo de Software'
    },
    {
      url: 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1600&q=80',
      label: 'Soluciones para Oficina'
    },
    {
      url: 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=1600&q=80',
      label: 'Infraestructura Tecnológica'
    },
    {
      url: 'https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?w=1600&q=80',
      label: 'Soporte y Servicios'
    }
  ];

  const INTERVAL = 5000;

  let current = 0;
  let timer = null;
  let progressTimer = null;
  let progressStart = null;

  const slidesEl  = document.getElementById('heroSlides');
  const dotsEl    = document.getElementById('slideDots');
  const progressEl= document.getElementById('slideProgress');

  SLIDES_CONFIG.forEach((s, i) => {
    const div = document.createElement('div');
    div.className = 'hero-slide' + (i === 0 ? ' active' : '');
    div.style.backgroundImage = `url('${s.url}')`;
    div.title = s.label;
    slidesEl.appendChild(div);
  });

  SLIDES_CONFIG.forEach((s, i) => {
    const btn = document.createElement('button');
    btn.className = 'slide-dot' + (i === 0 ? ' active' : '');
    btn.title = s.label;
    btn.addEventListener('click', () => goTo(i));
    dotsEl.appendChild(btn);
  });

  function goTo(idx) {
    const slides = slidesEl.querySelectorAll('.hero-slide');
    const dots   = dotsEl.querySelectorAll('.slide-dot');
    slides[current].classList.remove('active');
    dots[current].classList.remove('active');
    current = (idx + SLIDES_CONFIG.length) % SLIDES_CONFIG.length;
    slides[current].classList.add('active');
    dots[current].classList.add('active');
    resetProgress();
  }

  function next() { goTo(current + 1); }
  function prev() { goTo(current - 1); }

  document.getElementById('nextSlide').addEventListener('click', () => { next(); });
  document.getElementById('prevSlide').addEventListener('click', () => { prev(); });

  function resetProgress() {
    clearInterval(timer);
    cancelAnimationFrame(progressTimer);
    progressEl.style.width = '0%';
    progressStart = performance.now();

    function animate(now) {
      const elapsed = now - progressStart;
      const pct = Math.min((elapsed / INTERVAL) * 100, 100);
      progressEl.style.width = pct + '%';
      if (pct < 100) {
        progressTimer = requestAnimationFrame(animate);
      }
    }
    progressTimer = requestAnimationFrame(animate);
    timer = setInterval(next, INTERVAL);
  }

  resetProgress();

  slidesEl.addEventListener('mouseenter', () => {
    clearInterval(timer);
    cancelAnimationFrame(progressTimer);
  });
  slidesEl.addEventListener('mouseleave', resetProgress);

  window.addEventListener('scroll', () => {
    const nav = document.querySelector('nav');
    if (window.scrollY > 50) {
      nav.style.background = 'rgba(10,22,40,0.99)';
      nav.style.boxShadow = '0 4px 24px rgba(0,0,0,0.3)';
    } else {
      nav.style.background = 'rgba(10,22,40,0.97)';
      nav.style.boxShadow = 'none';
    }
  });

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(el => {
      if (el.isIntersecting) {
        el.target.style.opacity = '1';
        el.target.style.transform = 'translateY(0)';
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.service-card, .why-card, .licit-card, .about-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
  });
</script>

</body>
</html>

<?php
// Contact form handler
$form_success = false;
$form_error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email   = htmlspecialchars(trim($_POST['email'] ?? ''));
    $service = htmlspecialchars(trim($_POST['service'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    if ($name && $email && $message && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $to      = 'hello@ainika.xyz';
        $subject = "Ainika Enquiry from $name – $service";
        $body    = "Name: $name\nEmail: $email\nService: $service\n\nMessage:\n$message";
        $headers = "From: noreply@ainika.xyz\r\nReply-To: $email\r\nX-Mailer: PHP/" . phpversion();
        $form_success = mail($to, $subject, $body, $headers);
        if (!$form_success) $form_error = true;
    } else {
        $form_error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Ainika – AI-Powered Products. Human-Centred Strategy. Product consulting, AI/ML strategy, and data products by Josen Joy.">
<title>Ainika – AI-Powered Products. Human-Centred Strategy.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Mono:wght@300;400;500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  /* ─── RESET & ROOT ─── */
  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

  :root {
    --ink:      #0d0d0d;
    --ink-mid:  #3a3a3a;
    --ink-soft: #888;
    --paper:    #fafaf8;
    --paper-2:  #f2f1ee;
    --gold:     #b89a5a;
    --gold-lt:  #d4b87a;
    --rule:     #e4e2dc;
    --mono:     'DM Mono', monospace;
    --serif:    'Cormorant Garamond', Georgia, serif;
    --sans:     'DM Sans', sans-serif;
  }

  html { scroll-behavior: smooth; font-size: 16px; }

  body {
    background: var(--paper);
    color: var(--ink);
    font-family: var(--sans);
    font-weight: 300;
    line-height: 1.7;
    overflow-x: hidden;
    cursor: none;
  }

  /* ─── CUSTOM CURSOR ─── */
  .cursor-dot {
    width: 6px; height: 6px;
    background: var(--gold);
    border-radius: 50%;
    position: fixed; top: 0; left: 0;
    pointer-events: none; z-index: 9999;
    transform: translate(-50%, -50%);
    transition: transform 0.08s ease;
  }
  .cursor-ring {
    width: 28px; height: 28px;
    border: 1px solid var(--gold);
    border-radius: 50%;
    position: fixed; top: 0; left: 0;
    pointer-events: none; z-index: 9998;
    transform: translate(-50%, -50%);
    transition: all 0.18s ease;
    opacity: 0.6;
  }
  .cursor-ring.hover { width: 44px; height: 44px; opacity: 0.3; }

  /* ─── NOISE OVERLAY ─── */
  body::before {
    content: '';
    position: fixed; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
    pointer-events: none; z-index: 0; opacity: 0.4;
  }

  /* ─── NAVIGATION ─── */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    display: flex; align-items: center; justify-content: space-between;
    padding: 28px 60px;
    mix-blend-mode: normal;
    transition: background 0.4s ease, padding 0.4s ease, box-shadow 0.4s ease;
  }
  nav.scrolled {
    background: rgba(250, 250, 248, 0.94);
    backdrop-filter: blur(12px);
    padding: 18px 60px;
    box-shadow: 0 1px 0 var(--rule);
  }
  .nav-logo {
    font-family: var(--serif);
    font-size: 22px;
    font-weight: 300;
    letter-spacing: 0.12em;
    color: var(--ink);
    text-decoration: none;
    display: flex; align-items: center; gap: 10px;
  }
  .nav-logo span.dot { color: var(--gold); font-size: 28px; line-height: 1; }
  .nav-links { display: flex; gap: 40px; list-style: none; }
  .nav-links a {
    font-family: var(--mono);
    font-size: 11px;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--ink-mid);
    text-decoration: none;
    transition: color 0.2s;
    position: relative;
  }
  .nav-links a::after {
    content: ''; position: absolute; bottom: -3px; left: 0; right: 0;
    height: 1px; background: var(--gold);
    transform: scaleX(0); transform-origin: left;
    transition: transform 0.3s ease;
  }
  .nav-links a:hover { color: var(--ink); }
  .nav-links a:hover::after { transform: scaleX(1); }
  .nav-cta {
    font-family: var(--mono); font-size: 11px; letter-spacing: 0.18em;
    text-transform: uppercase; color: var(--gold);
    border: 1px solid var(--gold); padding: 10px 22px; text-decoration: none;
    transition: all 0.25s ease;
  }
  .nav-cta:hover { background: var(--gold); color: var(--paper); }

  /* ─── HERO ─── */
  #hero {
    min-height: 100vh;
    display: flex; flex-direction: column; justify-content: center;
    padding: 120px 60px 80px;
    position: relative;
    overflow: hidden;
  }
  .hero-grid-line {
    position: absolute; top: 0; bottom: 0;
    width: 1px; background: var(--rule);
  }
  .hero-grid-line:nth-child(1) { left: 60px; }
  .hero-grid-line:nth-child(2) { right: 60px; }
  .hero-grid-line:nth-child(3) { left: 50%; opacity: 0.4; }

  .hero-eyebrow {
    font-family: var(--mono); font-size: 11px; letter-spacing: 0.25em;
    color: var(--gold); text-transform: uppercase; margin-bottom: 32px;
    opacity: 0; animation: fadeUp 0.8s ease 0.2s forwards;
    display: flex; align-items: center; gap: 16px;
  }
  .hero-eyebrow::before {
    content: ''; display: block; width: 40px; height: 1px; background: var(--gold);
  }

  h1.hero-title {
    font-family: var(--serif);
    font-size: clamp(52px, 7vw, 96px);
    font-weight: 300;
    line-height: 1.08;
    letter-spacing: -0.02em;
    color: var(--ink);
    max-width: 900px;
    opacity: 0; animation: fadeUp 0.9s ease 0.4s forwards;
  }
  h1.hero-title em {
    font-style: italic; color: var(--gold);
  }

  .hero-tagline {
    font-family: var(--sans); font-size: 16px; font-weight: 300;
    color: var(--ink-soft); margin-top: 28px; max-width: 440px;
    letter-spacing: 0.01em; line-height: 1.8;
    opacity: 0; animation: fadeUp 0.9s ease 0.6s forwards;
  }

  .hero-actions {
    display: flex; gap: 20px; margin-top: 48px; align-items: center;
    opacity: 0; animation: fadeUp 0.9s ease 0.8s forwards;
  }
  .btn-primary {
    font-family: var(--mono); font-size: 11px; letter-spacing: 0.2em;
    text-transform: uppercase; background: var(--ink); color: var(--paper);
    padding: 16px 36px; text-decoration: none; transition: all 0.25s;
    display: inline-block;
  }
  .btn-primary:hover { background: var(--gold); }
  .btn-ghost {
    font-family: var(--mono); font-size: 11px; letter-spacing: 0.2em;
    text-transform: uppercase; color: var(--ink-mid); text-decoration: none;
    display: flex; align-items: center; gap: 10px; transition: color 0.2s;
  }
  .btn-ghost:hover { color: var(--gold); }
  .btn-ghost::after { content: '→'; font-size: 14px; transition: transform 0.2s; }
  .btn-ghost:hover::after { transform: translateX(4px); }

  .hero-scroll-hint {
    position: absolute; bottom: 40px; left: 60px;
    font-family: var(--mono); font-size: 10px; letter-spacing: 0.2em;
    color: var(--ink-soft); text-transform: uppercase;
    display: flex; align-items: center; gap: 12px;
    opacity: 0; animation: fadeUp 1s ease 1.2s forwards;
  }
  .hero-scroll-hint::before {
    content: ''; display: block; width: 1px; height: 40px; background: var(--ink-soft);
    animation: scrollLine 2s ease-in-out infinite;
  }
  @keyframes scrollLine {
    0%, 100% { transform: scaleY(1); opacity: 1; }
    50% { transform: scaleY(0.4); opacity: 0.3; }
  }

  .hero-stats {
    position: absolute; bottom: 40px; right: 60px;
    display: flex; gap: 48px;
    opacity: 0; animation: fadeUp 1s ease 1s forwards;
  }
  .stat-item { text-align: right; }
  .stat-num {
    font-family: var(--serif); font-size: 36px; font-weight: 300;
    color: var(--ink); line-height: 1; display: block;
  }
  .stat-label {
    font-family: var(--mono); font-size: 10px; letter-spacing: 0.2em;
    color: var(--ink-soft); text-transform: uppercase; margin-top: 4px; display: block;
  }

  /* ─── SECTION SHARED ─── */
  section { position: relative; z-index: 1; }
  .section-inner { max-width: 1200px; margin: 0 auto; padding: 0 60px; }

  .section-label {
    font-family: var(--mono); font-size: 10px; letter-spacing: 0.3em;
    color: var(--gold); text-transform: uppercase;
    display: flex; align-items: center; gap: 16px; margin-bottom: 20px;
  }
  .section-label::before {
    content: ''; display: block; width: 30px; height: 1px; background: var(--gold);
  }

  h2.section-title {
    font-family: var(--serif); font-size: clamp(36px, 4vw, 54px);
    font-weight: 300; line-height: 1.15; letter-spacing: -0.01em;
    color: var(--ink);
  }
  h2.section-title em { font-style: italic; color: var(--gold); }

  /* ─── ABOUT ─── */
  #about { padding: 140px 0; background: var(--paper); }
  .about-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center;
    margin-top: 64px;
  }
  .about-text p {
    font-size: 16px; color: var(--ink-mid); line-height: 1.9; margin-bottom: 20px;
    font-weight: 300;
  }
  .about-text p strong { color: var(--ink); font-weight: 500; }
  .about-credentials {
    border-top: 1px solid var(--rule); margin-top: 36px; padding-top: 36px;
    display: flex; flex-direction: column; gap: 14px;
  }
  .credential {
    display: flex; align-items: baseline; gap: 16px;
    font-family: var(--mono); font-size: 12px;
  }
  .credential-year { color: var(--gold); width: 40px; flex-shrink: 0; }
  .credential-text { color: var(--ink-mid); }

  .about-visual {
    position: relative;
  }
  .about-card {
    background: var(--ink); color: var(--paper);
    padding: 52px 44px; position: relative; overflow: hidden;
  }
  .about-card::before {
    content: ''; position: absolute; top: 0; left: 0;
    width: 3px; height: 100%; background: var(--gold);
  }
  .about-card-name {
    font-family: var(--serif); font-size: 32px; font-weight: 300;
    letter-spacing: 0.04em; margin-bottom: 8px;
  }
  .about-card-title {
    font-family: var(--mono); font-size: 11px; letter-spacing: 0.2em;
    color: var(--gold); text-transform: uppercase; margin-bottom: 32px;
  }
  .about-card-tags { display: flex; flex-wrap: wrap; gap: 8px; }
  .tag {
    font-family: var(--mono); font-size: 10px; letter-spacing: 0.15em;
    text-transform: uppercase; border: 1px solid rgba(255,255,255,0.15);
    padding: 6px 12px; color: rgba(255,255,255,0.6); transition: all 0.2s;
  }
  .tag:hover { border-color: var(--gold); color: var(--gold-lt); }
  .about-card-accent {
    position: absolute; bottom: -20px; right: -20px;
    font-family: var(--serif); font-size: 120px; font-weight: 300;
    color: rgba(184,154,90,0.08); line-height: 1; pointer-events: none;
    letter-spacing: -0.05em;
  }
  .about-links { display: flex; gap: 16px; margin-top: 32px; }
  .about-link {
    font-family: var(--mono); font-size: 10px; letter-spacing: 0.2em;
    text-transform: uppercase; color: rgba(255,255,255,0.5); text-decoration: none;
    border-bottom: 1px solid rgba(255,255,255,0.15); padding-bottom: 2px;
    transition: all 0.2s;
  }
  .about-link:hover { color: var(--gold-lt); border-color: var(--gold); }

  /* ─── SERVICES ─── */
  #services { padding: 140px 0; background: var(--paper-2); }
  .services-header { max-width: 640px; margin-bottom: 80px; }
  .services-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2px; }
  .service-card {
    background: var(--paper); padding: 52px 44px;
    border-top: 2px solid transparent;
    transition: border-color 0.3s, background 0.3s;
    position: relative; overflow: hidden;
  }
  .service-card:hover { border-top-color: var(--gold); background: #fff; }
  .service-num {
    font-family: var(--mono); font-size: 11px; color: var(--gold);
    letter-spacing: 0.2em; margin-bottom: 28px; display: block;
  }
  .service-icon {
    font-size: 28px; margin-bottom: 20px; display: block;
    filter: grayscale(0.3);
  }
  h3.service-title {
    font-family: var(--serif); font-size: 24px; font-weight: 400;
    line-height: 1.3; margin-bottom: 16px; color: var(--ink);
  }
  .service-desc {
    font-size: 14px; color: var(--ink-soft); line-height: 1.8;
    margin-bottom: 28px;
  }
  .service-deliverables { list-style: none; }
  .service-deliverables li {
    font-family: var(--mono); font-size: 11px; color: var(--ink-mid);
    letter-spacing: 0.05em; padding: 7px 0;
    border-bottom: 1px solid var(--rule);
    display: flex; align-items: center; gap: 10px;
  }
  .service-deliverables li::before { content: '—'; color: var(--gold); }
  .service-card-bg {
    position: absolute; bottom: 20px; right: 24px;
    font-family: var(--serif); font-size: 80px; font-weight: 300;
    color: var(--rule); line-height: 1; pointer-events: none;
  }

  /* ─── PROJECTS ─── */
  #projects { padding: 140px 0; background: var(--paper); }
  .projects-header { max-width: 640px; margin-bottom: 80px; }
  .projects-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 24px; }

  .project-card {
    border: 1px solid var(--rule); padding: 44px 40px;
    position: relative; overflow: hidden; transition: border-color 0.3s, box-shadow 0.3s;
    text-decoration: none; display: block; color: inherit;
  }
  .project-card:hover {
    border-color: var(--gold);
    box-shadow: 0 8px 40px rgba(184,154,90,0.08);
  }
  .project-status {
    font-family: var(--mono); font-size: 10px; letter-spacing: 0.2em;
    text-transform: uppercase; display: inline-flex; align-items: center; gap: 8px;
    margin-bottom: 24px;
  }
  .status-dot {
    width: 6px; height: 6px; border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
  }
  .status-dot.live { background: #2ecc71; }
  .status-dot.building { background: var(--gold); }
  @keyframes pulse {
    0%, 100% { opacity: 1; } 50% { opacity: 0.3; }
  }
  .status-live { color: #2ecc71; }
  .status-building { color: var(--gold); }

  a.project-card { color: inherit; text-decoration: none; }

  h3.project-title {
    font-family: var(--serif); font-size: 26px; font-weight: 400;
    line-height: 1.25; margin-bottom: 12px;
  }
  .project-sector {
    font-family: var(--mono); font-size: 10px; letter-spacing: 0.2em;
    color: var(--gold); text-transform: uppercase; margin-bottom: 16px;
  }
  .project-desc { font-size: 14px; color: var(--ink-soft); line-height: 1.8; margin-bottom: 24px; }
  .project-tech { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 24px; }
  .tech-badge {
    font-family: var(--mono); font-size: 10px; letter-spacing: 0.1em;
    background: var(--paper-2); color: var(--ink-mid);
    padding: 4px 10px; border-radius: 2px;
  }
  .project-cta {
    font-family: var(--mono); font-size: 11px; letter-spacing: 0.15em;
    text-transform: uppercase; color: var(--gold);
    display: flex; align-items: center; gap: 8px; transition: gap 0.2s;
  }
  .project-card:hover .project-cta { gap: 14px; }
  .project-card-num {
    position: absolute; top: 28px; right: 32px;
    font-family: var(--serif); font-size: 60px; font-weight: 300;
    color: var(--rule); line-height: 1;
  }

  /* SAAS TEASER */
  .saas-teaser {
    grid-column: 1 / -1;
    background: var(--ink); padding: 56px 52px;
    display: flex; align-items: center; justify-content: space-between; gap: 40px;
    border: none; position: relative; overflow: hidden;
  }
  .saas-teaser::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, transparent 60%, rgba(184,154,90,0.06));
  }
  .saas-teaser-text h3 {
    font-family: var(--serif); font-size: 28px; font-weight: 300;
    color: var(--paper); margin-bottom: 10px;
  }
  .saas-teaser-text p { font-size: 14px; color: rgba(255,255,255,0.45); max-width: 480px; }
  .saas-teaser-cta {
    font-family: var(--mono); font-size: 11px; letter-spacing: 0.2em;
    text-transform: uppercase; border: 1px solid rgba(255,255,255,0.2);
    color: rgba(255,255,255,0.7); padding: 14px 28px; text-decoration: none;
    transition: all 0.25s; white-space: nowrap; flex-shrink: 0;
  }
  .saas-teaser-cta:hover { border-color: var(--gold); color: var(--gold-lt); }

  /* ─── PROCESS ─── */
  #process { padding: 140px 0; background: var(--ink); }
  #process .section-label { color: var(--gold); }
  #process .section-title { color: var(--paper); }
  .process-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0; margin-top: 64px; }
  .process-step {
    padding: 44px 36px; border-right: 1px solid rgba(255,255,255,0.06);
    transition: background 0.3s;
  }
  .process-step:last-child { border-right: none; }
  .process-step:hover { background: rgba(255,255,255,0.02); }
  .process-step-num {
    font-family: var(--serif); font-size: 48px; font-weight: 300;
    color: rgba(184,154,90,0.3); line-height: 1; margin-bottom: 20px; display: block;
  }
  h3.process-title {
    font-family: var(--serif); font-size: 20px; font-weight: 400;
    color: var(--paper); margin-bottom: 12px;
  }
  .process-desc { font-size: 13px; color: rgba(255,255,255,0.4); line-height: 1.8; }

  /* ─── CONTACT ─── */
  #contact { padding: 140px 0; background: var(--paper); }
  .contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 100px; margin-top: 64px; align-items: start; }
  .contact-info h3 {
    font-family: var(--serif); font-size: 28px; font-weight: 300; margin-bottom: 16px;
  }
  .contact-info p { font-size: 15px; color: var(--ink-soft); line-height: 1.8; margin-bottom: 36px; }
  .contact-details { display: flex; flex-direction: column; gap: 16px; }
  .contact-detail {
    display: flex; gap: 20px; align-items: baseline;
    font-size: 14px;
  }
  .contact-detail-label {
    font-family: var(--mono); font-size: 10px; letter-spacing: 0.2em;
    color: var(--gold); text-transform: uppercase; width: 80px; flex-shrink: 0;
  }
  .contact-detail a { color: var(--ink-mid); text-decoration: none; transition: color 0.2s; }
  .contact-detail a:hover { color: var(--gold); }

  /* FORM */
  .contact-form { display: flex; flex-direction: column; gap: 24px; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
  .form-group { display: flex; flex-direction: column; gap: 8px; }
  .form-group label {
    font-family: var(--mono); font-size: 10px; letter-spacing: 0.2em;
    color: var(--ink-soft); text-transform: uppercase;
  }
  .form-group input,
  .form-group select,
  .form-group textarea {
    background: transparent; border: none; border-bottom: 1px solid var(--rule);
    padding: 12px 0; font-family: var(--sans); font-size: 14px; font-weight: 300;
    color: var(--ink); outline: none; transition: border-color 0.2s;
    width: 100%; appearance: none;
  }
  .form-group input:focus,
  .form-group select:focus,
  .form-group textarea:focus { border-bottom-color: var(--gold); }
  .form-group textarea { resize: vertical; min-height: 100px; }
  .form-group select { background: var(--paper); cursor: pointer; }
  .form-submit {
    font-family: var(--mono); font-size: 11px; letter-spacing: 0.2em;
    text-transform: uppercase; background: var(--ink); color: var(--paper);
    border: none; padding: 18px 40px; cursor: pointer;
    transition: background 0.25s; align-self: flex-start;
  }
  .form-submit:hover { background: var(--gold); }
  .form-msg {
    font-family: var(--mono); font-size: 12px; letter-spacing: 0.1em;
    padding: 14px 20px;
  }
  .form-msg.success { background: rgba(46,204,113,0.08); color: #2ecc71; border-left: 2px solid #2ecc71; }
  .form-msg.error { background: rgba(231,76,60,0.08); color: #e74c3c; border-left: 2px solid #e74c3c; }

  /* ─── FOOTER ─── */
  footer {
    background: var(--ink); padding: 56px 60px;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;
  }
  .footer-logo {
    font-family: var(--serif); font-size: 20px; font-weight: 300;
    letter-spacing: 0.1em; color: var(--paper);
  }
  .footer-logo span { color: var(--gold); }
  .footer-copy {
    font-family: var(--mono); font-size: 10px; letter-spacing: 0.15em;
    color: rgba(255,255,255,0.3); text-align: center;
  }
  .footer-links { display: flex; gap: 28px; }
  .footer-links a {
    font-family: var(--mono); font-size: 10px; letter-spacing: 0.15em;
    text-transform: uppercase; color: rgba(255,255,255,0.35); text-decoration: none;
    transition: color 0.2s;
  }
  .footer-links a:hover { color: var(--gold); }

  /* ─── ANIMATIONS ─── */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .reveal {
    opacity: 0; transform: translateY(30px);
    transition: opacity 0.7s ease, transform 0.7s ease;
  }
  .reveal.visible { opacity: 1; transform: translateY(0); }

  /* ─── RESPONSIVE ─── */
  @media (max-width: 900px) {
    nav { padding: 20px 28px; }
    nav.scrolled { padding: 14px 28px; }
    .nav-links { display: none; }
    #hero { padding: 100px 28px 60px; }
    .hero-grid-line { display: none; }
    .hero-stats { position: static; margin-top: 48px; justify-content: flex-start; }
    .section-inner { padding: 0 28px; }
    .about-grid, .services-grid, .projects-grid,
    .contact-grid, .process-grid { grid-template-columns: 1fr !important; }
    .saas-teaser { flex-direction: column; }
    .form-row { grid-template-columns: 1fr; }
    footer { flex-direction: column; text-align: center; padding: 40px 28px; }
    .process-step { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.06); }
  }
</style>
</head>
<body>

<div class="cursor-dot" id="cursorDot"></div>
<div class="cursor-ring" id="cursorRing"></div>

<!-- ─── NAV ─── -->
<nav id="mainNav">
  <a href="#hero" class="nav-logo">Ainika<span class="dot">·</span></a>
  <ul class="nav-links">
    <li><a href="#about">About</a></li>
    <li><a href="#services">Services</a></li>
    <li><a href="#projects">Projects</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
  <a href="#contact" class="nav-cta">Enquire</a>
</nav>

<!-- ─── HERO ─── -->
<section id="hero">
  <div class="hero-grid-line"></div>
  <div class="hero-grid-line"></div>
  <div class="hero-grid-line"></div>

  <div class="hero-eyebrow">AI Products &amp; Consulting</div>

  <h1 class="hero-title">
    AI&#8209;Powered Products.<br>
    <em>Human&#8209;Centred</em> Strategy.
  </h1>

  <p class="hero-tagline">
    Helping startups and enterprises translate data science into products that ship, scale, and matter.
  </p>

  <div class="hero-actions">
    <a href="#services" class="btn-primary">Our Services</a>
    <a href="#projects" class="btn-ghost">View Projects</a>
  </div>

  <div class="hero-scroll-hint">Scroll</div>

  <div class="hero-stats">
    <div class="stat-item">
      <span class="stat-num">10+</span>
      <span class="stat-label">Years Experience</span>
    </div>
    <div class="stat-item">
      <span class="stat-num">6</span>
      <span class="stat-label">Countries Delivered</span>
    </div>
    <div class="stat-item">
      <span class="stat-num">350k</span>
      <span class="stat-label">Users Served</span>
    </div>
  </div>
</section>

<!-- ─── ABOUT ─── -->
<section id="about">
  <div class="section-inner">
    <div class="section-label">Who We Are</div>
    <h2 class="section-title">Product thinking<br>meets <em>data science</em></h2>

    <div class="about-grid">
      <div class="about-text reveal">
        <p>Ainika is the consulting practice of <strong>Josen Joy</strong> — a Senior Product Owner and Business Analyst with over a decade of experience building AI/ML and SaaS products across fintech, enterprise automation, and digital transformation.</p>
        <p>With an <strong>MSc in Data Science &amp; Computational Intelligence</strong> from Coventry University, Josen bridges a gap that rarely gets bridged: deep technical literacy in machine learning alongside the product and stakeholder skills to actually ship things.</p>
        <p>We work with startups that need a sharp product mind, and enterprises navigating AI transformation that want someone who can talk to both the data science team and the C-suite.</p>

        <div class="about-credentials">
          <div class="credential">
            <span class="credential-year">2026</span>
            <span class="credential-text">MSc Data Science &amp; Computational Intelligence — Coventry University</span>
          </div>
          <div class="credential">
            <span class="credential-year">2024</span>
            <span class="credential-text">SAFe 5 Certified Product Owner / Product Manager</span>
          </div>
          <div class="credential">
            <span class="credential-year">2024</span>
            <span class="credential-text">Senior Product Owner — Publicis Re:Sources (AI/ML Accounts Payable platform)</span>
          </div>
          <div class="credential">
            <span class="credential-year">2021</span>
            <span class="credential-text">Product Owner — Digital Transformation &amp; Data Products (Equifax, RM plc)</span>
          </div>
        </div>
      </div>

      <div class="about-visual reveal">
        <div class="about-card">
          <div class="about-card-name">Josen Joy</div>
          <div class="about-card-title">Founder · Product Owner · AI/ML Strategist</div>
          <div class="about-card-tags">
            <span class="tag">AI/ML Products</span>
            <span class="tag">Data Science</span>
            <span class="tag">FinTech</span>
            <span class="tag">SAFe Agile</span>
            <span class="tag">Motorsport</span>
            <span class="tag">MedTech</span>
            <span class="tag">Python</span>
            <span class="tag">Power BI</span>
            <span class="tag">Azure DevOps</span>
          </div>
          <div class="about-links">
            <a href="https://linkedin.com/in/josenjoy" target="_blank" class="about-link">LinkedIn</a>
            <a href="https://github.com/ainikaventures" target="_blank" class="about-link">GitHub</a>
            <a href="mailto:hello@ainika.xyz" class="about-link">hello@ainika.xyz</a>
          </div>
          <div class="about-card-accent">A</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ─── SERVICES ─── -->
<section id="services">
  <div class="section-inner">
    <div class="services-header reveal">
      <div class="section-label">What We Do</div>
      <h2 class="section-title">Four ways we<br>can <em>work together</em></h2>
    </div>

    <div class="services-grid">
      <div class="service-card reveal">
        <span class="service-num">01</span>
        <span class="service-icon">🧠</span>
        <h3 class="service-title">AI/ML Product Strategy &amp; Roadmapping</h3>
        <p class="service-desc">Turn your data science capability into a product. We define what to build, in what order, and how to measure success — bridging ML teams and business stakeholders.</p>
        <ul class="service-deliverables">
          <li>AI product vision &amp; opportunity assessment</li>
          <li>Model-to-product integration roadmap</li>
          <li>ML feature prioritisation framework</li>
          <li>Stakeholder alignment workshops</li>
        </ul>
        <div class="service-card-bg">01</div>
      </div>

      <div class="service-card reveal">
        <span class="service-num">02</span>
        <span class="service-icon">📐</span>
        <h3 class="service-title">Business Analysis &amp; Requirements Engineering</h3>
        <p class="service-desc">Precise, unambiguous requirements that development teams can actually build from. From discovery to acceptance criteria — no gaps, no surprises.</p>
        <ul class="service-deliverables">
          <li>BRD / FRD documentation</li>
          <li>User story mapping &amp; backlog creation</li>
          <li>Process design &amp; gap analysis</li>
          <li>UAT planning &amp; sign-off support</li>
        </ul>
        <div class="service-card-bg">02</div>
      </div>

      <div class="service-card reveal">
        <span class="service-num">03</span>
        <span class="service-icon">📊</span>
        <h3 class="service-title">Data Product Consulting</h3>
        <p class="service-desc">From raw data to a product people pay for. We help you design the data layer, the product experience, and the commercial model — with real technical depth.</p>
        <ul class="service-deliverables">
          <li>Data product architecture &amp; scoping</li>
          <li>ETL workflow &amp; pipeline review</li>
          <li>BI &amp; analytics product design</li>
          <li>API integration strategy</li>
        </ul>
        <div class="service-card-bg">03</div>
      </div>

      <div class="service-card reveal">
        <span class="service-num">04</span>
        <span class="service-icon">⚡</span>
        <h3 class="service-title">Fractional Product Owner</h3>
        <p class="service-desc">A senior PO embedded in your team on a part-time basis. Ideal for early-stage startups that need product leadership without a full-time hire.</p>
        <ul class="service-deliverables">
          <li>Sprint planning &amp; backlog grooming</li>
          <li>Stakeholder management</li>
          <li>Product metrics &amp; KPI definition</li>
          <li>Agile ceremony facilitation</li>
        </ul>
        <div class="service-card-bg">04</div>
      </div>
    </div>
  </div>
</section>

<!-- ─── PROJECTS ─── -->
<section id="projects">
  <div class="section-inner">
    <div class="projects-header reveal">
      <div class="section-label">Our Work</div>
      <h2 class="section-title">Products built.<br><em>Problems solved.</em></h2>
    </div>

    <div class="projects-grid">

      <a href="https://toplisters.xyz" target="_blank" class="project-card reveal">
        <div class="project-card-num">01</div>
        <div class="project-status status-live">
          <span class="status-dot live"></span>Live
        </div>
        <div class="project-sector">Job Market · Intelligence Platform</div>
        <h3 class="project-title">TopListers</h3>
        <p class="project-desc">Privacy-first job market intelligence platform. Track applications via a Kanban board, submit anonymous job sightings, and explore global hiring trends with heatmaps and trend charts — all without compromising your privacy.</p>
        <div class="project-tech">
          <span class="tech-badge">Python</span>
          <span class="tech-badge">FastAPI</span>
          <span class="tech-badge">React</span>
          <span class="tech-badge">Supabase</span>
          <span class="tech-badge">Adzuna API</span>
        </div>
        <div class="project-cta">Visit toplisters.xyz →</div>
      </a>

      <a href="https://github.com/ainikaventures/splitai" target="_blank" class="project-card reveal">
        <div class="project-card-num">02</div>
        <div class="project-status status-building">
          <span class="status-dot building"></span>In Development
        </div>
        <div class="project-sector">FinTech · Expense Management</div>
        <h3 class="project-title">SplitAI</h3>
        <p class="project-desc">A smart expense splitting app that takes the awkwardness out of shared costs. Built with Flutter for iOS and Android, with a PHP backend — designed to make splitting bills effortless without ever asking for money.</p>
        <div class="project-tech">
          <span class="tech-badge">Flutter</span>
          <span class="tech-badge">Dart</span>
          <span class="tech-badge">PHP</span>
          <span class="tech-badge">iOS</span>
          <span class="tech-badge">Android</span>
        </div>
        <div class="project-cta">Follow Progress on GitHub →</div>
      </a>

      <a href="https://github.com/ainikaventures/2048" target="_blank" class="project-card reveal">
        <div class="project-card-num">03</div>
        <div class="project-status status-building">
          <span class="status-dot building"></span>In Development
        </div>
        <div class="project-sector">Gaming · Mobile App</div>
        <h3 class="project-title">2048 by Ainika</h3>
        <p class="project-desc">A beautifully crafted reimagination of the classic 2048 puzzle game. Features custom tile icons from your photo gallery, multiple themes, smooth animations, and fully offline play — built with Flutter for iOS and Android.</p>
        <div class="project-tech">
          <span class="tech-badge">Flutter</span>
          <span class="tech-badge">Dart</span>
          <span class="tech-badge">Provider</span>
          <span class="tech-badge">iOS</span>
          <span class="tech-badge">Android</span>
        </div>
        <div class="project-cta">Follow Progress on GitHub →</div>
      </a>

      <div class="saas-teaser reveal">
        <div class="saas-teaser-text">
          <h3>Three products — built in public.</h3>
          <p>We share our progress, thinking, and code as we go. Follow the journey on GitHub and LinkedIn as these products evolve from prototype to production.</p>
        </div>
        <a href="https://github.com/ainikaventures" target="_blank" class="saas-teaser-cta">Follow on GitHub →</a>
      </div>

    </div>
  </div>
</section>

<!-- ─── PROCESS ─── -->
<section id="process">
  <div class="section-inner">
    <div class="section-label reveal">How We Work</div>
    <h2 class="section-title reveal">A clear process.<br><em>No ambiguity.</em></h2>
    <div class="process-grid">
      <div class="process-step reveal">
        <span class="process-step-num">01</span>
        <h3 class="process-title">Discovery</h3>
        <p class="process-desc">A focused conversation to understand your problem, your data, and where you want to go. No jargon, no assumptions.</p>
      </div>
      <div class="process-step reveal">
        <span class="process-step-num">02</span>
        <h3 class="process-title">Define</h3>
        <p class="process-desc">We map the solution space — requirements, constraints, success metrics — and align stakeholders before a single line of code is written.</p>
      </div>
      <div class="process-step reveal">
        <span class="process-step-num">03</span>
        <h3 class="process-title">Deliver</h3>
        <p class="process-desc">Iterative delivery in short cycles with clear milestones. You see progress weekly, not at the end of six months.</p>
      </div>
      <div class="process-step reveal">
        <span class="process-step-num">04</span>
        <h3 class="process-title">Evolve</h3>
        <p class="process-desc">Post-launch isn't the end. We help you measure, learn, and continuously improve the product as your users and data grow.</p>
      </div>
    </div>
  </div>
</section>

<!-- ─── CONTACT ─── -->
<section id="contact">
  <div class="section-inner">
    <div class="section-label reveal">Get In Touch</div>
    <h2 class="section-title reveal">Let's build something<br><em>worth building.</em></h2>

    <div class="contact-grid">
      <div class="contact-info reveal">
        <h3>Start with a conversation.</h3>
        <p>Whether you need a fractional PO, an AI product strategy, or just want to explore what's possible with your data — reach out. First call is always free.</p>
        <div class="contact-details">
          <div class="contact-detail">
            <span class="contact-detail-label">Email</span>
            <a href="mailto:hello@ainika.xyz">hello@ainika.xyz</a>
          </div>
          <div class="contact-detail">
            <span class="contact-detail-label">LinkedIn</span>
            <a href="https://linkedin.com/in/josenjoy" target="_blank">linkedin.com/in/josenjoy</a>
          </div>
          <div class="contact-detail">
            <span class="contact-detail-label">GitHub</span>
            <a href="https://github.com/ainikaventures" target="_blank">github.com/ainikaventures</a>
          </div>
          <div class="contact-detail">
            <span class="contact-detail-label">Based</span>
            <span style="color:var(--ink-mid)">Coventry, UK · Available globally</span>
          </div>
        </div>
      </div>

      <div class="reveal">
        <?php if ($form_success): ?>
          <div class="form-msg success">Thank you — your message has been received. We'll be in touch within 24 hours.</div>
        <?php elseif ($form_error): ?>
          <div class="form-msg error">Something went wrong. Please email hello@ainika.xyz directly.</div>
        <?php endif; ?>

        <form class="contact-form" method="POST" action="#contact">
          <div class="form-row">
            <div class="form-group">
              <label for="name">Your Name</label>
              <input type="text" id="name" name="name" required placeholder="Jane Smith">
            </div>
            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" id="email" name="email" required placeholder="jane@company.com">
            </div>
          </div>
          <div class="form-group">
            <label for="service">Service of Interest</label>
            <select id="service" name="service">
              <option value="">Select a service...</option>
              <option>AI/ML Product Strategy &amp; Roadmapping</option>
              <option>Business Analysis &amp; Requirements Engineering</option>
              <option>Data Product Consulting</option>
              <option>Fractional Product Owner</option>
              <option>General Enquiry</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message">Tell Us About Your Project</label>
            <textarea id="message" name="message" required placeholder="Give us a brief overview of what you're building or the problem you're trying to solve..."></textarea>
          </div>
          <button type="submit" name="contact_submit" class="form-submit">Send Enquiry →</button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ─── FOOTER ─── -->
<footer>
  <div class="footer-logo">Ainika<span>·</span></div>
  <div class="footer-copy">© <?php echo date('Y'); ?> Ainika. All rights reserved.</div>
  <div class="footer-links">
    <a href="https://linkedin.com/in/josenjoy" target="_blank">LinkedIn</a>
    <a href="https://github.com/ainikaventures" target="_blank">GitHub</a>
    <a href="mailto:hello@ainika.xyz">Email</a>
  </div>
</footer>

<script>
// ── CURSOR
const dot  = document.getElementById('cursorDot');
const ring = document.getElementById('cursorRing');
let mx = 0, my = 0, rx = 0, ry = 0;
document.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; });
(function animCursor() {
  rx += (mx - rx) * 0.14; ry += (my - ry) * 0.14;
  dot.style.left  = mx + 'px'; dot.style.top  = my + 'px';
  ring.style.left = rx + 'px'; ring.style.top = ry + 'px';
  requestAnimationFrame(animCursor);
})();
document.querySelectorAll('a, button, .service-card, .project-card').forEach(el => {
  el.addEventListener('mouseenter', () => ring.classList.add('hover'));
  el.addEventListener('mouseleave', () => ring.classList.remove('hover'));
});

// ── NAV SCROLL
const nav = document.getElementById('mainNav');
window.addEventListener('scroll', () => {
  nav.classList.toggle('scrolled', window.scrollY > 60);
});

// ── REVEAL ON SCROLL
const reveals = document.querySelectorAll('.reveal');
const obs = new IntersectionObserver((entries) => {
  entries.forEach((e, i) => {
    if (e.isIntersecting) {
      setTimeout(() => e.target.classList.add('visible'), i * 80);
      obs.unobserve(e.target);
    }
  });
}, { threshold: 0.1 });
reveals.forEach(r => obs.observe(r));
</script>
</body>
</html>

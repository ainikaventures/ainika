<?php
session_start();

if (!isset($_SESSION['captcha_a']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['captcha_a'] = rand(1, 9);
    $_SESSION['captcha_b'] = rand(1, 9);
}

$form_success = false;
$form_error = false;
$form_bot = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    if (!empty($_POST['website_url'])) {
        $form_bot = true;
    }

    $captcha_answer = intval($_POST['captcha'] ?? 0);
    $captcha_expected = ($_SESSION['captcha_a'] ?? 0) + ($_SESSION['captcha_b'] ?? 0);
    if ($captcha_answer !== $captcha_expected) {
        $form_error = 'verify';
    }

    if (!$form_bot && !$form_error) {
        $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
        $email   = htmlspecialchars(trim($_POST['email'] ?? ''));
        $service = htmlspecialchars(trim($_POST['service'] ?? ''));
        $message = htmlspecialchars(trim($_POST['message'] ?? ''));

        if ($name && $email && $message && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $to      = 'hello@ainika.xyz';
            $subject = "ainika. enquiry from $name – $service";
            $body    = "Name: $name\nEmail: $email\nService: $service\n\nMessage:\n$message";
            $headers = "From: noreply@ainika.xyz\r\nReply-To: $email\r\nX-Mailer: PHP/" . phpversion();
            $form_success = mail($to, $subject, $body, $headers);
            if (!$form_success) $form_error = 'send';
        } else {
            $form_error = 'fields';
        }
    }

    $_SESSION['captcha_a'] = rand(1, 9);
    $_SESSION['captcha_b'] = rand(1, 9);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>ainika. — AI-powered products. Human-centred strategy.</title>
<meta name="description" content="ainika. is the consulting practice of Josen Joy — Senior Product Owner and AI/ML strategist. We help startups and enterprises translate data science into products that ship.">
<link rel="canonical" href="https://ainika.xyz/">

<link rel="icon" type="image/svg+xml" href="/brand/ainika-favicon.svg">
<link rel="alternate icon" href="/brand/ainika-favicon-32.png">
<link rel="apple-touch-icon" href="/brand/ainika-apple-touch.svg">

<meta property="og:title" content="ainika.">
<meta property="og:description" content="AI-powered products. Human-centred strategy.">
<meta property="og:image" content="https://ainika.xyz/brand/ainika-og.svg">
<meta property="og:type" content="website">
<meta property="og:url" content="https://ainika.xyz">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="ainika.">
<meta name="twitter:description" content="AI-powered products. Human-centred strategy.">
<meta name="twitter:image" content="https://ainika.xyz/brand/ainika-og.svg">

<meta name="theme-color" content="#FAFAF7">
<meta name="robots" content="index, follow">
<meta name="author" content="Josen Joy">
<meta name="msvalidate.01" content="37732678DBE45B49903B790E524316AC">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-QJCQB8Y65N"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-QJCQB8Y65N');
</script>

<!-- Microsoft Clarity -->
<script type="text/javascript">
  (function(c,l,a,r,i,t,y){
    c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
    t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
    y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
  })(window, document, "clarity", "script", "wq6kitujjx");
</script>

<style>
  :root {
    --ink:    #0E0E10;
    --paper:  #FAFAF7;
    --signal: #FF5B2E;
    --smoke:  #F1EFEA;
    --line:   rgba(14,14,16,0.08);
    --muted:  rgba(14,14,16,0.55);
    --paper-soft: rgba(250,250,247,0.72);
    --paper-muted: rgba(250,250,247,0.55);

    --font-display: 'Outfit', system-ui, -apple-system, sans-serif;
    --font-body:    'Inter',  system-ui, -apple-system, sans-serif;
    --font-mono:    'JetBrains Mono', ui-monospace, monospace;

    --radius-sm:  8px;
    --radius-md: 14px;
    --radius-lg: 24px;

    --pad: clamp(20px, 5vw, 96px);
  }

  *,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }
  html { scroll-behavior: smooth; }
  body {
    font-family: var(--font-body); color: var(--ink); background: var(--paper);
    font-size: 16px; line-height: 1.6; -webkit-font-smoothing: antialiased;
    text-rendering: optimizeLegibility;
  }
  img, svg { display: block; max-width: 100%; height: auto; }
  a { color: inherit; text-decoration: none; }
  ::selection { background: var(--signal); color: var(--paper); }
  :focus-visible { outline: 2px solid var(--signal); outline-offset: 2px; border-radius: 2px; }

  /* ─── NAV ─── */
  .nav {
    position: fixed; top: 0; left: 0; right: 0; height: 64px; z-index: 50;
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 var(--pad);
    background: transparent; color: var(--paper);
    transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    border-bottom: 1px solid transparent;
  }
  .nav.is-scrolled {
    background: var(--paper-soft);
    backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    color: var(--ink); border-bottom-color: var(--line);
  }
  .nav-wordmark {
    font-family: var(--font-display); font-weight: 700; font-size: 22px;
    letter-spacing: -0.04em; line-height: 1;
  }
  .nav-wordmark .dot { color: var(--signal); }
  .nav-links { display: flex; gap: 28px; align-items: center; }
  .nav-links a {
    font-family: var(--font-mono); font-size: 12px; letter-spacing: 0.04em;
    color: inherit; opacity: 0.75; transition: opacity 0.2s;
  }
  .nav-links a:hover { opacity: 1; }
  .nav-cta {
    font-family: var(--font-mono); font-size: 12px; letter-spacing: 0.04em;
    padding: 8px 16px; border-radius: 999px;
    background: var(--signal); color: var(--ink);
    transition: transform 0.2s ease;
  }
  .nav-cta:hover { transform: translateY(-1px); }
  @media (max-width: 720px) {
    .nav-links a:not(.nav-cta) { display: none; }
  }

  /* ─── HERO ─── */
  .hero {
    background: var(--ink); color: var(--paper);
    min-height: 100vh; min-height: 100svh;
    display: flex; flex-direction: column; justify-content: center;
    padding: 120px var(--pad) 80px;
    position: relative; overflow: hidden;
  }
  .hero-kicker {
    position: absolute; top: 88px; left: var(--pad);
    font-family: var(--font-mono); font-size: 12px; letter-spacing: 0.08em;
    color: var(--paper-muted);
  }
  .wordmark {
    font-family: var(--font-display); font-weight: 700;
    font-size: clamp(64px, 14vw, 220px);
    letter-spacing: -0.04em; line-height: 1;
    white-space: nowrap; color: var(--paper);
    margin-bottom: 40px;
  }
  .wordmark .dot { color: var(--signal); animation: blink 1s step-end infinite; }
  .wordmark .suffix {
    display: inline-block; overflow: hidden; vertical-align: bottom;
    max-width: 6em;
    animation: collapse 10s cubic-bezier(0.65, 0, 0.35, 1) infinite;
  }
  @keyframes blink    { 0%, 50%, 100% { opacity: 1; } 25%, 75% { opacity: 0.15; } }
  @keyframes collapse {
    0%, 50%  { max-width: 6em; opacity: 1; }
    55%, 95% { max-width: 0;   opacity: 0; }
    100%     { max-width: 6em; opacity: 1; }
  }
  .hero-sub {
    font-family: var(--font-display); font-weight: 600;
    font-size: clamp(28px, 4.4vw, 48px);
    letter-spacing: -0.025em; line-height: 1.15;
    max-width: 22ch; margin-bottom: 24px;
  }
  .hero-sub em { font-style: normal; color: var(--signal); }
  .hero-tagline {
    font-family: var(--font-body); font-weight: 400;
    font-size: clamp(15px, 1.4vw, 18px); line-height: 1.55;
    color: var(--paper-muted); max-width: 56ch; margin-bottom: 48px;
  }
  .hero-actions { display: flex; gap: 16px; flex-wrap: wrap; }
  .cta-pill {
    display: inline-flex; align-items: center; gap: 12px;
    height: 56px; padding: 0 28px; border-radius: 999px;
    background: var(--signal); color: var(--ink);
    font-family: var(--font-display); font-weight: 600; font-size: 17px;
    letter-spacing: -0.01em;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .cta-pill:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(255,91,46,0.3); }
  .cta-pill .arrow { transition: transform 0.2s ease; }
  .cta-pill:hover .arrow { transform: translateX(4px); }
  .cta-ghost {
    display: inline-flex; align-items: center; gap: 12px;
    height: 56px; padding: 0 28px; border-radius: 999px;
    background: transparent; color: var(--paper);
    border: 1px solid rgba(250,250,247,0.25);
    font-family: var(--font-display); font-weight: 600; font-size: 17px;
    letter-spacing: -0.01em;
    transition: border-color 0.2s ease, color 0.2s ease;
  }
  .cta-ghost:hover { border-color: var(--signal); color: var(--signal); }

  .hero-stats {
    display: flex; gap: clamp(32px, 5vw, 64px); margin-top: 72px; flex-wrap: wrap;
    padding-top: 32px; border-top: 1px solid rgba(250,250,247,0.12);
    max-width: 720px;
  }
  .stat-num {
    display: block; font-family: var(--font-display); font-weight: 700;
    font-size: clamp(32px, 4vw, 48px); letter-spacing: -0.03em; line-height: 1;
    color: var(--paper); margin-bottom: 8px;
  }
  .stat-num .dot { color: var(--signal); }
  .stat-label {
    font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.08em;
    color: var(--paper-muted); text-transform: lowercase;
  }

  /* ─── SECTION SCAFFOLD ─── */
  .section {
    padding: clamp(96px, 12vw, 160px) var(--pad);
  }
  .section.is-smoke { background: var(--smoke); }
  .section.is-paper { background: var(--paper); }

  .section-head {
    display: flex; flex-direction: column; gap: 12px; margin-bottom: 64px;
  }
  .section-kicker {
    font-family: var(--font-mono); font-size: 12px; letter-spacing: 0.08em;
    color: var(--signal);
  }
  .section-title {
    font-family: var(--font-display); font-weight: 700;
    font-size: clamp(36px, 5.4vw, 64px);
    letter-spacing: -0.035em; line-height: 1.05;
    max-width: 20ch;
  }
  .section-title em { font-style: normal; color: var(--signal); }

  /* ─── ABOUT ─── */
  .about-grid {
    display: grid; grid-template-columns: 1.2fr 1fr; gap: clamp(40px, 6vw, 96px);
    align-items: start;
  }
  .about-text p {
    font-size: 17px; line-height: 1.7; margin-bottom: 20px; max-width: 60ch;
  }
  .about-text strong { font-weight: 600; }
  .about-credentials {
    margin-top: 40px; display: flex; flex-direction: column; gap: 12px;
  }
  .credential {
    display: grid; grid-template-columns: 80px 1fr; gap: 16px;
    padding-bottom: 16px; border-bottom: 1px solid var(--line);
    align-items: baseline;
  }
  .credential-year {
    font-family: var(--font-mono); font-size: 12px; letter-spacing: 0.08em;
    color: var(--signal);
  }
  .credential-text {
    font-family: var(--font-body); font-size: 15px; line-height: 1.5; color: var(--ink);
  }
  .about-card {
    background: var(--ink); color: var(--paper);
    border-radius: var(--radius-md); padding: 40px 32px;
    position: sticky; top: 96px;
  }
  .about-card-name {
    font-family: var(--font-display); font-weight: 700;
    font-size: 32px; letter-spacing: -0.03em; line-height: 1.05;
    margin-bottom: 8px;
  }
  .about-card-name .dot { color: var(--signal); }
  .about-card-title {
    font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.08em;
    color: var(--paper-muted); margin-bottom: 28px;
  }
  .about-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 28px; }
  .tag {
    font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.04em;
    padding: 6px 12px; border-radius: 999px;
    background: rgba(250,250,247,0.08); color: var(--paper);
  }
  .about-links { display: flex; flex-direction: column; gap: 12px; }
  .about-link {
    font-family: var(--font-display); font-weight: 500; font-size: 15px;
    color: var(--paper); padding-bottom: 6px;
    border-bottom: 1px solid rgba(250,250,247,0.18);
    transition: border-color 0.2s, color 0.2s;
  }
  .about-link:hover { border-color: var(--signal); color: var(--signal); }
  @media (max-width: 900px) {
    .about-grid { grid-template-columns: 1fr; }
    .about-card { position: static; }
  }

  /* ─── SERVICES ─── */
  .services-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 24px;
  }
  .service-card {
    background: var(--paper); border-radius: var(--radius-md);
    padding: 40px 36px; display: flex; flex-direction: column; gap: 16px;
    position: relative; overflow: hidden;
  }
  .service-num {
    font-family: var(--font-mono); font-size: 12px; letter-spacing: 0.08em;
    color: var(--signal);
  }
  .service-title {
    font-family: var(--font-display); font-weight: 600;
    font-size: clamp(22px, 2.4vw, 28px); letter-spacing: -0.02em; line-height: 1.2;
  }
  .service-desc { font-size: 15px; line-height: 1.65; color: var(--muted); }
  .service-deliverables {
    list-style: none; padding: 0; margin-top: 8px;
    display: flex; flex-direction: column; gap: 8px;
  }
  .service-deliverables li {
    font-family: var(--font-body); font-size: 14px; line-height: 1.5; color: var(--ink);
    padding-left: 20px; position: relative;
  }
  .service-deliverables li::before {
    content: ''; position: absolute; left: 0; top: 9px;
    width: 6px; height: 6px; border-radius: 50%; background: var(--signal);
  }
  @media (max-width: 900px) {
    .services-grid { grid-template-columns: 1fr; }
  }

  /* ─── PROJECTS ─── */
  .work-list {
    display: flex; flex-direction: column; gap: clamp(48px, 8vw, 96px);
  }
  .work-tile {
    display: grid; grid-template-columns: 5fr 6fr; gap: clamp(32px, 6vw, 80px);
    align-items: center;
  }
  .work-tile.flip .work-thumb { order: 2; }
  .work-thumb {
    background: var(--ink); color: var(--paper);
    border-radius: var(--radius-md);
    aspect-ratio: 4 / 3;
    display: flex; align-items: center; justify-content: center;
    position: relative; overflow: hidden; padding: 40px;
  }
  .work-thumb.is-smoke { background: var(--smoke); color: var(--ink); }
  .work-thumb.is-toplisters { background: #1F6FEB; color: #F6F4EE; }
  .work-thumb.is-toplisters .work-status { color: rgba(246,244,238,0.75); }
  .work-thumb.is-toplisters .status-dot.is-live { background: #D4F564; box-shadow: 0 0 0 3px rgba(212,245,100,0.18); }
  .work-thumb-title {
    font-family: var(--font-display); font-weight: 700;
    font-size: clamp(40px, 6vw, 80px);
    letter-spacing: -0.035em; line-height: 1;
    text-align: center;
  }
  .work-thumb-title .dot { color: var(--signal); }
  .toplisters-brand {
    display: flex; flex-direction: column; align-items: center; gap: 22px;
  }
  .toplisters-mark {
    width: clamp(90px, 14vw, 140px); height: auto; display: block;
  }
  .toplisters-word {
    font-family: var(--font-display); font-weight: 700;
    font-size: clamp(40px, 6vw, 72px);
    letter-spacing: -0.04em; line-height: 1;
    color: #F6F4EE;
  }
  .toplisters-word .dot { color: #D4F564; }
  .work-status {
    position: absolute; top: 20px; left: 20px;
    font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.08em;
    display: inline-flex; align-items: center; gap: 8px;
    color: var(--paper-muted);
  }
  .work-thumb.is-smoke .work-status { color: var(--muted); }
  .status-dot {
    width: 6px; height: 6px; border-radius: 50%; background: var(--muted);
  }
  .status-dot.is-live { background: var(--signal); }

  .work-meta {
    font-family: var(--font-mono); font-size: 12px; letter-spacing: 0.08em;
    color: var(--muted); margin-bottom: 16px;
  }
  .work-title {
    font-family: var(--font-display); font-weight: 700;
    font-size: clamp(28px, 3.6vw, 42px); letter-spacing: -0.03em; line-height: 1.1;
    margin-bottom: 16px;
  }
  .work-desc {
    font-size: 16px; line-height: 1.65; color: var(--ink);
    margin-bottom: 20px; max-width: 42ch;
  }
  .work-tech { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 24px; }
  .tech-badge {
    font-family: var(--font-mono); font-size: 10px; letter-spacing: 0.04em;
    padding: 4px 10px; border-radius: 999px;
    background: var(--smoke); color: var(--muted);
  }
  .work-links { display: flex; gap: 20px; align-items: center; flex-wrap: wrap; }
  .work-link {
    font-family: var(--font-display); font-weight: 600; font-size: 15px;
    display: inline-flex; align-items: center; gap: 8px;
    padding-bottom: 4px; border-bottom: 1px solid var(--ink);
    transition: gap 0.2s, border-color 0.2s;
  }
  .work-link:hover { gap: 14px; border-color: var(--signal); }
  .work-link.is-secondary {
    font-family: var(--font-mono); font-size: 12px; letter-spacing: 0.04em;
    color: var(--muted); border-bottom-color: var(--line);
  }
  .work-link.is-secondary:hover { color: var(--ink); border-bottom-color: var(--ink); }
  @media (max-width: 800px) {
    .work-tile, .work-tile.flip { grid-template-columns: 1fr; }
    .work-tile.flip .work-thumb { order: 0; }
  }

  /* ─── PROCESS ─── */
  .process-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;
  }
  .process-step {
    display: flex; flex-direction: column; gap: 16px;
    padding: 32px 24px 32px 0;
    border-right: 1px solid var(--line);
  }
  .process-step:last-child { border-right: none; }
  .process-num {
    font-family: var(--font-mono); font-size: 12px; letter-spacing: 0.08em;
    color: var(--signal);
  }
  .process-title {
    font-family: var(--font-display); font-weight: 600;
    font-size: clamp(22px, 2vw, 26px); letter-spacing: -0.02em; line-height: 1.2;
  }
  .process-desc { font-size: 14px; line-height: 1.65; color: var(--muted); }
  @media (max-width: 900px) {
    .process-grid { grid-template-columns: 1fr 1fr; }
    .process-step:nth-child(2n) { border-right: none; }
  }
  @media (max-width: 560px) {
    .process-grid { grid-template-columns: 1fr; }
    .process-step { border-right: none; border-bottom: 1px solid var(--line); padding: 24px 0; }
    .process-step:last-child { border-bottom: none; }
  }

  /* ─── CONTACT ─── */
  .contact-grid {
    display: grid; grid-template-columns: 1fr 1.2fr; gap: clamp(40px, 6vw, 80px);
    align-items: start;
  }
  .contact-info h3 {
    font-family: var(--font-display); font-weight: 600;
    font-size: clamp(22px, 2.4vw, 28px); letter-spacing: -0.02em;
    margin-bottom: 16px;
  }
  .contact-info p {
    font-size: 16px; line-height: 1.65; color: var(--muted); max-width: 36ch;
    margin-bottom: 32px;
  }
  .contact-details { display: flex; flex-direction: column; gap: 16px; }
  .contact-detail {
    display: grid; grid-template-columns: 100px 1fr; gap: 16px;
    padding-bottom: 14px; border-bottom: 1px solid var(--line);
    align-items: baseline;
  }
  .contact-detail-label {
    font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.08em;
    color: var(--muted);
  }
  .contact-detail a, .contact-detail span {
    font-family: var(--font-display); font-weight: 500; font-size: 16px;
    color: var(--ink);
  }
  .contact-detail a:hover { color: var(--signal); }

  .contact-form {
    background: var(--smoke); border-radius: var(--radius-md);
    padding: 40px;
    display: flex; flex-direction: column; gap: 20px;
  }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
  .form-group { display: flex; flex-direction: column; gap: 8px; }
  .form-group label {
    font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.08em;
    color: var(--muted);
  }
  .form-group input, .form-group select, .form-group textarea {
    font-family: var(--font-body); font-size: 15px;
    background: var(--paper); color: var(--ink);
    border: 1px solid var(--line); border-radius: var(--radius-sm);
    padding: 12px 14px; line-height: 1.4;
    transition: border-color 0.2s ease;
  }
  .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
    outline: none; border-color: var(--signal);
  }
  .form-group textarea { min-height: 140px; resize: vertical; }
  .form-submit {
    display: inline-flex; align-items: center; justify-content: center; gap: 10px;
    height: 56px; padding: 0 28px; border: none; border-radius: 999px;
    background: var(--signal); color: var(--ink);
    font-family: var(--font-display); font-weight: 600; font-size: 17px;
    letter-spacing: -0.01em; cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    align-self: flex-start;
  }
  .form-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(255,91,46,0.3); }
  .form-msg {
    padding: 14px 18px; border-radius: var(--radius-sm);
    font-family: var(--font-body); font-size: 14px; line-height: 1.5;
  }
  .form-msg.success { background: rgba(255,91,46,0.08); color: var(--ink); border: 1px solid var(--signal); }
  .form-msg.error   { background: rgba(14,14,16,0.04); color: var(--ink); border: 1px solid var(--line); }
  @media (max-width: 900px) {
    .contact-grid { grid-template-columns: 1fr; }
    .form-row { grid-template-columns: 1fr; }
    .contact-form { padding: 28px; }
  }

  /* ─── FOOTER ─── */
  .footer {
    background: var(--ink); color: var(--paper);
    padding: clamp(96px, 12vw, 160px) var(--pad) 48px;
  }
  .footer-lead {
    font-family: var(--font-display); font-weight: 700;
    font-size: clamp(48px, 8vw, 120px);
    letter-spacing: -0.04em; line-height: 0.95;
    margin-bottom: 48px; max-width: 18ch;
  }
  .footer-lead .dot { color: var(--signal); }
  .footer-email {
    font-family: var(--font-display); font-weight: 500;
    font-size: clamp(22px, 3vw, 36px); letter-spacing: -0.02em;
    display: inline-block; padding-bottom: 8px;
    border-bottom: 1px solid var(--paper-muted);
    transition: border-color 0.2s ease;
  }
  .footer-email:hover { border-bottom-color: var(--signal); }
  .footer-socials {
    display: flex; gap: 28px; margin-top: 40px;
    font-family: var(--font-display); font-weight: 500; font-size: 17px;
  }
  .footer-socials a {
    padding-bottom: 4px; border-bottom: 1px solid transparent;
    transition: border-color 0.2s ease;
  }
  .footer-socials a:hover { border-bottom-color: var(--signal); }
  .footer-bottom {
    display: flex; justify-content: space-between; gap: 24px; flex-wrap: wrap;
    margin-top: clamp(80px, 12vw, 140px); padding-top: 32px;
    border-top: 1px solid rgba(250,250,247,0.12);
    font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.08em;
    color: var(--paper-muted);
  }

  /* ─── CURSOR DOT ─── */
  .cursor-dot {
    position: fixed; top: 0; left: 0;
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--signal); pointer-events: none; z-index: 100;
    transform: translate3d(-100px, -100px, 0);
    transition: transform 80ms linear, opacity 0.2s ease;
    mix-blend-mode: difference;
  }
  @media (hover: none), (pointer: coarse) {
    .cursor-dot { display: none; }
  }

  /* ─── REDUCE MOTION ─── */
  @media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
      animation-duration: 0.001ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.001ms !important;
      scroll-behavior: auto !important;
    }
    .wordmark .dot, .wordmark .suffix { animation: none; }
    .cursor-dot { display: none; }
  }

  .sr-only {
    position: absolute; width: 1px; height: 1px;
    padding: 0; margin: -1px; overflow: hidden;
    clip: rect(0,0,0,0); white-space: nowrap; border: 0;
  }

  /* ─── COOKIE NOTICE ─── */
  .cookie-bar {
    position: fixed; bottom: 16px; left: 50%; transform: translateX(-50%);
    z-index: 60; max-width: calc(100% - 32px);
    background: var(--ink); color: var(--paper);
    border: 1px solid rgba(250,250,247,0.12);
    border-radius: 999px;
    padding: 10px 10px 10px 20px;
    display: none; align-items: center; gap: 16px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.18);
  }
  .cookie-bar.is-visible { display: inline-flex; }
  .cookie-bar p {
    font-family: var(--font-mono); font-size: 12px; letter-spacing: 0.04em;
    color: var(--paper-muted); margin: 0; white-space: nowrap;
  }
  .cookie-bar .dot { color: var(--signal); }
  .cookie-bar button {
    font-family: var(--font-mono); font-size: 12px; letter-spacing: 0.04em;
    background: var(--signal); color: var(--ink);
    border: none; padding: 8px 16px; border-radius: 999px;
    cursor: pointer; transition: transform 0.2s ease;
  }
  .cookie-bar button:hover { transform: translateY(-1px); }
  @media (max-width: 640px) {
    .cookie-bar {
      border-radius: var(--radius-md);
      padding: 14px 14px 14px 18px;
      gap: 12px;
      left: 16px; right: 16px; transform: none;
      max-width: none;
    }
    .cookie-bar p { font-size: 11px; white-space: normal; line-height: 1.4; flex: 1; }
    .cookie-bar button { white-space: nowrap; flex-shrink: 0; }
  }
</style>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ProfessionalService",
  "name": "ainika.",
  "url": "https://ainika.xyz",
  "description": "AI-powered products and human-centred strategy. Product consulting, AI/ML strategy, business analysis, and data product consulting.",
  "founder": {
    "@type": "Person",
    "name": "Josen Joy",
    "jobTitle": "Senior Product Owner & AI/ML Strategist",
    "url": "https://linkedin.com/in/josenjoy",
    "sameAs": [
      "https://linkedin.com/in/josenjoy",
      "https://github.com/ainikaventures"
    ]
  },
  "email": "hello@ainika.xyz",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "Coventry",
    "addressCountry": "GB"
  },
  "areaServed": "Worldwide",
  "knowsAbout": ["AI/ML Products", "Data Science", "Product Management", "Business Analysis", "FinTech", "SaaS"],
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "Consulting Services",
    "itemListElement": [
      {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "AI/ML Product Strategy & Roadmapping"}},
      {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Business Analysis & Requirements Engineering"}},
      {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Data Product Consulting"}},
      {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Fractional Product Owner"}}
    ]
  },
  "sameAs": [
    "https://linkedin.com/in/josenjoy",
    "https://github.com/ainikaventures"
  ]
}
</script>
</head>
<body>

<div class="cursor-dot" id="cursorDot" aria-hidden="true"></div>

<nav class="nav" id="nav" aria-label="primary">
  <a href="#top" class="nav-wordmark" aria-label="ainika.">ainika<span class="dot">.</span></a>
  <div class="nav-links">
    <a href="#about">about</a>
    <a href="#services">services</a>
    <a href="#projects">projects</a>
    <a href="/blog/">writing</a>
    <a href="#contact" class="nav-cta">start a conversation</a>
  </div>
</nav>

<section class="hero" id="top">
  <div class="hero-kicker">ainika · ai products &amp; consulting</div>
  <div class="wordmark" aria-label="ainika."><span>ai</span><span class="suffix">nika</span><span class="dot">.</span></div>
  <h1 class="hero-sub">AI-powered products<span class="dot" style="color:var(--signal)">.</span><br><em>Human-centred</em> strategy<span class="dot" style="color:var(--signal)">.</span></h1>
  <p class="hero-tagline">Helping startups and enterprises translate data science into products that ship, scale, and matter.</p>
  <div class="hero-actions">
    <a href="#services" class="cta-pill">our services <span class="arrow">→</span></a>
    <a href="#projects" class="cta-ghost">view projects</a>
  </div>
  <div class="hero-stats">
    <div>
      <span class="stat-num">10+<span class="dot">.</span></span>
      <span class="stat-label">years experience</span>
    </div>
    <div>
      <span class="stat-num">6<span class="dot">.</span></span>
      <span class="stat-label">countries delivered</span>
    </div>
    <div>
      <span class="stat-num">350k<span class="dot">.</span></span>
      <span class="stat-label">users served</span>
    </div>
  </div>
</section>

<section class="section is-paper" id="about">
  <div class="section-head">
    <span class="section-kicker">§ who we are</span>
    <h2 class="section-title">Product thinking<br>meets <em>data science</em>.</h2>
  </div>
  <div class="about-grid">
    <div class="about-text">
      <p>ainika. is the consulting practice of <strong>Josen Joy</strong> — a Senior Product Owner and Business Analyst with over a decade of experience building AI/ML and SaaS products across fintech, enterprise automation, and digital transformation.</p>
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
          <span class="credential-text">Senior Product Owner — Publicis Re:Sources (AI/ML accounts-payable platform)</span>
        </div>
        <div class="credential">
          <span class="credential-year">2021</span>
          <span class="credential-text">Product Owner — digital transformation &amp; data products (Equifax, RM plc)</span>
        </div>
      </div>
    </div>

    <aside class="about-card">
      <div class="about-card-name">Josen Joy<span class="dot">.</span></div>
      <div class="about-card-title">founder · product owner · ai/ml strategist</div>
      <div class="about-tags">
        <span class="tag">AI/ML</span>
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
        <a href="https://linkedin.com/in/josenjoy" target="_blank" rel="noopener" class="about-link">linkedin ↗</a>
        <a href="https://github.com/ainikaventures" target="_blank" rel="noopener" class="about-link">github ↗</a>
        <a href="mailto:hello@ainika.xyz" class="about-link">hello@ainika.xyz</a>
      </div>
    </aside>
  </div>
</section>

<section class="section is-smoke" id="services">
  <div class="section-head">
    <span class="section-kicker">§ what we do</span>
    <h2 class="section-title">Four ways we<br>can <em>work together</em>.</h2>
  </div>
  <div class="services-grid">
    <article class="service-card">
      <span class="service-num">01 · strategy</span>
      <h3 class="service-title">AI/ML Product Strategy &amp; Roadmapping</h3>
      <p class="service-desc">Turn your data science capability into a product. We define what to build, in what order, and how to measure success — bridging ML teams and business stakeholders.</p>
      <ul class="service-deliverables">
        <li>AI product vision &amp; opportunity assessment</li>
        <li>Model-to-product integration roadmap</li>
        <li>ML feature prioritisation framework</li>
        <li>Stakeholder alignment workshops</li>
      </ul>
    </article>

    <article class="service-card">
      <span class="service-num">02 · requirements</span>
      <h3 class="service-title">Business Analysis &amp; Requirements Engineering</h3>
      <p class="service-desc">Precise, unambiguous requirements that development teams can actually build from. From discovery to acceptance criteria — no gaps, no surprises.</p>
      <ul class="service-deliverables">
        <li>BRD / FRD documentation</li>
        <li>User story mapping &amp; backlog creation</li>
        <li>Process design &amp; gap analysis</li>
        <li>UAT planning &amp; sign-off support</li>
      </ul>
    </article>

    <article class="service-card">
      <span class="service-num">03 · data</span>
      <h3 class="service-title">Data Product Consulting</h3>
      <p class="service-desc">From raw data to a product people pay for. We help you design the data layer, the product experience, and the commercial model — with real technical depth.</p>
      <ul class="service-deliverables">
        <li>Data product architecture &amp; scoping</li>
        <li>ETL workflow &amp; pipeline review</li>
        <li>BI &amp; analytics product design</li>
        <li>API integration strategy</li>
      </ul>
    </article>

    <article class="service-card">
      <span class="service-num">04 · embedded</span>
      <h3 class="service-title">Fractional Product Owner</h3>
      <p class="service-desc">A senior PO embedded in your team part-time. Ideal for early-stage startups that need product leadership without a full-time hire.</p>
      <ul class="service-deliverables">
        <li>Sprint planning &amp; backlog grooming</li>
        <li>Stakeholder management</li>
        <li>Product metrics &amp; KPI definition</li>
        <li>Agile ceremony facilitation</li>
      </ul>
    </article>
  </div>
</section>

<section class="section is-paper" id="projects">
  <div class="section-head">
    <span class="section-kicker">§ selected work</span>
    <h2 class="section-title">Products built.<br><em>Problems solved.</em></h2>
  </div>
  <div class="work-list">

    <article class="work-tile">
      <a class="work-thumb is-toplisters" href="https://toplisters.xyz" target="_blank" rel="noopener" aria-label="Visit TopListers">
        <span class="work-status"><span class="status-dot is-live"></span>100k+ live jobs</span>
        <span class="toplisters-brand">
          <svg class="toplisters-mark" viewBox="0 0 68 68" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <rect x="0" y="0" width="68" height="68" rx="14" fill="#0E1116"/>
            <rect x="14" y="16" width="40" height="8" rx="2" fill="#1F6FEB"/>
            <rect x="14" y="30" width="28" height="8" rx="2" fill="#F6F4EE" fill-opacity="0.85"/>
            <rect x="14" y="44" width="20" height="8" rx="2" fill="#F6F4EE" fill-opacity="0.55"/>
          </svg>
          <span class="toplisters-word">toplisters<span class="dot">.</span></span>
        </span>
      </a>
      <div class="work-copy">
        <div class="work-meta">2025 · job market intelligence</div>
        <h3 class="work-title">TopListers</h3>
        <p class="work-desc">Privacy-first job market intelligence. Track applications on a Kanban board, share anonymous job sightings, and explore global hiring trends with heatmaps and trend charts. 100,000+ live jobs, hand-checked every morning.</p>
        <div class="work-tech">
          <span class="tech-badge">Python</span>
          <span class="tech-badge">FastAPI</span>
          <span class="tech-badge">React</span>
          <span class="tech-badge">Supabase</span>
          <span class="tech-badge">Adzuna API</span>
        </div>
        <div class="work-links">
          <a class="work-link" href="https://toplisters.xyz" target="_blank" rel="noopener">visit toplisters <span aria-hidden="true">→</span></a>
          <a class="work-link is-secondary" href="/blog/toplisters-100k.html">read the 100k story ↗</a>
          <a class="work-link is-secondary" href="https://github.com/ainikaventures/toplisters" target="_blank" rel="noopener">github ↗</a>
        </div>
      </div>
    </article>

    <article class="work-tile flip">
      <a class="work-thumb is-smoke" href="https://github.com/ainikaventures/splitai" target="_blank" rel="noopener" aria-label="SplitAI on GitHub">
        <span class="work-status"><span class="status-dot"></span>in development</span>
        <span class="work-thumb-title">split<br>ai<span class="dot">.</span></span>
      </a>
      <div class="work-copy">
        <div class="work-meta">2025 · fintech · mobile</div>
        <h3 class="work-title">SplitAI</h3>
        <p class="work-desc">A smart expense-splitting app that takes the awkwardness out of shared costs. Built with Flutter for iOS and Android, with a PHP backend — designed to never ask for money.</p>
        <div class="work-tech">
          <span class="tech-badge">Flutter</span>
          <span class="tech-badge">Dart</span>
          <span class="tech-badge">PHP</span>
          <span class="tech-badge">iOS</span>
          <span class="tech-badge">Android</span>
        </div>
        <div class="work-links">
          <a class="work-link" href="https://github.com/ainikaventures/splitai" target="_blank" rel="noopener">view on github <span aria-hidden="true">→</span></a>
        </div>
      </div>
    </article>

    <article class="work-tile">
      <a class="work-thumb" href="https://github.com/ainikaventures/2048" target="_blank" rel="noopener" aria-label="2048 by Ainika on GitHub">
        <span class="work-status"><span class="status-dot"></span>in development</span>
        <span class="work-thumb-title">2048<span class="dot">.</span></span>
      </a>
      <div class="work-copy">
        <div class="work-meta">2025 · gaming · mobile</div>
        <h3 class="work-title">2048 by Ainika</h3>
        <p class="work-desc">A reimagined 2048 puzzle. Custom tile icons from your photo gallery, multiple themes, smooth animations, and fully offline play — built with Flutter for iOS and Android.</p>
        <div class="work-tech">
          <span class="tech-badge">Flutter</span>
          <span class="tech-badge">Dart</span>
          <span class="tech-badge">Provider</span>
          <span class="tech-badge">iOS</span>
          <span class="tech-badge">Android</span>
        </div>
        <div class="work-links">
          <a class="work-link" href="https://github.com/ainikaventures/2048" target="_blank" rel="noopener">view on github <span aria-hidden="true">→</span></a>
        </div>
      </div>
    </article>

  </div>
</section>

<section class="section is-smoke" id="process">
  <div class="section-head">
    <span class="section-kicker">§ how we work</span>
    <h2 class="section-title">A clear process.<br><em>No ambiguity.</em></h2>
  </div>
  <div class="process-grid">
    <div class="process-step">
      <span class="process-num">01</span>
      <h3 class="process-title">Discovery</h3>
      <p class="process-desc">A focused conversation to understand your problem, your data, and where you want to go. No jargon, no assumptions.</p>
    </div>
    <div class="process-step">
      <span class="process-num">02</span>
      <h3 class="process-title">Define</h3>
      <p class="process-desc">We map the solution space — requirements, constraints, success metrics — and align stakeholders before a single line of code is written.</p>
    </div>
    <div class="process-step">
      <span class="process-num">03</span>
      <h3 class="process-title">Deliver</h3>
      <p class="process-desc">Iterative delivery in short cycles with clear milestones. You see progress weekly, not at the end of six months.</p>
    </div>
    <div class="process-step">
      <span class="process-num">04</span>
      <h3 class="process-title">Evolve</h3>
      <p class="process-desc">Post-launch isn't the end. We help you measure, learn, and continuously improve the product as your users and data grow.</p>
    </div>
  </div>
</section>

<section class="section is-paper" id="contact">
  <div class="section-head">
    <span class="section-kicker">§ get in touch</span>
    <h2 class="section-title">Let's build something<br><em>worth building.</em></h2>
  </div>
  <div class="contact-grid">
    <div class="contact-info">
      <h3>Start with a conversation.</h3>
      <p>Whether you need a fractional PO, an AI product strategy, or just want to explore what's possible with your data — reach out. First call is always free.</p>
      <div class="contact-details">
        <div class="contact-detail">
          <span class="contact-detail-label">email</span>
          <a href="mailto:hello@ainika.xyz">hello@ainika.xyz</a>
        </div>
        <div class="contact-detail">
          <span class="contact-detail-label">linkedin</span>
          <a href="https://linkedin.com/in/josenjoy" target="_blank" rel="noopener">linkedin.com/in/josenjoy</a>
        </div>
        <div class="contact-detail">
          <span class="contact-detail-label">github</span>
          <a href="https://github.com/ainikaventures" target="_blank" rel="noopener">github.com/ainikaventures</a>
        </div>
        <div class="contact-detail">
          <span class="contact-detail-label">based</span>
          <span>Coventry, UK · available globally</span>
        </div>
      </div>
    </div>

    <div>
      <?php if ($form_success): ?>
        <div class="form-msg success">Thank you — your message has been received. We'll be in touch within 24 hours.</div>
      <?php elseif ($form_error === 'verify'): ?>
        <div class="form-msg error">Verification failed — please check your answer and try again.</div>
      <?php elseif ($form_error === 'send'): ?>
        <div class="form-msg error">Something went wrong. Please email hello@ainika.xyz directly.</div>
      <?php elseif ($form_error === 'fields'): ?>
        <div class="form-msg error">Please fill in all required fields with a valid email address.</div>
      <?php endif; ?>

      <form class="contact-form" method="POST" action="#contact" novalidate>
        <div class="form-row">
          <div class="form-group">
            <label for="name">your name</label>
            <input type="text" id="name" name="name" required placeholder="Jane Smith">
          </div>
          <div class="form-group">
            <label for="email">email address</label>
            <input type="email" id="email" name="email" required placeholder="jane@company.com">
          </div>
        </div>
        <div class="form-group">
          <label for="service">service of interest</label>
          <select id="service" name="service">
            <option value="">Select a service…</option>
            <option>AI/ML Product Strategy &amp; Roadmapping</option>
            <option>Business Analysis &amp; Requirements Engineering</option>
            <option>Data Product Consulting</option>
            <option>Fractional Product Owner</option>
            <option>General Enquiry</option>
          </select>
        </div>
        <div class="form-group">
          <label for="message">tell us about your project</label>
          <textarea id="message" name="message" required placeholder="Give us a brief overview of what you're building or the problem you're trying to solve…"></textarea>
        </div>

        <div style="position:absolute;left:-9999px;top:-9999px;" aria-hidden="true">
          <label for="website_url">Leave this empty</label>
          <input type="text" name="website_url" id="website_url" tabindex="-1" autocomplete="off">
        </div>

        <div class="form-group">
          <label for="captcha">quick check — what is <?php echo $_SESSION['captcha_a'] . ' + ' . $_SESSION['captcha_b']; ?>?</label>
          <input type="number" id="captcha" name="captcha" required placeholder="Your answer" inputmode="numeric">
        </div>

        <button type="submit" name="contact_submit" class="form-submit">send enquiry <span aria-hidden="true">→</span></button>
      </form>
    </div>
  </div>
</section>

<footer class="footer" id="footer" aria-label="footer">
  <h2 class="footer-lead">let's build something worth building<span class="dot">.</span></h2>
  <a href="mailto:hello@ainika.xyz" class="footer-email">hello@ainika.xyz</a>
  <div class="footer-socials">
    <a href="https://linkedin.com/in/josenjoy" target="_blank" rel="noopener">linkedin ↗</a>
    <a href="https://github.com/ainikaventures" target="_blank" rel="noopener">github ↗</a>
  </div>
  <div class="footer-bottom">
    <span>© <?php echo date('Y'); ?> ainika.  ·  ainika.xyz  ·  all rights reserved</span>
    <span>ai-powered products. human-centred strategy.</span>
  </div>
</footer>

<div class="cookie-bar" id="cookieBar" role="region" aria-label="cookie notice">
  <p>this site uses cookies for analytics and session recording<span class="dot">.</span></p>
  <button type="button" id="cookieAck">got it</button>
</div>

<script>
  (function () {
    var nav = document.getElementById('nav');
    var threshold = 80;
    var ticking = false;
    function onScroll() {
      if (!ticking) {
        window.requestAnimationFrame(function () {
          nav.classList.toggle('is-scrolled', window.scrollY > threshold);
          ticking = false;
        });
        ticking = true;
      }
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var fine = window.matchMedia('(pointer: fine)').matches;
    if (fine && !prefersReduced) {
      var dot = document.getElementById('cursorDot');
      var tx = 0, ty = 0, cx = 0, cy = 0;
      window.addEventListener('mousemove', function (e) { tx = e.clientX; ty = e.clientY; });
      (function loop() {
        cx += (tx - cx) * 0.18;
        cy += (ty - cy) * 0.18;
        dot.style.transform = 'translate3d(' + (cx - 3) + 'px,' + (cy - 3) + 'px,0)';
        requestAnimationFrame(loop);
      })();
    }

    try {
      var bar = document.getElementById('cookieBar');
      var ack = document.getElementById('cookieAck');
      if (bar && !localStorage.getItem('ainika.cookieAck.v2')) {
        bar.classList.add('is-visible');
        ack.addEventListener('click', function () {
          try { localStorage.setItem('ainika.cookieAck.v2', '1'); } catch (e) {}
          bar.classList.remove('is-visible');
        });
      }
    } catch (e) {}
  })();
</script>

</body>
</html>

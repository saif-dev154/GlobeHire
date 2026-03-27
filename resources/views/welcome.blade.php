<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlobeHire — Global Recruitment Platform</title>
    <meta name="description" content="GlobeHire connects employers, agents, and candidates in one seamless global hiring workflow — from job posting to visa clearance and flight scheduling.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --v: #4f46e5; --vd: #3730a3; --vl: #eef2ff; --vll: #f5f3ff;
            --teal: #0d9488; --teal-l: #f0fdfa;
            --amber: #d97706; --amber-l: #fffbeb;
            --rose: #e11d48; --rose-l: #fff1f2;
            --slate: #0f172a; --slate-m: #334155; --slate-s: #64748b; --slate-x: #94a3b8;
            --border: #e2e8f0; --surface: #f8fafc; --white: #ffffff;
        }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', -apple-system, sans-serif; color: var(--slate); background: #fff; line-height: 1.6; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }

        /* ── NAV ── */
        .nav {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226,232,240,.6);
            padding: 0 5%; height: 68px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .logo { display: flex; align-items: center; gap: 10px; }
        .logo-mark { width: 36px; height: 36px; background: var(--v); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: #fff; }
        .logo-name { font-size: 18px; font-weight: 800; color: var(--slate); letter-spacing: -.4px; }
        .logo-dot { color: var(--v); }
        .nav-links { display: flex; gap: 32px; }
        .nav-links a { font-size: 13.5px; font-weight: 500; color: var(--slate-s); transition: color .2s; }
        .nav-links a:hover { color: var(--v); }
        .nav-end { display: flex; align-items: center; gap: 10px; }
        .btn { display: inline-flex; align-items: center; gap: 6px; border-radius: 10px; font-weight: 600; font-size: 13.5px; cursor: pointer; transition: all .18s; border: none; font-family: 'Inter', sans-serif; }
        .btn-ghost { background: transparent; color: var(--slate-m); padding: 9px 18px; border: 1.5px solid var(--border); border-radius: 10px; font-weight: 600; font-size: 13.5px; }
        .btn-ghost:hover { border-color: var(--v); color: var(--v); background: var(--vll); }
        .btn-solid { background: var(--v); color: #fff; padding: 10px 22px; }
        .btn-solid:hover { background: var(--vd); }
        .btn-lg { padding: 13px 28px; font-size: 15px; border-radius: 12px; font-weight: 700; }

        /* ── HERO ── */
        .hero { padding: 88px 5% 80px; position: relative; overflow: hidden; background: #fff; }
        .hero-noise {
            position: absolute; inset: 0; pointer-events: none;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(79,70,229,.06) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(13,148,136,.05) 0%, transparent 40%),
                radial-gradient(circle at 60% 90%, rgba(217,119,6,.04) 0%, transparent 40%);
        }
        .hero-inner { max-width: 1160px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center; position: relative; z-index: 1; }
        .hero-eyebrow { display: inline-flex; align-items: center; gap: 8px; background: var(--vll); border: 1px solid #c7d2fe; border-radius: 100px; padding: 5px 16px 5px 5px; font-size: 12px; font-weight: 600; color: var(--v); margin-bottom: 22px; }
        .eyebrow-pip { background: var(--v); color: #fff; border-radius: 100px; padding: 2px 10px; font-size: 11px; font-weight: 700; }
        .hero h1 { font-size: clamp(34px, 4.5vw, 54px); font-weight: 900; line-height: 1.08; letter-spacing: -.03em; color: var(--slate); margin-bottom: 20px; }
        .accent { color: var(--v); position: relative; display: inline-block; }
        .accent::after { content: ''; position: absolute; bottom: -4px; left: 0; right: 0; height: 3px; background: var(--v); border-radius: 2px; opacity: .3; }
        .hero-sub { font-size: 16.5px; color: var(--slate-s); line-height: 1.75; margin-bottom: 34px; max-width: 490px; }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 44px; }
        .btn-hero-out { display: inline-flex; align-items: center; gap: 7px; padding: 12px 24px; border-radius: 12px; font-size: 14.5px; font-weight: 600; color: var(--slate-m); border: 1.5px solid var(--border); background: #fff; cursor: pointer; transition: all .2s; font-family: 'Inter', sans-serif; }
        .btn-hero-out:hover { border-color: var(--v); color: var(--v); background: var(--vll); }
        .play-icon { width: 30px; height: 30px; background: var(--vl); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; color: var(--v); }
        .hero-trust { display: flex; align-items: center; gap: 16px; }
        .trust-avs { display: flex; }
        .trust-av { width: 32px; height: 32px; border-radius: 50%; border: 2px solid #fff; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; margin-left: -8px; }
        .trust-av:first-child { margin-left: 0; }
        .trust-text { font-size: 12.5px; color: var(--slate-s); line-height: 1.4; }
        .trust-text strong { color: var(--slate); font-weight: 700; }

        /* Mockup */
        .hero-mockup { position: relative; padding: 20px; }
        .mockup-shell { background: #fff; border: 1px solid var(--border); border-radius: 20px; overflow: hidden; box-shadow: 0 4px 40px rgba(15,23,42,.08), 0 1px 4px rgba(15,23,42,.04); }
        .mockup-topbar { background: var(--surface); border-bottom: 1px solid var(--border); padding: 10px 16px; display: flex; align-items: center; justify-content: space-between; }
        .mtb-dots { display: flex; gap: 5px; }
        .mtb-dot { width: 9px; height: 9px; border-radius: 50%; }
        .mtb-title { font-size: 11px; font-weight: 600; color: var(--slate-s); }
        .mockup-body { padding: 16px; display: flex; flex-direction: column; gap: 10px; }
        .mk-stat-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
        .mk-stat { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 10px 12px; }
        .mk-stat-val { font-size: 19px; font-weight: 800; color: var(--slate); line-height: 1; }
        .mk-stat-lbl { font-size: 10px; color: var(--slate-x); margin-top: 2px; }
        .mk-stat-badge { font-size: 9px; font-weight: 700; padding: 1px 6px; border-radius: 20px; display: inline-block; margin-top: 4px; }
        .mk-card { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 12px; }
        .mk-card-title { font-size: 10.5px; font-weight: 700; color: var(--slate); margin-bottom: 8px; }
        .mk-row { display: flex; align-items: center; gap: 8px; padding: 5px 0; border-bottom: 1px solid #f1f5f9; }
        .mk-row:last-child { border-bottom: none; padding-bottom: 0; }
        .mk-av { width: 24px; height: 24px; border-radius: 50%; font-size: 8px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .mk-name { font-size: 10.5px; font-weight: 600; color: var(--slate); flex: 1; }
        .mk-meta { font-size: 9px; color: var(--slate-x); }
        .mk-pill { font-size: 8.5px; font-weight: 700; padding: 2px 7px; border-radius: 20px; white-space: nowrap; }
        .float-badge { position: absolute; background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 9px 14px; box-shadow: 0 4px 16px rgba(15,23,42,.1); display: flex; align-items: center; gap: 8px; white-space: nowrap; z-index: 10; }
        .fb-icon { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
        .fb-label { font-size: 11px; font-weight: 700; color: var(--slate); }
        .fb-sub { font-size: 9.5px; color: var(--slate-x); margin-top: 1px; }

        /* ── LOGOS ── */
        .logos-bar { padding: 28px 5%; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); background: var(--surface); }
        .logos-inner { max-width: 1160px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
        .logos-label { font-size: 12px; color: var(--slate-x); font-weight: 500; white-space: nowrap; margin-right: 32px; }
        .logo-items { display: flex; align-items: center; gap: 32px; flex: 1; justify-content: space-between; }
        .logo-item { font-size: 14px; font-weight: 800; color: #cbd5e1; letter-spacing: -.3px; }

        /* ── SECTIONS ── */
        .section { padding: 96px 5%; }
        .sec-wrap { max-width: 1160px; margin: 0 auto; }
        .sec-kicker { display: inline-flex; align-items: center; gap: 6px; font-size: 11.5px; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; color: var(--v); margin-bottom: 12px; }
        .sec-kicker-line { width: 24px; height: 2px; background: var(--v); border-radius: 2px; }
        .sec-h { font-size: clamp(26px, 3.5vw, 40px); font-weight: 900; letter-spacing: -.03em; color: var(--slate); line-height: 1.15; margin-bottom: 14px; }
        .sec-p { font-size: 15.5px; color: var(--slate-s); line-height: 1.75; max-width: 540px; }
        .sec-header { margin-bottom: 60px; }
        .sec-header.center { text-align: center; }
        .sec-header.center .sec-kicker { justify-content: center; }
        .sec-header.center .sec-p { margin: 0 auto; }

        /* ── HOW IT WORKS ── */
        .hiw-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px; background: var(--border); border-radius: 20px; overflow: hidden; }
        .hiw-card { background: #fff; padding: 36px 30px; position: relative; transition: background .2s; }
        .hiw-card:hover { background: var(--vll); }
        .hiw-num { font-size: 11px; font-weight: 800; color: var(--v); letter-spacing: 1px; text-transform: uppercase; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .hiw-num::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--v); display: inline-block; }
        .hiw-icon-wrap { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 18px; }
        .hiw-title { font-size: 16px; font-weight: 800; color: var(--slate); margin-bottom: 10px; }
        .hiw-desc { font-size: 13.5px; color: var(--slate-s); line-height: 1.7; }

        /* ── ROLES ── */
        .roles-section { background: var(--surface); }
        .roles-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .role-card { background: #fff; border-radius: 24px; padding: 36px 30px; border: 1px solid var(--border); transition: all .25s; position: relative; overflow: hidden; }
        .role-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; }
        .role-card.emp::before { background: var(--v); }
        .role-card.agt::before { background: var(--teal); }
        .role-card.cnd::before { background: var(--amber); }
        .role-card:hover { transform: translateY(-6px); box-shadow: 0 20px 60px rgba(15,23,42,.1); }
        .role-chip { font-size: 11px; font-weight: 700; letter-spacing: .6px; text-transform: uppercase; padding: 4px 12px; border-radius: 100px; display: inline-block; margin-bottom: 18px; }
        .role-chip.emp { background: var(--vll); color: var(--v); }
        .role-chip.agt { background: var(--teal-l); color: var(--teal); }
        .role-chip.cnd { background: var(--amber-l); color: var(--amber); }
        .role-h { font-size: 20px; font-weight: 800; color: var(--slate); margin-bottom: 10px; }
        .role-p { font-size: 13.5px; color: var(--slate-s); line-height: 1.7; margin-bottom: 22px; }
        .role-list { list-style: none; display: flex; flex-direction: column; gap: 9px; margin-bottom: 28px; }
        .role-list li { display: flex; align-items: flex-start; gap: 9px; font-size: 13px; color: var(--slate-m); line-height: 1.5; }
        .chk { width: 18px; height: 18px; border-radius: 5px; display: flex; align-items: center; justify-content: center; font-size: 9px; font-weight: 800; flex-shrink: 0; margin-top: 1px; }
        .chk.emp { background: var(--vll); color: var(--v); }
        .chk.agt { background: var(--teal-l); color: var(--teal); }
        .chk.cnd { background: var(--amber-l); color: var(--amber); }
        .role-cta { display: inline-flex; align-items: center; gap: 7px; padding: 11px 20px; border-radius: 11px; font-size: 13.5px; font-weight: 700; cursor: pointer; transition: all .2s; border: none; font-family: 'Inter', sans-serif; }
        .role-cta.emp { background: var(--vll); color: var(--v); }
        .role-cta.emp:hover { background: var(--v); color: #fff; }
        .role-cta.agt { background: var(--teal-l); color: var(--teal); }
        .role-cta.agt:hover { background: var(--teal); color: #fff; }
        .role-cta.cnd { background: var(--amber-l); color: var(--amber); }
        .role-cta.cnd:hover { background: var(--amber); color: #fff; }

        /* ── FEATURES ── */
        .feats-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .feat-big { background: var(--vll); border-radius: 20px; padding: 40px; border: 1px solid #c7d2fe; grid-row: span 2; display: flex; flex-direction: column; }
        .feat-big-icon { width: 56px; height: 56px; background: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(79,70,229,.15); }
        .feat-big-h { font-size: 22px; font-weight: 800; color: var(--slate); margin-bottom: 10px; line-height: 1.2; }
        .feat-big-p { font-size: 14px; color: var(--slate-s); line-height: 1.75; flex: 1; margin-bottom: 24px; }
        .feat-big-steps { display: flex; flex-direction: column; gap: 10px; margin-top: auto; }
        .feat-big-step { display: flex; align-items: center; gap: 10px; font-size: 13px; color: var(--slate-m); }
        .feat-big-step-n { width: 22px; height: 22px; background: var(--v); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 800; color: #fff; flex-shrink: 0; }
        .feat-sm { background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: 28px; transition: all .2s; }
        .feat-sm:hover { border-color: #c7d2fe; transform: translateY(-3px); }
        .feat-sm-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 14px; }
        .feat-sm-h { font-size: 15px; font-weight: 700; color: var(--slate); margin-bottom: 7px; }
        .feat-sm-p { font-size: 13px; color: var(--slate-s); line-height: 1.65; }

        /* ── FLOW ── */
        .flow-section { background: var(--slate); padding: 96px 5%; }
        .flow-wrap { max-width: 1160px; margin: 0 auto; }
        .flow-header { text-align: center; margin-bottom: 64px; }
        .flow-timeline { display: grid; grid-template-columns: repeat(5, 1fr); position: relative; }
        .flow-timeline::before { content: ''; position: absolute; top: 36px; left: calc(10% + 18px); right: calc(10% + 18px); height: 1px; background: rgba(255,255,255,.1); }
        .flow-node { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 0 10px; position: relative; z-index: 1; }
        .flow-orb { width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 18px; border: 1px solid rgba(255,255,255,.1); }
        .flow-step-h { font-size: 13px; font-weight: 700; color: #e2e8f0; margin-bottom: 5px; }
        .flow-step-p { font-size: 11.5px; color: #64748b; line-height: 1.55; }

        /* ── STATS ── */
        .stats-section { padding: 80px 5%; background: var(--v); }
        .stats-wrap { max-width: 1160px; margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); }
        .stat-block { text-align: center; padding: 0 24px; border-right: 1px solid rgba(255,255,255,.15); }
        .stat-block:last-child { border-right: none; }
        .stat-n { font-size: 48px; font-weight: 900; color: #fff; line-height: 1; letter-spacing: -.03em; margin-bottom: 6px; }
        .stat-l { font-size: 14px; color: #a5b4fc; font-weight: 500; }

        /* ── TESTIMONIALS ── */
        .testi-section { background: var(--surface); }
        .testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .testi-card { background: #fff; border: 1px solid var(--border); border-radius: 18px; padding: 30px; transition: all .2s; }
        .testi-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(15,23,42,.08); }
        .testi-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
        .testi-stars { color: #f59e0b; font-size: 14px; letter-spacing: 2px; }
        .testi-logo { font-size: 10px; font-weight: 700; color: var(--slate-x); letter-spacing: .5px; text-transform: uppercase; }
        .testi-quote { font-size: 14px; color: var(--slate-m); line-height: 1.8; margin-bottom: 22px; font-style: italic; }
        .testi-author { display: flex; align-items: center; gap: 12px; }
        .testi-av { width: 42px; height: 42px; border-radius: 50%; font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .testi-name { font-size: 13.5px; font-weight: 700; color: var(--slate); }
        .testi-role { font-size: 11.5px; color: var(--slate-x); margin-top: 1px; }

        /* ── FAQ ── */
        .faq-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .faq-item { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 22px 24px; cursor: pointer; transition: border-color .2s; }
        .faq-item:hover { border-color: #c7d2fe; }
        .faq-q { font-size: 14px; font-weight: 700; color: var(--slate); display: flex; justify-content: space-between; align-items: center; gap: 12px; }
        .faq-icon { width: 24px; height: 24px; background: var(--vll); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 14px; color: var(--v); flex-shrink: 0; font-weight: 700; }
        .faq-a { font-size: 13px; color: var(--slate-s); line-height: 1.7; margin-top: 10px; }

        /* ── CTA FINAL ── */
        .final-cta { padding: 100px 5%; text-align: center; position: relative; overflow: hidden; background: #fff; }
        .final-cta::before { content: ''; position: absolute; top: -200px; left: 50%; transform: translateX(-50%); width: 700px; height: 700px; background: radial-gradient(circle, rgba(79,70,229,.07) 0%, transparent 70%); pointer-events: none; }
        .final-inner { max-width: 680px; margin: 0 auto; position: relative; z-index: 1; }
        .final-badge { display: inline-flex; align-items: center; gap: 7px; background: var(--vll); border: 1px solid #c7d2fe; border-radius: 100px; padding: 5px 16px; font-size: 12px; font-weight: 600; color: var(--v); margin-bottom: 24px; }
        .final-h { font-size: clamp(30px, 5vw, 50px); font-weight: 900; color: var(--slate); letter-spacing: -.03em; line-height: 1.1; margin-bottom: 16px; }
        .final-p { font-size: 16px; color: var(--slate-s); line-height: 1.7; margin-bottom: 36px; }
        .final-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
        .final-note { font-size: 12px; color: var(--slate-x); margin-top: 20px; display: flex; align-items: center; justify-content: center; gap: 16px; flex-wrap: wrap; }
        .final-note span { display: flex; align-items: center; gap: 5px; }
        .note-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--slate-x); }

        /* ── FOOTER ── */
        .footer { background: #020617; padding: 64px 5% 28px; }
        .footer-wrap { max-width: 1160px; margin: 0 auto; }
        .footer-top { display: grid; grid-template-columns: 2.2fr 1fr 1fr 1fr; gap: 48px; margin-bottom: 52px; }
        .footer-brand-desc { font-size: 13.5px; color: #475569; line-height: 1.75; margin: 12px 0 20px; max-width: 240px; }
        .socials { display: flex; gap: 9px; }
        .soc { width: 34px; height: 34px; background: #1e293b; border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 15px; transition: all .2s; cursor: pointer; }
        .soc:hover { background: var(--v); color: #fff; }
        .footer-col h5 { font-size: 11px; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; color: #475569; margin-bottom: 16px; }
        .footer-col a { display: block; font-size: 13px; color: #64748b; margin-bottom: 9px; transition: color .2s; }
        .footer-col a:hover { color: #a5b4fc; }
        .footer-bottom { border-top: 1px solid #1e293b; padding-top: 22px; display: flex; align-items: center; justify-content: space-between; }
        .footer-copy { font-size: 12px; color: #334155; }
        .footer-links { display: flex; gap: 18px; }
        .footer-links a { font-size: 12px; color: #334155; transition: color .2s; }
        .footer-links a:hover { color: #a5b4fc; }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .hero-inner    { grid-template-columns: 1fr; }
            .hero-mockup   { display: none; }
            .feats-layout  { grid-template-columns: 1fr; }
            .feat-big      { grid-row: auto; }
            .footer-top    { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .nav-links     { display: none; }
            .hiw-grid      { grid-template-columns: 1fr; }
            .roles-grid    { grid-template-columns: 1fr; }
            .testi-grid    { grid-template-columns: 1fr; }
            .faq-grid      { grid-template-columns: 1fr; }
            .flow-timeline { grid-template-columns: 1fr; gap: 28px; }
            .flow-timeline::before { display: none; }
            .stats-wrap    { grid-template-columns: repeat(2, 1fr); gap: 28px; }
            .stat-block    { border-right: none; padding: 16px 0; }
        }
        @media (max-width: 540px) {
            .section       { padding: 64px 5%; }
            .stats-wrap    { grid-template-columns: 1fr; }
            .footer-top    { grid-template-columns: 1fr; }
            .logos-label   { display: none; }
            .logo-items    { gap: 16px; }
        }
    </style>
</head>
<body>

{{-- ── NAVBAR ── --}}
<nav class="nav">
    <div class="logo">
        <div class="logo-mark">G</div>
        <span class="logo-name">Globe<span class="logo-dot">Hire</span></span>
    </div>
    <div class="nav-links">
        <a href="#how-it-works">How it works</a>
        <a href="#for-you">For employers</a>
        <a href="#for-you">For agents</a>
        <a href="#for-you">For candidates</a>
    </div>
    <div class="nav-end">
        <a href="{{ route('login') }}" class="btn-ghost" style="font-family:'Inter',sans-serif;font-weight:600;font-size:13.5px;padding:9px 18px;border-radius:10px;border:1.5px solid var(--border);color:var(--slate-m);cursor:pointer;transition:all .2s">Sign in</a>
        <a href="{{ route('register') }}" class="btn btn-solid">Get started free →</a>
    </div>
</nav>

{{-- ── HERO ── --}}
<section class="hero">
    <div class="hero-noise"></div>
    <div class="hero-inner">
        <div>
            <div class="hero-eyebrow"><span class="eyebrow-pip">New</span> End-to-end global hiring platform</div>
            <h1>Hire globally.<br>Place <span class="accent">smarter</span>.<br>Move faster.</h1>
            <p class="hero-sub">GlobeHire connects employers, agents, and candidates in one seamless workflow — from job posting through interviews, contracts, visa processing, and flight coordination.</p>
            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn btn-solid btn-lg">Start for free →</a>
                <button class="btn-hero-out"><div class="play-icon">▶</div> Watch how it works</button>
            </div>
            <div class="hero-trust">
                <div class="trust-avs">
                    <div class="trust-av" style="background:#eef2ff;color:#4f46e5">RM</div>
                    <div class="trust-av" style="background:#f0fdfa;color:#0d9488">SA</div>
                    <div class="trust-av" style="background:#fffbeb;color:#d97706">AK</div>
                    <div class="trust-av" style="background:#fff1f2;color:#e11d48">NZ</div>
                    <div class="trust-av" style="background:#f5f3ff;color:#7c3aed">+</div>
                </div>
                <div class="trust-text"><strong>12,400+ candidates</strong> placed globally<br>Trusted by 850+ employers worldwide</div>
            </div>
        </div>
        <div class="hero-mockup">
            <div class="mockup-shell">
                <div class="mockup-topbar">
                    <div class="mtb-dots">
                        <div class="mtb-dot" style="background:#ef4444"></div>
                        <div class="mtb-dot" style="background:#f59e0b"></div>
                        <div class="mtb-dot" style="background:#22c55e"></div>
                    </div>
                    <div class="mtb-title">GlobeHire — Employer Dashboard</div>
                    <div style="width:48px"></div>
                </div>
                <div class="mockup-body">
                    <div class="mk-stat-row">
                        <div class="mk-stat">
                            <div class="mk-stat-val">8</div>
                            <div class="mk-stat-lbl">Active jobs</div>
                            <span class="mk-stat-badge" style="background:#eef2ff;color:#4f46e5">↑ 3 new</span>
                        </div>
                        <div class="mk-stat">
                            <div class="mk-stat-val">24</div>
                            <div class="mk-stat-lbl">Applications</div>
                            <span class="mk-stat-badge" style="background:#f0fdf4;color:#15803d">↑ 12</span>
                        </div>
                        <div class="mk-stat">
                            <div class="mk-stat-val">6</div>
                            <div class="mk-stat-lbl">Interviews</div>
                            <span class="mk-stat-badge" style="background:#fffbeb;color:#b45309">This week</span>
                        </div>
                    </div>
                    <div class="mk-card">
                        <div class="mk-card-title">Recent applications</div>
                        <div class="mk-row">
                            <div class="mk-av" style="background:#eef2ff;color:#4f46e5">AK</div>
                            <div class="mk-name">Asad Khan<div class="mk-meta">React Developer</div></div>
                            <span class="mk-pill" style="background:#f0fdf4;color:#15803d">Shortlisted</span>
                        </div>
                        <div class="mk-row">
                            <div class="mk-av" style="background:#f0fdfa;color:#0d9488">NZ</div>
                            <div class="mk-name">Nadia Zahra<div class="mk-meta">Laravel Engineer</div></div>
                            <span class="mk-pill" style="background:#fffbeb;color:#b45309">Interview</span>
                        </div>
                        <div class="mk-row">
                            <div class="mk-av" style="background:#fdf2f8;color:#db2777">SM</div>
                            <div class="mk-name">Sara Malik<div class="mk-meta">UI/UX Designer</div></div>
                            <span class="mk-pill" style="background:#eef2ff;color:#4f46e5">Pending</span>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
                        <div class="mk-card">
                            <div class="mk-card-title">Contracts</div>
                            <div style="display:flex;flex-direction:column;gap:5px">
                                <div style="display:flex;justify-content:space-between;font-size:10px;color:var(--slate-s)">Signed <span class="mk-pill" style="background:#f0fdf4;color:#15803d">1</span></div>
                                <div style="display:flex;justify-content:space-between;font-size:10px;color:var(--slate-s)">Pending <span class="mk-pill" style="background:#fffbeb;color:#b45309">2</span></div>
                            </div>
                        </div>
                        <div class="mk-card">
                            <div class="mk-card-title">Visa status</div>
                            <div style="display:flex;flex-direction:column;gap:5px">
                                <div style="display:flex;justify-content:space-between;font-size:10px;color:var(--slate-s)">Approved <span class="mk-pill" style="background:#f0fdf4;color:#15803d">3</span></div>
                                <div style="display:flex;justify-content:space-between;font-size:10px;color:var(--slate-s)">In review <span class="mk-pill" style="background:#eef2ff;color:#4f46e5">2</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="float-badge" style="bottom:-16px;left:-24px">
                <div class="fb-icon" style="background:#f0fdf4;color:#15803d">✈</div>
                <div><div class="fb-label">Flight scheduled</div><div class="fb-sub">ISB → DXB · 15 Apr</div></div>
            </div>
            <div class="float-badge" style="top:-14px;right:-20px">
                <div class="fb-icon" style="background:#fffbeb;color:#d97706">📄</div>
                <div><div class="fb-label">Contract signed</div><div class="fb-sub">Asad Khan · Just now</div></div>
            </div>
        </div>
    </div>
</section>

{{-- ── LOGOS ── --}}
<div class="logos-bar">
    <div class="logos-inner">
        <span class="logos-label">Trusted by leading companies</span>
        <div class="logo-items">
            <span class="logo-item">TECHCORP</span>
            <span class="logo-item">NEXUSHR</span>
            <span class="logo-item">GLOBALIS</span>
            <span class="logo-item">WORKNET</span>
            <span class="logo-item">TALENTIQ</span>
            <span class="logo-item">HIREPLUS</span>
        </div>
    </div>
</div>

{{-- ── HOW IT WORKS ── --}}
<section class="section" id="how-it-works">
    <div class="sec-wrap">
        <div class="sec-header">
            <div class="sec-kicker"><div class="sec-kicker-line"></div> How it works</div>
            <div class="sec-h">Six steps from posting to placement</div>
            <p class="sec-p">Every part of the global hiring journey — tracked, managed, and streamlined in one platform.</p>
        </div>
        <div class="hiw-grid">
            <div class="hiw-card" style="border-radius:20px 0 0 0">
                <div class="hiw-num">Step 01</div>
                <div class="hiw-icon-wrap" style="background:#eef2ff"><i class="bi bi-briefcase-fill" style="font-size:22px;color:#4f46e5"></i></div>
                <div class="hiw-title">Post a job</div>
                <div class="hiw-desc">Employers create detailed listings with required skills, salary structure, visa sponsorship, and assign agents to manage the pipeline.</div>
            </div>
            <div class="hiw-card">
                <div class="hiw-num">Step 02</div>
                <div class="hiw-icon-wrap" style="background:#f0fdfa"><i class="bi bi-person-fill" style="font-size:22px;color:#0d9488"></i></div>
                <div class="hiw-title">Candidates apply</div>
                <div class="hiw-desc">Candidates submit full applications with resume, cover letter, education history, and experience. An agent is auto-assigned from the job's agent list.</div>
            </div>
            <div class="hiw-card" style="border-radius:0 20px 0 0">
                <div class="hiw-num">Step 03</div>
                <div class="hiw-icon-wrap" style="background:#fffbeb"><i class="bi bi-camera-video-fill" style="font-size:22px;color:#d97706"></i></div>
                <div class="hiw-title">Agents interview</div>
                <div class="hiw-desc">Agents schedule video interviews with meeting links and update outcomes in real time — pass, fail, postpone — with optional remarks.</div>
            </div>
            <div class="hiw-card" style="border-radius:0 0 0 20px">
                <div class="hiw-num">Step 04</div>
                <div class="hiw-icon-wrap" style="background:#fff1f2"><i class="bi bi-file-earmark-check-fill" style="font-size:22px;color:#e11d48"></i></div>
                <div class="hiw-title">Shortlist & contract</div>
                <div class="hiw-desc">Employers shortlist candidates from passed interviews and issue detailed digital contracts — salary, terms, jurisdiction, start date, and deadline.</div>
            </div>
            <div class="hiw-card">
                <div class="hiw-num">Step 05</div>
                <div class="hiw-icon-wrap" style="background:#eef2ff"><i class="bi bi-passport-fill" style="font-size:22px;color:#4f46e5"></i></div>
                <div class="hiw-title">Visa document review</div>
                <div class="hiw-desc">Candidates upload 14 required visa documents. Agents review and approve each field individually with per-document feedback and rejection remarks.</div>
            </div>
            <div class="hiw-card" style="border-radius:0 0 20px 0">
                <div class="hiw-num">Step 06</div>
                <div class="hiw-icon-wrap" style="background:#f0fdf4"><i class="bi bi-airplane-fill" style="font-size:22px;color:#0d9488"></i></div>
                <div class="hiw-title">Flight scheduling</div>
                <div class="hiw-desc">Once visa is approved, agents schedule flights with airline details, ticket uploads, and sponsorship letters. Candidates track everything in real time.</div>
            </div>
        </div>
    </div>
</section>

{{-- ── ROLES ── --}}
<section class="section roles-section" id="for-you">
    <div class="sec-wrap">
        <div class="sec-header center">
            <div class="sec-kicker"><div class="sec-kicker-line"></div> Built for everyone</div>
            <div class="sec-h">One platform, three powerful roles</div>
            <p class="sec-p">Whether you're hiring talent, facilitating placements, or seeking your next opportunity — GlobeHire has a tailored experience just for you.</p>
        </div>
        <div class="roles-grid">
            <div class="role-card emp">
                <span class="role-chip emp">For employers</span>
                <div class="role-h">Hire globally with ease</div>
                <p class="role-p">Post international jobs, manage the full hiring funnel, issue digital contracts, and track every candidate from application to relocation.</p>
                <ul class="role-list">
                    <li><span class="chk emp">✓</span> Post jobs with visa sponsorship details</li>
                    <li><span class="chk emp">✓</span> Assign agents to manage your applicants</li>
                    <li><span class="chk emp">✓</span> Shortlist from passed interviews</li>
                    <li><span class="chk emp">✓</span> Issue, sign &amp; approve digital contracts</li>
                    <li><span class="chk emp">✓</span> Full analytics dashboard with hiring funnel</li>
                </ul>
                <a href="{{ route('register') }}" class="role-cta emp">Post a job <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="role-card agt">
                <span class="role-chip agt">For agents</span>
                <div class="role-h">Manage the entire journey</div>
                <p class="role-p">Handle applications, schedule interviews, review visa documents field by field, and coordinate flights — all in one clean workspace.</p>
                <ul class="role-list">
                    <li><span class="chk agt">✓</span> View and manage assigned applications</li>
                    <li><span class="chk agt">✓</span> Schedule and update interview outcomes</li>
                    <li><span class="chk agt">✓</span> Review all 14 visa document fields</li>
                    <li><span class="chk agt">✓</span> Schedule flights with ticket uploads</li>
                    <li><span class="chk agt">✓</span> Real-time pipeline status across all stages</li>
                </ul>
                <a href="{{ route('register') }}" class="role-cta agt">Join as agent <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="role-card cnd">
                <span class="role-chip cnd">For candidates</span>
                <div class="role-h">Land your dream job abroad</div>
                <p class="role-p">Browse international opportunities, apply with a full profile, sign contracts digitally, and track your visa and flight status end to end.</p>
                <ul class="role-list">
                    <li><span class="chk cnd">✓</span> Browse active international job listings</li>
                    <li><span class="chk cnd">✓</span> Apply with resume, CV &amp; cover letter</li>
                    <li><span class="chk cnd">✓</span> Track interviews and receive feedback</li>
                    <li><span class="chk cnd">✓</span> Sign contracts with digital signature pad</li>
                    <li><span class="chk cnd">✓</span> Upload visa docs &amp; monitor flight schedule</li>
                </ul>
                <a href="{{ route('register') }}" class="role-cta cnd">Find jobs <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

{{-- ── FEATURES ── --}}
<section class="section" id="features">
    <div class="sec-wrap">
        <div class="sec-header">
            <div class="sec-kicker"><div class="sec-kicker-line"></div> Platform features</div>
            <div class="sec-h">Everything you need,<br>nothing you don't</div>
            <p class="sec-p">Purpose-built tools covering every stage of global recruitment — built right, not bolted on.</p>
        </div>
        <div class="feats-layout">
            <div class="feat-big">
                <div>
                    <div class="feat-big-icon"><i class="bi bi-kanban-fill" style="font-size:24px;color:#4f46e5"></i></div>
                    <div class="feat-big-h">Full end-to-end hiring pipeline</div>
                    <p class="feat-big-p">Track every candidate across every stage — application, interview, shortlisting, contract, visa processing, and flight coordination — in one unified view. No spreadsheets. No lost emails. No confusion whatsoever.</p>
                    <div class="feat-big-steps">
                        <div class="feat-big-step"><div class="feat-big-step-n">1</div> Application submitted &amp; agent assigned</div>
                        <div class="feat-big-step"><div class="feat-big-step-n">2</div> Interview scheduled &amp; outcome recorded</div>
                        <div class="feat-big-step"><div class="feat-big-step-n">3</div> Contract issued &amp; digitally signed</div>
                        <div class="feat-big-step"><div class="feat-big-step-n">4</div> Visa approved &amp; flight booked</div>
                    </div>
                </div>
            </div>
            <div class="feat-sm">
                <div class="feat-sm-icon" style="background:#f0fdfa;color:#0d9488"><i class="bi bi-camera-video-fill" style="font-size:19px"></i></div>
                <div class="feat-sm-h">Video interview scheduling</div>
                <p class="feat-sm-p">Agents schedule meetings with links, real-time status: pending, in-progress, ended. Pass/fail/postpone outcomes recorded instantly.</p>
            </div>
            <div class="feat-sm">
                <div class="feat-sm-icon" style="background:#fffbeb;color:#d97706"><i class="bi bi-pen-fill" style="font-size:19px"></i></div>
                <div class="feat-sm-h">Digital contract signing</div>
                <p class="feat-sm-p">Rich contracts with salary, terms, jurisdiction, and deadlines. Candidates sign with a signature pad directly in the browser.</p>
            </div>
            <div class="feat-sm">
                <div class="feat-sm-icon" style="background:#fff1f2;color:#e11d48"><i class="bi bi-passport-fill" style="font-size:19px"></i></div>
                <div class="feat-sm-h">14-field visa checklist</div>
                <p class="feat-sm-p">Per-document approval and rejection with remarks. Automatic overall status recalculation — submitted, in review, approved, rejected.</p>
            </div>
            <div class="feat-sm">
                <div class="feat-sm-icon" style="background:#eef2ff;color:#7c3aed"><i class="bi bi-airplane-fill" style="font-size:19px"></i></div>
                <div class="feat-sm-h">Flight coordination</div>
                <p class="feat-sm-p">Agents upload tickets and sponsorship letters. Candidates see live travel status — scheduled, boarding, in-flight, completed.</p>
            </div>
        </div>
    </div>
</section>

{{-- ── FLOW ── --}}
<section class="flow-section">
    <div class="flow-wrap">
        <div class="flow-header">
            <div class="sec-kicker" style="justify-content:center;color:#818cf8"><div class="sec-kicker-line" style="background:#818cf8"></div> End-to-end workflow</div>
            <div class="sec-h" style="color:#fff;text-align:center">From posting to landing — in five stages</div>
        </div>
        <div class="flow-timeline">
            <div class="flow-node">
                <div class="flow-orb" style="background:rgba(79,70,229,.2)"><i class="bi bi-briefcase-fill" style="font-size:24px;color:#818cf8"></i></div>
                <div class="flow-step-h">Job posted</div>
                <div class="flow-step-p">Employer creates listing, assigns agents</div>
            </div>
            <div class="flow-node">
                <div class="flow-orb" style="background:rgba(13,148,136,.2)"><i class="bi bi-send-fill" style="font-size:24px;color:#5eead4"></i></div>
                <div class="flow-step-h">Application</div>
                <div class="flow-step-p">Candidate applies, agent auto-assigned</div>
            </div>
            <div class="flow-node">
                <div class="flow-orb" style="background:rgba(217,119,6,.2)"><i class="bi bi-camera-video-fill" style="font-size:24px;color:#fbbf24"></i></div>
                <div class="flow-step-h">Interview</div>
                <div class="flow-step-p">Scheduled, conducted, result recorded</div>
            </div>
            <div class="flow-node">
                <div class="flow-orb" style="background:rgba(225,29,72,.2)"><i class="bi bi-file-earmark-text-fill" style="font-size:24px;color:#fda4af"></i></div>
                <div class="flow-step-h">Contract & visa</div>
                <div class="flow-step-p">Signed digitally, 14 docs verified</div>
            </div>
            <div class="flow-node">
                <div class="flow-orb" style="background:rgba(16,185,129,.2)"><i class="bi bi-airplane-fill" style="font-size:24px;color:#34d399"></i></div>
                <div class="flow-step-h">Departure</div>
                <div class="flow-step-p">Flight booked, candidate lands</div>
            </div>
        </div>
    </div>
</section>

{{-- ── STATS ── --}}
<div class="stats-section">
    <div class="stats-wrap">
        <div class="stat-block"><div class="stat-n">12,400+</div><div class="stat-l">Candidates placed globally</div></div>
        <div class="stat-block"><div class="stat-n">850+</div><div class="stat-l">Active employers</div></div>
        <div class="stat-block"><div class="stat-n">340+</div><div class="stat-l">Certified agents</div></div>
        <div class="stat-block"><div class="stat-n">98%</div><div class="stat-l">Client satisfaction rate</div></div>
    </div>
</div>

{{-- ── TESTIMONIALS ── --}}
<section class="section testi-section" id="testimonials">
    <div class="sec-wrap">
        <div class="sec-header center">
            <div class="sec-kicker"><div class="sec-kicker-line"></div> Testimonials</div>
            <div class="sec-h">Loved by employers, agents &amp; candidates</div>
            <p class="sec-p">Real feedback from people who use GlobeHire every day to hire, place, and find work globally.</p>
        </div>
        <div class="testi-grid">
            <div class="testi-card">
                <div class="testi-top"><div class="testi-stars">★★★★★</div><div class="testi-logo">Employer</div></div>
                <div class="testi-quote">"GlobeHire transformed our international hiring. The visa workflow and contract signing alone saved us weeks of back-and-forth. I can't imagine hiring globally without it."</div>
                <div class="testi-author"><div class="testi-av" style="background:#eef2ff;color:#4f46e5">RM</div><div><div class="testi-name">Raza Malik</div><div class="testi-role">HR Director · TechCorp UAE</div></div></div>
            </div>
            <div class="testi-card">
                <div class="testi-top"><div class="testi-stars">★★★★★</div><div class="testi-logo">Agent</div></div>
                <div class="testi-quote">"Managing 20+ candidates used to be chaos — spreadsheets everywhere. Now I have one dashboard for applications, interviews, visa docs, and flights. A complete game changer."</div>
                <div class="testi-author"><div class="testi-av" style="background:#f0fdfa;color:#0d9488">SA</div><div><div class="testi-name">Sara Anwar</div><div class="testi-role">Senior Recruitment Agent</div></div></div>
            </div>
            <div class="testi-card">
                <div class="testi-top"><div class="testi-stars">★★★★★</div><div class="testi-logo">Candidate</div></div>
                <div class="testi-quote">"I landed a job in Dubai through GlobeHire. My interview, contract, visa upload, and flight were all in one place. I always knew exactly what was happening and what came next."</div>
                <div class="testi-author"><div class="testi-av" style="background:#fffbeb;color:#d97706">AK</div><div><div class="testi-name">Asad Khan</div><div class="testi-role">Software Engineer · Placed in UAE</div></div></div>
            </div>
        </div>
    </div>
</section>

{{-- ── FAQ ── --}}
<section class="section" id="faq">
    <div class="sec-wrap">
        <div class="sec-header center">
            <div class="sec-kicker"><div class="sec-kicker-line"></div> FAQ</div>
            <div class="sec-h">Common questions</div>
            <p class="sec-p">Everything you need to know before getting started with GlobeHire.</p>
        </div>
        <div class="faq-grid">
            @php
                $faqs = [
                    ['q'=>'Who is GlobeHire for?','a'=>'GlobeHire is built for three roles: employers who post jobs and hire internationally, agents who facilitate and manage the hiring process, and candidates looking for overseas employment opportunities.'],
                    ['q'=>'How does agent assignment work?','a'=>"When an employer creates a job, they attach agent IDs. When a candidate applies, the system randomly assigns one of those agents to manage that candidate's application journey."],
                    ['q'=>'What visa documents are required?','a'=>'GlobeHire manages 14 document fields including passport scans (front & back), national ID, passport photo, education certificates, police clearance, medical certificate, visa application form, offer letter, resume/CV, declaration/consent, and NOC.'],
                    ['q'=>'How does contract signing work?','a'=>'Employers create contracts with full terms, salary, working hours, and jurisdiction. Candidates review and sign directly in the browser using a digital signature pad. Employers can then approve or reject the signed contract.'],
                    ['q'=>'Can candidates track their flight status?','a'=>'Yes. Once an agent schedules a flight, candidates see full details including airline, flight number, departure/arrival airports, dates, and live travel status — scheduled, boarding, in-flight, completed.'],
                    ['q'=>'Is there role-based access control?','a'=>'Yes. GlobeHire uses strict middleware so employers, agents, and candidates each see only what\'s relevant to their role. There are completely separate dashboards, routes, and permissions for each role.'],
                ];
            @endphp
            @foreach($faqs as $faq)
            <div class="faq-item">
                <div class="faq-q">{{ $faq['q'] }} <div class="faq-icon">+</div></div>
                <div class="faq-a">{{ $faq['a'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── FINAL CTA ── --}}
<section class="final-cta">
    <div class="final-inner">
        <div class="final-badge">🚀 Join 12,400+ successful placements</div>
        <div class="final-h">Ready to bridge the gap?</div>
        <p class="final-p">Start your free account today. Whether you're an employer, agent, or candidate — GlobeHire gives you everything you need to hire or land a job globally.</p>
        <div class="final-btns">
            <a href="{{ route('register') }}" class="btn btn-solid btn-lg">Create free account →</a>
            <a href="{{ route('login') }}" class="btn-ghost" style="padding:13px 28px;font-size:15px;border-radius:12px;font-weight:700;font-family:'Inter',sans-serif">Sign in</a>
        </div>
        <div class="final-note">
            <span>✓ No credit card required</span>
            <div class="note-dot"></div>
            <span>✓ Set up in minutes</span>
            <div class="note-dot"></div>
            <span>✓ Free for candidates</span>
        </div>
    </div>
</section>

{{-- ── FOOTER ── --}}
<footer class="footer">
    <div class="footer-wrap">
        <div class="footer-top">
            <div>
                <div class="logo">
                    <div class="logo-mark">W</div>
                    <span style="font-size:17px;font-weight:800;color:#e2e8f0;letter-spacing:-.3px">Work<span style="color:#818cf8">Bridge</span></span>
                </div>
                <p class="footer-brand-desc">The end-to-end global recruitment platform connecting employers, agents, and candidates worldwide — from posting to placement.</p>
                <div class="socials">
                    <a href="#" class="soc"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="soc"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="soc"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="soc"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h5>Platform</h5>
                <a href="#how-it-works">How it works</a>
                <a href="#features">Features</a>
                <a href="#for-you">For employers</a>
                <a href="#for-you">For agents</a>
                <a href="#for-you">For candidates</a>
            </div>
            <div class="footer-col">
                <h5>Account</h5>
                <a href="{{ route('register') }}">Sign up free</a>
                <a href="{{ route('login') }}">Sign in</a>
                <a href="{{ route('login') }}">Employer portal</a>
                <a href="{{ route('login') }}">Agent portal</a>
                <a href="{{ route('login') }}">Candidate portal</a>
            </div>
            <div class="footer-col">
                <h5>Company</h5>
                <a href="#">About us</a>
                <a href="#">Careers</a>
                <a href="#">Contact</a>
                <a href="#">Privacy policy</a>
                <a href="#">Terms of service</a>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-copy">© {{ date('Y') }} GlobeHire. All rights reserved.</div>
            <div class="footer-links">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="#">Support</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
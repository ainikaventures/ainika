# ainika.

A small studio site. Single-page, vanilla HTML/CSS, ~1 KB of JS.

## Stack

- Pure HTML/CSS in `index.php` (no PHP logic — file extension kept for host routing).
- ~1 KB inline JS (cursor dot + sticky-nav scroll class). Well under the 30 KB budget.
- Google Fonts: Outfit, Inter, JetBrains Mono. `font-display: swap` via Google's stylesheet.
- All critical CSS inlined in `<head>`. No external CSS.
- No third-party scripts, no trackers, no cookie banner.

## Routes

- `/` — single-page site (hero · manifesto · what we do · selected work · studio · contact).
- `/llms.txt`, `/sitemap.xml`, `/robots.txt` — site metadata.
- `/brand/` — all 12 brand assets, served verbatim from `ainika-brand-assets/typo/`.

## Brand assets

Copied verbatim into `/brand/` from the source set:

| File | Used as |
|---|---|
| `ainika-favicon.svg` | Browser tab icon |
| `ainika-favicon-32.png` | Legacy fallback |
| `ainika-apple-touch.svg` | iOS home screen |
| `ainika-og.svg` | Open Graph card (1200×630) |
| `ainika-wordmark-light.svg` | Static fallback (nav uses inline text) |
| Others | Available, not referenced on the home page yet |

## Implemented

- Animated hero wordmark (`ainika.` → collapses to `ai.` → loops every 10s, dot blinks `step-end`).
- Sticky top nav: transparent over the Ink hero, blurs to `rgba(250,250,247,0.72)` on scroll.
- Cursor-following Signal dot (`pointer: fine` only, lerped via `requestAnimationFrame`).
- Smooth scroll between anchors (native CSS — no JS).
- `prefers-reduced-motion` disables blink, collapse, cursor dot, smooth scroll, all transitions.
- Focus rings: `2px solid var(--signal)` with 2px offset.
- Three service cards on the Smoke band.
- Selected Work: 3 alternating tiles (TopListers live, SplitAI + 2048 in development).
- Studio bio + fact stack on Paper.
- Footer/contact on Ink — `let's begin.` lead, `mailto:hello@ainika.xyz`, LinkedIn + GitHub.
- `application/ld+json` ProfessionalService schema in `<head>`.
- OG + Twitter card meta tags.

## Deferred

- **`/work/[slug]` and `/journal/[slug]` templates.** Not built — no case-study or post content exists yet. Selected Work tiles link to live sites (toplisters.xyz) and GitHub repos instead.
- **Journal section.** Hidden from the page per scope decision; will be added when posts exist.
- **Real product screenshots.** Spec rules out stock photography. The three Work tiles use typographic Ink/Smoke blocks (product name in Outfit) until real screenshots exist. The thumbs satisfy "no stock" but the spec's preferred state is real screenshots.
- **Lighthouse run.** Not executed in this sandbox — recommend running before deploy.

## Open questions / notes

- **Founder name vs memory.** The site bio reads "Founded by Josen Ainikkal in 2025." Memory previously stored the founder as "Josen Joy" — overridden per your direction. The LinkedIn URL still points to `linkedin.com/in/josenjoy`. Flag if that should change too.
- **Spec date vs site date.** Spec text said "est. 2026" / "© 2026". Site uses **2025** throughout per your instruction. The `ainika-og.svg` asset's `AI-NATIVE STUDIO · 2026` caption was edited to `2025` to stay consistent — every other brand SVG was left verbatim.
- **Wordmark SVG fonts.** `ainika-wordmark-*.svg` reference a CSS class (`ainika-text`) with no inline `font-family`, so they fall back to the SVG default font when rendered standalone (e.g. RSS readers). The OG card and favicon both inline Outfit so they render correctly. Left verbatim per the "do not redraw" rule.
- **Hosting.** `index.php` extension preserved for Apache routing; the file contains no PHP. Rename to `index.html` if your host serves `.html` as the default index.
- **Selected Work hover.** Whole-tile `<a>` wraps the thumb; the text-side links are separate. Working as intended but worth a tap-target audit on touch.

## Acceptance checklist

- [x] Wordmark renders identically in Chrome (verified). Safari/Firefox: untested in sandbox but uses standard CSS animations.
- [x] `prefers-reduced-motion` disables blink, collapse, and cursor-dot.
- [x] Email link is `mailto:hello@ainika.xyz` (three places: nav CTA, hero CTA, footer email).
- [x] No third-party scripts. Total JS ~1 KB inline.
- [x] All logo SVGs load from `/brand/`; only the animated hero is inline.
- [ ] Lighthouse — not yet run. Static, no JS frameworks, no blocking third-parties. Expected Perf ≥ 95, A11y = 100.
- [ ] OG card preview (Slack/X/LinkedIn) — needs an external check once deployed.
- [ ] Favicon at 16/32/64 — SVG + 32 PNG provided, untested in tab.

## Local preview

```bash
php -S 127.0.0.1:8765
# open http://127.0.0.1:8765/
```

=== FoA Cleaner ===
Contributors: ivans3m
Requires at least: 6.6
Tested up to: 6.8
Requires PHP: 8.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A universal, minimalistic WordPress block theme built on Clean Design principles: self-hosted Geist and DM Sans typography, signature FoA Blue accents, built-in light and dark modes, editorial reading polish, and seamless optional Vibetiles compatibility.

== Description ==

FoA Cleaner is a restraint-first WordPress block theme crafted for SaaS product pages, long-form personal writing, and studio portfolios.

* **100% Native Core Blocks**: Every layout pattern and template uses standard WordPress blocks with zero proprietary shortcodes or theme-locked custom blocks.
* **Self-Hosted Variable Typography**: Bundles SIL OFL 1.1 variable .woff2 fonts — Geist (display & headings), DM Sans (body & overlines), and Geist Mono (metadata & code) — with zero third-party font CDN requests.
* **Built-In FOUC-Free Light & Dark Mode**: Includes a minimal Lucide Sun/Moon switcher in the sticky top header, respects visitor OS preferences, and yields automatically when Vibetiles is active.
* **21 Clean Design Block Patterns**: Bold Display Hero, Centered SaaS Hero, Spec Strip, Big Stats Grid, Dark Principles Band, Feature Cards Grid, Portfolio Grid, Dynamic Portfolio Query Grid, Portfolio Index List, Portfolio Editorial Gallery, Portfolio Full-Bleed Showcase Strip, Case Study Layout, Side-by-Side Comparison Table, Editorial Pull Quote, Testimonials, Three-Tier Pricing, Native FAQ Accordion, Latest Posts Grid, Chronological Yearly Archive, CV Header & Contact Strip, and Dark Closing CTA.
* **4 Curated Global Style Variations**: Default Clean Light (with FoA Blue `#2E70FF`), Swiss Ink, Warm Paper, Midnight Slate (native dark-first), and Forest Studio.
* **Editorial & Reading Polish**: Conditional copy-to-clipboard buttons on code blocks, single-post Focus Mode with a 1px reading progress bar, Auto-Generated Table of Contents (`Long posts only` / `Always on` / `Off` in Appearance > FoA Cleaner with sticky 1280px+ margin rail and collapsible mobile card), chronological Yearly Archive, Wide Page (`1200px`), and print-ready CV / Resume (`page-cv`, styled for `cv-md/1.1` Markdown & native blocks) custom page templates, and Post Format cards (Aside, Quote, Link, Status).
* **Portfolio & Optional Jetpack Integrations**: Includes a native Case Study page template and base/gallery portfolio patterns with zero plugins required, plus a non-intrusive Recommended Companion Plugins panel (Vibetiles & Jetpack) under Appearance > FoA Cleaner with mirrored Jetpack Portfolio and Jetpack Markdown (for CV) toggles and a built-in Create/Edit CV Page Markdown importer (supporting the canonical `cv-md/1.1` format at https://github.com/ivans3m/cv-formatter, optional companion PDF with a subtle `Download CV.md` link beneath it, or a `Download CV.MD` primary button when no PDF is attached).
* **Progressive Micro-Animations**: Subtle IntersectionObserver scroll-reveal transitions enabled by default, with an easy opt-out under Appearance > FoA Cleaner (or via the `foa_cleaner_enable_motion` filter) and automatic `prefers-reduced-motion` support.
* **Vibetiles Ready (Optional)**: Zero hard dependency, full Guest Mode palette and dark-mode coexistence out of the box.

== Installation ==

1. In your WordPress admin panel, go to Appearance > Themes and click "Add New".
2. Upload the `foa-cleaner.zip` archive (or search for "FoA Cleaner" once listed in the WordPress.org directory).
3. Click "Install Now" and then "Activate".
4. Customize navigation, header CTA, footer, templates, and Global Style Variations under Appearance > Editor.
5. Configure the default color mode (Light / System / Dark) and micro-animations toggle under Appearance > FoA Cleaner.

== Frequently Asked Questions ==

= Does FoA Cleaner require any plugins? =

No. Every template, pattern, light/dark switcher, Focus Mode control, copy-code button, and Yearly Archive works completely standalone on WordPress 6.6+. Optional integration with the free Vibetiles plugin activates automatically if installed.

= How do I create a Yearly Archive page? =

Create a new Page, assign the "Yearly Archive" template in the Page sidebar (or insert the "Chronological Yearly Archive" pattern), and publish.

= How do I turn off scroll-reveal animations? =

Go to Appearance > FoA Cleaner and uncheck "Enable subtle scroll-reveal and interaction micro-animations", or return `false` from the `foa_cleaner_enable_motion` PHP filter. Visitors with reduced motion enabled in their operating system always receive static rendering automatically.

= How do I enable Jetpack Portfolio Projects and Markdown in this block theme? =

Go to Appearance > FoA Cleaner. From the Recommended Companion Plugins panel (or the inline Install/Activate Jetpack link beside each option), install and activate Jetpack, then toggle "Jetpack Portfolio" (mirrors Jetpack's `jetpack_portfolio` setting and restores Portfolio Projects in block themes) and/or "Jetpack Markdown (for CV)" (mirrors Jetpack's Markdown module for CV and documentation pages). Without Jetpack, both toggles stay disabled and you can build portfolios natively using Pages, the "Case Study" page template, and FoA Cleaner's portfolio patterns.

= How do I create a CV page from Markdown? =

Enable Jetpack and turn on "Jetpack Markdown (for CV)" under Appearance > FoA Cleaner. The inline "Create CV Page" panel unlocks right beneath the toggle: upload a UTF-8 `cv-md/1.1` Markdown file (see the canonical format specification at https://github.com/ivans3m/cv-formatter) and an optional companion PDF, and FoA Cleaner generates a Draft `/cv/` page with the CV / Resume template, populated CV Header, and Jetpack Markdown body. A sanitized public copy of the `.md` file (with trailing `## Facts` notes stripped) is registered in the WordPress Media Library for easy management alongside the PDF without altering global upload MIME rules. When a PDF is uploaded, the header renders a "Download PDF" button with a subtle "Download CV.md" link directly beneath it so both visitors and AI agents can download the Markdown file. If no PDF is uploaded, the button itself becomes "Download CV.MD" with no second link. Once created, the panel switches to "Edit CV Page" with Publish, Preview/View, Edit, and Delete (Move to Trash) controls.

= Does FoA Cleaner load fonts from Google Fonts? =

No. Geist, DM Sans, and Geist Mono are self-hosted directly inside `assets/fonts/webfonts/` under the SIL Open Font License 1.1.

= Is FoA Cleaner translation-ready? =

Yes. All user-facing strings use the `foa-cleaner` text domain and are cataloged in `languages/foa-cleaner.pot`.

== Changelog ==

= 1.0.0 =
* Initial public release.
* Full Site Editing (`theme.json` v3) design system with Clean Design Light palette and signature `foa-blue` (`#2E70FF`) accent.
* Self-hosted Geist, DM Sans, and Geist Mono variable fonts (SIL OFL 1.1).
* Standalone FOUC-free Light/Dark mode switcher with Appearance > FoA Cleaner defaults and automatic Vibetiles coexistence.
* 10 core block templates including Front Page, Home, Single, Page, Page (No Title / Full Canvas), Yearly Archive, Archive, Search, Index, and 404.
* 15 Clean Design core-block patterns and 14 core block styles.
* 4 curated Global Style Variations: Swiss Ink, Warm Paper, Midnight Slate, and Forest Studio.
* Conditional copy-code button, single-post Focus Mode, 1px reading progress bar, Post Format cards, and progressive micro-animations.

== Copyright ==

FoA Cleaner WordPress Theme, Copyright 2026 Ivan Diuldia (https://ivan.diuldia.com).
FoA Cleaner is distributed under the terms of the GNU General Public License v2 or later.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

FoA Cleaner bundles the following third-party resources:

Geist & Geist Mono
Copyright 2023 Vercel, Inc. (https://vercel.com/font)
License: SIL Open Font License, Version 1.1 (assets/fonts/GEIST-OFL.txt, assets/fonts/GEISTMONO-OFL.txt)
Source: https://github.com/vercel/geist-font

DM Sans
Copyright 2014 The DM Sans Project Authors (https://github.com/googlefonts/dm-fonts)
License: SIL Open Font License, Version 1.1 (assets/fonts/DMSANS-OFL.txt)
Source: https://github.com/googlefonts/dm-fonts

Lucide Icons (inline SVG paths)
Copyright (c) for portions of Lucide are held by Cole Bemis 2013-2022 as part of Feather (MIT). All other copyright (c) for Lucide are held by Lucide Contributors 2022.
License: ISC License (https://lucide.dev/license)
Source: https://lucide.dev

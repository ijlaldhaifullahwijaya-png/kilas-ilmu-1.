---
name: Kilas Ilmu Clarity
colors:
  surface: '#faf8ff'
  surface-dim: '#d1d8ff'
  surface-bright: '#faf8ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f3f2ff'
  surface-container: '#ebedff'
  surface-container-high: '#e4e7ff'
  surface-container-highest: '#dce1ff'
  on-surface: '#071747'
  on-surface-variant: '#434655'
  inverse-surface: '#202d5d'
  inverse-on-surface: '#eff0ff'
  outline: '#737686'
  outline-variant: '#c3c6d7'
  surface-tint: '#0053db'
  primary: '#004ac6'
  on-primary: '#ffffff'
  primary-container: '#2563eb'
  on-primary-container: '#eeefff'
  inverse-primary: '#b4c5ff'
  secondary: '#006e2d'
  on-secondary: '#ffffff'
  secondary-container: '#7cf994'
  on-secondary-container: '#007230'
  tertiary: '#46566c'
  on-tertiary: '#ffffff'
  tertiary-container: '#5e6e85'
  on-tertiary-container: '#e9f0ff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dbe1ff'
  primary-fixed-dim: '#b4c5ff'
  on-primary-fixed: '#00174b'
  on-primary-fixed-variant: '#003ea8'
  secondary-fixed: '#7ffc97'
  secondary-fixed-dim: '#62df7d'
  on-secondary-fixed: '#002109'
  on-secondary-fixed-variant: '#005320'
  tertiary-fixed: '#d3e4fe'
  tertiary-fixed-dim: '#b7c8e1'
  on-tertiary-fixed: '#0b1c30'
  on-tertiary-fixed-variant: '#38485d'
  background: '#faf8ff'
  on-background: '#071747'
  surface-variant: '#dce1ff'
typography:
  display:
    fontFamily: Inter
    fontSize: 3rem
    fontWeight: '700'
    lineHeight: '1.15'
    letterSpacing: -0.025em
  display-mobile:
    fontFamily: Inter
    fontSize: 2.25rem
    fontWeight: '700'
    lineHeight: '1.2'
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 2rem
    fontWeight: '700'
    lineHeight: '1.25'
    letterSpacing: -0.02em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 1.5rem
    fontWeight: '600'
    lineHeight: '1.3'
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Inter
    fontSize: 1.5rem
    fontWeight: '600'
    lineHeight: '1.35'
    letterSpacing: -0.015em
  headline-sm:
    fontFamily: Inter
    fontSize: 1.25rem
    fontWeight: '600'
    lineHeight: '1.4'
    letterSpacing: '0'
  body-lg:
    fontFamily: Inter
    fontSize: 1.125rem
    fontWeight: '400'
    lineHeight: '1.6'
    letterSpacing: '0'
  body-md:
    fontFamily: Inter
    fontSize: 1rem
    fontWeight: '400'
    lineHeight: '1.5'
    letterSpacing: '0'
  body-sm:
    fontFamily: Inter
    fontSize: 0.875rem
    fontWeight: '400'
    lineHeight: '1.5'
    letterSpacing: '0'
  label-md:
    fontFamily: Inter
    fontSize: 0.875rem
    fontWeight: '500'
    lineHeight: '1.25'
    letterSpacing: 0.01em
  label-sm:
    fontFamily: Inter
    fontSize: 0.75rem
    fontWeight: '600'
    lineHeight: '1.25'
    letterSpacing: 0.025em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  gutter: 1.5rem
  gutter-mobile: 1rem
  margin: 2rem
  margin-mobile: 1rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2rem
---

## Brand & Style

The design system embodies modern institutional clarity, academic optimism, and utilitarian discipline. Built specifically for an educational technology competition context, it avoids frivolous embellishments in favor of immediate cognitive comprehension, high readability, and effortless execution.

### Personality & Tone
- **Focused & Calm:** Minimal visual noise to maximize student engagement and retention.
- **Accessible & Trustworthy:** Built with strict color contrast, open spacing, and robust layout structures.
- **Crisp & Modern:** Combines flat aesthetic principles with structural line work and deliberate hierarchy.

### Visual Style
A tailored **Clean Flat** design system featuring solid color planes, crisp hairline borders, generous white space, and subtle, micro-depth accents. It explicitly rejects gradients, heavy dropshadows, glassmorphic blurs, and skeuomorphic bevels.

## Colors

The palette is strictly calibrated for a clean light-mode experience. No dark mode is supported, ensuring deterministic color contrast across every surface.

### Palette Specifications
- **Canvas Base (`#F8FAFC`):** Soft light slate background that minimizes screen glare compared to pure white.
- **Surface (`#FFFFFF`):** High-clarity white for cards, panels, and interaction containers.
- **Border Subtle (`#E2E8F0`):** Single-pixel perimeter framing that structures content without visual weight.
- **Primary Accent (`#2563EB`):** Royal Blue used for dominant interactive triggers, progress bars, and focus states.
- **Primary Accent Hover (`#1D4ED8`):** Deepened blue for tactile hover states.
- **Success (`#16A34A`):** Vivid emerald green reserved for completed modules, verified tasks, and positive feedback.
- **Text Main (`#172554`):** Deep navy offering maximum legibility without the harshness of pure black.
- **Text Secondary (`#64748B`):** Cool slate gray for secondary metadata, labels, and timestamps.
- **Text Inverse (`#FFFFFF`):** White text strictly paired with Primary Accent and Success fills.

## Typography

The type scale relies exclusively on **Inter** (falling back cleanly to system sans-serif: `-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif`). The typographic hierarchy operates on disciplined sizing, deliberate weights (400, 500, 600, 700), and tightened tracking at display sizes to maintain architectural rigor.

- **Headlines:** Set in Deep Navy (`#172554`) to deliver structured anchors across the page.
- **Body Copy:** Set at 16px (`1rem`) minimum for long-form readability, utilizing Slate Gray (`#64748B`) for auxiliary copy and Deep Navy for core content.
- **Labels & Badges:** Standardized at medium and semibold weights with slight tracking expansion to ensure legibility when rendered in smaller containers.

## Layout & Spacing

Layouts adhere to an 8px rhythmic grid wrapped in a centralized fixed-width container system. Side navigation is excluded; layouts prioritize an unencumbered single-axis scroll driven by a persistent horizontal top navigation bar.

### Grid & Max Widths
- **Max Content Width:** `1200px` centered via auto margins.
- **Columns:** 12-column grid on desktop (`>= 1024px`), 6-column grid on tablet (`>= 640px`), and 1-column stack on mobile (`< 640px`).
- **Gutter:** `1.5rem` (24px) desktop, scaling to `1rem` (16px) on mobile screens.

### Navigation Architecture
- **Header:** Sticky or static horizontal bar (height: 64px) pinned to the top of the viewport.
- **Alignment:** Logo left-aligned, pill-based navigation items center- or right-aligned, followed by action buttons.

## Elevation & Depth

Visual hierarchy is maintained primarily through surface contrast and crisp 1px borders rather than elevation stacking. 

### Elevation Strategy
- **Layer 0 (Canvas):** `#F8FAFC` flat surface.
- **Layer 1 (Card & Content Blocks):** `#FFFFFF` fill bounded by a solid `1px` border of `#E2E8F0` and an ultra-subtle micro-shadow: `box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05)`.
- **Layer 2 (Overlays & Modals):** `#FFFFFF` fill bounded by `#E2E8F0` with a clean, low-intensity drop: `box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08), 0 2px 4px -2px rgba(0, 0, 0, 0.04)`.
- **Strict Constraints:** No colored shadow ambient bleeding, no multiple-layer blurred drop shadows, and no glassmorphic `backdrop-filter` effects.

## Shapes

The design system maintains an intentional, friendly geometry with a uniform 12px (`0.75rem` / `rounded-xl`) radius applied to structural surfaces. 

- **Cards, Panels, Inputs, and Modals:** Radiused strictly at `12px` (`0.75rem`) to ensure cohesive curvature.
- **Interactive Badges and Pill Navigators:** Fully rounded (`rounded-full` / `9999px`) for functional status indicators and top navigation pills.
- **Micro Elements (Checkboxes, small indicators):** Radiused at `4px` (`0.25rem`).

## Components

### Buttons
- **Primary:** Background `#2563EB`, text `#FFFFFF`, border `none`, padding `0.625rem 1.25rem`, radius `12px`. Hover state: `#1D4ED8`. Active state: `#1E40AF`.
- **Secondary / Outline:** Background `#FFFFFF`, text `#172554`, border `1px solid #E2E8F0`, padding `0.625rem 1.25rem`, radius `12px`. Hover: background `#F8FAFC`, border `#CBD5E1`.
- **Success / Action:** Background `#16A34A`, text `#FFFFFF`, radius `12px`. Hover: `#15803D`.

### Top Navigation Pills
- **Container:** Height `64px`, background `#FFFFFF`, border-bottom `1px solid #E2E8F0`.
- **Navigation Links:** Inline pills with `0.5rem 1rem` padding, font weight 500, radius `9999px`.
- **Default State:** Transparent background, text `#64748B`.
- **Active / Hover State:** Background `#F1F5F9`, text `#172554` (or `#2563EB` when designated as the active route).

### Cards
- **Base Card:** Background `#FFFFFF`, border `1px solid #E2E8F0`, radius `12px`, micro-shadow `0 1px 2px 0 rgba(0, 0, 0, 0.05)`, padding `1.5rem`.
- **Interactive Card:** Transitions border color to `#2563EB` on hover with no change in shadow blur.

### Chips & Badges
- **Status Chip (Neutral):** Background `#F1F5F9`, text `#64748B`, font-size `0.75rem`, font-weight 600, padding `0.25rem 0.75rem`, radius `9999px`.
- **Status Chip (Success):** Background `#DCFCE7`, text `#16A34A`, font-size `0.75rem`, font-weight 600, padding `0.25rem 0.75rem`, radius `9999px`.
- **Category Badge:** Background `#DBEAFE`, text `#2563EB`, font-size `0.75rem`, font-weight 600, padding `0.25rem 0.75rem`, radius `9999px`.

### Input Fields
- **Standard Input:** Background `#FFFFFF`, border `1px solid #E2E8F0`, radius `12px`, padding `0.625rem 0.875rem`, color `#172554`, font-size `0.875rem`.
- **Focus State:** Outline `none`, border-color `#2563EB`, box-shadow `0 0 0 3px rgba(37, 99, 235, 0.15)`.
- **Placeholder:** Color `#94A3B8`.

### Checkboxes & Radios
- **Checkbox:** Width `1.125rem`, height `1.125rem`, border `1px solid #CBD5E1`, radius `4px`. Checked: background `#2563EB`, border-color `#2563EB`, white checkmark.
- **Radio:** Width `1.125rem`, height `1.125rem`, border `1px solid #CBD5E1`, radius `9999px`. Checked: `#2563EB` inner dot with `#FFFFFF` rim.

### Progress Bars (Educational Path Tracking)
- **Track:** Height `8px`, background `#E2E8F0`, radius `9999px`, overflow hidden.
- **Fill:** Background `#2563EB` (or `#16A34A` upon 100% completion), transition `width 0.3s ease`.
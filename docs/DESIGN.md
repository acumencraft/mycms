# Archvadze Design System

## Spacing Standards
- Section padding: `py-24` (96px top/bottom)
- Container: `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`
- Section header margin-bottom: `mb-16`
- Card padding: `p-8`
- Element gaps: `gap-6` (cards), `gap-12` (alternating layout)

## Typography
- H1 (hero): `text-4xl md:text-5xl font-bold` + `letter-spacing:-0.02em`
- H2 (section): `text-4xl font-bold` + `letter-spacing:-0.02em`
- H3 (card): `text-xl font-semibold`
- Body large: `text-xl text-gray-600 leading-relaxed`
- Body: `text-gray-600 leading-relaxed`
- Small: `text-sm text-gray-500`

## Colors
- Primary: `text-primary` / `bg-primary`
- Primary light: `bg-primary/10 text-primary`
- Gray scale: gray-900 (headings), gray-600 (body), gray-400 (muted), gray-100 (bg)
- Success: `text-green-600`
- Error: `text-red-500`

## Buttons
- Primary: `rounded-md bg-primary text-primary-foreground hover:bg-primary/90 text-sm font-medium h-10 px-6`
- Secondary: `rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 text-sm font-medium h-10 px-6`
- Large: `h-11 px-8`

## Cards
- Standard: `bg-white rounded-xl border border-gray-100 shadow-sm p-8`
- Hover: `hover:shadow-lg transition-all duration-300`
- Dark: `bg-gray-50 rounded-2xl p-8`

## Form Inputs
- Standard: `flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring text-gray-900`
- Textarea: same + `min-h-[80px]`

## Layout Patterns
- Hero section: `pt-24 pb-20`
- Alternating: `grid grid-cols-1 md:grid-cols-2 gap-12 items-center`
- 3-column grid: `grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6`
- Section header: centered, h2 + subtitle paragraph

## Images
- Rounded: `rounded-xl` or `rounded-2xl`
- Aspect ratio: `aspect-video` for service/portfolio images
- Avatar: `w-10 h-10 rounded-full object-cover`

## Footer
- Background: `bg-gray-950`
- Text: `text-gray-300` / muted: `text-gray-400` / `text-gray-500`
- Social icons: `w-8 h-8 bg-gray-800 rounded-lg`

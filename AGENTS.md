# IstanaLaundry / LaundryOS

Static HTML/JS prototype — **no build step, no package manager, no backend.**

## Entry points

- `index.html` — Public landing page (marketing site for Istana Laundry Samarinda)
- `dashboard.html` — The LaundryOS SPA application (~2000+ lines, single-file)
- `TechSheet.md` — Full PRD / TAD / ERD / UI-UX / SRD spec. Read this before proposing architecture changes.

## No build step

Serve the directory with any HTTP server:
```
python3 -m http.server 8000
```
All dependencies are loaded via CDN (Tailwind CSS, Chart.js, Font Awesome, Iconify, Google Fonts).

## App architecture (dashboard.html)

- **Vanilla JS SPA** — no framework, no router. The `render()` function reads global `S` state and rebuilds `#app` innerHTML.
- **State machine** — `S.orders` with status flow: `received → washing → drying → ironing → quality_check → packing → ready → completed`. Transitions are enforced by `nextStatus()`.
- **Mock data only** — all orders, customers, materials, shifts are hardcoded in the `S` object. No real API calls anywhere.
- **PIN login** — demo PIN `1234`. Roles: `cashier`, `workshop`, `owner`, `admin`.
- **Workshop scanner** — accepts text input (USB barcode scanner emulation) or quick-pick buttons. Has 300ms debounce + 1s cooldown + offline queue (`S.offlineQueue`).
- **ESC/POS printing** — sends thermal printer commands to `http://127.0.0.1:8001/print` (mock, `no-cors`).

## Key conventions

- Prices use `fmt()` → `Rp 1.234.567` format (Indonesian locale)
- Phone numbers: always `62xx` format, validated by `validatePhone()`
- Status labels/colors follow `statusLabel()` / `statusColor()` lookup tables
- PPN, rounding, and price tier lookups use dedicated utility functions

## What's NOT in this repo

No backend, no database, no real API, no test suite, no CI/CD, no package.json.

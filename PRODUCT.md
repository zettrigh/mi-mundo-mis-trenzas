# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

Three roles, each with its own dashboard (confirmed by the UserRole enum and the role-specific views):

- **Cliente** — wants braiding or hairstyling at home; books a service with date, time, address, zone, and phone; waits for confirmation; receives the stylist; reviews the completed visit.
- **Estilista a Domicilio** — travels to the client's home; sees assigned appointments and advances them through "En Camino / En Proceso" to "Completada".
- **Administradora** — owner-operator; manages stylist assignment and status of every appointment from the admin dashboard.

## Product Purpose

Booking platform for professional women's braiding and hairstyling performed in the client's home (peinados femeninos a domicilio). A client picks a service from the catalog, proposes date, time, and address, and receives an appointment code (TRZ-XXXXXX). The administrator assigns a stylist, the stylist runs the visit, and the client reviews the completed appointment. Success: a booking moves from request to a completed, reviewed home visit with the client always knowing where it stands.

## Positioning

The salon travels to the client. Neighboring options are fixed-location salons or informal WhatsApp-only arranging; this product's mechanism is structured at-home booking with an accountable lifecycle — a catalog with fixed prices and durations, a formal status flow (Pendiente → Confirmada → En Camino/En Proceso → Completada / Cancelada), appointment codes, stylist assignment, and per-visit reviews.

## Operating Context

- Interface language: Spanish (Venezuela).
- Agent communication with the user — responses, suggestions, questions, and findings — is written in Spanish. This is a standing project preference, confirmed by the user, not a per-session choice.
- Money: prices are stored and shown in USD; showing VES alongside is a committed goal (the app currently prices only in USD).
- WhatsApp is the real coordination channel between client and business; the app supplements it (appointment code, status record) and never replaces the human conversation.
- Payment always happens outside the app — cash or transfer at the door; the platform never processes payment.
- Service is delivered in the client's home; every appointment carries address, zone, client phone, hair details, and access notes (e.g., intercom, elevator).
- This is a school/course project: seeded data and homepage claims (e.g., "4.9/5") are illustrative placeholders, not evidence.

## Capabilities and Constraints

- Roles are fixed: Cliente, Estilista a Domicilio, Administradora.
- Client: books from the active service catalog (category, price, estimated duration, whether extensions are included), cancels with reason, and reviews completed appointments (rating 1–5 + comment).
- Administrator: assigns/changes the stylist and sets status on any appointment; completing stamps `completed_at`.
- Stylist: only the assigned stylist may act, and only to advance to In Progress or Completed.
- Appointment lifecycle with code TRZ-XXXXXX; a client's first booking backfills phone and address on their profile.
- Services: name, slug, category, description, price, estimated duration, image, extensions flag, active flag.
- Email verification is required before dashboard access (Breeze auth).
- No payment processing by commitment; no notifications yet (the "nos comunicaremos contigo" promise is fulfilled out of band, consistent with WhatsApp-first).
- Catalog management gap: services have no admin CRUD; they exist via seeder only.
- Explicitly undecided: whether "zone" becomes a fixed service-coverage list (it is free text today); whether clients may request a preferred stylist at booking (today only the administrator assigns); the VES conversion mechanism for dual pricing.

## Brand Commitments

- Name: Mi Mundo Mis Trenzas.
- Asset: logo at `public/images/logo.jpg` (used in the nav and favicon; not marked as unchangeable).
- Voice: warm, close, feminine Spanish — "tú", celebratory tone, emoji accents in CTAs.

## Evidence on Hand

- Working Laravel app (routes, controllers, Blade views): welcome landing page, role dashboards (admin/stylist/client), Breeze auth, full appointment flow, review flow.
- Seed data (`database/seeders/DatabaseSeeder.php`): 1 administrator (Carla Gómez), 2 stylists (Yomaira Martínez — Knotless/Fulani, Zona Norte; Sofía Valderrama — Box Braids/Twists/Eventos, Zona Este y Centro), 1 client (Valeria Morales), 6 services in 6 categories at $35–$60 and 120–270 minutes, 3 sample appointments, 1 five-star review. All seeded demo content for the school-project context — not real customers, reviews, or work photos (service images are Unsplash URLs).
- Absences future work must not dress up as proof: no real testimonials, no real rating history, no photo library of actual client work, no business metrics. Homepage stats ("100%", "Cero Dolor", "4.9/5") are placeholder copy.

## Product Principles

1. The visit is the product — every surface should make the home visit feel safe and accounted for: what happens, when, who comes, what it costs.
2. Status is the truth — the appointment lifecycle is the backbone; a client should never wonder where her booking stands.
3. WhatsApp is a feature, not a competitor — the app is the structured record the WhatsApp conversation points back to.
4. Trust through specificity — real prices, real durations, clear booking requirements; no surprises at the door.
5. Spanish-first — the interface speaks the way the client speaks; no translation debt.

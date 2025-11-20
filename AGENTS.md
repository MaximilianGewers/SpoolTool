## Project overview
- Symfony 7.3 app running on PHP 8.3 with PostgreSQL (see `composer.json` for platform and bundle requirements).
- Uses Symfony AssetMapper with Tailwind (via `symfonycasts/tailwind-bundle`) for styling, Twig for templating, and Twig Components for reusable UI pieces.
- Turbo UX (`symfony/ux-turbo`) is enabled for progressive, real-time page updates without full reloads.
- Stimulus controllers (from `symfony/stimulus-bundle`) handle small interactive behaviors on the front end.

---


## Code layout

- `src/`  
  Application code.
  - `Entity/` – Doctrine entities and enums used for persistence.
  - `Repository/` – Data access classes, usually extending `ServiceEntityRepository`.
  - `Controller/` – HTTP controllers, returning `Response` or rendering Twig templates.
  - `Form/` – Form types describing form fields, validation, and mapping to DTOs or entities.
  - `Security/`, `EventSubscriber/`, `Service/`, etc. – Additional namespaces may exist; follow established patterns when adding new code.

- `config/`  
  Framework and bundle configuration.
  - `packages/` – Per-bundle config (Doctrine, FrameworkBundle, Security, Twig, etc).
  - `routes/` – Route definitions (PHP, YAML, or attributes imported here).
  - `services.yaml` and friends – Service wiring, autowiring adjustments, aliases, and parameters.
  - Only add configuration that is required for new code; do not rewrite global settings without reason.

- `templates/`  
  Twig templates and components.
  - Layouts (e.g. `base.html.twig`) define the global HTML skeleton.
  - Page templates extend the base layout.
  - Twig Components and partials are used for reusable fragments (navigation, forms, table rows, etc).
  - When changing a view, prefer updating the existing template that the controller renders instead of introducing a new one unless necessary.

- `assets/`  
  Front-end entry points bundled by AssetMapper.
  - `assets/app.js` boots the front-end (imports `styles/app.css`, registers Stimulus controllers, etc).
  - Stimulus controllers live under `assets/controllers/`.
  - `assets/styles/app.css` contains Tailwind directives and custom styles; Tailwind is processed via AssetMapper.
  - When adding JS or CSS, import it into the existing entry points instead of creating new, unused files.

- `public/`  
  Public web root.
  - `index.php` is the front controller used by the web server.
  - Static assets (favicons, robots.txt, built assets from AssetMapper) are served from here.
  - Do not put PHP application logic in `public/` beyond the front controller.

- `migrations/`  
  Doctrine migrations for schema changes.
  - Generate with `php bin/console doctrine:migrations:diff`.
  - Apply with `php bin/console doctrine:migrations:migrate`.
  - Every change to Doctrine entities that affects the schema should have a corresponding migration.

- `var/`  
  Runtime data.
  - Cache, logs, and other writable files.
  - Never commit `var/` contents (except potentially custom subfolders explicitly intended for version control).

- `vendor/`  
  Composer dependencies.
  - Managed by `composer.json` and `composer.lock`.
  - Do not edit files in `vendor/`.

- `tests/`  
  Test suite.
  - PHPUnit tests mirror `src/` structure where possible.
  - When changing behavior, add or update tests in the corresponding namespace.

---

## Coding rules for the assistant

- Follow existing namespaces and directory patterns when adding files.
- Use dependency injection; do not add service locators or global state.
- Keep controllers thin; move business logic into services or domain classes.
- When modifying entities, also check:
  - Related forms
  - Repositories
  - Migrations
  - Templates that render changed fields

When unsure where to place new code, prefer the closest existing pattern in `src/` instead of inventing a new structure.

--- 

## Twig Components

This project uses **Twig Components** to build reusable UI blocks.  
A component consists of:

1. A PHP class defining the API (inputs/props).
2. A Twig template rendering the component.

### Location

- Component classes live under:  
  `src/Twig/Components/`
- Component templates live under:  
  `templates/components/`
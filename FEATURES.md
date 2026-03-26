# Components Features

Functional definition for `softspring/components`.

This file defines the expected behavior and functional scope of the package. It describes what the package must provide to Symfony applications and back offices.

## Purpose

- Provide shared Twig building blocks for Symfony applications.
- Reduce repeated layout work across Softspring bundles and projects.
- Give applications a practical starting point for public pages and admin pages.

## Main Features

- Provide a base Twig layout that applications can extend as their main page skeleton.
- Provide an admin-oriented layout with header, breadcrumb area, sidebar slot, and flash messages.
- Provide reusable paginator templates for page navigation and list tables.
- Provide reusable flash message templates.
- Provide reusable sidebar templates for admin menus.
- Provide an admin horizontal form theme for Bootstrap 5 forms.
- Ship translations for shared UI labels used by the package.

## Theme Expectations

- Support a shared `sfs_components_theme` Twig global.
- Use `bootstrap5` as the default theme for the main layouts and shared templates.
- Keep legacy Semantic UI paginator templates available for projects that still use them.

## Expected Usage

- Extend `@SfsComponents/base.html.twig` to start an application base layout.
- Extend `@SfsComponents/layout/admin.html.twig` to start an admin layout.
- Include `@SfsComponents/flash-messages/alerts.html.twig` to render flash messages consistently.
- Include `@SfsComponents/paginator/pager.html.twig` or embed `@SfsComponents/paginator/table.html.twig` for list pages.
- Use `@SfsComponents/sidebar/sidebar-list.html.twig` or `@SfsComponents/sidebar/sidebar-pills.html.twig` to render admin menus.
- Use `@SfsComponents/forms/admin-horizontal.html.twig` as a Symfony form theme when building admin filters or edit forms.

## Integration Expectations

- The package should work as a template toolbox and not require its own controllers.
- Applications should be able to override any shipped template from their own project templates.
- The admin layout and sidebar templates should compose well with other Softspring packages such as `twig-extra-bundle`, `user-bundle`, and admin menu configuration.
- Projects should be able to choose the shipped templates they need without having to adopt the whole package surface.

## Extension Expectations

- Applications should be able to override base or admin layouts in `templates/bundles/SfsComponentsBundle/`.
- Applications should be able to provide their own sidebar view and menu structure.
- Applications should be able to override Bootstrap classes, blocks, and assets by redefining Twig blocks.
- Applications should be able to keep bundle defaults for most screens and customize only a few templates.

## Current Limits

- The package is template-focused and does not provide business logic or controllers.
- The admin layout assumes common Softspring Twig helpers when optional profile and menu features are used.
- Bootstrap 5 is the main maintained theme; Semantic UI support is limited to paginator templates kept for legacy integrations.

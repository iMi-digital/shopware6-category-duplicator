# Shopware 6 Category Duplicator

## Project Overview

A Shopware 6 plugin that enables duplication of full category subtrees via right-click context menu in the admin panel. When duplicating, the plugin creates a complete copy of the category and all its children with their hierarchical structure preserved.

**Plugin Name:** iMidiCategoryDuplicator
**Namespace:** `iMidiCategoryDuplicator`
**License:** AGPL-3.0-or-later
**Author:** iMi digital GmbH

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP 8.0+ |
| Framework | Shopware 6.6-6.7, Symfony 6.x/7.x |
| API | RESTful (Attribute-based Routing) |
| Admin UI | Vue.js 3 Component Override |
| Templating | Twig |
| Build | Webpack (6.6) / Vite (6.7) |

## Version Compatibility

| Plugin Version | Shopware Version |
|----------------|------------------|
| 2.x | 6.4.x |
| 3.x | 6.6.x - 6.7.x |

> **Note:** Das Plugin verwendet `Component.override()`, das in Shopware 6.8 deprecated wird. Migration zur Composition API wird dann erforderlich.

## Project Structure

```
src/
├── iMidiCategoryDuplicator.php              # Plugin bootstrap class
├── Core/Framework/Api/Controller/
│   └── CloneCategoryController.php          # API controller (94 lines)
└── Resources/
    ├── config/
    │   ├── routes.xml                       # API route definitions
    │   ├── services.xml                     # Dependency injection
    │   └── config.xml                       # Plugin settings UI
    ├── app/administration/src/
    │   ├── main.js                          # Admin module entry
    │   └── module/sw-category/.../
    │       └── sw-category-tree-override/   # Vue.js override
    └── public/administration/js/
        └── i-midi-category-duplicator.js    # Compiled bundle
```

## Key Components

### CloneCategoryController.php

Main API controller handling category duplication:

- **Route:** `POST /api/_admin/imidi-category-duplicator/clone-category/{categoryId}`
- **Methods:**
  - `cloneCategory()` - Entry point, creates clone with " - Copy" suffix
  - `cloneChildren()` - Recursive method for child categories
  - `getCloneBehavior()` - Configures clone based on settings

### Admin Override

The `sw-category-tree` Vue component is overridden to:
- Enable `allow-duplicate="true"` on tree items
- Add `duplicateElement()` method for API calls

## Configuration Options

Two settings available in Admin → Extensions → iMidiCategoryDuplicator:

| Setting | Key | Description |
|---------|-----|-------------|
| Clone Product Categories | `cloneProductCategories` | Also assign products to cloned category |
| Clone Custom Fields | `cloneCustomFields` | Copy custom field values |

## Development

### Installation

```bash
composer require imi/shopware6-category-duplicator
bin/console plugin:refresh
bin/console plugin:install -a iMidiCategoryDuplicator
```

### Building Admin JS

```bash
cd src/Resources/app/administration
npm install
npm run build
```

### Testing Changes

After modifications, rebuild SEO URL indices at `/admin#/sw/settings/cache/index`.

## Known Issues (FIXME in Code)

1. **Positioning** (`CloneCategoryController.php:76`): Cloned category may not appear at expected position
2. **Translation** (`CloneCategoryController.php:80`): " - Copy" suffix is hardcoded, not translatable
3. **SEO URLs**: Not generated for copied categories (manual rebuild required)

## Local Documentation

Detailed documentation is available in `.claude/docs/`:
- `architecture.md` - Plugin architecture and flow diagrams
- `api.md` - API endpoint documentation
- `configuration.md` - Configuration options
- `known-issues.md` - Known problems and workarounds

## Dependencies

Injected services in CloneCategoryController:
- `category.repository` - Shopware Category EntityRepository
- `translator` - TranslatorInterface
- `SystemConfigService` - Plugin configuration access

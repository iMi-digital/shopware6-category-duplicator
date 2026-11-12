This Version is updated with use of AI (Claude) and should work with SW6.6.10.X and SW6.7.?
As I do not have an running Shopware 6.7 it's not testet, I will if i migrate from 6.6.10.X.
Please add Console log if u find an error. - HOTTE

# Shopware 6 Category Duplicator

Shopware 6 extension to duplicate full category subtrees including all child categories.

[![Open in Gitpod](https://gitpod.io/button/open-in-gitpod.svg)](https://gitpod.io/#https://github.com/iMi-digital/shopware6-category-duplicator)

## Installation

```bash
composer require imi/shopware6-category-duplicator
bin/console plugin:refresh
bin/console plugin:install -a iMidiCategoryDuplicator
```

## Version Support

| Plugin Version | Shopware Version |
|----------------|------------------|
| 2.x | 6.4.x |
| 3.x | 6.6.x - 6.7.x |

## How To Use

1. Right click on any category in the tree in the admin panel
2. Choose "Duplicate"
3. The category and all its children will be cloned

![Screenshot](/screenshot.png?raw=true "Screenshot")

## Configuration

Navigate to **Settings > Extensions > iMidiCategoryDuplicator** to configure:

| Setting | Description |
|---------|-------------|
| Clone Product Categories | Also assign products from the original category to the cloned category |
| Clone Custom Fields | Copy custom field values to the cloned categories |

## Known Limitations

- **SEO URLs** are not automatically generated for copied categories. Use `/admin#/sw/settings/cache/index` to rebuild the SEO URL indices after duplicating.
- **Category Position** may need manual adjustment after duplication.
- **" - Copy" Suffix** is hardcoded and not translatable.

For known issues, check the [issues page](https://github.com/iMi-digital/shopware6-category-duplicator/issues).

## About Us - Forked from

iMi digital GmbH offers Shopware related open source modules. If you are confronted with any bugs, you may want to open an issue here.

In need of support or an implementation of a module in an existing system, feel free to contact us. In this case, we will provide full service support for a fee.

Of course we provide development of closed-source modules and full Shopware 6 shops as well.

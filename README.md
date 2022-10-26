# shopware6-category-duplicator

This is work in progress.

## Installation

```
composer require imi/shopware6-category-duplicator
bin/console plugin:refresh
bin/console plugin:install -a iMidiCategoryDuplicator
```

## How To Use

1. Right click on any category in the tree in the admin panel.
2. Choose duplicate

### Remarks

SEO Urls are not generated for the copied category. Please use `/admin#/sw/settings/cache/index` to rebuild the SEO URL indices, once you have configured / moved the copied categories.

For known issues, check the issues page.

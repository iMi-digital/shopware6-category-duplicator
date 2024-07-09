# Shopware 6 Category Duplicator

Shopware 6 extension to full category subtrees.

[![Open in Gitpod](https://gitpod.io/button/open-in-gitpod.svg)](https://gitpod.io/#https://github.com/iMi-digital/shopware6-category-duplicator)

## Installation

```
composer require imi/shopware6-category-duplicator
bin/console plugin:refresh
bin/console plugin:install -a iMidiCategoryDuplicator
```

## Version Support

* For Shopware 6.4 use the latest 2.x Version
* For Shopware 6.6 use the latest 4.x Version

We currently do not plan support for Shopware 6.5 - we spare out the 3.x versions, in case anyone wants to add support. 

## How To Use

1. Right click on any category in the tree in the admin panel.
2. Choose duplicate

![Screenshot](/screenshot.png?raw=true "Screenshot")

### Remarks

SEO Urls are not generated for the copied category. Please use `/admin#/sw/settings/cache/index` to rebuild the SEO URL indices, once you have configured / moved the copied categories.

For known issues, check the issues page.


## About Us

iMi digital GmbH offers Shopware related open source modules. If you are confronted with any bugs, you may want to open an issue here.

In need of support or an implementation of a modul in an existing system, free to contact us. In this case, we will provide full service support for a fee.

Of course we provide development of closed-source modules and full Shopware 6 shops as well.

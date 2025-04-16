# Blank Magento 2 Classic Frontend

Module for hiding the classic Magento frontend in headless setups.

This only affects routes that use the page layout system. This means APIs that are
implemented in the frontend area still function as usual (like Adyen notifications).

## Installation
```sh
composer require reach-digital/magento2-blank-classic-frontend
```

## Configuration
You can make the classic frontend redirect to the URL configured as base link url
by setting the `blank_classic_frontend/general/should_redirect` configuation option.

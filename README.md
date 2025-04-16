# Blank Magento 2 Classic Frontend

Module for hiding the classic Magento frontend in headless setups.

This only affects routes that use the page layout system. This means APIs that are
implemented in the frontend area still function as usual (like Adyen notifications).

## Allowing additional routes

To enable page layout rendering for specific routes, these can be injected into the
`allowedRoutes` parameter of `\ReachDigital\BlankClassicFrontend\Plugin\PreventLayoutRendering`

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <type name="Magento\Framework\View\Result\Page">
        <plugin name="ReachDigitalPreventFrontendLayoutRendering" type="ReachDigital\BlankClassicFrontend\Plugin\PreventLayoutRendering"/>
    </type>
    <type name="ReachDigital\BlankClassicFrontend\Plugin\PreventLayoutRendering">
        <arguments>
            <argument name="allowedRoutes" xsi:type="array">
                <item name="swagger" xsi:type="string">swagger</item>
            </argument>
        </arguments>
    </type>
</config>
```

(The above example is already included in the package)

## Installation
```sh
composer require reach-digital/magento2-blank-classic-frontend
```

## Configuration
You can make the classic frontend redirect to the URL configured as base link url
by setting the `blank_classic_frontend/general/should_redirect` configuation option.

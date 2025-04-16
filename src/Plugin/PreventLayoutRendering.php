<?php

namespace ReachDigital\BlankClassicFrontend\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Request\Http as RequestHttp;
use Magento\Framework\View\Result\Page;
use Magento\Store\Model\ScopeInterface;

class PreventLayoutRendering
{
    private ScopeConfigInterface $scopeConfig;
    private RequestHttp $request;
    private array $allowedRoutes;

    public function __construct (
        ScopeConfigInterface $scopeConfig,
        RequestHttp $request,
        array $allowedRoutes = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
        $this->allowedRoutes = $allowedRoutes;
    }

    public function afterRenderResult(
        Page $subject,
        $result,
        $response
    ) {
        $shouldBlankFrontend = $this->scopeConfig->isSetFlag('blank_classic_frontend/general/enabled', ScopeInterface::SCOPE_STORE);
        $shouldRedirect = $this->scopeConfig->isSetFlag('blank_classic_frontend/general/should_redirect', ScopeInterface::SCOPE_STORE);

        if ($shouldBlankFrontend) {
            if ($this->routeIsAllowed($this->request->getRouteName())) {
                return $result;
            }
            /** @var \Magento\Framework\App\Response\Http $response */
            $response->clearBody();
            if ($shouldRedirect) {
                $customUrl = $this->scopeConfig->getValue('blank_classic_frontend/general/custom_redirect', ScopeInterface::SCOPE_STORE) ?? '';
                $baseUrl = $this->scopeConfig->getValue('web/secure/base_link_url', ScopeInterface::SCOPE_STORE);
                $response->setRedirect(strlen(trim($customUrl)) > 0 ? $customUrl : $baseUrl);
            }
        }

        return $result;
    }

    public function routeIsAllowed(string $routeName): bool
    {
        return in_array($routeName, $this->allowedRoutes);
    }
}

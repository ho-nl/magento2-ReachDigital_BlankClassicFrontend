<?php

namespace ReachDigital\BlankClassicFrontend\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Request\Http as RequestHttp;
use Magento\Framework\View\Result\Page;
use Magento\Store\Model\ScopeInterface;

class PreventLayoutRendering
{
    protected ScopeConfigInterface $scopeConfig;

    const allowedRoutes = [
        'swagger',
    ];
    private RequestHttp $request;

    public function __construct (
        ScopeConfigInterface $scopeConfig,
        RequestHttp $request
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
    }

    public function afterRenderResult(
        Page $subject,
        $result,
        $response
    ) {
        $shouldBlankFrontend = $this->scopeConfig->isSetFlag("blank_classic_frontend/general/enabled", ScopeInterface::SCOPE_STORE);
        $shouldRedirect = $this->scopeConfig->isSetFlag("blank_classic_frontend/general/should_redirect", ScopeInterface::SCOPE_STORE);

        if ($shouldBlankFrontend) {
            if ($this->routeIsAllowed()) {
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

    private function routeIsAllowed(): bool
    {
        return in_array($this->request->getRouteName(), self::allowedRoutes);
    }
}

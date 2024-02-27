<?php

namespace ReachDigital\BlankClassicFrontend\Plugin;

use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;

class CancelLayoutRendering
{
    /**
     * @var State
     */
    protected $_state;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @param State $state
     */
    public function __construct (
        State $state,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->_state = $state;
        $this->_scopeConfig = $scopeConfig;
    }

    public function afterGetOutput($subject, $result) {
        if ($this->_state->getAreaCode() == Area::AREA_FRONTEND) {
            if($this->_scopeConfig->isSetFlag("blank_classic_frontend/general/should_redirect")) {
                $base_link_url = $this->_scopeConfig->getValue('web/secure/base_link_url', "store");
                return sprintf('<meta http-equiv="refresh" content="0;url=%s">', $base_link_url);
            } else {
                return '';
            }
        }

        return $result;
    }
}

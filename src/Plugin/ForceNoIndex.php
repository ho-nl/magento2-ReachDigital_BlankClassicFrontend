<?php

namespace ReachDigital\BlankClassicFrontend\Plugin;

use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;

class ForceNoIndex
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
    public function __construct(
        State                $state,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->_state = $state;
        $this->_scopeConfig = $scopeConfig;
    }

    public function afterGetRobots($subject, $result)
    {
        $shouldBlankFrontend = $this->_scopeConfig->isSetFlag("blank_classic_frontend/general/enabled", "store");
        $shouldForceNoIndex = $this->_scopeConfig->isSetFlag("blank_classic_frontend/general/noindex_nofollow", "store");
        if ($shouldBlankFrontend && $shouldForceNoIndex && $this->_state->getAreaCode() == Area::AREA_FRONTEND) {
            return 'NOINDEX,NOFOLLOW';
        }

        return $result;
    }
}

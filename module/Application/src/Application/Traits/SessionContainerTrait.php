<?php

namespace Application\Traits;

use Zend\Session\Container as SessionContainer;

trait SessionContainerTrait {

    private $sessionContainer;

    /**
     *
     * @return SessionContainer
     */
    public function getSessionContainer()
    {
        $scn = get_class($this);

        if (null === $this->sessionContainer) {
            $this->sessionContainer = new SessionContainer( $scn );
        }
        return $this->sessionContainer;
    }

    /**
     *
     * @param SessionContainer $sessionContainer
     * @return self
     */
    public function setSessionContainer(SessionContainer $sessionContainer)
    {
        $this->sessionContainer = $sessionContainer;
        return $this;
    }
}
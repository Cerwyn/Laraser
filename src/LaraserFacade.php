<?php

namespace Cerwyn\Laraser;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Cerwyn\Laraser\Skeleton\SkeletonClass
 */
class LaraserFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laraser';
    }
}

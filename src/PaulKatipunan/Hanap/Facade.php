<?php 

namespace Mannysoft\Hanap;

class Facade extends \Illuminate\Support\Facades\Facade {
    /**
     * Return facade accessor
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'hanap';
    }
}
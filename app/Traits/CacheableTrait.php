<?php

namespace App\Traits;

use Cache;

trait CacheableTrait
{
    private $store;
    private $cacheable = true;
    private $cacheKey;

    public function disableCache()
    {
        $this->cacheable = false;

        $this->store = Cache::store('null');
    }

    private function cachekey($index)
    {
        // Warning: 不可變更快取鍵名的順序
        return [
            'CACHEKEY_ALLROLES',
            'CACHEKEY_ALLRRIVILEGES',
            'CACHEKEY_ALLUSERS'
        ][$index];
    }

    /**
     * After call this method, you can use $this->store to deal with cache directly
     *
     * @return void
     */
    private function cacheStore()
    {
        if( $this->cacheable===true ) $this->store = Cache::store();
    }


}
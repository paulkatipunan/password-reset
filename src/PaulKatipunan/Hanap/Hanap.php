<?php 

namespace Mannysoft\Hanap;

class Hanap {
    

    public function __construct()
    {
        //$this->client = new Client;
    }

    public function filter()
    {
        return 'filter';
    }

    public function sort($request)
    {
        
    }

    public function search()
    {
        return 'search';
    }

    public function showFields($array)
    {
        // If fields is available in query then just
        // return the fields
        if (request('fields')) {
            $fields = explode(',', request('fields'));

            if (count($fields) != 0) {
                return collect($array)->only($fields)->toArray();
            }
        }

        return $array;
    }

    // use this for hiding fileds
    // https://hackernoon.com/hiding-api-fields-dynamically-laravel-5-5-82744f1dd15a

}
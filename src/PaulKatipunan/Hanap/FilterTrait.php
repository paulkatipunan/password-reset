<?php 

namespace Mannysoft\Hanap;

use Sofa\Eloquence\Eloquence;

use DB;


trait FilterTrait
{
    use Eloquence;
    
    public function scopeFilter($query)
    {
        $fields = request()->except(['sort', 'q']);

        $fieldFilter = [];

        foreach ($fields as $key => $val) {
            if (in_array($key, $this->filters)) {
                $fieldFilter[] = $key;
                if (in_array($key, $this->getColumns())) {
                    $query->where($key, $val);
                }
            }
        }

        return $query;
    }

    public function scopeSort($query)
    {
        if ( ! request('sort') ) {
            return;
        }
        $fields = explode(',', request('sort'));

        // if the sort value is only one then
        // use only one field
        if (count($fields) == 1) {
            
            $order = 'asc';

            $field = $fields[0];

            // Check the first letter of the text
            if (substr($fields[0], 0, 1) == '-') {
                $order = 'desc';

                $field = substr($fields[0], 1);
            }

            if (in_array($field, $this->getColumns())) {
                return $query->orderBy($field, $order);
            }

            

        } else {
            foreach ($fields as $field) {
                $order = 'asc';

                // Check the first letter of the text
                if (substr($field, 0, 1) == '-') {
                    $order = 'desc';

                    $field = substr($field, 1);
                }
                if (in_array($field, $this->getColumns())) {
                    $query->orderBy($field, $order);
                }
            }

            return $query;

        }
    }

    public function scopeSearchRecord($query)
    {
        if ( ! request('q') ) {
            return;
        }

        return $query->search(request('q'));
    }

   
    private function getColumns()
    {
        return DB::connection()->getSchemaBuilder()->getColumnListing($this->table);
    }
}
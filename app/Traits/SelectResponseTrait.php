<?php

// app/Traits/SelectResponseTrait.php

namespace App\Traits;

trait SelectResponseTrait
{
    public function generateSelectResponse($selectCollection,$attribute,$price_type=null)
    {
        $arr_data = array();
        $key = 0;

        if ($selectCollection) {
            foreach ($selectCollection->get() as $select) {
                $arr_data[$key]['id'] = $select->id;                
                $arr_data[$key]['text'] = isset($select->{$attribute}) ? $select->{$attribute} : null ;

                if($price_type != null)
                {
                    $arr_data[$key]['price'] = isset($select->{$price_type}) ? $select->{$price_type} : null;
                }

                $key++;
            }
        }

        return json_encode($arr_data);
    }
}
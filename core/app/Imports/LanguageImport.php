<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class LanguageImport implements ToCollection
{

    protected $lang;

    function __construct($lang)
    {
        $this->lang = $lang;
    }
   
    public function collection(Collection $collection)
    {
        $language = $this->lang;
        $newArray = [];

        foreach ($collection->toArray() as $key => $value) {
            if($key == 0) continue;
            $newArray[$value[0]] = $value[1];

        }

        file_put_contents(resource_path()."/lang/$language->short_code.json",json_encode(array_filter($newArray)));
    }
}

<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class LanguageExport implements FromView
{
    protected $languages;

    public function __construct(array $languages)
    {
        $this->languages = $languages;
    }

    public function view(): View
    {
        return view('backend.language.excel', [
            'languages' => $this->languages
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * Export Credits
     *
     * @return \Illuminate\Http\Response
     */
    public function credits()
    {
        return (new \App\Exports\HistoryExport('1bbbSqqR8ikdy7aFjzxbAg36mm1hrdhE8'))->download('1bbbSqqR8ikdy7aFjzxbAg36mm1hrdhE8.xlsx');
    }
}

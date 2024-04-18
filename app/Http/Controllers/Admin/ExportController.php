<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportProduct;
use App\Exports\ExportProject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportUsers;
// use Excel;



// use App\Exports;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;




class ExportController extends Controller
{
    //
    public function export_projects(){return Excel::download(new ExportProject, 'projects.xlsx');}
    public function export_products(){return Excel::download(new ExportProduct, 'products.xlsx');}
}

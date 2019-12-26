<?php namespace App\Http\Controllers;

use Date;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller;

class Dashboard extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('dashboard');
    }
}
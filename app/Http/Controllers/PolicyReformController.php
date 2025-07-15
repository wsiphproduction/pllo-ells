<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Page;
use App\Models\Member;
use App\Models\PolicyReform;
use App\Models\PolicyReformCategory;

class PolicyReformController extends Controller
{
    
    public function index()
    {
        $page = new Page;
        $page->name = 'Policy Reforms';
        $bills = PolicyReform::all();
        $categories = PolicyReformCategory::all();

        return view('theme.pages.policy-reform.index', compact('page', 'bills', 'categories'));
    }
}

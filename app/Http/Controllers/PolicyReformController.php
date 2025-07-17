<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Page;
use App\Models\Member;
use App\Models\PolicyReform;
use App\Models\PolicyReformCategory;

use Auth;
use Session;
use Storage;
use Image;

class PolicyReformController extends Controller
{
    
    public function index()
    {
        $page = new Page;
        $page->name = 'Policy Reforms';
        $categories = PolicyReformCategory::all();
        $bills = PolicyReform::query()->where('deleted_at', null);

        if(request('bill_word')) {
            $bills->where(function ($query) {
                $word = request('bill_word');
                $query->where('title', 'like', "%{$word}%")
                    ->orWhere('description', 'like', "%{$word}%");
            });
        }

        if(request('category_select')) {
            $bills->where(function ($query) {
                $word = request('category_select');
                $query->where('category', $word);
            });
        }

        $bills = $bills->get();

        return view('theme.pages.policy-reform.index', compact('page', 'bills', 'categories'));
    }

    public function view($id)
    {
        $page = new Page;
        $page->name = 'View Policy Reform';

        $bill = PolicyReform::find($id);


        return view('theme.pages.policy-reform.view', compact('page', 'bill'));
    }

    public function create()
    {
        $page = new Page;
        $page->name = 'PROPOSE A BILL';

        $categories = PolicyReformCategory::all();

        return view('theme.pages.policy-reform.create', compact('page', 'categories'));
    }

    public function store(Request $request)
    {
        // Simple validation
        if(!$request->category) {
            return back()->with('error', 'Please select a category.');
        }

        if ($request->hasFile('photo')) {

            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = 'storage/bills/' . $filename;

            Storage::disk('public')->putFileAs('bills', $image, $filename);

            $photo = $path;

        } else {
            return back()->with('error', 'Please upload a photo.');
        }

        // Save
        $requests = $request->all();
        $requests['photo'] = $photo;
        PolicyReform::create($requests);

        return redirect()->route('policyreform.index')->with('success','Proposed Bill Submited.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Page;
use App\Models\Member;
use App\Models\PolicyReform;
use App\Models\PolicyReformAction;
use App\Models\PolicyReformComment;
use App\Models\PolicyReformBookmark;
use App\Models\PolicyReformCategory;

use Auth;
use Session;
use Storage;
use Image;

class PolicyReformController extends Controller
{
    
    public function index()
    {
        if(!Auth::user()){
            session(['url.intended' => url()->current()]);
            return redirect()->route('home')->with('error', 'Access Denied');
        }
        
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
        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'Access Denied');
        }

        $page = new Page;
        $page->name = 'View Policy Reform';

        $bill = PolicyReform::find($id);

        if(auth()->user()->is_an_admin()) {
            return back()->with('error', 'Viewing policy reform is for members only.');
        }

        $member = Member::where('user_id', auth()->user()->id )->first();
        $bookmark = PolicyReformBookmark::where('member_id', $member->id)
                                        ->where('policy_reform_id', $bill->id)
                                        ->first();
        $like = PolicyReformAction::where('member_id', $member->id)
                                        ->where('policy_reform_id', $bill->id)
                                        ->where('action_type', 'like')
                                        ->first();
        $dislike = PolicyReformAction::where('member_id', $member->id)
                                        ->where('policy_reform_id', $bill->id)
                                        ->where('action_type', 'dislike')
                                        ->first();
        $likers = PolicyReformAction::where('action_type', 'like')
                                    ->join('members', 'members.id', 'policy_reform_actions.member_id',)
                                    ->join('designation', 'designation.id', 'members.designation',)
                                    ->limit(3)
                                    ->get();
        $comments = PolicyReformComment::where('policy_reform_id', $bill->id)
                                        ->get();

        return view('theme.pages.policy-reform.view', compact('page', 'bill', 'bookmark', 'like', 'dislike', 'likers', 'comments'));
    }

    public function create()
    {
        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'Access Denied');
        }

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

        if ($request->hasFile('document')) {

            $document_image = $request->file('document');
            $document_filename = time() . '.' . $document_image->getClientOriginalExtension();
            $document_path = 'storage/documents/' . $document_filename;

            Storage::disk('public')->putFileAs('documents', $document_image, $document_filename);

            $document = $document_path;

        } else {
            return back()->with('error', 'Please upload a document.');
        }


        $member = Member::where('user_id', $request['member_id'])->first();

        // Save
        $requests = $request->all();
        $requests['team'] = implode("::", $request['team']);
        $requests['member_id'] = $member->id;
        $requests['photo'] = $photo;
        $requests['document'] = $document;
        PolicyReform::create($requests);

        return redirect()->route('policyreform.index')->with('success','Proposed Bill Submited.');
    }

    public function bookmark(Request $request)
    {
        $requests = $request->all();
        $member = Member::where('user_id', $request->member_id)->first();
        $requests['member_id'] = $member->id;
        PolicyReformBookmark::create($requests);

        return back()->with('success', 'Policy Reform Bookmarked.');
    }

    public function unbookmark(Request $request)
    {
        $requests = $request->all();
        $member = Member::where('user_id', $request->member_id)->first();
        $bookmark = PolicyReformBookmark::where('member_id', $member->id)
                                        ->where('policy_reform_id', $request->bookmark_id)
                                        ->first();
        $bookmark->delete();

        return back()->with('error', 'Policy Reform Unbookmarked.');
    }

    public function like(Request $request)
    {
        $requests = $request->all();
        $member = Member::where('user_id', $request->member_id)->first();
        $requests['member_id'] = $member->id;
        $requests['policy_reform_id'] = $request->like_id;
        $requests['action_type'] = 'like';
        $policyreform = PolicyReform::find($request->like_id);
        $bill = PolicyReformAction::where('member_id', $member->id)
                                      ->where('policy_reform_id', $request->like_id)
                                      ->first();

        if($bill) {
            $bill->action_type = 'like';
            $bill->save();
            $policyreform->like = $policyreform->like + 1;
            $policyreform->dislike = $policyreform->dislike - 1;
            $policyreform->save();
        } else {
            $policyreform->like = $policyreform->like + 1;
            $policyreform->save();
            PolicyReformAction::create($requests);
        }

        return back()->with('success', 'Policy Reform Liked.');
    }

    public function dislike(Request $request)
    {
        $requests = $request->all();
        $member = Member::where('user_id', $request->member_id)->first();
        $requests['member_id'] = $member->id;
        $requests['policy_reform_id'] = $request->dislike_id;
        $requests['action_type'] = 'like';
        $policyreform = PolicyReform::find($request->dislike_id);
        $bill = PolicyReformAction::where('member_id', $member->id)
                                      ->where('policy_reform_id', $request->dislike_id)
                                      ->first();

        if($bill) {
            $bill->action_type = 'dislike';
            $bill->save();
            $policyreform->like = $policyreform->like - 1;
            $policyreform->dislike = $policyreform->dislike + 1;
            $policyreform->save();
        } else {
            PolicyReformAction::create($requests);
            $policyreform->dislike = $policyreform->dislike + 1;
            $policyreform->save();
        }

        return back()->with('error', 'Policy Reform Disliked.');
    }

    public function comment(Request $request)
    {
        $member = Member::where('user_id', auth()->user()->id )->first();
        $requests = $request->all();
        $requests['member_id'] = $member->id;
        $requests['policy_reform_id'] = $request->bill_id;
        PolicyReformComment::create($requests);

        return back()->with('success', 'Your comment added.');
    }
}

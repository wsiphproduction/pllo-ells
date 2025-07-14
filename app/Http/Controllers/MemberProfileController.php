<?php

namespace App\Http\Controllers;

use Facades\App\Helpers\FileHelper;
use Facades\App\Helpers\ListingHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Helpers\Setting;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\RegisterMail;
use App\Mail\RegisterConfirmationMail;

use App\Models\Hor;
use App\Models\User;
use App\Models\Page;
use App\Models\Gender;
use App\Models\Agency;
use App\Models\Member;
use App\Models\Senator;
use App\Models\Article;
use App\Models\Cluster;
use App\Models\Official;
use App\Models\UserType;
use App\Models\SubAgency;
use App\Models\Designation;
use App\Models\SavedContact;
use App\Models\Custom\Event;
use App\Models\MessagingNumber;
use App\Models\Custom\EventParticipant;

use DB;
use Auth;
use Session;
use Storage;
use Image;

class MemberProfileController extends Controller
{

	private $searchFields = ['name'];

	private $page_limit = 10;

	public function memberDashboard() {

	    $page = new Page();
	    $page->name = 'Member Dashboard';

	    $memberDetails = Member::where('user_id', Auth::user()->id)->first();

	    $genders = Gender::all();
	    $clustersList = Cluster::all();
	    $policy_reforms = Article::all();
	    $memberAgency = Agency::find($memberDetails->agency);
	    $saved_contacts = SavedContact::where('user_id', $memberDetails->user_id)->get();
	    $events  = EventParticipant::where('member_id', $memberDetails->id)->get();
	    $userTypeMembers = Member::where('user_type', $memberDetails->user_type)
	    							->where('user_id', '<>', Auth::user()->id)
	    							->get();

	    if (auth()->user()) {
	        return view('theme.pages.member.dashboard', compact('page', 'memberDetails', 'clustersList', 'memberAgency', 'events', 'genders', 'userTypeMembers', 'saved_contacts', 'policy_reforms'));
	    } else {
	        return back()->with('error', ('Please login to your account.'));
	    }

	}

	// Delete User Account
	public function memberDelete(Request $request)
	{
		$member = Member::find($request->member_id);
		$member->delete();

		$user = User::find($request->user_id);
		$user->delete();

		Auth::logout();
		return redirect()->route('home')->with('success', 'Account deleted!');
	}

	public function senatorProfileUpdate(Request $request, $id) {

		$birth_arr = [$request['sen_month'], $request['sen_day']];
		$sen_birthday = implode('::', $birth_arr);

		if ($request['sen_email_agree'] == 'on') {
			$request['sen_email_agree'] = 1;
		} else { $request['sen_email_agree'] = 0; }
		if ($request['sen_landline_agree'] == 'on') {
			$request['sen_landline_agree'] = 1;
		} else { $request['sen_landline_agree'] = 0; }
		if ($request['sen_office_cellphone_agree'] == 'on') {
			$request['sen_office_cellphone_agree'] = 1;
		} else { $request['sen_office_cellphone_agree'] = 0; }

		$requests = $request->all();
		unset($requests['_token']);
		unset($requests['sen_month']);
		unset($requests['sen_day']);
		Senator::where('id', $id)->update($requests);

		return back()->with('success', 'Senator details updated.');
	}

	public function horProfileUpdate(Request $request, $id) {

		if ($request['hor_email_agree'] == 'on') {
			$request['hor_email_agree'] = 1;
		} else { $request['hor_email_agree'] = 0; }
		if ($request['hor_landline_agree'] == 'on') {
			$request['hor_landline_agree'] = 1;
		} else { $request['hor_landline_agree'] = 0; }
		if ($request['hor_office_cellphone_agree'] == 'on') {
			$request['hor_office_cellphone_agree'] = 1;
		} else { $request['hor_office_cellphone_agree'] = 0; }

		$request['hor_birthday'] = $request['hor_month']."::".$request['hor_day'];
		
		$requests = $request->all();
		unset($requests['_token']);
		unset($requests['hor_month']);
		unset($requests['hor_day']);
		Hor::where('id', $id)->update($requests);

		return back()->with('success', 'Representative details updated.');
	}

	public function profileAddContact(Request $request) {

		$requests = $request->all();
		$contact = SavedContact::create($requests);

		return back()->with('success', 'Contact added.');

	}

	public function profileRemoveContact(Request $request) {

		$saved_contact = SavedContact::where('user_id', Auth()->user()->id)
									 ->where('contact_id', $request->contact_id)
									 ->first();
		$saved_contact->delete();

		return back()->with('success', 'Contact removed.');

	}

	// Directory Fuctions
	public function directory(Request $request)
	{
	    if(!Auth::user()){
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'Cabinet Members';
	    
	    $members = Official::query()->whereIn('position', ['president','vice-president','cabinet-member']);

	    if (request('member_name')) {
	        $members->where(function ($query) {
	            $name = request('member_name');
	            $query->where('firstname', 'like', "%{$name}%")
	                ->orWhere('lastname', 'like', "%{$name}%");
	        });
	    }

	    $members = $members->paginate($this->page_limit);
	    // dd($members);
	    return view('theme.pages.directory.cabinet', compact('page', 'members'));
	}

	public function llsDirectory(Request $request)
	{	
		if(!Auth::user()){
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'LLS Members';
	    
	    $birthmonth = 0;
	    $designations = Designation::where('user_type_id', 1)->get();
	    $members = Member::query()->where('user_id', '<>', Auth()->user()->id)
	    						  ->where('user_type', 1);

	    // filters
	    if (request('member_name')) {
	        $members->where(function ($query) {
	            $name = request('member_name');
	            $query->where('firstname', 'like', "%{$name}%")
	                ->orWhere('lastname', 'like', "%{$name}%");
	        });
	    }

	    if (request('designation')) {
	    	$designation = request('designation');
	    	if ($designation) {
		        $members = Member::where('user_id', '<>', Auth()->user()->id)
		        				->where('user_type', 1)
		        				->join('designation', 'designation.id', 'members.designation')
		        				->where('designation.id', $designation)
		        				->get();
	    	} else {
	    		$members = Member::where('user_id', '<>', Auth()->user()->id)
		        				->where('user_type', 1)
		        				->get();
	    	}
	    }

	    if (request('birthmonth')) {
	    	$birthmonth = request('birthmonth');
	    	if ($birthmonth) {
	    		$members = Member::where('user_id', '<>', Auth()->user()->id)
	    						->where('user_type', 1)
		        				->where('birthdate', 'like', "%{$birthmonth}%")
		        				->get();
	    	}
	    }
	    // end filters

	    $members = $members->paginate($this->page_limit);

		return view('theme.pages.directory.lls', compact('page', 'members', 'designations'));
	}

	public function plloDirectory(Request $request)
	{
		if(!Auth::user()){
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'PLLO';
	    
	    $members = Member::query()->where('user_id', '<>', Auth()->user()->id)
	    					->where('user_type', 6);

	    if (request('member_name')) {
	        $members->where(function ($query) {
	            $name = request('member_name');
	            $query->where('firstname', 'like', "%{$name}%")
	                ->orWhere('lastname', 'like', "%{$name}%");
	        });
	    }

	    $members = $members->paginate($this->page_limit);

		return view('theme.pages.directory.pllo', compact('page', 'members'));
	}

	public function senartorsDirectory(Request $request)
	{
		if(!Auth::user()){
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'Senators';

		return view('theme.pages.directory.senator', compact('page'));
	}

	public function senartorStaffDirectory(Request $request)
	{
		if(!Auth::user()){
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'Senators Staff';

		return view('theme.pages.directory.senator-staff', compact('page'));
	}

	public function senartorComSecDirectory(Request $request)
	{
		if(!Auth::user()){
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'Senators Committee Secretary';

		return view('theme.pages.directory.senator-com-sec', compact('page'));
	}

	public function horsDirectory(Request $request)
	{
		if(!Auth::user()){
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'House of Representatives';

		return view('theme.pages.directory.hor', compact('page'));
	}

	public function horStaffDirectory(Request $request)
	{
		if(!Auth::user()){
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'House of Representatives Staff';

		return view('theme.pages.directory.hor-staff', compact('page'));
	}

	public function horComSecDirectory(Request $request)
	{
		if(!Auth::user()){
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'House of Representatives Committee Secretary';

		return view('theme.pages.directory.hor-com-sec', compact('page'));
	}

}
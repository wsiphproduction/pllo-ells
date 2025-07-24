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
use App\Models\MemberStaff;
use App\Models\Designation;
use App\Models\SavedContact;
use App\Models\SavedContactStaff;
use App\Models\SavedContactOfficial;
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
	    $saved_contacts_official = SavedContactOfficial::where('user_id', $memberDetails->user_id)->get();
	    $saved_contacts_staff = SavedContactStaff::where('user_id', $memberDetails->user_id)->get();
	    $events  = EventParticipant::where('member_id', $memberDetails->id)->get();
	    $userTypeMembers = Member::where('user_type', $memberDetails->user_type)
	    							->where('user_id', '<>', Auth::user()->id)
	    							->get();

	    if ($memberDetails->user_type < 5) { $staffs = MemberStaff::where('member_id', $memberDetails->id)->get(); } else { $staffs = null; }

	    if (auth()->user()) {
	        return view('theme.pages.member.dashboard', compact('page', 'memberDetails', 'clustersList', 'memberAgency', 'events', 'genders', 'userTypeMembers', 'saved_contacts', 'saved_contacts_official', 'saved_contacts_staff', 'policy_reforms', 'staffs'));
	    } else {
	        return back()->with('error', ('Please login to your account.'));
	    }

	}

	public function memberProfileUpdate(Request $request) {
		// dd($request->all());
	    $member = Member::where('user_id', auth()->user()->id)->first();
	    $user = User::find(auth()->user()->id);
	    
	    if(auth()->user()->password == $request->password) {
	        $requests['password'] = auth()->user()->password;
	    } else {
	        $member->password = Hash::make($request->password);
	        $user->password = $member->password;
	        if($request->password != $request->alt_password) {
	            return back()->with('error', ('Password and Confirm Password do not match.'));
	        }
	    }

	    if ($request->hasFile('photo')) {

	        $image = $request->file('photo');
	        $filename = time() . '.' . $image->getClientOriginalExtension();
	        $path = 'storage/photo/' . $filename;

	        Storage::disk('public')->putFileAs('photo', $image, $filename);

	        $member->photo = $path;
	        $user->avatar = $path;

	    }

	    $user->email = $request['email'];

	    // Cluster Algo //
	    if ($member->user_type == 1 || $member->user_type == 6) {
	         $member->cluster = implode("::", $request['cluster']);
	    }

	    $member->email = $request['email'];
	    $member->alt_email = $request['alt_email'];
	    $member->firstname = $request['firstname'];
	    $member->lastname = $request['lastname'];
	    $member->middle_initial = $request['middle_initial'];
	    $member->suffix = $request['suffix'];
	    $member->nickname = $request['nickname'];
	    $member->contact_number = $request['contact_number'];
	    $member->gender = $request['gender'];
	    // --> birthday new code on saving

	    if($member->user_type == 2) {
	    	foreach ($request->staff as $index => $staff) {

	    			if($staff['type_number'] > 0 && $staff['other_number'] !== null ) {
		    			$staff_type_number = implode('::', $staff['type_number']);
		    			$staff_other_number = implode('::', $staff['other_number']);
	    			} else { $staff['type_number'] = null; $staff['other_number'] == null; }

	    			$staffAgreeEmail = $staff['agree_email'] ?? null;
	    			$staffAgreeContactNumber = $staff['agree_contact_number'] ?? null;

	    			if ($staffAgreeEmail == 'on') {
	    				$staffAgreeEmail = 1;
	    			} else { $staffAgreeEmail = 0; }
	    			if ($staffAgreeContactNumber == 'on') {
	    				$staffAgreeContactNumber = 1;
	    			} else { $staffAgreeContactNumber = 0; }

	    			if ($request->hasFile("staff.".$index.".photo")) {

	    			    $image = $request->file("staff.".$index.".photo");
	    			    $filename = time() . '.' . $image->getClientOriginalExtension();
	    			    $path = 'storage/photo/' . $filename;

	    			    Storage::disk('public')->putFileAs('photo', $image, $filename);

	    			    $staff['photo'] = $path;
	    			}

	    	        $memberStaff = MemberStaff::find($staff['staff_id']);
                    $memberStaff->firstname = $staff['firstname'];
                    $memberStaff->lastname = $staff['lastname'];
                    $memberStaff->middle_initial = $staff['middle_initial'];
                    $memberStaff->suffix = $staff['suffix'] ?? null;
                    $memberStaff->nickname = $staff['nickname'];
                    $memberStaff->gender = $staff['gender'] ?? null;;
                    $memberStaff->birthday = $staff['month'] . ' ' . $staff['day'];
                    $memberStaff->email = $staff['email'];
                    $memberStaff->agree_email = $staffAgreeEmail;
                    $memberStaff->contact_number = $staff['contact_number'];
                    $memberStaff->agree_contact_number = $staffAgreeContactNumber;
                    $memberStaff->type_number = $staff_type_number;
                    $memberStaff->other_number = $staff_other_number;
                    $memberStaff->photo = $staff['photo'] ?? $memberStaff->photo;
	    	        $memberStaff->save();
	    	    }
	    }

	    $member->save();
	    $user->save();
	    
	    return back()->with('success', ('Profile updated successfully.'));
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

	public function profileAddContactOfficial(Request $request) {
// dd($request);
		$requests = $request->all();
		$contact = SavedContactOfficial::create($requests);

		return back()->with('success', 'Contact added.');

	}

	public function profileAddContactStaff(Request $request) {

		$requests = $request->all();
		$contact = SavedContactStaff::create($requests);

		return back()->with('success', 'Contact added.');

	}

	public function profileRemoveContact(Request $request) {

		$saved_contact = SavedContact::where('user_id', Auth()->user()->id)
									 ->where('contact_id', $request->contact_id)
									 ->first();
		$saved_contact->delete();

		return back()->with('error', 'Contact removed.');

	}

	public function profileRemoveContactOfficial(Request $request) {

		$saved_contact = SavedContactOfficial::where('user_id', $request->user_id)
									 ->where('official_id', $request->official_id)
									 ->first();
		$saved_contact->delete();

		return back()->with('error', 'Contact removed.');

	}

	public function profileRemoveContactStaff(Request $request) {

		$saved_contact = SavedContactStaff::where('user_id', $request->user_id)
									 ->where('staff_id', $request->official_id)
									 ->first();
		$saved_contact->delete();

		return back()->with('error', 'Contact removed.');

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
	    						  ->where('is_verified', 1)
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
	    					->where('is_verified', 1)
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

	    $members = Official::query()->where('position', 'senator');

	    if (request('member_name')) {
	        $members->where(function ($query) {
	            $name = request('member_name');
	            $query->where('firstname', 'like', "%{$name}%")
	                ->orWhere('lastname', 'like', "%{$name}%");
	        });
	    }

	    $members = $members->paginate($this->page_limit);

		return view('theme.pages.directory.senator', compact('page', 'members'));
	}

	public function senartorStaffDirectory(Request $request)
	{
		if(!Auth::user()){
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'Senators Staff';

	    $members = Member::query()->where('user_id', '<>', Auth()->user()->id)
	    					->where('is_verified', 1)
	    					->where('user_type', 2);

	    if (request('member_name')) {
	        $members->where(function ($query) {
	            $name = request('member_name');
	            $query->where('firstname', 'like', "%{$name}%")
	                ->orWhere('lastname', 'like', "%{$name}%");
	        });
	    }

	    $members = $members->paginate($this->page_limit);

		return view('theme.pages.directory.senator-staff', compact('page', 'members'));
	}

	public function senartorComSecDirectory(Request $request)
	{
		if(!Auth::user()){
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'Senators Committee Secretary';

	    $members = Member::query()->where('user_id', '<>', Auth()->user()->id)
	    					->join('designation', 'designation.id', 'members.designation')
	    					->where('members.is_verified', 1)
	    					->where('members.user_type', 2)
	    					->where('designation.name', '=', 'Appointment Secretary');

	    if (request('member_name')) {
	        $members->where(function ($query) {
	            $name = request('member_name');
	            $query->where('firstname', 'like', "%{$name}%")
	                ->orWhere('lastname', 'like', "%{$name}%");
	        });
	    }

	    $members = $members->paginate($this->page_limit);


		return view('theme.pages.directory.senator-com-sec', compact('page', 'members'));
	}

	public function horsDirectory(Request $request)
	{
		if(!Auth::user()){
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'House of Representatives';

	    $members = Official::query()->where('position', 'hor');

	    if (request('member_name')) {
	        $members->where(function ($query) {
	            $name = request('member_name');
	            $query->where('firstname', 'like', "%{$name}%")
	                ->orWhere('lastname', 'like', "%{$name}%");
	        });
	    }

	    $members = $members->paginate($this->page_limit);

		return view('theme.pages.directory.hor', compact('page', 'members'));
	}

	public function horStaffDirectory(Request $request)
	{
		if(!Auth::user()){
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'House of Representatives Staff';

	    $members = Member::query()->where('user_id', '<>', Auth()->user()->id)
	    					->where('is_verified', 1)
	    					->where('user_type', 3);

	    if (request('member_name')) {
	        $members->where(function ($query) {
	            $name = request('member_name');
	            $query->where('firstname', 'like', "%{$name}%")
	                ->orWhere('lastname', 'like', "%{$name}%");
	        });
	    }

	    $members = $members->paginate($this->page_limit);

		return view('theme.pages.directory.hor-staff', compact('page', 'members'));
	}

	public function horComSecDirectory(Request $request)
	{
		if(!Auth::user()){
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'House of Representatives Committee Secretary';

	    $members = Member::query()->where('user_id', '<>', Auth()->user()->id)
	    					->join('designation', 'designation.id', 'members.designation')
	    					->where('members.user_type', 3)
	    					->where('members.is_verified', 1)
	    					->where('designation.name', '=', 'Appointment Secretary');

	    if (request('member_name')) {
	        $members->where(function ($query) {
	            $name = request('member_name');
	            $query->where('firstname', 'like', "%{$name}%")
	                ->orWhere('lastname', 'like', "%{$name}%");
	        });
	    }

	    $members = $members->paginate($this->page_limit);


		return view('theme.pages.directory.hor-com-sec', compact('page', 'members'));
	}

	public function profileStaffUpdate(Request $request ,$id)
	{
		if ($request['agree_email'] == 'on') {
			$request['agree_email'] = 1;
		} else { $request['agree_email'] = 0; }
		if ($request['agree_contact_number'] == 'on') {
			$request['agree_contact_number'] = 1;
		} else { $request['agree_contact_number'] = 0; }

		$requests = $request->all();
		unset($requests['_token']);
		unset($requests['month']);
		unset($requests['day']);
		MemberStaff::where('id', $id)->update($requests);

		return back()->with('success', ('Profile updated successfully.'));
	}

}
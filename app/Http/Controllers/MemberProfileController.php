<?php

namespace App\Http\Controllers;

use Facades\App\Helpers\FileHelper;
use Facades\App\Helpers\ListingHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Helpers\Setting;

use App\Mail\RegisterMail;
use App\Mail\ClusterModifyMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
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
use App\Models\Custom\Event;
use App\Models\MessagingNumber;
use App\Models\SavedContactStaff;
use App\Models\ClusterUpdateHolder;
use App\Models\SavedContactOfficial;
use App\Models\PolicyReformBookmark;
use App\Models\Custom\EventParticipant;
use App\Models\Custom\ReferenceMaterial;

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

		if(!auth::user()) {
		    return redirect()->route('home');
		}
		
	    $page = new Page();
	    $page->name = 'Member Dashboard';

	    $memberDetails = Member::where('user_id', Auth::user()->id)->first();

	    $genders = Gender::all();
	    $clustersList = Cluster::all();
	    $memberAgency = Agency::find($memberDetails->agency);
	    $saved_contacts = SavedContact::where('user_id', $memberDetails->user_id)->get();
	    $saved_contacts_official = SavedContactOfficial::where('user_id', $memberDetails->user_id)->get();
	    $saved_contacts_staff = SavedContactStaff::where('user_id', $memberDetails->user_id)->get();
	    $events  = EventParticipant::where('member_id', $memberDetails->id)
	    							->join('events', 'events.id', 'event_participants.event_id')
	    							->whereNull('deleted_at')
	    							->get();
	    $policy_reforms = PolicyReformBookmark::where('member_id', $memberDetails->id)->get();
	    $references = ReferenceMaterial::where('created_by', auth()->user()->id)->get();
	    $userTypeMembers = Member::where('user_type', $memberDetails->user_type)
	    							->where('user_id', '<>', Auth::user()->id)
	    							->get();

	    if ($memberDetails->user_type < 5) { $staffs = MemberStaff::where('member_id', $memberDetails->id)->get(); } else { $staffs = null; }

	    if (auth()->user()) {
	        return view('theme.pages.member.dashboard', compact('page', 'memberDetails', 'clustersList', 'memberAgency', 'events', 'genders', 'userTypeMembers', 'saved_contacts', 'saved_contacts_official', 'saved_contacts_staff', 'policy_reforms', 'staffs', 'references'));
	    } else {
	        return back()->with('error', ('Please login to your account.'));
	    }

	}

	public function memberProfileUpdate(Request $request) {
		
	    $member = Member::where('user_id', auth()->user()->id)->first();
	    $user = User::find(auth()->user()->id);
    	// dd($member);

	    if($request['password'] === '' || empty($request['password'])) {
	    	$request['password'] = auth()->user()->password;
	    } else {
	        $member->password = Hash::make($request['password']);
	        $user->password = $member->password;
	        if($request['password'] != $request['confirm_password']) {
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

	    if($member->user_type < 5) {
	    	foreach ($request->staff as $index => $staff) {
	    		// $test = empty($staff['firstname']);
	    			// dd($request->staff);
	    			if(empty($staff['firstname']) || empty($staff['lastname']) || $staff['day'] == 0) {
	    				return back()->with('error', ('Staff details must be completed.'));
	    			}

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

	    // Cluster Algo //
	    if($member->user_type == 1 || $member->user_type == 6) {

	    	if($member->cluster != $request['cluster']) {
	    		// email send condition
	    		$admin = User::find(1);
	    		Mail::to($admin->email)->send(new ClusterModifyMail(Setting::info(), $admin));

	    		// store temp data
	    		$cluste_data = new ClusterUpdateHolder;
	    		$cluste_data->member_id = $member->id;
	    		$cluste_data->cluster = implode("::", $request['cluster']);
	    		$cluste_data->save();

	    	} else {
	         	$member->cluster = implode("::", $request['cluster']);
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

		if ($request['email_agree'] == 'on') {
			$request['email_agree'] = 1;
		} else { $request['email_agree'] = 0; }
		if ($request['landline_agree'] == 'on') {
			$request['landline_agree'] = 1;
		} else { $request['landline_agree'] = 0; }
		if ($request['office_cellphone_agree'] == 'on') {
			$request['office_cellphone_agree'] = 1;
		} else { $request['office_cellphone_agree'] = 0; }

		$requests = $request->all();
		unset($requests['_token']);

		Official::where('id', $id)->update($requests);

		return back()->with('success', 'Senator details updated.');
	}

	public function horProfileUpdate(Request $request, $id) {

		if ($request['email_agree'] == 'on') {
			$request['email_agree'] = 1;
		} else { $request['email_agree'] = 0; }
		if ($request['landline_agree'] == 'on') {
			$request['landline_agree'] = 1;
		} else { $request['landline_agree'] = 0; }
		if ($request['office_cellphone_agree'] == 'on') {
			$request['office_cellphone_agree'] = 1;
		} else { $request['office_cellphone_agree'] = 0; }
		
		$requests = $request->all();
		unset($requests['_token']);

		Official::where('id', $id)->update($requests);

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
	    	session(['url.intended' => url()->current()]);
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

	    // fetch staff
	    foreach($members as $member ) {
	    	if($member->position == 'president' || $member->position == 'vice-president' || $member->position == 'cabinet-member') {

	    		$staff_president = Member::where('user_type', 4)
							    		->where('op_id', $member->id)
							    		->where('remarks', 'president')
							    		->first();

				$staff_vicepresident = Member::where('user_type', 4)
										->where('op_id', $member->id)
							    		->where('remarks', 'vice-president')
							    		->first();

				if($staff_president) {
					$member->has_staff = true;
					$member->staff_of = 'president';
					$member->staff_name = $staff_president->FullName;
					$member->staff_number = $staff_president->contact_number;
					$member->staff_email = $staff_president->email;
				}

				if($staff_vicepresident) {
					$member->has_staff = true;
					$member->staff_of = 'vice-president';
					$member->staff_name = $staff_vicepresident->FullName;
					$member->staff_number = $staff_vicepresident->contact_number;
					$member->staff_email = $staff_vicepresident->email;
				}
	    	}
	    }
	    // dd($staff);
	    return view('theme.pages.directory.cabinet', compact('page', 'members'));
	}

	public function llsDirectory(Request $request)
	{	
		if(!Auth::user()){
			session(['url.intended' => url()->current()]);
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'LLS Members';
	    
	    $birthmonth = 0;
	    $designations = Designation::where('user_type_id', 1)->get();
	    $agencies = Agency::where('user_type_id', 1)->get();
	    $clusters = Cluster::all();
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

	    if (request('agency')) {
	    	$agency = request('agency');
	        $members = Member::where('user_id', '<>', Auth()->user()->id)
	        				->where('user_type', 1)
	        				->join('agency', 'agency.id', 'members.agency')
	        				->where('agency.id', $agency)
	        				->get();
	    }

	    if (request('cluster')) {
	    	$cluster = request('cluster');
	        $members = Member::where('user_id', '<>', Auth()->user()->id)
	        				->where('user_type', 1)
	        				->where(function ($query) use ($cluster) {
        				        foreach ($cluster as $cl) {
        				            $query->orWhere('members.cluster', 'like', "%$cl%");
        				        }
        				    })
        				    ->get();
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

        foreach($members as $member) {
    	    $staff = MemberStaff::where('member_id', $member->id)
    	    					->get();

    	    if($staff->count() > 0) {
    		   	$member->has_staff = true;
    		   	if($staff[0]->firstname) {
	    		   	$member->staff_name1 = $staff[0]->FullName;
    		   	}
    		   	if($staff[1]->firstname) {
	    		   	$member->staff_name2 = $staff[1]->FullName;
    		   	}
    		   	if($staff[2]->firstname) {
	    		   	$member->staff_name3 = $staff[2]->FullName;
    		   	}
    		   	if($staff[3]->firstname) {
	    		   	$member->staff_name4 = $staff[3]->FullName;
    		   	}
    		   	$member->staff_number1 = $staff[0]->contact_number;
    		   	$member->staff_number2 = $staff[1]->contact_number;
    		   	$member->staff_number3 = $staff[2]->contact_number;
    		   	$member->staff_number4 = $staff[3]->contact_number;
    		   	
    		   	$member->staff_email1 = $staff[0]->email;
    		   	$member->staff_email2 = $staff[1]->email;
    		   	$member->staff_email3 = $staff[2]->email;
    		   	$member->staff_email4 = $staff[3]->email;

    		   	$member->staff_designation1 = $staff[0]->designation;
    		   	$member->staff_designation2 = $staff[1]->designation;
    		   	$member->staff_designation3 = $staff[2]->designation;
    		   	$member->staff_designation4 = $staff[3]->designation;
    	    }
        }
        // dd($member);

		return view('theme.pages.directory.lls', compact('page', 'members', 'designations', 'agencies', 'clusters'));
	}

	public function plloDirectory(Request $request)
	{
		if(!Auth::user()){
			session(['url.intended' => url()->current()]);
	        return redirect()->route('home')->with('error', 'Access Denied');
	    }

	    $page = new Page();
	    $page->name = 'PLLO';

	    $birthmonth = 0;
	    $designations = Designation::where('user_type_id', 2)->get();
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

	    if (request('gender')) {
        		$gender = request('gender');
        		if ($gender) {
			        $members->where('gender', $gender)
			            ->get();
			    };
	    }

	    if (request('birthmonth')) {
	    	$birthmonth = request('birthmonth');
	    	if ($birthmonth) {
	    		$members = Member::where('user_id', '<>', Auth()->user()->id)
	    						->where('user_type', 6)
		        				->where('birthdate', 'like', "%{$birthmonth}%")
		        				->get();
	    	}
	    }

        if (request('designation')) {
        	$designation = request('designation');
        	if ($designation) {
    	        $members = Member::where('user_id', '<>', Auth()->user()->id)
    	        				->where('user_type', 6)
    	        				->join('designation', 'designation.id', 'members.designation')
    	        				->where('designation.id', $designation)
    	        				->get();
        	} else {
        		$members = Member::where('user_id', '<>', Auth()->user()->id)
    	        				->where('user_type', 6)
    	        				->get();
        	}
        }

	    $members = $members->paginate($this->page_limit);

	    foreach($members as $member) {
		    $staff = MemberStaff::where('member_id', $member->id)
		    					->first();
		    if($staff) {
			   	$member->has_staff = true;
			   	$member->staff_name = $staff->FullName;
			   	$member->staff_number = $staff->contact_number;
			   	$member->staff_email = $staff->email;
		    }
	    }

		return view('theme.pages.directory.pllo', compact('page', 'members', 'designations'));
	}

	public function senartorsDirectory(Request $request)
	{
		if(!Auth::user()){
			session(['url.intended' => url()->current()]);
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

        foreach($members as $member) {
    	    $sen_staff = Member::where('senator_id', $member->id)
    	    					->where('designation', 10)
    	    					->first();
    	    $sen_officer = Member::where('senator_id', $member->id)
    	    					->where('designation', 11)
    	    					->first();
    	    $sen_secretary = Member::where('senator_id', $member->id)
    	    					->where('designation', 12)
    	    					->first();
    	    if($sen_staff) {
    		   	$member->has_staff = true;
    		   	$member->sen_staff_name = $sen_staff->FullName;
    		   	$member->sen_staff_number = $sen_staff->contact_number;
    		   	$member->sen_staff_email = $sen_staff->email;
    	    }

    	    if($sen_officer) {
    		   	$member->has_staff = true;
    		   	$member->sen_officer_name = $sen_officer->FullName;
    		   	$member->sen_officer_number = $sen_officer->contact_number;
    		   	$member->sen_officer_email = $sen_officer->email;
    	    }

    	    if($sen_secretary) {
    		   	$member->has_staff = true;
    		   	$member->sen_secretary_name = $sen_secretary->FullName;
    		   	$member->sen_secretary_number = $sen_secretary->contact_number;
    		   	$member->sen_secretary_email = $sen_secretary->email;
    	    }
        }

		return view('theme.pages.directory.senator', compact('page', 'members'));
	}

	public function senartorStaffDirectory(Request $request)
	{
		if(!Auth::user()){
			session(['url.intended' => url()->current()]);
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
			session(['url.intended' => url()->current()]);
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
			session(['url.intended' => url()->current()]);
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

        foreach($members as $member) {
    	    $staff = MemberStaff::where('member_id', $member->id)
    	    					->first();
    	    if($staff) {
    		   	$member->has_staff = true;
    		   	$member->staff_name = $staff->FullName;
    		   	$member->staff_number = $staff->contact_number;
    		   	$member->staff_email = $staff->email;
    	    }
        }

		return view('theme.pages.directory.hor', compact('page', 'members'));
	}

	public function horStaffDirectory(Request $request)
	{
		if(!Auth::user()){
			session(['url.intended' => url()->current()]);
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
			session(['url.intended' => url()->current()]);
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
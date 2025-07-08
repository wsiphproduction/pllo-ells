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
use App\Models\Senator;
use App\Models\SubAgency;
use App\Models\UserType;
use App\Models\Cluster;
use App\Models\Designation;
use App\Models\Member;
use App\Models\MessagingNumber;
use App\Models\Custom\EventParticipant;
use App\Models\Custom\Event;

use DB;
use Auth;
use Session;
use Storage;
use Image;

class MemberProfileController extends Controller
{

	private $searchFields = ['name'];

	public function memberDashboard() {

	    $page = new Page();
	    $page->name = 'Member Dashboard';

	    $clustersList = Cluster::all();
	    $memberDetails = Member::where('user_id', Auth::user()->id)->first();
	    $memberAgency = Agency::find($memberDetails->agency);
	    $genders = Gender::all();
	    $events  = EventParticipant::where('member_id', $memberDetails->id)->get();
	    $userTypeMembers = Member::where('user_type', $memberDetails->user_type)
	    							->where('user_id', '<>', Auth::user()->id)
	    							->get();

	    if (auth()->user()) {
	        return view('theme.pages.member.dashboard', compact('page', 'memberDetails', 'clustersList', 'memberAgency', 'events', 'genders', 'userTypeMembers'));
	    } else {
	        return back()->with('error', ('Please login to your account.'));
	    }

	}

	public function senatorProfileUpdate(Request $request, $id) {

		$birth_arr = [$request['sen_month'], $request['sen_day']];
		$sen_birthday = implode('::', $birth_arr);

		if ($request['sen_email_agree'] == 'on') {
			$sen_email_agree = 1;
		} else { $sen_email_agree = 0; }
		if ($request['sen_landline_agree'] == 'on') {
			$sen_landline_agree = 1;
		} else { $sen_email_agree = 0; }
		if ($request['sen_office_cellphone_agree'] == 'on') {
			$sen_office_cellphone_agree = 1;
		} else { $sen_email_agree = 0; }

		$senator = Senator::find($id);
		$senator->sen_firstname = $request['sen_firstname'];
		$senator->sen_middle_initial = $request['sen_middle_initial'];
		$senator->sen_lastname = $request['sen_lastname'];
		$senator->sen_nickname = $request['sen_nickname'];
		$senator->sen_email = $request['sen_email'];
		$senator->sen_email_agree = $sen_email_agree;
		$senator->sen_landline = $request['sen_landline'];
		$senator->sen_landline_agree = $sen_landline_agree;
		$senator->sen_office_cellphone = $request['sen_office_cellphone'];
		$senator->sen_office_cellphone_agree = $sen_office_cellphone_agree;
		$senator->sen_group = $request['sen_group'];
		$senator->sen_gender = $request['sen_gender'];
		$senator->sen_birthday = $sen_birthday;
		$senator->sen_facebook = $request['sen_facebook'];
		$senator->sen_twitter = $request['sen_twitter'];
		$senator->sen_instagram = $request['sen_instagram'];
		$senator->sen_youtube = $request['sen_youtube'];
		$senator->sen_main_room_number = $request['sen_main_room_number'];
		$senator->sen_main_direct_line = $request['sen_main_direct_line'];
		$senator->sen_main_fax_number = $request['sen_main_fax_number'];
		$senator->sen_main_trunk_local_number = $request['sen_main_trunk_local_number'];
		$senator->sen_extension_room_number = $request['sen_extension_room_number'];
		$senator->sen_extension_direct_line = $request['sen_extension_direct_line'];
		$senator->sen_extension_fax_number = $request['sen_extension_fax_number'];
		$senator->sen_extension_trunk_local_number = $request['sen_extension_trunk_local_number'];
		$senator->sen_spouse_firstname = $request['sen_spouse_firstname'];
		$senator->sen_spouse_middle_initial = $request['sen_spouse_middle_initial'];
		$senator->sen_spouse_lastname = $request['sen_spouse_lastname'];
		$senator->sen_spouse_gender = $request['sen_spouse_gender'];
		$senator->sen_spouse_birthday = $request['sen_spouse_birthday'];
		$senator->sen_spouse_office_address = $request['sen_spouse_office_address'];
		$senator->sen_spouse_email_address = $request['sen_spouse_email_address'];
		$senator->sen_spouse_landline_number = $request['sen_spouse_landline_number'];
		$senator->sen_spouse_cellphone_number = $request['sen_spouse_cellphone_number'];

		$senator->save();

		return back()->with('success', 'Senator details updated.');
	}

}
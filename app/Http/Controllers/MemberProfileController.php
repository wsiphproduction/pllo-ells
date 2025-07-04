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

	public function senatorProfileUpdate(Request $request) {
		dd($request);
	}

}
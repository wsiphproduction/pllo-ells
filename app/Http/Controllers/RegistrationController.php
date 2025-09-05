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
use App\Models\Official;
use App\Models\SubAgency;
use App\Models\UserType;
use App\Models\Cluster;
use App\Models\Designation;
use App\Models\Member;
use App\Models\MemberStaff;
use App\Models\MessagingNumber;
use App\Models\Custom\EventParticipant;
use App\Models\Custom\Event;

use DB;
use Auth;
use Session;
use Storage;
use Image;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    private $searchFields = ['name'];
    
    public function register() {
        
        $page = new Page();
        $user_types = UserType::all();
        $agencies = Agency::all();
        $clusters = Cluster::all();
        $genders = Gender::all();
        $designations = Designation::all();
        $messaging_numbers = MessagingNumber::all();
        $senators = Official::where('position', 'senator')->get();
        $hors = Official::where('position', 'hor')->get();

        $designations_lls = Designation::where('user_type_id', 1)->get();
        $designations_senators = Designation::where('user_type_id', 2)->get();
        $designations_hor = Designation::where('user_type_id', 3)->get();
        $designations_op = Designation::where('user_type_id', 4)->get();

        $pllo_lls_agencies = Agency::where([
                                            ['id', '<>', 9],
                                            ['id', '<>', 10],
                                            ['id', '<>', 11]
                                           ])->get();

        $op_agencies = Agency::whereIn('id', [9,10,11])->get();

        $op_subagencies = DB::table('agency')->select('*')
                                ->where('agency.agency_name', 'like', '%'.'op proper'.'%')
                                ->join('sub_agency', 'sub_agency.agency_id', '=', 'agency.id')
                                ->get();

        $cabinet_subagencies = DB::table('agency')->select('*')
                                ->where('agency.agency_name', 'like', '%'.'cabinet member'.'%')
                                ->join('sub_agency', 'sub_agency.agency_id', '=', 'agency.id')
                                ->get();

        $page->name = 'Registration';

        if (auth()->user()) {
            return back()->with('error', ('You are already logged in, please logout first to continue.'));
        } else {
            return view('theme.pages.registration.register', compact('page', 'user_types', 'agencies', 'clusters', 'genders', 'designations', 'messaging_numbers', 'designations_lls', 'designations_senators', 'designations_hor', 'designations_op', 'pllo_lls_agencies', 'op_agencies', 'op_subagencies', 'cabinet_subagencies', 'senators', 'hors'));
        }
    }

    public function registerStore(Request $request) {

        // Validate email //
        $validator = $request->validate([
            'email' => 'required|email|unique:users',
        ]);

        if ($request->$contact_number !== 9) {
            return redirect()->back()->withInput()->with('error', 'Mobile number must be exactly 9 digits.');
        }

        if(!$validator) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        if ($request->password != $request->confrim_password) {
            return redirect()->back()->withInput()->with('error', 'Password and Confirm Password do not match.');
        }

        if ($request->user_type == 1) {
            if ($request->designation == 0) {
                return redirect()->back()->withInput()->with('error', 'Please select Designation.');
            }

            if ($request->agency == 0) {
                return redirect()->back()->withInput()->with('error', 'Please select Agency.');
            } 
        }
        if ($request->birthdate == null) {
            return redirect()->back()->withInput()->with('error', 'Invalid birthday.');
        } else {
            $birthdate = explode('/', $request->birthdate);
            $month = $birthdate[0];
            $day = $birthdate[1];

            foreach(config('months') as $key => $month_name) {
                if ( $key == $month) {
                    $month = $month_name;
                }
            }
        }
        // End validation //

        if ($request->user_type != 2) { $request['senator_id'] = null; }
        if ($request->user_type != 3) { $request['hor_id'] = null; }
        if ($request->user_type != 4) { $request['congsec_type'] = null; }

        // Parallel saving users to members table //
        $request['firstname'] = strtoupper($request['firstname']);
        $request['lastname'] = strtoupper($request['lastname']);
        $request['middle_initial'] = strtoupper($request['middle_initial']);
        $requests = $request->all();
        $requests['name'] = $request['firstname'] . " " . $request['middle_initial'] . ". " . $request['lastname'] . " " . $request['suffix'];
        $requests['mobile'] = $requests['contact_number'];
        $requests['role_id'] = '2';
        $requests['is_active'] = '0';
        $requests['avatar'] = $request->hasFile('office_id') ? FileHelper::move_to_folder($request->file('office_id'), 'photo')['url'] : null;
        $requests['password'] = Hash::make($request->password);

        $user = User::create($requests);

        // Create new member //
        if ($request->user_type == 1 || $request->user_type == 6) {
            $requests['cluster'] = implode("::", $request['cluster']);
        }

        $requests['user_id'] = $user->id;
        $requests['type_number'] = implode("::", $request['type_number']);
        $requests['other_number'] = implode("::", $request['other_number']);
        $requests['birthdate'] = $month ." ". $day;
        $requests['photo'] = $request->hasFile('office_id') ? FileHelper::move_to_folder($request->file('office_id'), 'photo')['url'] : null;
        $requests['logo'] = $request->hasFile('agency_logo') ? FileHelper::move_to_folder($request->file('agency_logo'), 'logo')['url'] : null;

        $member = Member::create($requests);

        // Prallel saving on members staff table if registered as senator staff
        // LLS Member
        if($request->user_type == 1) {
            for ($i=1; $i<5; $i++) { 
                $staff = new MemberStaff();
                if ($i == 1) {
                    $staff->designation = 'APPOINTMENT SECRETARY';
                } else if($i == 2) {
                    $staff->designation = 'DLLO: DEPARTMENT LEGISLATIVE LIASION OFFICER';
                } else if($i == 3) {
                    $staff->designation = 'DLLS-SENATE: DEPARTMENT LEGISLATIVE LIAISON STAFF';
                } else {
                    $staff->designation = 'DLLS-HREP: DEPARTMENT LEGISLATIVE LIAISON STAFF';
                }
                $staff->member_id = $member->id;
                $staff->save();
            }
        }
        // Senators Staff
        if($request->user_type == 2) {
            for ($i=1; $i<4; $i++) { 
                $staff = new MemberStaff();
                if ($i == 1) {
                    $staff->designation = 'CHIEF OF STAFF';
                } else if($i == 2) {
                    $staff->designation = 'APPOINTMENT SECRETARY';
                } else {
                    $staff->designation = 'CHIEF LEGIS OFFICER';
                }
                $staff->member_id = $member->id;
                $staff->save();
            }
        }
        // HoR Staff
        if($request->user_type == 3) {
            for ($i=1; $i<4; $i++) { 
                $staff = new MemberStaff();
                if ($i == 1) {
                    $staff->designation = 'CHIEF OF STAFF';
                } else if($i == 2) { 
                    $staff->designation = 'APPOINTMENT SECRETARY';
                } else {
                    $staff->designation = 'STAFF';
                }
                $staff->member_id = $member->id;
                $staff->save();
            }
        }
        // OP Proper
        if($request->user_type == 4) {
                $staff = new MemberStaff();
                $staff->designation = 'APPOINTMENT SECRETARY';
                $staff->member_id = $member->id;
                $staff->save();
        }

        // Email condition //
        Mail::to($requests['email'])->send(new RegisterMail(Setting::info(), $user));

        return redirect()->back()->with("success","Registered Successfully!");
    }

    public function agencyList(Request $request)
    {
        $searchFields = ['name'];
        $filterFields = ['name', 'description'];

        $agencies = ListingHelper::sort_by('created_at')
            ->filter_fields($filterFields)
            ->simple_search(Agency::class, $searchFields);

        $filter = ListingHelper::filter_fields($filterFields)->get_filter($searchFields);

        $searchType = 'simple_search';

        return view('admin.registrations.agencies.index', compact('agencies', 'filter', 'searchType'));
    }

    public function agencyCreate() {
        return view('admin.registrations.agencies.create');
    }

    public function agencyStore(Request $request) {

        $requests = $request->all();
        $agency = Agency::create($requests);

        return redirect()->route('registration.agency-list')->with("success", "Agency Successfully Added.");
    }

    public function agencyEdit($agency_id) {

        $agency = Agency::find($agency_id);

        return view('admin.registrations.agencies.edit', compact('agency'));
    }

    public function agencyUpdate(Agency $agency, Request $request) {

        $agency = $request->all();

        dd($agency);

        return back()->with("success", "Agency Updated Successfully.");
    }

    /**
     * Remove the specified agency from storage.
     *
     * @param \App\Agency $agency
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function agencyDelete($agency_id)
    { 
        $agency = Agency::find($agency_id);
        $agency = $agency->delete();

        if($agency) {
            return redirect()->route('registration.agency-list')->with("success", "Agency Deleted!");
        } else {
            return redirect()->route('registration.agency-list')->with("error", "Something went wrong, please try again later.");
        }
    }


    // Email Confrim
    public function confirmEmail(Request $request) {

        // Email condition confirmation //
        $email = request()->get('email');

        $member = Member::where('email', $email)->first();
        $member->is_verified = 1;
        $member->save();

        // Create verification code base on latest code //
        $user_vr_code = User::where('verification_code', '<>', null)->orderBy('verification_code', 'desc')->first();
        $user_vr_code->verification_code++;

        // Parallel update of user details //
        $user = User::where('email', $email)->first();
        $user->email_verified_at = now();
        $user->verification_code = $user_vr_code->verification_code;
        $user->save();

        $page = new Page();
        $page->name = 'New Member Confirmation';

        return view('theme.pages.registration.register-confirm', compact('page'));
    }

    public function login() {

        $page = new Page();
        $page->name = "Member Login";

        if (auth()->user()) {
            return back()->with('error', ('You are already logged in, please logout first to continue.'));
        } else {
            return view('theme.pages.login', compact('page'));
        }
    }

    public function online(Request $request) {

        $userCredentials = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            unset($userCredentials['username']);
            $userCredentials['email'] = $request->email;
        }
        
        if (Auth::attempt($userCredentials)) {

            if(Auth::user()->role_id <> 2){ // block users from using this login form

                // Auth::logout();
                // return back()->with('error', 'Administrative accounts are not allowed to login as member.'); 

                return redirect(route('admin.dashboard'));
            }

            if(Auth::user()->is_active <> 1){ // block inactive users from using this login form
                Auth::logout();
                return back()->with('error', 'Account needs approval.'); 
            }

            $page = new Page();
            $page->name = 'Member Dashboard';

            $url = session()->pull('url.intended', '/member-dashboard'); // fallback if none
            return redirect($url);
            // return redirect()->intended('/member-dashboard');
            // return redirect(route('member.dashboard'));

        } else {
            return back()->with('error', 'Incorrect username or password. Please try again.'); 
            // return redirect(route('member.login.error'));
        }
    }

    public function loginError() {
         $page = new Page;
         $page->name = 'Login Error';
         
         return view('theme.pages.login-error', compact('page'));
    }

    public function logout() {
        Auth::logout();
        return redirect(route('home'));   
    }

    public function adminDashboard() {

        $page = new Page();
        $page->name = 'Admin Dashboard';

        $registrations_pending = User::where('role_id', 2)
                        ->leftJoin('members', 'members.user_id', '=', 'users.id')
                        ->where('members.is_verified', 1)
                        ->where('users.is_active','<>', 1)
                        ->get();

        $registrations_approve = User::where('role_id', 2)
                        ->leftJoin('members', 'members.user_id', '=', 'users.id')
                        ->where('members.is_verified', 1)
                        ->where('users.is_active', 1)
                        ->get();

        $registrations_process = User::where('role_id', 2)
                        ->leftJoin('members', 'members.user_id', '=', 'users.id')
                        ->where('members.is_verified', '<>', 1)
                        ->where('users.is_active', '<>', 1)
                        ->get();

        $upcoming_events = Event::whereDate('date', '>=', Carbon::today())
                        ->where(function ($query) {
                            $query->whereDate('date', '>', Carbon::today())
                                ->orWhere(function ($q) {
                                    $q->whereDate('date', Carbon::today())
                                        ->whereTime('end_time', '>=', Carbon::now()->toTimeString());
                                });
                        })
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->take(5);

        $month = date('F');
        $celebrants = Member::where('birthdate', 'like', "%$month%" )->get();
// dd($celebrants);
        return view('theme.pages.admin.dashboard', compact('page', 'registrations_pending', 'registrations_approve', 'registrations_process', 'upcoming_events', 'celebrants'));

    }

    public function adminRegistrationApprove(Request $request) {

        $user = User::where('id', $request->reg_id_approve)->first();
        $user->is_active = 1;
        $user->save();

        Mail::to($user->email)->send(new RegisterConfirmationMail(Setting::info(), $user));

        return back()->with('success', 'Registration Approved!');
    }

    public function adminRegistrationDelete(Request $request) {

        // user and member deletion //
        $user = User::find($request->reg_id_delete);
        $user->delete();

        $member = Member::where('user_id', $user->id)->first();
        $member->delete();

        return back()->with('success', 'Registration Deleted!');
    }

    // Email confirmation
    public function resendRegisterConfirmation(Request $request) {

        $member = Member::find($request->reg_id);
        $user = User::find($member->user_id);

        Mail::to($user->email)->send(new RegisterConfirmationMail(Setting::info(), $user));

        return back()->with('success', 'Email Confirmation Resent.');
    }

    public function uploadMemberLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        $member = Member::where('user_id', auth()->user()->id)->first();

        if ($request->hasFile('logo')) {

            if($member->user_type == 5) {
                $image = $request->file('logo');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = 'storage/photo/' . $filename;

                Storage::disk('public')->putFileAs('photo', $image, $filename);

                $member->photo = $path;
            } else {
                $image = $request->file('logo');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = 'storage/logo/' . $filename;

                Storage::disk('public')->putFileAs('logo', $image, $filename);

                $member->logo = $path;
            }

            $member->save();

        } else {

            return back()->with('error', 'No logo selected.');

        }

        return back()->with('success', 'New logo uploaded.');
    
    }

    public function registerViewMember($id)
    {   
        $page = new Page;
        $page->name = 'Member Details';
        $memberDetails = Member::find($id);

        return view('theme.pages.registration.register-view-member', compact('page', 'memberDetails'));
    }


}
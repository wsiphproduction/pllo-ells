<?php

namespace App\Http\Controllers;

use Facades\App\Helpers\FileHelper;
use Facades\App\Helpers\ListingHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Helpers\Setting;

use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;
use App\Mail\RegisterConfirmationMail;

use App\Models\User;
use App\Models\Page;
use App\Models\Gender;
use App\Models\Agency;
use App\Models\System;
use App\Models\Cluster;
use App\Models\Designation;
use App\Models\Member;
use App\Models\MessagingNumber;

use DB;
use Auth;
use Session;

class RegistrationController extends Controller
{
    private $searchFields = ['name'];
    
    public function register() {
        $page = new Page();
        $systems = System::all();
        $agencies = Agency::all();
        $clusters = Cluster::all();
        $genders = Gender::all();
        $designations = Designation::all();
        $messaging_numbers = MessagingNumber::all();

        $page->name = 'Registration';

        if (auth()->user()) {
            return back()->with('error', ('You are already logged in, please logout first to continue.'));
        } else {
            return view('theme.pages.registration.register', compact('page', 'systems', 'agencies', 'clusters', 'genders', 'designations', 'messaging_numbers'));
        }
    }

    public function registerStore(Request $request) {

        // Validate email //
        $validator = $request->validate([
            'email' => 'required|email|unique:users',
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        // Create new member //
        $requests = $request->all();

        $requests['cluster'] = implode("::", $request['cluster']);
        $requests['password'] = "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi";
        $requests['photo'] = $request->hasFile('office_id') ? FileHelper::move_to_folder($request->file('office_id'), 'photo')['url'] : null;
        $requests['logo'] = $request->hasFile('agency_logo') ? FileHelper::move_to_folder($request->file('agency_logo'), 'logo')['url'] : null;

        Member::create($requests);

        // Parallel saving to users table //
        $user_id = Member::where('email', $requests['email'])->first();

        $requests['name'] = $request['firstname'] . " " . $request['middle_initial'] . ". " . $request['lastname'] . " " . $request['suffix'];
        $requests['mobile'] = $requests['contact_number'];
        $requests['birth_date'] = $requests['birthdate'];
        $requests['role_id'] = '2';
        $requests['is_active'] = '1';
        $requests['user_id'] = $user_id->id;

        $user = User::create($requests);

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

        Mail::to($email)->send(new RegisterConfirmationMail(Setting::info(), $user));

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

            if(Auth::user()->role_id <> '2'){ // block cms users from using this login form
                Auth::logout();
                return back()->with('error', 'Administrative accounts are not allowed to login as customer.'); 
            }

            if(Auth::user()->is_active <> 1){ // block inactive users from using this login form
                Auth::logout();
                return back()->with('error', 'Account is not active.'); 
            }

            $page = new Page();
            $page->name = 'Member Dashboard';

            return redirect(route('member.dashboard'));

        } else {
            Auth::logout();
            return back()->with('error', __('auth.login.incorrect_input'));    
        }
    }

    public function dashboard() {

        $page = new Page();
        $page->name = 'Member Dashboard';

        if (auth()->user()) {
            return view('theme.pages.member.dashboard', compact('page'));
        } else {
            return back()->with('error', ('Please login to your account.'));
        }

    }

    public function logout() {
        Auth::logout();
        return redirect(route('member.login'));   
    }

}

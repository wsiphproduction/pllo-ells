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
use Storage;
use Image;

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

        if(!$validator) {
            return Redirect::back()->withErrors($validator);
        }

        if ($request->month == 0) {
            return back()->with('error', 'Invalid birthdate.');
        }

        if ($request->day == 0) {
            return back()->with('error', 'Invalid birthdate.');
        }

        if ($request->gender == 0) {
            return back()->with('error', 'Please select Gender.');
        }

        if ($request->agency == 0) {
            return back()->with('error', 'Please select Agency.');
        }

        if ($request->designation == 0) {
            return back()->with('error', 'Please select Designation.');
        }

        if ($request->password != $request->confrim_password) {
            return back()->with('error', 'Password and Confirm Password do not match.');
        }

        // Parallel saving users to members table //
        $requests = $request->all();
        $requests['name'] = $request['firstname'] . " " . $request['middle_initial'] . ". " . $request['lastname'] . " " . $request['suffix'];
        $requests['mobile'] = $requests['contact_number'];
        $requests['role_id'] = '2';
        $requests['is_active'] = '0';
        $requests['password'] = Hash::make($request->password);

        $user = User::create($requests);

        // Create new member //
        $requests['user_id'] = $user->id;
        $requests['type_number'] = implode("::", $request['type_number']);
        $requests['other_number'] = implode("::", $request['other_number']);
        $requests['cluster'] = implode("::", $request['cluster']);
        $requests['birthdate'] = $requests['month'] ." ". $requests['day'];
        $requests['photo'] = $request->hasFile('office_id') ? FileHelper::move_to_folder($request->file('office_id'), 'photo')['url'] : null;
        $requests['logo'] = $request->hasFile('agency_logo') ? FileHelper::move_to_folder($request->file('agency_logo'), 'logo')['url'] : null;

        Member::create($requests);

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

            if(Auth::user()->role_id <> '2'){ // block cms users from using this login form

                // Auth::logout();
                // return back()->with('error', 'Administrative accounts are not allowed to login as customer.'); 

                return redirect(route('admin.dashboard'));
            }

            if(Auth::user()->is_active <> 1){ // block inactive users from using this login form
                Auth::logout();
                return back()->with('error', 'Account needs approval.'); 
            }

            $page = new Page();
            $page->name = 'Member Dashboard';

            return redirect(route('member.dashboard'));

        } else {
            Auth::logout();
            return back()->with('error', __('auth.login.incorrect_input'));
        }
    }

    public function memberDashboard() {

        $page = new Page();
        $page->name = 'Member Dashboard';

        $clustersList = Cluster::all();
        $memberDetails = Member::where('user_id', Auth::user()->id)->first();
        $memberAgency = Agency::find($memberDetails->agency);

        if (auth()->user()) {
            return view('theme.pages.member.dashboard', compact('page', 'memberDetails', 'clustersList', 'memberAgency'));
        } else {
            return back()->with('error', ('Please login to your account.'));
        }

    }

    public function memberProfileUpdate(Request $request) {

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
            $path = 'photo/' . $filename;

            Storage::disk('public')->putFileAs('photo', $image, $filename);

            $member->photo = $path;
            $user->avatar = $path;

        }

        $member->email = $request['email'];
        $member->alt_email = $request['alt_email'];
        $member->cluster = implode('::', $request['cluster']);

        $user->email = $request['email'];

        $member->save();
        $user->save();
        
        return back()->with('success', ('Profile updated successfully.'));
    }

    public function logout() {
        Auth::logout();
        return redirect(route('member.login'));   
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

        return view('theme.pages.admin.dashboard', compact('page', 'registrations_pending', 'registrations_approve', 'registrations_process'));

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

    public function maintenanceDashboard() {

        $page = new Page;
        $page->name = "Maintenance Dashboard";

        $genders = Gender::all();
        $agencies = Agency::all();

        return view('theme.pages.maintenance.agency.index', compact('page', 'agencies', 'genders'));
    }

    public function maintenanceAgencyStore(Request $request) {

        $requests = $request->all();
        Agency::create($requests);

        return back()->with('success', 'Agency added successfully.');
    }

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

                $image = $request->file('logo');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = 'logo/' . $filename;

                Storage::disk('public')->putFileAs('logo', $image, $filename);

                $member->logo = $path;

                $member->save();
                
            } else {
                return back()->with('error', 'No logo selected.');
            }
            return back()->with('success', 'New logo uploaded.');
        
        }
}
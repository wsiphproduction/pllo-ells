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
use App\Models\Custom\EventParticipant;
use App\Models\Custom\Event;

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
            return Redirect::back()->withInput()->withErrors($validator);
        }

        if ($request->month == 0) {
            return redirect()->back()->withInput()->with('error', 'Invalid birthdate.');
        }

        if ($request->day == 0) {
            return redirect()->back()->withInput()->with('error', 'Invalid birthdate.');
        }

        if ($request->gender == 0) {
            return redirect()->back()->withInput()->with('error', 'Please select Gender.');
        }

        if ($request->agency == 0) {
            return redirect()->back()->withInput()->with('error', 'Please select Agency.');
        }

        if ($request->designation == 0) {
            return redirect()->back()->withInput()->with('error', 'Please select Designation.');
        }

        if ($request->password != $request->confrim_password) {
            return redirect()->back()->withInput()->with('error', 'Password and Confirm Password do not match.');
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

            return redirect(route('member.dashboard'));

        } else {
            
            return redirect(route('member.login.error'));

        }
    }

    public function loginError() {
         $page = new Page;
         $page->name = 'Login Error';
         
         return view('theme.pages.login-error', compact('page'));
    }

    public function memberDashboard() {

        $page = new Page();
        $page->name = 'Member Dashboard';

        $clustersList = Cluster::all();
        $memberDetails = Member::where('user_id', Auth::user()->id)->first();
        $memberAgency = Agency::find($memberDetails->agency);

        $events  = EventParticipant::where('member_id', $memberDetails->id)->get();
        // dd($events);
        if (auth()->user()) {
            return view('theme.pages.member.dashboard', compact('page', 'memberDetails', 'clustersList', 'memberAgency', 'events'));
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

    // Agency
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

    public function maintenanceAgencyEdit($id) {

        $page = new Page;
        $page->name = 'Edit Agency';
        $agency = Agency::find($id);
        $genders = Gender::all();

        return view('theme.pages.maintenance.agency.edit', compact('page', 'agency', 'genders'));
    }

    public function maintenanceAgencyUpdate(Request $request, $id) {

        $agency = Agency::find($id);
        $agency->agency_name = $request['agency_name'];
        $agency->agency_address = $request['agency_address'];
        $agency->agency_email = $request['agency_email'];
        $agency->agency_landline = $request['agency_landline'];
        $agency->agency_cellphone = $request['agency_cellphone'];
        $agency->head_name = $request['head_name'];
        $agency->head_nickname = $request['head_nickname'];
        $agency->head_gender = $request['head_gender'];
        $agency->head_address = $request['head_address'];
        $agency->head_alt_address = $request['head_alt_address'];
        $agency->head_email = $request['head_email'];
        $agency->head_office_email = $request['head_office_email'];
        $agency->head_cellphone = $request['head_cellphone'];
        $agency->save();

        return redirect()->route('maintenance.dashboard')->with('success', 'Agency updated successfully.');
    }

    public function maintenanceAgencyDelete(Request $request) {

        $agency = Agency::find($request->agency_id);
        $agency->delete();

        return redirect()->route('maintenance.dashboard')->with('success', 'Agency deleted.');
    }

    public function maintenanceAgencyView($id) {

        $page = new Page;
        $page->name = "View Agency Details";
        $agency = Agency::find($id);

        return view('theme.pages.maintenance.agency.view', compact('page', 'agency'));
    }

    // Designation
    public function maintenanceDesignation() {

        $page = new Page();
        $page->name = "Manage Designations";

        $designations = Designation::all();
    
        return view('theme.pages.maintenance.designation.index', compact('page', 'designations'));
    }

    public function maintenanceDesignationStore(Request $request) {

        $requests = $request->all();
        Designation::create($requests);

        return back()->with('success', 'Designation added successfully.');
    }

    public function maintenanceDesignationEdit($id) {

        $page = new Page;
        $page->name = 'Edit Designation';
        $designation = Designation::find($id);

        return view('theme.pages.maintenance.designation.edit', compact('page', 'designation'));
    }

    public function maintenanceDesignationUpdate(Request $request, $id) {

        $designation = Designation::find($id);
        $designation->name = $request['name'];
        $designation->save();

        return redirect()->route('maintenance.designation')->with('success', 'Designation updated successfully.');
    }

    public function maintenanceDesignationDelete(Request $request) {

        $designation = Designation::find($request->designation_id);
        $designation->delete();

        return redirect()->route('maintenance.designation')->with('success', 'Designation deleted.');
    }

    // Cluster
    public function maintenanceCluster() {

        $page = new Page();
        $page->name = "Manage Designations";

        $clusters = Cluster::all();
    
        return view('theme.pages.maintenance.cluster.index', compact('page', 'clusters'));
    }

    public function maintenanceClusterStore(Request $request) {

        $requests = $request->all();
        Cluster::create($requests);

        return back()->with('success', 'Cluster added successfully.');
    }

    public function maintenanceClusterEdit($id) {

        $page = new Page;
        $page->name = 'Edit Cluster';
        $cluster = Cluster::find($id);

        return view('theme.pages.maintenance.cluster.edit', compact('page', 'cluster'));
    }

    public function maintenanceClusterUpdate(Request $request, $id) {

        $cluster = Cluster::find($id);
        $cluster->name = $request['name'];
        $cluster->save();

        return redirect()->route('maintenance.cluster')->with('success', 'Cluster updated successfully.');
    }

    public function maintenanceClusterDelete(Request $request) {

        $cluster = Cluster::find($request->cluster_id);
        $cluster->delete();

        return redirect()->route('maintenance.cluster')->with('success', 'Cluster deleted.');
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
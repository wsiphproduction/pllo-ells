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

        return view('theme.pages.registration.register', compact('page', 'systems', 'agencies', 'clusters', 'genders', 'designations', 'messaging_numbers'));
    }

    public function registerStore(Request $request) {

        // Validate email //
        $request->validate([
            'email' => 'required|email|unique:users',
        ]);

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

}

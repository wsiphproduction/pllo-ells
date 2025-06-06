<?php

namespace App\Http\Controllers;

use Facades\App\Helpers\FileHelper;
use Facades\App\Helpers\ListingHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Page;
use App\Models\Gender;
use App\Models\Agency;
use App\Models\System;
use App\Models\Cluster;
use App\Models\Designation;
use App\Models\Registration;
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

        // $alert = false;

        $page->name = 'Registration';

        return view('theme.pages.registration.register', compact('page', 'systems', 'agencies', 'clusters', 'genders', 'designations', 'messaging_numbers'));
    }

    public function registerStore(Request $request) {
        // dd($request);
        $requests = $request->all();

        $requests['cluster'] = implode("::", $request['cluster']);
        $requests['password'] = "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi";
        $requests['photo'] = $request->hasFile('photo') ? FileHelper::move_to_folder($request->file('photo'), 'photo')['url'] : null;
        $requests['logo'] = $request->hasFile('logo') ? FileHelper::move_to_folder($request->file('logo'), 'logo')['url'] : null;

        Registration::create($requests);

        // $alert = true;

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

        // dd($agencies);

        return view('admin.registrations.agencies.index', compact('agencies', 'filter', 'searchType'));
    }

    public function agencyCreate() {
        return view('admin.registrations.agencies.create');
    }

    public function agencyStore(Request $request) {

        $requests = $request->all();
        $agency = Agency::create($requests);
        // dd($requests);

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
        // dd($agency);
        $agency = $agency->delete();

        if($agency) {
            return redirect()->route('registration.agency-list')->with("success", "Agency Deleted!");
        } else {
            return redirect()->route('registration.agency-list')->with("error", "Something went wrong, please try again later.");
        }
    }

}

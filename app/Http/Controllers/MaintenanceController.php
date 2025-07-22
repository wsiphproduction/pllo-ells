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
use App\Models\UserType;
use App\Models\Cluster;
use App\Models\SubAgency;
use App\Models\Designation;
use App\Models\Custom\Event;
use App\Models\MessagingNumber;
use App\Models\PolicyReformCategory;
use App\Models\Custom\EventParticipant;

use DB;
use Auth;
use Session;
use Storage;
use Image;

class MaintenanceController extends Controller
{
	// Agency
	public function maintenanceDashboard() {

	    $page = new Page;
	    $page->name = "Maintenance Dashboard";

	    $genders = Gender::all();
	    $agencies = Agency::all();
	    $approvers = Member::all();

	    return view('theme.pages.maintenance.agency.index', compact('page', 'agencies', 'genders', 'approvers'));
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
	    $approvers = Member::all();

	    return view('theme.pages.maintenance.agency.edit', compact('page', 'agency', 'genders', 'approvers'));
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
	    $agency->approved_by = $request['approved_by'];
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
		$approver = Member::find($agency->approved_by);

	    return view('theme.pages.maintenance.agency.view', compact('page', 'agency', 'approver'));
	}

	// Designation
	public function maintenanceDesignation() {

	    $page = new Page();
	    $page->name = "Manage Designations";

	    $designations = Designation::all();
	    $user_types = UserType::all();
	
	    return view('theme.pages.maintenance.designation.index', compact('page', 'designations', 'user_types'));
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
	    $user_types = UserType::all();

	    return view('theme.pages.maintenance.designation.edit', compact('page', 'designation', 'user_types'));
	}

	public function maintenanceDesignationUpdate(Request $request, $id) {

	    $designation = Designation::find($id);
	    $designation->name = $request['name'];
	    $designation->name = $request['user_type_id'];
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
	    $page->name = "Manage Clusters";

	    $clusters = Cluster::all();
	    $approvers = Member::all();
	
	    return view('theme.pages.maintenance.cluster.index', compact('page', 'clusters', 'approvers'));
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
	    $approvers = Member::all();

	    return view('theme.pages.maintenance.cluster.edit', compact('page', 'cluster', 'approvers'));
	}

	public function maintenanceClusterUpdate(Request $request, $id) {

	    $cluster = Cluster::find($id);
	    $cluster->name = $request['name'];
	    $cluster->approved_by = $request['approved_by'];
	    $cluster->save();

	    return redirect()->route('maintenance.cluster')->with('success', 'Cluster updated successfully.');
	}

	public function maintenanceClusterDelete(Request $request) {

	    $cluster = Cluster::find($request->cluster_id);
	    $cluster->delete();

	    return redirect()->route('maintenance.cluster')->with('success', 'Cluster deleted.');
	}

	// Policy Reform
	public function maintenancePolicyReform()
	{
		$page = new Page;
		$page->name = 'Policy Reforms';

		$categories = PolicyReformCategory::all();

		return view('theme.pages.maintenance.policy-reform.index', compact('page', 'categories'));
	}

	public function maintenancePolicyReformStore(Request $request) {

	    $requests = $request->all();
	    PolicyReformCategory::create($requests);

	    return back()->with('success', 'New category added successfully.');
	}

	public function maintenancePolicyReformEdit($id) {

	    $page = new Page;
	    $page->name = 'Edit Policy Reforms';
	    $category = PolicyReformCategory::where('id', $id)->first();

	    return view('theme.pages.maintenance.policy-reform.edit', compact('page', 'category'));
	}

	public function maintenancePolicyReformUpdate(Request $request, $id) {

	    $category = PolicyReformCategory::find($id);
	    $category->name = $request['name'];
	    $category->save();

	    return redirect()->route('maintenance.policy.reform')->with('success', 'Category updated successfully.');
	}

	public function maintenancePolicyReformDelete(Request $request) {

	    $category = PolicyReformCategory::find($request->bill_id);
	    $category->delete();

	    return redirect()->route('maintenance.policy.reform')->with('error', 'Category deleted.');
	}
}
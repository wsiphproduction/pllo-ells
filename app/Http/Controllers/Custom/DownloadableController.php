<?php

namespace App\Http\Controllers\Custom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DownloadableRequest;

use Facades\App\Helpers\FileHelper;
use App\Helpers\Setting;

use App\Models\{Page};
use App\Models\Custom\{Downloadable};

use Auth;

class DownloadableController extends Controller
{
    private $page_limit = 10;

    public function republic_acts(Request $request)
    {
        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'Access Denied');
        }
        
        $page = new Page();
        $page->name = 'Summary of Laws Passed';

        $republic_acts = Downloadable::where('type', 'RA');

        if (request('search')) {
            $republic_acts->where(function ($query) {
                $search = request('search');
                $query->where('ra_jr_no', 'like', "%{$search}%")
                    ->orWhere('approved_on', 'like', "%{$search}%")
                    ->orWhere('congress', 'like', "%{$search}%")
                    ->orWhere('source_priority_level', 'like', "%{$search}%")
                    ->orWhere('long_title', 'like', "%{$search}%");
            });
        }

        if (request('source_priority_level')) {
            $republic_acts->where(function ($query) {
                $search = request('source_priority_level');
                $query->where('source_priority_level', 'like', "%{$search}%");
            });
        }

        if (request('approved_on')) {
            $republic_acts->where(function ($query) {
                $search = request('approved_on');
                $query->where('approved_on', 'like', "%{$search}%");
            });
        }

        if (request('congress')) {
            $republic_acts->where(function ($query) {
                $search = request('congress');
                $query->where('congress', 'like', "%{$search}%");
            });
        }

        $republic_acts = $republic_acts->orderByDesc('id')->get();
        // $republic_acts = $republic_acts->orderByDesc('id')->paginate($this->page_limit);

        return view('theme.pages.downloadables.republic-acts', compact('page', 'republic_acts'));
    }

    public function bills_certified(Request $request)
    {
        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'Access Denied');
        }
        
        $page = new Page();
        $page->name = 'Summary of Bills Certified by The President for Immediate Enactment';

        $bills_certified = Downloadable::where('type', 'BC');

        if (request('search')) {
            $bills_certified->where(function ($query) {
                $search = request('search');
                $query->where('proposed_measure', 'like', "%{$search}%")
                    ->orWhere('source_priority_level', 'like', "%{$search}%")
                    ->orWhere('bill_no', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        if (request('source_priority_level')) {
            $bills_certified->where(function ($query) {
                $search = request('source_priority_level');
                $query->where('source_priority_level', 'like', "%{$search}%");
            });
        }

        $bills_certified = $bills_certified->orderByDesc('id')->get();
        // $bills_certified = $bills_certified->orderByDesc('id')->paginate($this->page_limit);

        return view('theme.pages.downloadables.bills-certified', compact('page', 'bills_certified'));
    }

    public function legislative_priorities(Request $request)
    {
        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'Access Denied');
        }
        
        $page = new Page();
        $page->name = 'President Legislative Priorities';

        $legislative_priorities = Downloadable::where('type', 'PLP');

        if (request('search')) {
            $legislative_priorities->where(function ($query) {
                $search = request('search');
                $query->where('proposed_measure', 'like', "%{$search}%")
                    ->orWhere('source_priority_level', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        if (request('status')) {
            $legislative_priorities->where(function ($query) {
                $search = request('status');
                $query->where('status', 'like', "%{$search}%");
            });
        }

        if (request('source_priority_level')) {
            $legislative_priorities->where(function ($query) {
                $search = request('source_priority_level');
                $query->where('source_priority_level', 'like', "%{$search}%");
            });
        }

        $legislative_priorities = $legislative_priorities->orderByDesc('id')->get();
        // $legislative_priorities = $legislative_priorities->orderByDesc('id')->paginate($this->page_limit);

        return view('theme.pages.downloadables.legislative-priorities', compact('page', 'legislative_priorities'));
    }

    public function store(DownloadableRequest $request)
    {
        $requestData = $request->validated();
        $requestData['created_by'] = Auth::user()->id;

        $downloadable = Downloadable::create($requestData);

        if ($request->hasFile('attachments')) {
            $attachments = [];

            foreach ($request->file('attachments') as $attachment) {
                $file = FileHelper::move_to_folder($attachment, 'downloads/'. $request->type .'/'. $downloadable->id);
                if ($file && isset($file['url'])) {
                    $attachments[] = $file['url'];
                }
            }
            $data['attachments'] = json_encode($attachments);
        }

        $downloadable->update($data);

        return redirect()->back()->with('success', 'Downloadable has been added.');
    }

}

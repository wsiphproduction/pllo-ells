<?php

namespace App\Http\Controllers\Custom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ReferenceMaterialRequest;
use Facades\App\Helpers\FileHelper;

use App\Models\{Page, Cluster, Agency, Member, FileDownload};
use App\Models\Custom\{ReferenceMaterial};
use Auth;

class ReferenceMaterialController extends Controller
{

    private $page_limit = 10;

    public function index(Request $request)
    {
        $page = new Page();
        $page->name = 'Reference Materials';

        $clusters = Cluster::all();

        $reference_materials = ReferenceMaterial::query();

        if (request('search')) {
            $reference_materials->where(function ($query) {
                $search = request('search');
                $query->where('subject', 'like', "%{$search}%")
                    ->orWhere('significance_level', 'like', "%{$search}%")
                    ->orWhere('remarks', 'like', "%{$search}%");
            });
        }

        $reference_materials = $reference_materials->orderByDesc('updated_at')->paginate($this->page_limit);

        return view('theme.pages.reference-materials.index', compact('page', 'reference_materials', 'clusters'));
    }


    public function store(ReferenceMaterialRequest $request){

        $data = $request->validated();

        $data['created_by'] = Auth::user()->id;
        $reference_material = ReferenceMaterial::create($data);

       if ($request->hasFile('attachments')) {
            $attachments = [];

            foreach ($request->file('attachments') as $attachment) {
                $file = FileHelper::move_to_folder($attachment, 'reference-materials/'. $reference_material->id .'/attachments');
                if ($file && isset($file['url'])) {
                    $attachments[] = $file['url'];
                }
            }

            $data['attachments'] = json_encode($attachments);

            $reference_material->update($data);
        }
        
        return redirect()->back()->with('success', 'You successfully added a reference material');
    }

    public function update(ReferenceMaterial $reference_material, ReferenceMaterialRequest $request){

        $data = $request->validated();
        $reference_material->update($data);

        if ($request->hasFile('attachments')) {
            $attachments = [];

            foreach ($request->file('attachments') as $attachment) {
                $file = FileHelper::move_to_folder($attachment, 'reference-materials/'. $reference_material->id .'/attachments');
                if ($file && isset($file['url'])) {
                    $attachments[] = $file['url'];
                }
            }

            $data['attachments'] = json_encode($attachments);

            $reference_material->update($data);
        }

        return redirect()->back()->with('success', 'You successfully updated a reference material');

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Facades\App\Helpers\ListingHelper;
use Facades\App\Helpers\FileHelper;
use Illuminate\Support\Str;

use App\Models\{FileDownload, FileDownloadCategory};
use Illuminate\Http\Request;

use Storage;
use Auth;

class FileDownloadController extends Controller
{
    private $searchFields = ['title', 'version_no'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = ListingHelper::simple_search(FileDownload::class, $this->searchFields);

        // Simple search init data
        $filter = ListingHelper::get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('admin.ecommerce.downloadables.index',compact('files', 'filter', 'searchType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      

        return view('admin.ecommerce.downloadables.create');   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|max:150',
            'ra_jr' => 'required|max:150',
            'congress' => 'required',
            'file' => 'required|mimes:csv,xlsx,xls,pdf|max:2000',
            'approved_on' => 'required',
            'source_priority_level' => 'required'
        ])->validate();

        $requestData = $request->all();
        $requestData['unique_hash'] = Str::random(32);
        $requestData['status'] = 1;

        $file = FileDownload::create($requestData);
        $this->upload_photo($request,$file->id);

        return redirect(route('downloadables.index'))->with('success', 'Downloadable has been added.');
    }

    public function front_store(Request $request)
    {
        $requestData = Validator::make($request->all(), [
            'title' => 'required|max:150',
            'ra_jr' => 'required|max:150',
            'congress' => 'required',
            'approved_on' => 'required',
            'source_priority_level' => 'required'
        ])->validate();

        $requestData['unique_hash'] = Str::random(32);
        $requestData['status'] = 1;

        $file_download = FileDownload::create($requestData);

        if ($request->hasFile('file_url')) {
            $file_url = [];

            foreach ($request->file('file_url') as $attachment) {
                $file = FileHelper::move_to_folder($attachment, 'file-downloads/'. $file_download->id .'/file_url');
                if ($file && isset($file['url'])) {
                    $file_url[] = $file['url'];
                }
            }

            $data['file_url'] = json_encode($file_url);

            $file_download->update([
                'file_url' => $data['file_url']
            ]);
        }

        if ($request->event_id) {
            $file_download->update([
                'event_id' => $request->event_id
            ]);
        }

        return redirect()->back()->with('success', 'Downloadable has been added.');
    }

    public function upload_photo($request,$id)
    {
        $folder = 'downloadables';
        if($request->hasFile('file')){
            $file = $request->file('file');
            $filename = time().'_'.$file->getClientOriginalName();

            Storage::disk('public')->putFileAs($folder, $file, $filename);
            FileDownload::find($id)->update(['file_url' => $filename]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileDownload  $fileDownload
     * @return \Illuminate\Http\Response
     */
    public function show(FileDownload $fileDownload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileDownload  $fileDownload
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fileDownload = FileDownload::find($id);

        $departments = FileDownloadCategory::where('type', 0)->orderBy('title','asc')->get();
        $categories  = FileDownloadCategory::where('type', 1)->orderBy('title','asc')->get();

        return view('admin.ecommerce.downloadables.edit', compact('departments','categories', 'fileDownload'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FileDownload  $fileDownload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|max:150',
            'version_no' => 'required|max:150',
            'category_id' => 'required',
            'file' => 'mimes:csv,xlsx,xls,pdf|max:2000',
            'department_id' => 'required'
        ])->validate();

        $requestData = $request->all();

        $arr_departments = [];
        foreach($requestData['department_id'] as $dept){
            array_push($arr_departments, $dept);
        }

        $requestData['department_id'] = json_encode($arr_departments);

        FileDownload::find($request->id)->update($requestData);
        $this->upload_photo($request,$request->id);

        return redirect(route('downloadables.index'))->with('success', 'Downloadable has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileDownload  $fileDownload
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileDownload $fileDownload)
    {
        //
    }

    public function single_delete(Request $request)
    {
        $category = FileDownload::findOrFail($request->categories);
        $category->delete();

        return back()->with('success', 'File has been deleted permanently.');
    }

    public function multiple_delete(Request $request)
    {
        $files = explode("|",$request->categories);

        foreach($files as $file){
            FileDownload::whereId((int) $file)->delete();
        }

        return back()->with('success', 'Selected files has been deleted permanently.');
    }
}

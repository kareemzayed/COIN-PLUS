<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LanguageExport;
use App\Http\Controllers\Controller;
use App\Imports\LanguageImport;
use App\Models\Language;
use Illuminate\Http\Request;
use Vonage\Message\Shortcode\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;

class LanguageController extends Controller
{
    public function index()
    {
        $data['pageTitle'] = 'Language Settings';
        $data['languages'] = Language::latest()->get();
        $data['navGeneralSettingsActiveClass'] = 'active';
        $data['subNavManageLanguageActiveClass'] = 'active';
        return view('backend.language.index')->with($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'language' => 'required|unique:languages,name',
            'short_code' => 'required|unique:languages,short_code',
        ]);

        $language = Language::first();

        if($language){
            $is_default = 0;
        }else{
            $is_default = 1;
        }

        Language::create([
            'name'=> $request->language,
            'short_code' => $request->short_code,
            'is_default' => $is_default
        ]);

        $path = resource_path('lang/');
        fopen($path."$request->short_code.json", "w");
        file_put_contents($path."$request->short_code.json",'{}');
        $notify[] = ['success','Language Created Successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request)
    {
        $language = Language::findOrFail($request->id);

        $request->validate([
            'language' => 'required|unique:languages,name,'.$language->id,
            'short_code' => 'required|unique:languages,short_code,'.$language->id,
        ]);

        if($request->is_default){
            $language->is_default = $request->is_default;
            $language->save();
            DB::table('languages')->where('id','!=',$language->id)->update(['is_default' => 0]);
        }

        $language->update([
            'name'=> $request->language,
            'short_code' => $request->short_code
        ]);

        $path = resource_path()."/lang/$language->short_code.json";


        if(file_exists($path)){

            $file_data = json_encode(file_get_contents($path));

            unlink($path);

            file_put_contents($path,json_decode($file_data));
        }else{

            fopen(resource_path()."/lang/$request->short_code.json", "w");

            file_put_contents(resource_path()."/lang/$request->short_code.json", '{}');
        }
        $notify[] = ['success','Language Updated Successfully'];
        return back()->withNotify($notify);
    }

    public function delete(Request $request)
    {
        $language = Language::findOrFail($request->id);
        if($language->is_default){
            $notify[] = ['error','Default Language Can not Deleted'];
            return back()->withNotify($notify);
        }
        $path = resource_path()."/lang/$language->short_code.json";
        if(file_exists($path)){
            unlink($path);
        }
        if(session('locale') == $language->short_code){

            session()->forget('locale');
        }


        $language->delete();


        $notify[] = ['success','Language Deleted Successfully'];

        return back()->withNotify($notify);
    }


    public function transalate(Request $request)
    {
       $pageTitle = "Language Translator";

       $languages = Language::where('short_code','!=',$request->lang)->get();

       $language = Language::where('short_code', $request->lang)->firstOrFail();

       $translators = collect(json_decode(file_get_contents(resource_path()."/lang/$language->short_code.json"),true));

       $all = $translators;

       $translators = $this->paginate($translators, 20);

       return view('backend.language.translate',compact('translators','languages','all','pageTitle'));
    }


    public function transalateUpate(Request $request)
    {
        $language = Language::where('short_code', $request->lang)->firstOrFail();

        if($request->key == null && $request->value == null){
            $request->merge(['key' => ['home']]);
            $request->merge(['value' => ['home']]);
        }


        $translator = array_filter(array_combine($request->key,$request->value));

        file_put_contents(resource_path()."/lang/$language->short_code.json",json_encode($translator));

        return back();
    }

    public function import(Request $request, $lang)
    {
        $language = Language::where('short_code', $lang)->firstOrFail();

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);


        Excel::import(new LanguageImport($language),request()->file('file'));


        return redirect()->back()->with('success','Successfully Updated Language');


    }

    public function export($lang)
    {

        $language = Language::where('short_code', $lang)->firstOrFail();

        $translators =json_decode(file_get_contents(resource_path()."/lang/$language->short_code.json"),true);

        return Excel::download(new LanguageExport($translators), $lang.'.xlsx');
    }

    public function paginate(Collection $results, $showPerPage)
    {
        $pageNumber = Paginator::resolveCurrentPage('page');

        $totalPageNumber = $results->count();

        return self::paginator($results->forPage($pageNumber, $showPerPage), $totalPageNumber, $showPerPage, $pageNumber, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

    }

    protected static function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }


    public function changeLang (Request $request)
    {
        App::setLocale($request->lang);

        session()->put('locale', $request->lang);

        return redirect()->back()->with('success', __('Successfully Changed Language'));
    }

}

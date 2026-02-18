<?php

namespace App\Http\Controllers\Admin;

use App\Helper\MakeSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use App\Upload\Upload;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:add_faq'])->only(['create', 'store']);
        $this->middleware(['permission:edit_faq'])->only(['edit', 'update']);
        $this->middleware(['permission:view_faq'])->only(['index']);
        $this->middleware(['permission:delete_faq'])->only(['delete']);
        $this->middleware(['permission:active_faq'])->only(['active']);
        $this->middleware(['permission:restore_faq'])->only(['restore']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::get();
        return view('admin.faqs.index', ['faqs' => $faqs]);
    }

    public function trash()
    {
        $faqs = Faq::onlyTrashed()->get();
        return view('admin.faqs.trash', ['faqs' => $faqs]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faqs.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FaqRequest $request)
    {
        $faq = Faq::create($request->all());

        foreach ($request->translations as $locale => $translation) {
            $faq->translateOrNew($locale)->fill($translation)->save();
        }

        activity()->log('قام '.auth()->user()->name.'باضافة سؤال جديد'.$request->translations['ar']['question']);

        $message = [
            'alert-type' => 'success',
            'title' =>  trans('faq.add_success'),
            'message' => trans('faq.add_success')
        ];

        return redirect()->route('admin.faqs.index')->with($message);
    }

      /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', ['faq' => $faq]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        $faq->update($request->all());

        foreach ($request->translations as $locale => $translation) {
            $faq->translateOrNew($locale)->fill($translation)->save();
        }

        activity()->log('قام '.auth()->user()->name.'بتعديل السؤال'.$request->translations['ar']['question']);

        $message = [
            'alert-type' => 'success',
            'title' =>  trans('faq.updated_success'),
            'message' => trans('faq.updated_success')
        ];

        return redirect()->route('admin.faqs.index')->with($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        activity()->log('قام '.auth()->user()->name.'بحذف الصفحة'.$faq->translate('ar')->title);

        $message = [
            'alert-type' => 'success',
            'title' =>  trans('faq.deleted_success'),
            'message' => trans('faq.deleted_success')
        ];

        return redirect()->route('admin.faqs.index')->with($message);
    }

    public function restore($id)
    {
        $faq = Faq::withTrashed()->whereId($id)->firstOrFail()->restore();

        $message = [
            'alert-type' => 'success',
            'title' =>  trans('faq.restored_success'),
            'message' => trans('faq.restored_success')
        ];

        activity()->log('قام '.auth()->user()->name.'باستعادة الصفحة '.Faq::whereId($id)->first()->translate('ar')->title);

        return redirect()->back()->with($message);
    }



}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MixinsMainTypes;
use App\Traits\ImagesTrait;
use Illuminate\Http\Request;
use DB;

class MainTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ImagesTrait;

    public function index()
    {
        if (auth()->user()->branch->same_type) {
            $mainTypes = MixinsMainTypes::with(
                ['products' => function ($q) {
                    $q->where('is_deleted', false);
                }]
            )->get();
        } else {
            $mainTypes = MixinsMainTypes::where('branch_id', '=', auth()->user()->branch_id)->with(
                [
                    'products' => function ($q) {
                        $q->where('is_deleted', false);
                    }
                ]
            )->get();
        }


        return  json_encode($mainTypes);
    }
    public function printers()
    {

        return  json_encode(shell_exec('wmic printer get name'));
    }
    public function setDefaultprinter($name)
    {

        shell_exec("wmic printer where name='" . $name . "' call setdefaultprinter");

        // shell_exec('rundll32 printui.dll,PrintUIEntry /y /n '".$name.");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array();
        if ($request->type_icon) {
            $image_url = $this->UploadImage($request->type_icon, 'backend/products/');
        } else {
            $image_url = 'backend/products/product.png';
        }
        $data['type_icon'] = $image_url;

        $data["main_type_title_ar"] = $request->main_type_title_ar;
        $data["main_type_title_en"] = $request->main_type_title_en;
        $data["printer_name"] = $request->printer_name;

        $data['branch_id'] = auth()->user()->branch_id;

        MixinsMainTypes::insert($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mainTypes = DB::table('mixins_main_types')->where('main_type_id', $id)->first();
        if (!$mainTypes)
            $mainTypes = DB::table('mixins_main_types')->where('main_type_id', $id)->first();
        if (!$mainTypes)
            $mainTypes = DB::table('mixins_main_types')->where('main_type_id', $id)->first();
        return response()->json($mainTypes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = array();
        if ($request->newphoto) {
            $image_url = $this->UploadImage($request->newphoto, 'backend/products/');
        } else {
            $image_url = 'backend/products/product.png';
        }

        $data['type_icon'] = $image_url;
        $data["main_type_title_ar"] = $request->main_type_title_ar;
        $data["main_type_title_en"] = $request->main_type_title_en;
        $data["printer_name"] = $request->printer_name;
        MixinsMainTypes::where('main_type_id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('mixins_main_types')->where('main_type_id', $id)->first();

    }
}

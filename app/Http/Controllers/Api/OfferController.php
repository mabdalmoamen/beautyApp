<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupllierRequest;
use App\Models\MixinsSuppliers;
use App\Models\Offer;
use Illuminate\Http\Request;
use DB;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (!auth()->user()->is_admin) {

            $offers = Offer::where('branch_id', '=', auth()->user()->branch_id)->with(['mainOfferType', 'offerType'])->get()->all();
        } else {
            $offers = Offer::with(['mainOfferType', 'offerType'])->get()->all();
        }
        return  json_encode($offers);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $offer = array();
        $offer['main_type'] = $request->main_type;
        $offer['sup_type'] = $request->sup_type;
        $offer['offer_discount_percent'] = $request->offer_discount_percent;
        $offer['main_type_count'] = $request->main_type_count;
        $offer['branch_id'] = auth()->user()->branch_id;

        DB::table('offers')->insert($offer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offers = Offer::where('branch_id', '=', auth()->user()->branch_id)->where('id', $id)->with(['mainOfferType', 'offerType'])->first();

        return  json_encode($offers);
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
        $offer = array();
        $offer['main_type'] = $request->main_type;
        $offer['sup_type'] = $request->sup_type;
        $offer['offer_discount_percent'] = $request->offer_discount_percent;
        $offer['main_type_count'] = $request->main_type_count;
        DB::table('offers')->where('id', $id)->update($offer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('offers')->where('id', $id)->first();

        DB::table('offers')->where('id', $id)->delete();
    }
}

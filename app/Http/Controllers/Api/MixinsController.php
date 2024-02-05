<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mixins;
use App\Traits\ImagesTrait;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class MixinsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ImagesTrait;
    public function index()
    {
        $mixins = DB::table('mixins_info')->get();
        return json_encode($mixins);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //where('branch_id', '=', auth()->user()->branch_id)->
        $mixins = Mixins::where('id', $id)->with('currency', 'sale')->first();
        return json_encode($mixins);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $mixins = array();
        $mixins['same_type'] = $request->same_type;
        $mixins['digit'] = $request->digit;
        $mixins['active_point'] = $request->active_point;
        $mixins['bill_lang'] = $request->bill_lang;

        $mixins['point_price'] = $request->point_price;
        $mixins['valid_days'] = $request->valid_days;
        $mixins['point_every'] = $request->point_every;
        $mixins['contruct_no'] = $request->contruct_no;
        $mixins['item_request_qty'] = $request->item_request_qty;
        $mixins['logo_height'] = $request->logo_height;
        $mixins['logo_width'] = $request->logo_width;
        $mixins['fixed_vat'] = $request->fixed_vat;
        $mixins['smoken_vat'] = $request->smoken_vat;
        $mixins['active_offer'] = $request->active_offer;
        $mixins['offer_percenet'] = $request->offer_percenet;
        $mixins['offer_value'] = $request->offer_value;
        $mixins['sale_type'] = $request->sale_type;
        $mixins['use_type_uints'] = $request->use_type_uints;
        $mixins['offer_end_date'] = $request->offer_end_date;
        $mixins['reqeust_alert'] = $request->reqeust_alert;
        $mixins['weight_barcode'] = $request->weight_barcode;
        $mixins['weight_barcode_count'] = $request->weight_barcode_count;
        // $mixins['codies_type'] = $request->codies_type;
        $mixins['country'] = $request->country;
        $mixins['printer_type'] = $request->printer_type;
        $mixins['weight'] = $request->weight;

        $mixins['offer_start_date'] = $request->offer_start_date;
        $mixins['active_type_offer'] = $request->active_type_offer;
        $mixins['bill_discount'] = $request->bill_discount;
        $mixins['mixins_vat_val'] = $request->mixins_vat_val;
        $mixins['mixins_mobile'] = $request->mixins_mobile;
        $mixins['mixins_adress'] = $request->mixins_adress;
        $mixins['mixins_name'] = $request->mixins_name;
        $mixins['mixins_adress_en'] = $request->mixins_adress_en;
        $mixins['mixins_name_en'] = $request->mixins_name_en;
        $mixins['mixins_note'] = $request->mixins_note;
        $mixins['render_en_names'] = $request->render_en_names;
        $mixins['bill_type'] = $request->bill_type;
        $mixins['email_from'] = $request->email_from;
        $mixins['email_to'] = $request->email_to;
        $mixins['send_time'] = $request->send_time;
        $mixins['closure_hour'] = $request->closure_hour;
        $mixins['as_card'] = $request->as_card;
        $mixins['show_side_menu'] = $request->show_side_menu;
        $mixins['count_in_row_bill'] = $request->count_in_row_bill;
        $mixins['count_in_row_main'] = $request->count_in_row_main;
        $mixins['printer_count'] = $request->printer_count;
        $mixins['pretty'] = $request->pretty;
        $mixins['default_printer'] = $request->default_printer;
        $mixins['active_distributing'] = $request->active_distributing;

        $mixins['mixins_main_payment_method'] = $request->mixins_main_payment_method;
        $mixins['render_cash_point'] = $request->render_cash_point;
        $mixins['process_bills'] = $request->process_bills;
        $mixins['currency'] = $request->currency['id'];
        $mixins['bill_with_main_type'] = $request->bill_with_main_type;
        $mixins['default_lang'] = $request->default_lang;


        $mixins['mixins_price_include_vat'] = $request->mixins_price_include_vat;

        if ($request->mixins_new_logo) {
            $mixins_logo = $this->UploadImage($request->mixins_new_logo, 'backend/mixins/');
            $mixins['mixins_logo'] = $mixins_logo;
            DB::table('mixins_info')->where('id', $id)->update($mixins);
        } else {
            DB::table('mixins_info')->where('id', $id)->update($mixins);
        }
        if ($request->new_background) {
            $new_background = $this->UploadImage($request->new_background, 'backend/mixins/');
            $mixins['mixins_background'] = $new_background;
            DB::table('mixins_info')->where('id', $id)->update($mixins);
        }
        Cookie::queue('locale', $request->default_lang, time() + (20 * 365 * 24 * 60 * 60));
        if (isset($request->default_lang)) {
            app()->setLocale($request->default_lang);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

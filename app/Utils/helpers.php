<?php

namespace App\utils;

use App\Models\Currency;
use App\Models\Mixins;
use Illuminate\Support\Facades\Auth;

class helpers
{

    //  Helper Multiple Filter
    public function filter($model, $columns, $param, $request)
    {
        // Loop through the fields checking if they've been input, if they have add
        //  them to the query.
        $fields = [];
        for ($key = 0; $key < count($columns); $key++) {
            $fields[$key]['param'] = $param[$key];
            $fields[$key]['value'] = $columns[$key];
        }

        foreach ($fields as $field) {
            $model->where(function ($query) use ($request, $field, $model) {
                return $model->when(
                    $request->filled($field['value']),
                    function ($query) use ($request, $model, $field) {
                        $field['param'] = 'like' ?
                            $model->where($field['value'], 'like', "{$request[$field['value']]}")
                            : $model->where($field['value'], $request[$field['value']]);
                    }
                );
            });
        }

        // Finally return the model
        return $model;
    }

    //  Check If Hass Permission Show All records
    public function Show_Records($model)
    {

            return $model->where('user_id', '=', Auth::user()->id);
    }

    // Get Currency
    public function Get_Currency()
    {
        $mixins = Mixins::with('currency')->first();

        if ($mixins && $mixins->id) {
            if (Currency::where('id', $mixins->id)

                ->first()
            ) {
                $symbol = '$';
            } else {
                $symbol = '';
            }
        } else {
            $symbol = '';
        }
        return $symbol;
    }

    // Get Currency COde
    public function Get_Currency_Code()
    {
        $mixins = Mixins::with('currency')->first();

        if ($mixins && $mixins->id) {
            if (Currency::where('id', $mixins->id)

                ->first()
            ) {
                $code = $mixins['currency']->id;
            } else {
                $code = 'egP';
            }
        } else {
            $code = 'egP';
        }
        return $code;
    }
}

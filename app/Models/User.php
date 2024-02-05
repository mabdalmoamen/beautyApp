<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'id', 'name', 'password', 'branch_id','pin_code', 'status', 'is_admin', 'mobile', 'salary', 'full_name', 'email', 'is_user', 'hour_price', 'work_hour_count', 'jop_title', 'period_report', 'bill_details', 'bills', 'new_bill', 'puraches_bill', 'expenses', 'puraches_bills',
        'delete_bill', 'delete_reserved_type', 'branch_id', 'resend', 'change_type_in_kitchen',
        'customers', 'delete_customer',
        'commission', 'is_percent_commission',
        'edit_customer', 'create_customer', 'users', 'delete_user', 'edit_user', 'create_user', 'user_roles', 'change_price', 'types', 'create_type', 'delete_type', 'edit_type', 'reports', 'daily_report', 'monthly_report', 'bills_report', 'puraches_bill_report', 'expenses_reports', 'process_bill', 'process_bill_report', 'stock', 'pay_bill', 'remove_from_cart', 'bill_discount', 'type_discount', 'bill_extra', 'shift', 'shift_report', 'customer_pay', 'customer_pay_report', 'suppliers', 'supplier_report', 'create_supplier', 'edit_supplier', 'delete_supplier', 'settings', 'units', 'create_unit', 'add_unit', 'edit_unit', 'offers', 'create_offer', 'edit_offer', 'delete_offer', 'barcode_settings', 'print_barcode', 'reprint_bill', 'main_types', 'create_main_type', 'edit_main_type', 'delete_unit', 'delete_main_type'
    ];
    public $timestamps = false;


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'period_report' => 'boolean',
        'bill_details' => 'boolean',
        'is_admin' => 'boolean',
        'status' => 'boolean',
        'bills' => 'boolean',
        'new_bill' => 'boolean',
        'puraches_bill' => 'boolean',
        'expenses' => 'boolean',
        'puraches_bills' => 'boolean',
        'delete_bill' => 'boolean',
        'delete_reserved_type' => 'boolean',
        'resend' => 'boolean',
        'change_type_in_kitchen' => 'boolean',
        'customers' => 'boolean',
        'delete_customer' => 'boolean',
        'edit_customer' => 'boolean',
        'create_customer' => 'boolean',
        'users' => 'boolean',
        'delete_user' => 'boolean',
        'edit_user' => 'boolean',
        'create_user' => 'boolean',
        'user_roles' => 'boolean',
        'change_price' => 'boolean',
        'types' => 'boolean',
        'create_type' => 'boolean',
        'delete_type' => 'boolean',
        'edit_type' => 'boolean',
        'reports' => 'boolean',
        'daily_report' => 'boolean',
        'monthly_report' => 'boolean',
        'bills_report' => 'boolean',
        'puraches_bill_report' => 'boolean',
        'expenses_reports' => 'boolean',
        'process_bill' => 'boolean',
        'process_bill_report' => 'boolean',
        'stock' => 'boolean',
        'pay_bill' => 'boolean',
        'remove_from_cart' => 'boolean',
        'bill_discount' => 'boolean',
        'type_discount' => 'boolean',
        'bill_extra' => 'boolean',
        'shift' => 'boolean',
        'shift_report' => 'boolean',
        'customer_pay' => 'boolean',
        'customer_pay_report' => 'boolean',
        'suppliers' => 'boolean',
        'supplier_report' => 'boolean',
        'create_supplier' => 'boolean',
        'edit_supplier' => 'boolean',
        'delete_supplier' => 'boolean',
        'settings' => 'boolean',
        'units' => 'boolean',
        'create_unit' => 'boolean',
        'add_unit' => 'boolean',
        'edit_unit' => 'boolean',
        'offers' => 'boolean',
        'create_offer' => 'boolean',
        'edit_offer' => 'boolean',
        'delete_offer' => 'boolean',
        'barcode_settings' => 'boolean',
        'print_barcode' => 'boolean',
        'reprint_bill' => 'boolean',
        'main_types' => 'boolean',
        'create_main_type' => 'boolean',
        'edit_main_type' => 'boolean',
        'delete_unit' => 'boolean',
        'delete_main_type' => 'boolean',

    ];
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            return Cache::forget('activeChannels');
        });
    }
    public function branch()
    {
        return $this->hasOne('App\Models\Mixins', 'id', 'branch_id')->with(['currency','sale']);
    }
    // Rest omitted for brevity
    public function roles()
    {
        return $this->hasMany('App\Models\UserRoles', "user_id", 'id');
    }
    public function bills()
    {
        return $this->hasMany('App\Models\Bill', "worker_id", 'id');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'uid');
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

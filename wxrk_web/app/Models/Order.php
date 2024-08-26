<?php
namespace App\Models;

use PDF;
use Str;

use App\User;
use App\Models\Admin;
use App\Models\Address;
use App\Services\Mailers\Mailer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'order_number', 
        'offer_id', 
        'offer_name', 
        'offer_price', 
        'offer_promo_code', 
        'promo_code_redemption_status', 
        'promo_code_redemption_date', 
        'offer_type', 
        'offer_category', 
        'offer_premium_category', 
        'time_to_redeem', 
        'highlight_of_offer', 
        'details_of_offer', 
        'link', 
        'user_id', 
        'customer_name', 
        'customer_mobile', 
        'customer_email', 
        'customer_country', 
        'admin_id', 
        'vendor_name', 
        'vendor_mobile', 
        'vendor_email', 
        'vendor_country', 
        'vendor_category', 
        'vendor_state', 
        'vendor_city', 
        'vendor_address', 
        'vendor_postal_code', 
        'status', 
        'created_by', 
        'updated_by'
    ];

    protected $casts = [
        'offer_id' => 'string',
        'user_id' => 'string',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */

    protected $appends = [
        'remaining_hours',
        'end_time',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = ['deleted_at'];

    public function addPayout() {

        foreach($this->items as $item) {
            $item->addPayout();
        }
    }

    public function offer(){
        return $this->belongsTo(Offer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    
    public function createdBy(){
        return $this->belongsTo(Admin::class);
    }

    public function updatedBy(){
        return $this->belongsTo(User::class);
    }

    public function paymenttransaction()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function transactions()
    {
        return $this->morphMany('App\Models\Transactions', 'payable');
    }

    public function getRemainingHoursAttribute(){
        $end_date = date('Y-m-d H:i:s', strtotime(' +'.(int)$this->time_to_redeem.' hours', strtotime($this->created_at)));
        $future = strtotime($end_date);
        $now = time();
        $timeleft = $future-$now;
        $H = floor($timeleft / 3600);
        $i = ($timeleft / 60) % 60;
        $s = $timeleft % 60;
        // $remaining_hours = date('H:i:s', strtotime($timeleft));
        $remaining_hours = $H.":".$i.":".$s;
        $remaining_hours = ($remaining_hours > 0 ? $remaining_hours : '00:00:00');
        return (string)$remaining_hours;
    }

    public function getEndTimeAttribute(){
        $end_date = date('Y-m-d H:i:s', strtotime(' +'.(int)$this->time_to_redeem.' hours', strtotime($this->created_at)));
        return $end_date;
    }



}

<?php

namespace App\Models;

use App\User;
use App\Helpers\GeneralHelper;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{

    protected $fillable = [
        'invoice_id',
        'item_sequence',
        'item_code',
        'item',
        'unit_price',
        'quantity',
        'is_taxable',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = ['deleted_at'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {

            $invoice = Invoice::find($model->invoice_id);
            $userData = User::find($invoice->user_id);
            $model->tax_perc_1 = 0;
            $model->tax_perc_2 = 0;

            $model->sub_total = round(($model->unit_price * $model->quantity), 2);
            if($userData->tax_exempt == 1){
                $model->is_taxable = 0;
            }
            if($invoice->currency == 'INR' && $model->is_taxable) {
                $taxPerc = GeneralHelper::getProductServiceGstPerc();
                if(isset($invoice->customer['billing_address']['state']) &&  $invoice->customer['billing_address']['state'] == 'Delhi') {
                    $model->tax_1 = "SGST";
                    $model->tax_2 = "CGST";
                    $taxPerc = round($taxPerc/2, 2);
                    $model->tax_perc_1 = $taxPerc;
                    $model->tax_perc_2 = $taxPerc;
                }
                else {
                    $model->tax_1 = "IGST";
                    $model->tax_perc_1 = $taxPerc;
                }
            }
            $model->tax_value_1 = round(($model->sub_total * $model->tax_perc_1) / 100 , 2);
            $model->tax_value_2 = round(($model->sub_total * $model->tax_perc_2) / 100 , 2);

            $model->total_tax = $model->tax_value_1 + $model->tax_value_2;
            $model->total_amount = $model->sub_total + $model->total_tax;

        });

    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

}

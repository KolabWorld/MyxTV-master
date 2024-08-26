<?php

namespace App\Http\Controllers;

use View;
use Session;
use Request;

use App\Models\TokenSetting;
use App\Models\ProductType;
use App\Models\ServerGroup;
use App\Models\Configuration;
use App\Models\ProductService;
use App\Models\SubscriptionPlan;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $uri = Request::getHost();
        // $productTypes = ProductType::with('serverGroups')->where('is_enable', 1)->orderBy('sortorder')->get();
        // //$productTypes = ProductType::with('serverGroups')->where('is_enable', 1)->get();
        // $reseller = User::where('reseller_type', '=', $uri)->first();
        // $clientConfiguration = "";
        // if(isset($reseller->id))
        //     $clientConfiguration = Configuration::where('user_id', '=', $reseller->id)->first();
        
	    // View::share('productTypes', $productTypes);
        // View::share('clientConfiguration', $clientConfiguration);
        $plans = SubscriptionPlan::where('plan_type', '=', 'monthly')
            ->where('status', '=', 'active')
            ->get();
        View::share('plans', $plans);

        $tokenSetting = TokenSetting::first();
        View::share('tokenSetting',$tokenSetting);
    }

    public function amountInWords($number) {
    	$num = intval($number);
        $dec_n = round($number - $num, 2) * 100;
        $num = self::convert_amount($num);
        $dec = self::convert_amount($dec_n);

        if($dec_n == 0)
        {
            $string = ucfirst($num)."rupees";
        }
        else if($dec_n != 0)
        {
            $string = ucfirst($num)."rupees and ".$dec."paise";
        }

        return $string;
    }

    private function convert_amount($number) {

       $no = intval($number);
       $point = round($number - $no, 2) * 100;
       $hundred = null;
       $digits_1 = strlen($no);
       $i = 0;
       $str = array();
       $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety'
        );
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');

        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' ' : null;
                $str [] = ($number < 21) ? $words[$number] .
                    " " . $digits[$counter] . $plural . " " . $hundred
                    :
                    $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else $str[] = null;
        }

        $str = array_reverse($str);
        $result = implode('', $str);
        $string = $result;

        return $string;
    }
}

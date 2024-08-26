<?php

use App\Models\CurrencyExchangeRate;
use App\Models\Product;
function dateFormat($date)
{
    return date('jS M Y', strtotime($date));
}

function dateTimeFormat($date)
{
    return date('jS M Y h:i A', strtotime($date));
}

function timeFormat($date)
{
    return date('h:i A', strtotime($date));
}

function getUserCurrency(){

    $currency = session('user_currency');
    return $currency ?: env('DEFAULT_CURRENCY');
}

function currencyConvert($fromCurrency, $amount)
{
    $rate = 1;
    $fromCurrency = $fromCurrency ? $fromCurrency->alias : env('DEFAULT_CURRENCY');
    $toCurrency = session('user_currency') ?: env('DEFAULT_CURRENCY');

    if($fromCurrency !== $toCurrency) {
        $exchangeRate = CurrencyExchangeRate::where('from', '=', $fromCurrency)
            ->where('to', '=', $toCurrency)
            ->first();

        if($exchangeRate) {
            $rate = $exchangeRate->rate;
        }

    }

    return round($amount * $rate);
}
function currencyConvertForPayout($fromCurrency, $amount)
{
    $rate = 1;
    $fromCurrency = $fromCurrency->alias;
    $toCurrency = 'USD';

    if($fromCurrency !== $toCurrency) {
        $exchangeRate = CurrencyExchangeRate::where('from', '=', $fromCurrency)
            ->where('to', '=', $toCurrency)
            ->first();

        if($exchangeRate) {
            $rate = $exchangeRate->rate;
        }

    }

    return round($amount * $rate);
}

function currencyConvertHTML($fromCurrency, $amount, $withSymbol= true)
{
    $rate = 1;
    $currencySign = '$';
    $fromCurrency = $fromCurrency ? $fromCurrency->alias : env('DEFAULT_CURRENCY');
    $toCurrency = session('user_currency') ?: env('DEFAULT_CURRENCY');

    if($fromCurrency !== $toCurrency) {
        $exchangeRate = CurrencyExchangeRate::where('from', '=', $fromCurrency)
            ->where('to', '=', $toCurrency)
            ->first();

        if($exchangeRate) {
            $rate = $exchangeRate->rate;
        }

        if($toCurrency == 'INR'){
			$currencySign = 'Rs.';	
		}
    }

    if ($withSymbol) {
        return $currencySign .' '. round($amount * $rate);
    }else{
        return round($amount * $rate);
    }

    
}

function getCurrencyRate($fromCurrency)
{
    $rate = 1;
    $toCurrency = session('user_currency') ?: env('DEFAULT_CURRENCY');

    if($fromCurrency !== $toCurrency) {
        $exchangeRate = CurrencyExchangeRate::where('from', '=', $fromCurrency)
            ->where('to', '=', $toCurrency)
            ->first();

        if($exchangeRate) {
            $rate = $exchangeRate->rate;
        }
    }
    
    return $rate;
}


function currencySymbol()
{
    
    $toCurrency = session('user_currency') ?: env('DEFAULT_CURRENCY');
    $currencySign = "$";
    if($toCurrency == 'INR'){
        $currencySign = 'Rs.';  
    }
    return $currencySign;

    
}

function getDesignerCurrencyByProduct($product_id)
{
    
    $productDetails = Product::with('designer')->where('id',$product_id)->first();
    return $currency = $productDetails->designer->currency;    
}

/**
 * $keyname - name of file element which contain file in request 
 * $videoSize - need to pass here validation rules such as "|max15000|min:1000"
 * $imageSize - need to pass here validation rules such as "|max15000|min:1000"
 */
function imageVideoValidation($request,$keyname,$videoSize,$imageSize){
    $filevalidate='';
    if( $request->hasFile($keyname) ) {
        $file = $request->file($keyname);
        $imagemimes = ['image/png','image/jpeg','image/png']; 
        $videomimes = ['video/mp4','video/mkv','video/mkv','video/avi']; 
        if(in_array($file->getMimeType() ,$imagemimes)) {
            $filevalidate = 'mimes:jpeg,png,jpg'. $imageSize;
        }
        //Validate video
        if (in_array($file->getMimeType() ,$videomimes)) {
            $filevalidate = 'mimes:mp4,mkv'.$videoSize;
        }
    }
    return $filevalidate;
}

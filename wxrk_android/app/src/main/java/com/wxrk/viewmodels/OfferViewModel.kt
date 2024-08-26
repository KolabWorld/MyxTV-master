package com.wxrk.viewmodels

import android.app.Application
import android.widget.Toast
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.MutableLiveData
import com.contactandroidapp.Network.RetrofitBuilder
import com.contactandroidapp.Network.RetrofitBuilder.lastFmService
import com.google.gson.Gson
import com.google.gson.reflect.TypeToken
import com.wxrk.model.ErrorResponse
import com.wxrk.model.offers.OfferListRes
import com.wxrk.model.offers.PromoCodeData
import com.wxrk.model.offers.offercat.JoinOfferBody
import com.wxrk.model.offers.offercat.ResOfferCat
import com.wxrk.utils.Common
import com.wxrk.utils.Common.Companion.logUnlimited
import com.wxrk.utils.Prefs
import kotlinx.coroutines.GlobalScope
import kotlinx.coroutines.launch
import org.json.JSONArray


class OfferViewModel(application: Application) : AndroidViewModel(application) {
    var itemcategory: MutableLiveData<ResOfferCat> = MutableLiveData()

    var itemOfferlist: MutableLiveData<OfferListRes> = MutableLiveData()

    var itempromocodedate: MutableLiveData<PromoCodeData> = MutableLiveData()
    var loader: MutableLiveData<Boolean> = MutableLiveData()
 var errorres: MutableLiveData<ErrorResponse> = MutableLiveData()

    fun getOfferCat() {
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(getApplication()).token

        GlobalScope.launch {
            val call = lastFmService?.getOfferCat()!!
            if (call.isSuccessful) {
                itemcategory.postValue(call.body())
            }
            logUnlimited("body", "- ${call.body()}")
        }

    }

    fun getOfferList(array: List<Int>) {
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(getApplication()).token

        var arr = JSONArray(array)
        logUnlimited("arrayvalue", "$arr")
        GlobalScope.launch {
            val call = lastFmService?.getOfferList(array)!!
            if (call.isSuccessful) {
                itemOfferlist.postValue(call.body())
            } else {
                itemOfferlist.postValue(OfferListRes())

            }
            logUnlimited("offerlis", call.body().toString())
            logUnlimited("offerlis", call.code().toString())
            logUnlimited("offerlis", call.message().toString())
            logUnlimited("offerlis", call.errorBody().toString())

        }

    }

    fun JoinOffer(offerid: Int) {
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(getApplication()).token

        loader.postValue(true)
        GlobalScope.launch {
            val call = lastFmService?.setJoinOffer(
                JoinOfferBody(
                    offerid,
                    Prefs.getInstance(getApplication()).userid
                )
            )!!
            if (call.isSuccessful) {
                itempromocodedate.postValue(call.body())
            } else {

//                val jObjError = JSONObject(call.errorBody().toString())
//                logUnlimited("offerlis","array= $jObjError")


                val gson = Gson()
                val type = object : TypeToken<ErrorResponse>() {}.type
                var errorResponse: ErrorResponse? = gson.fromJson(call.errorBody()!!.charStream(), type)
                logUnlimited("offerliserror", errorResponse!!.errors!!.message.toString())
                errorres.postValue(errorResponse!!)

            }
            loader.postValue(false)

            logUnlimited("offerlis", call.body().toString())
            logUnlimited("offerliserr", call.toString())
            logUnlimited("offerlis", "inn $offerid")

        }

    }


}
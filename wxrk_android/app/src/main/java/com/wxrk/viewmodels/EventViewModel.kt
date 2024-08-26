package com.wxrk.viewmodels

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.contactandroidapp.Network.RetrofitBuilder
import com.contactandroidapp.Network.RetrofitBuilder.lastFmService
import com.google.gson.Gson
import com.google.gson.reflect.TypeToken
import com.wxrk.model.Dashboarddata.WatchTimeres
import com.wxrk.model.ErrorResponse
import com.wxrk.model.Twitch.GetAllVideo
import com.wxrk.model.dashbord.ResDasbord
import com.wxrk.model.event.JoinEventBody
import com.wxrk.model.event.JoinEventRes
import com.wxrk.utils.Common
import com.wxrk.utils.Prefs
import kotlinx.coroutines.GlobalScope
import kotlinx.coroutines.launch

class EventViewModel(application: Application) : AndroidViewModel(application) {


    var itemcategory: MutableLiveData<ResDasbord> = MutableLiveData()
    var twitch_list: MutableLiveData<GetAllVideo> = MutableLiveData()

    var itemjoinres: MutableLiveData<JoinEventRes> = MutableLiveData()
    var itemloader: MutableLiveData<Boolean> = MutableLiveData()
    var errorres: MutableLiveData<ErrorResponse> = MutableLiveData()
    var watchtimedata: MutableLiveData<WatchTimeres> = MutableLiveData()

    fun geteventlist() {
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(getApplication()).token

        GlobalScope.launch {
            val call = lastFmService?.getEventList()!!
            if (call.isSuccessful) {
                itemcategory.postValue(call.body())
            }
        }
    }

    fun JoinEvent(body: JoinEventBody) {
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(getApplication()).token
        itemloader.postValue(true)
        GlobalScope.launch {
            val call = lastFmService?.getJoinEvent(body)!!
            if (call.isSuccessful) {
                itemjoinres.postValue(call.body())
            } else {
                val gson = Gson()
                val type = object : TypeToken<ErrorResponse>() {}.type
                var errorResponse: ErrorResponse? = gson.fromJson(call.errorBody()!!.charStream(), type)
                Common.logUnlimited("offerliserror", errorResponse!!.errors!!.message.toString())
                errorres.postValue(errorResponse!!)
            }
            itemloader.postValue(false)

        }
    }

    fun getallvideos() {

        viewModelScope.launch {
            val call = lastFmService?.get_twitchvideos()!!

            twitch_list.postValue(call.body())
        }
    }

    fun getWatchtime() {
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(getApplication()).token
        GlobalScope.launch {
            val call = lastFmService?.getWatchtime()!!
            if (call.isSuccessful) {
                watchtimedata.postValue(call.body())
            }
            Common.logUnlimited( "callGetDashboard: ", "${call.body()}")
            Common.logUnlimited( "token: ", "${RetrofitBuilder.token}")
        }

    }
}
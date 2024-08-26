package com.wxrk.viewmodels

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.MutableLiveData
import com.contactandroidapp.Network.RetrofitBuilder
import com.contactandroidapp.Network.RetrofitBuilder.lastFmService
import com.wxrk.model.transection.BodyTransection
import com.wxrk.model.transection.IosWeekdataRes
import com.wxrk.model.transection.Weekres
import com.wxrk.model.transection.toptrac.Transectionres
import com.wxrk.utils.Common
import com.wxrk.utils.Prefs
import kotlinx.coroutines.GlobalScope
import kotlinx.coroutines.launch

class TransectionViewModel(application: Application) : AndroidViewModel(application) {


    var itemdataweek: MutableLiveData<Weekres> = MutableLiveData()
    var itemdataweekios: MutableLiveData<IosWeekdataRes> = MutableLiveData()
    var itemdatatransection: MutableLiveData<Transectionres> = MutableLiveData()
    var itemdataAlltransection: MutableLiveData<Transectionres> = MutableLiveData()

    fun getWeekdata() {
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(getApplication()).token

        GlobalScope.launch {
            val call = lastFmService?.getWeekData()!!
            if (call.isSuccessful) {
                itemdataweek.postValue(call.body())
            } else {
                itemdataweek.postValue(Weekres())

            }
        }
    }

    fun getWeekdatanew() {
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(getApplication()).token

        GlobalScope.launch {
            val call = lastFmService?.getWeekDataIosAppPerformance()!!
            if (call.isSuccessful) {
                itemdataweekios.postValue(call.body())
            } else {
                itemdataweekios.postValue(IosWeekdataRes())

            }
        }
    }


    fun getTopTraction() {
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(getApplication()).token

        GlobalScope.launch {
            val call = lastFmService?.getTopTransection()!!
            if (call.isSuccessful) {
                itemdatatransection.postValue(call.body())
            } else {
                itemdatatransection.postValue(Transectionres())

            }
        }
    }

    fun getAllTraction(body: BodyTransection) {
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(getApplication()).token

        GlobalScope.launch {
            val call = lastFmService?.getAllTransections(body.from_date!!, body.to_date!!)!!
            if (call.isSuccessful) {
                itemdataAlltransection.postValue(call.body())
            } else {
                itemdataAlltransection.postValue(Transectionres())

            }
            Common.logUnlimited("res",call.body().toString())
        }
    }

}
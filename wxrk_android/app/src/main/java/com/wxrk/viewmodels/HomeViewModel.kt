package com.wxrk.viewmodels

import android.app.Application
import android.util.Log
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.MutableLiveData
import com.contactandroidapp.Network.RetrofitBuilder.lastFmService
import com.contactandroidapp.Network.RetrofitBuilder.token
import com.wxrk.model.Dashboarddata.WatchTimeres
import com.wxrk.model.dashbord.ResDasbord
import com.wxrk.utils.Common
import com.wxrk.utils.Prefs
import kotlinx.coroutines.GlobalScope
import kotlinx.coroutines.launch

class HomeViewModel(application: Application) : AndroidViewModel(application) {
    var dashbordData: MutableLiveData<ResDasbord> = MutableLiveData()
 var watchtimedata: MutableLiveData<WatchTimeres> = MutableLiveData()

    fun callGetDashboard() {
        token = "Bearer " + Prefs.getInstance(getApplication()).token
        GlobalScope.launch {
            val call = lastFmService?.getDashboard()!!
            if (call.isSuccessful) {
                dashbordData.postValue(call.body())
            }
            Common.logUnlimited( "callGetDashboard: ", "${call.body()}")
            Common.logUnlimited( "token: ", "$token")
        }

    }
    fun getWatchtime() {
        token = "Bearer " + Prefs.getInstance(getApplication()).token
        GlobalScope.launch {
            val call = lastFmService?.getWatchtime()!!
            if (call.isSuccessful) {
                watchtimedata.postValue(call.body())
            }
            Common.logUnlimited( "callGetDashboard: ", "${call.body()}")
            Common.logUnlimited( "token: ", "$token")
        }

    }
}
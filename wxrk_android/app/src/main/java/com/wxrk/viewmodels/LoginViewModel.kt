package com.wxrk.viewmodels

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.MutableLiveData
import com.contactandroidapp.Network.RetrofitBuilder
import com.contactandroidapp.Network.RetrofitBuilder.lastFmService
import com.google.gson.Gson
import com.google.gson.reflect.TypeToken
import com.wxrk.model.ErrorResponse
import com.wxrk.model.login.LoginBody
import com.wxrk.model.login.LoginRes
import com.wxrk.model.login.otp.MobileOtpRes
import com.wxrk.model.login.otp.SendOTPBody
import com.wxrk.model.login.otp.VerifyOtpBody
import com.wxrk.utils.Common
import com.wxrk.utils.Common.Companion.logUnlimited
import com.wxrk.utils.Common.Companion.tooast
import com.wxrk.utils.Prefs
import kotlinx.coroutines.GlobalScope
import kotlinx.coroutines.launch

class LoginViewModel(application: Application) : AndroidViewModel(application) {

    var itemlogin: MutableLiveData<LoginRes> = MutableLiveData()
    var itemotp: MutableLiveData<MobileOtpRes> = MutableLiveData()
    var loader: MutableLiveData<Boolean> = MutableLiveData()
    var error: MutableLiveData<String> = MutableLiveData()
    var errorres: MutableLiveData<ErrorResponse> = MutableLiveData()


    fun Login(password: String, username: String) {
        var loginBody = LoginBody(
            "187",
            "2",
            "CBRYoCsb8L8Fmx6uam9q2rBT797yDybaTB2JQFzS",
            "postman-ashish",
            "Ashish Postman",
            "0",
            "password",
            "27.4383838",
            "77.947464",
            "Android",
            password,
            "*",
            username
        )

        logUnlimited("loginbody", "${loginBody.toString()}")

        GlobalScope.launch {
            val call = lastFmService?.login(loginBody)!!
            if (call.isSuccessful) {
                itemlogin.postValue(call.body())
            }else {
                val gson = Gson()
                val type = object : TypeToken<ErrorResponse>() {}.type
                var errorResponse: ErrorResponse? = gson.fromJson(call.errorBody()!!.charStream(), type)
                Common.logUnlimited("offerliserror", errorResponse!!.errors!!.message.toString())
                errorres.postValue(errorResponse!!)
            }
        }

    }

    fun send_otp(countrycode: String, mobile: String, email: String) {
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(getApplication()).token

        if (mobile.length != 10) {
            tooast(getApplication(), "Please enter valid mobile no")
            return
        }
        loader.postValue(true)
        var loginBody =
            SendOTPBody(mobile, countrycode, Prefs.getInstance(getApplication()).userid, email)

        GlobalScope.launch {
            val call = lastFmService?.send_otp(loginBody)!!
            if (call.isSuccessful) {
                loader.postValue(false)

                itemotp.postValue(call.body())
            } else {
                loader.postValue(false)
                logUnlimited("send_otp", "${call.body()}")

                itemotp.postValue(call.body())
            }

        }

    }

    fun verify_otp(mobile: String) {
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(getApplication()).token

        if (mobile.length != 4) {
            tooast(getApplication(), "Please enter valid mobile no")
            return
        }
        loader.postValue(true)

        var loginBody = VerifyOtpBody(mobile, Prefs.getInstance(getApplication()).userid)

        GlobalScope.launch {
            val call = lastFmService?.verify_otp(loginBody)!!
            if (call.isSuccessful) {
                loader.postValue(false)

                itemotp.postValue(call.body())
            } else {
                loader.postValue(false)
                itemotp.postValue(call.body())

            }
        }

    }


    fun updateprofile() {
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(getApplication()).token
        loader.postValue(true)
        GlobalScope.launch {
            val call = lastFmService?.profile_login(
                Prefs.getInstance(getApplication()).userid,
                Prefs.getInstance(getApplication()).userFirstName
            )!!
            if (call.isSuccessful) {
                loader.postValue(false)
                itemotp.postValue(call.body())
            } else {
                loader.postValue(false)
                itemotp.postValue(call.body())

            }
        }

    }

}
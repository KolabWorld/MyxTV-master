package com.wxrk.viewmodels

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.MutableLiveData
import com.contactandroidapp.Network.RetrofitBuilder
import com.contactandroidapp.Network.RetrofitBuilder.lastFmService
import com.wxrk.model.login.otp.MobileOtpRes
import com.wxrk.utils.Common.Companion.logUnlimited
import com.wxrk.utils.Common.Companion.tooast
import com.wxrk.utils.Prefs
import kotlinx.coroutines.GlobalScope
import kotlinx.coroutines.launch
import okhttp3.MediaType
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody
import java.io.File


class EditProfileViewModel(application: Application) : AndroidViewModel(application) {

    var itemotp: MutableLiveData<MobileOtpRes> = MutableLiveData()
    var loader: MutableLiveData<Boolean> = MutableLiveData()


    fun updateprofile(namestr: String, dobstr: String, file: File) {
        if (!(dobstr.length > 0)) {
            tooast(getApplication(), "Please enter DOB")
            return
        }
        loader.postValue(true)

        val requestFile: RequestBody =
            RequestBody.create("multipart/form-data".toMediaTypeOrNull(), file)

        val body: MultipartBody.Part =
            MultipartBody.Part.createFormData("image", file.name, requestFile)

        val userid: RequestBody = RequestBody.create(
            "text/plain".toMediaTypeOrNull(),
            Prefs.getInstance(getApplication()).userid.toString()
        )

        val name: RequestBody = RequestBody.create("text/plain".toMediaTypeOrNull(), namestr)
        val dob: RequestBody = RequestBody.create("text/plain".toMediaTypeOrNull(), dobstr)
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(getApplication()).token

        GlobalScope.launch {
            logUnlimited(
                "body", "${Prefs.getInstance(getApplication()).userid},\n" +
                        "     $name,$dob , ${file.name} , ${body.body}"
            )
            val call = lastFmService?.profile(
                userid,
                name, dob, body
            )!!
            if (call.isSuccessful) {
                loader.postValue(false)
                itemotp.postValue(call.body())
            } else {
                loader.postValue(false)
                itemotp.postValue(call.body())

            }
            logUnlimited("profile", call.body().toString())
        }


    }


}
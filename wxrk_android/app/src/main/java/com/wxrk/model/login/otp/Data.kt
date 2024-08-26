package com.wxrk.model.login.otp

import com.google.gson.annotations.SerializedName


data class Data(

    @SerializedName("message") var message: String? = null,
    @SerializedName("data") var data: Datainside? = Datainside()

)
package com.wxrk.model.login.otp

import com.google.gson.annotations.SerializedName


data class MobileOtpRes(

    @SerializedName("status") var status: Int? = null,
    @SerializedName("data") var data: Data? = Data(),
    @SerializedName("errors") var errors: Errors? = Errors()

)


data class Errors(

    @SerializedName("message") var message: String? = null

)
package com.wxrk.model.login

import com.google.gson.annotations.SerializedName


data class LoginRes(

    @SerializedName("status") var status: Int? = null,
    @SerializedName("data") var data: Data? = Data()

)
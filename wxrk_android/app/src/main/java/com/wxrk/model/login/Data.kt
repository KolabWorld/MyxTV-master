package com.wxrk.model.login

import com.google.gson.annotations.SerializedName


data class Data(

    @SerializedName("message") var message: String? = null,
    @SerializedName("data") var data: DataInside? = DataInside(),
    @SerializedName("access_token") var accessToken: String? = null

)
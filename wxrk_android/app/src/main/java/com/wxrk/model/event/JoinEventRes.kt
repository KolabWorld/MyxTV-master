package com.wxrk.model.event


import com.google.gson.annotations.SerializedName


data class JoinEventRes(

    @SerializedName("status") var status: Int? = null,
    @SerializedName("data") var data: Data? = Data()

)


data class Data(

    @SerializedName("message") var message: String? = null,
    @SerializedName("data") var data: String? = null

)
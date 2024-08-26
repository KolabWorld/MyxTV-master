package com.wxrk.model.transection

import com.google.gson.annotations.SerializedName


data class Weekres(

    @SerializedName("status") var status: Int? = null,
    @SerializedName("data") var data: Data? = Data()

)
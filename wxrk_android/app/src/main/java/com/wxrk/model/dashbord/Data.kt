package com.wxrk.model.dashbord

import com.google.gson.annotations.SerializedName


data class Data(

    @SerializedName("message") var message: String? = null,
    @SerializedName("data") var data: InsideData? = InsideData()

)
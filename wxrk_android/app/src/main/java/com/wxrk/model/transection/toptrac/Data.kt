package com.wxrk.model.transection.toptrac

import com.google.gson.annotations.SerializedName


data class Data(

    @SerializedName("message") var message: String? = null,
    @SerializedName("data") var data: DataInside? = DataInside()

)
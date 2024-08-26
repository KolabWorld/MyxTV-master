package com.wxrk.model.dashbord

import com.google.gson.annotations.SerializedName


data class ResDasbord(

    @SerializedName("status") var status: Int? = null,
    @SerializedName("data") var data: Data? = Data()

)
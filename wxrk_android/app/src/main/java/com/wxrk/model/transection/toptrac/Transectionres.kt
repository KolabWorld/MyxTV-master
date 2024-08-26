package com.wxrk.model.transection.toptrac

import com.google.gson.annotations.SerializedName
import com.wxrk.model.transection.toptrac.Data


data class Transectionres(

    @SerializedName("status") var status: Int? = null,
    @SerializedName("data") var data: Data? = Data()

)
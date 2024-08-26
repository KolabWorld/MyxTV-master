package com.wxrk.model

import com.google.gson.annotations.SerializedName
import com.wxrk.model.Dashboarddata.Data


data class ResAppLogs(

    @SerializedName("status") var status: Int? = null,
    @SerializedName("data") var data: Data? = Data()

)
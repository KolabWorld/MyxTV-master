package com.wxrk.model.Dashboarddata

import com.google.gson.annotations.SerializedName

data class WatchTimeres (

    @SerializedName("status" ) var status : Int?  = null,
    @SerializedName("data"   ) var data   : DataInside? = DataInside()

)

data class Data1 (

    @SerializedName("today_watch_time"   ) var todayWatchTime   : Int?    = null,
    @SerializedName("today_wxrk_balance" ) var todayWxrkBalance : String? = null

)

data class DataInside (

    @SerializedName("message" ) var message : String? = null,
    @SerializedName("data"    ) var data    : Data1?   = Data1()

)
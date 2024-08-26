package com.wxrk.model.transection
import com.google.gson.annotations.SerializedName
import com.wxrk.model.dashbord.IosAppPerformace

data class IosWeekdataRes(
    @SerializedName("status" ) var status : Int?  = null,
    @SerializedName("data"   ) var data   : Datain? = Datain()
)

data class Datain (

    @SerializedName("message" ) var message : String? = null,
    @SerializedName("data"    ) var data    : Datainside?   = Datainside()

)

data class Datainside (

    @SerializedName("ios_app_performace" ) var iosAppPerformace : ArrayList<IosAppPerformace> = arrayListOf()

)
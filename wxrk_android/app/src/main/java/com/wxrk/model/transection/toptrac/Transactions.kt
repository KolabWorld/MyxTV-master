package com.wxrk.model.transection.toptrac

import com.google.gson.annotations.SerializedName
import com.wxrk.model.dashbord.Offers


data class Transactions(

    @SerializedName("id"             ) var id           : Int?    = null,
    @SerializedName("offer_id"       ) var offerId      : String? = null,
    @SerializedName("user_id"        ) var userId       : String? = null,
    @SerializedName("type"           ) var type         : String? = null,
    @SerializedName("wxrk_balance"   ) var wxrkBalance  : String? = null,
    @SerializedName("app_usage_time" ) var appUsageTime : String? = null,
    @SerializedName("idle_time"      ) var idleTime     : String? = null,
    @SerializedName("watch_time"     ) var watchTime    : String? = null,
    @SerializedName("status"         ) var status       : String? = null,
    @SerializedName("created_at"     ) var createdAt    : String? = null,
    @SerializedName("updated_at"     ) var updatedAt    : String? = null,
    @SerializedName("offer") var offer: Offers? = Offers()

)
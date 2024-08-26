package com.wxrk.model.dashbord

import com.google.gson.annotations.SerializedName


data class InsideData(

    @SerializedName("android_app_performace") var android_app_performace: ArrayList<AndroidAppPerformace> = arrayListOf(),
    @SerializedName("banners") var banners: ArrayList<Banners> = arrayListOf(),
    @SerializedName("events") var events: ArrayList<Events> = arrayListOf(),
    @SerializedName("offers") var offers: ArrayList<PremiumOffer> = arrayListOf(),
    @SerializedName("time_saver_apps") var timeSaverApps: ArrayList<TimeSaverApps> = arrayListOf(),
    @SerializedName("total_balance"      ) var totalBalance     : String?                     = null,
@SerializedName("day_wise_summary"   ) var dayWiseSummary   : DayWiseSummary?             = DayWiseSummary(),
@SerializedName("ios_app_performace" ) var iosAppPerformace : ArrayList<IosAppPerformace> = arrayListOf(),
@SerializedName("user"               ) var user             : User?                       = User()
)


data class TimeSaverApps(

    @SerializedName("id") var id: Int? = null,
    @SerializedName("user_id") var userId: String? = null,
    @SerializedName("log_date") var logDate: String? = null,
    @SerializedName("app_name") var appName: String? = null,
    @SerializedName("package_name") var packageName: String? = null,
    @SerializedName("start_time") var startTime: String? = null,
    @SerializedName("end_time") var endTime: String? = null,
    @SerializedName("usage_time") var usageTime: String? = null,
    @SerializedName("status") var status: String? = null,
    @SerializedName("created_at") var createdAt: String? = null,
    @SerializedName("updated_at") var updatedAt: String? = null,
    @SerializedName("time_saved_percentage") var timeSavedPercentage: String? = null,
    @SerializedName("time_saved") var timeSaved: String? = null,
    @SerializedName("today_usage_time") var todayUsageTime: String? = null

)

data class IosAppPerformace (

    @SerializedName("id"                   ) var id                : Int?    = null,
    @SerializedName("user_id"              ) var userId            : String? = null,
    @SerializedName("user_type"            ) var userType          : String? = null,
    @SerializedName("android_usage_log_id" ) var androidUsageLogId : String? = null,
    @SerializedName("app_summary_log_id"   ) var appSummaryLogId   : String? = null,
    @SerializedName("log_date"             ) var logDate           : String? = null,
    @SerializedName("wxrk_per_minute"      ) var wxrkPerMinute     : String? = null,
    @SerializedName("total_app_usage_time" ) var totalAppUsageTime : String? = null,
    @SerializedName("day_total_time"       ) var dayTotalTime      : String? = null,
    @SerializedName("day_idle_time"        ) var dayIdleTime       : String? = null,
    @SerializedName("watch_time"           ) var watchTime         : String? = null,
    @SerializedName("wxrk_earned"          ) var wxrkEarned        : String? = null,
    @SerializedName("wxrk_spent"           ) var wxrkSpent         : String? = null,
    @SerializedName("wxrk_balance"         ) var wxrkBalance       : String? = null,
    @SerializedName("time_saved_percentage") var timeSavedPercentage: String? = null,
    @SerializedName("status"               ) var status            : String? = null,
    @SerializedName("created_at"           ) var createdAt         : String? = null,
    @SerializedName("updated_at"           ) var updatedAt         : String? = null


)
package com.wxrk.model.transection

import com.google.gson.annotations.SerializedName

data class DataRes(
    @SerializedName("weeklyAverage") var weeklyAverage: String? = null,
    @SerializedName("lastWeekData") var lastWeekData: ArrayList<TodaysData> = arrayListOf(),
    @SerializedName("todaysData") var todaysData: ArrayList<TodaysData> = arrayListOf(),
    @SerializedName("dayWiseSummaryData") var dayWiseSummaryData: ArrayList<DayWiseSummaryData> = arrayListOf()

)


data class DayWiseSummaryData(

    @SerializedName("id") var id: Int? = null,
    @SerializedName("user_id") var userId: String? = null,
    @SerializedName("user_type") var userType: String? = null,
    @SerializedName("android_usage_log_id") var androidUsageLogId: String? = null,
    @SerializedName("app_summary_log_id") var appSummaryLogId: String? = null,
    @SerializedName("log_date") var logDate: String? = null,
    @SerializedName("wxrk_per_minute") var wxrkPerMinute: String? = null,
    @SerializedName("total_app_usage_time") var totalAppUsageTime: String? = null,
    @SerializedName("day_total_time") var dayTotalTime: String? = null,
    @SerializedName("day_idle_time") var dayIdleTime: String? = null,
    @SerializedName("wxrk_earned") var wxrkEarned: String? = null,
    @SerializedName("wxrk_spent") var wxrkSpent: String? = null,
    @SerializedName("wxrk_balance") var wxrkBalance: String? = null,
    @SerializedName("status") var status: String? = null,
    @SerializedName("created_at") var createdAt: String? = null,
    @SerializedName("updated_at") var updatedAt: String? = null

)
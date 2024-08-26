package com.wxrk.model.Dashboarddata

import com.google.gson.annotations.SerializedName


data class DailyWiseSummaryData(

    @SerializedName("id") var id: Int? = null,
    @SerializedName("user_id") var userId: String? = null,
    @SerializedName("user_type") var userType: String? = null,
    @SerializedName("android_usage_log_id") var androidUsageLogId: String? = null,
    @SerializedName("app_summary_log_id") var appSummaryLogId: String? = null,
    @SerializedName("log_date") var logDate: String? = null,
    @SerializedName("wxrk_per_minute") var wxrkPerMinute: String? = null,
    @SerializedName("total_app_usage_time") var totalAppUsageTime: Double? = null,
    @SerializedName("day_total_time") var dayTotalTime: Int? = null,
    @SerializedName("day_idle_time") var dayIdleTime: Double? = null,
    @SerializedName("wxrk_earned") var wxrkEarned: Double? = null,
    @SerializedName("wxrk_spent") var wxrkSpent: Int? = null,
    @SerializedName("wxrk_balance") var wxrkBalance: Double? = null,
    @SerializedName("status") var status: String? = null,
    @SerializedName("created_at") var createdAt: String? = null,
    @SerializedName("updated_at") var updatedAt: String? = null

)
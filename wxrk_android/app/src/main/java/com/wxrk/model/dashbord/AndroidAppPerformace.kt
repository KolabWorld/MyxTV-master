package com.wxrk.model.dashbord

import com.google.gson.annotations.SerializedName


data class AndroidAppPerformace(

    @SerializedName("total_usage_time") var totalUsageTime: String? = null,
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
    @SerializedName("updated_at") var updatedAt: String? = null

)
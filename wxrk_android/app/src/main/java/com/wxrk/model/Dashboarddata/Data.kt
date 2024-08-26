package com.wxrk.model.Dashboarddata

import com.google.gson.annotations.SerializedName
import com.wxrk.model.Dashboarddata.DailyWiseSummaryData


data class Data(

    @SerializedName("message") var message: String? = null,
    @SerializedName("total_idle_time") var totalIdleTime: Double? = null,
    @SerializedName("daily_wise_summary_data") var dailyWiseSummaryData: DailyWiseSummaryData? = DailyWiseSummaryData()

)


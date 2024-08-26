package com.wxrk.model.body

data class AppLogs(
    var user_id: Int,
    var app_name: String,
    var package_name: String,
    var usage_time: Long
) {
}
package com.wxrk.model.login.otp

data class VerifyOtpBody(
    val otp: String,
    val user_id: Int
)
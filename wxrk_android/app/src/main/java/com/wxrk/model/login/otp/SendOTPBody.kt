package com.wxrk.model.login.otp

data class SendOTPBody(
    val mobile: String,
    val dial_code: String,
    val user_id: Int,
    val email: String
)
package com.wxrk.model.login

data class LoginBody(
    val app_version: String,
    val client_id: String,
    val client_secret: String,
    val device_address: String,
    val device_name: String,
    val firebase_id: String,
    val grant_type: String,
    val latitude: String,
    val longitude: String,
    val os_version: String,
    val password: String,
    val scope: String,
    val username: String
)
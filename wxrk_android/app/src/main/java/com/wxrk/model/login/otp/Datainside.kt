package com.wxrk.model.login.otp

import com.google.gson.annotations.SerializedName


data class Datainside(

    @SerializedName("user") var user: User? = User()

)
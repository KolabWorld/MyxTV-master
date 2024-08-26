package com.wxrk.model.Error

import com.google.gson.annotations.SerializedName


data class ErrorRes(

    @SerializedName("status") var status: Int? = null,
    @SerializedName("data") var data: String? = null,
    @SerializedName("errors") var errors: Errors? = Errors()

)
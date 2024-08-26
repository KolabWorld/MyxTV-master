package com.wxrk.model.Error


import com.google.gson.annotations.SerializedName


data class Errors(

    @SerializedName("message") var message: String? = null

)
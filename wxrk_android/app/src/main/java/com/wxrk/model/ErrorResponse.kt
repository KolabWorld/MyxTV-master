package com.wxrk.model

import com.google.gson.annotations.SerializedName


data class ErrorResponse (

    @SerializedName("status" ) var status : Int?    = null,
    @SerializedName("data"   ) var data   : String? = null,
    @SerializedName("errors" ) var errors : Errors? = Errors()

)

data class Errors (

    @SerializedName("message" ) var message : String? = null

)
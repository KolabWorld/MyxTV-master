package com.wxrk.model.offers

import com.google.gson.annotations.SerializedName


data class OfferListRes(

    @SerializedName("status") var status: Int? = null,
    @SerializedName("data") var data: Data? = Data()

)
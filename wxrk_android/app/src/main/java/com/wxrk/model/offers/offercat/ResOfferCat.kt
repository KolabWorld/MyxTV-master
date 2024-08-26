package com.wxrk.model.offers.offercat

import com.google.gson.annotations.SerializedName


data class ResOfferCat(

    @SerializedName("status") var status: Int? = null,
    @SerializedName("data") var data: Data? = Data()

)
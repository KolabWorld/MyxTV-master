package com.wxrk.model.dashbord

import com.google.gson.annotations.SerializedName

data class PremiumOffer(
    val created_at: String? = null,
    val id: Int? = null,
    val name: String? = null,
    val status: String? = null,
    val updated_at: String? = null,
    @SerializedName("offers") var offers: ArrayList<Offers> = arrayListOf(),

    )
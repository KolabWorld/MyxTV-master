package com.wxrk.model.offers.offercat

import com.google.gson.annotations.SerializedName


data class DataUnder(

    @SerializedName("offer_categories") var offer_categories: ArrayList<OfferCategories> = arrayListOf()

)
package com.wxrk.model.offers

import com.google.gson.annotations.SerializedName
import com.wxrk.model.dashbord.Offers


data class DataInside(

    @SerializedName("offers") var data: ArrayList<Offers>? = ArrayList()

)
package com.wxrk.model.transection.toptrac

import com.google.gson.annotations.SerializedName

data class DataInside(

    @SerializedName("transactions") var transactions: ArrayList<Transactions> = arrayListOf()

)
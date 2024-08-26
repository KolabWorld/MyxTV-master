package com.wxrk.model.offers

import com.google.gson.annotations.SerializedName


data class Banner(

    @SerializedName("id") var id: Int? = null,
    @SerializedName("model_type") var modelType: String? = null,
    @SerializedName("model_id") var modelId: String? = null,
    @SerializedName("collection_name") var collectionName: String? = null,
    @SerializedName("name") var name: String? = null,
    @SerializedName("file_name") var fileName: String? = null,
    @SerializedName("mime_type") var mimeType: String? = null,
    @SerializedName("disk") var disk: String? = null,
    @SerializedName("size") var size: String? = null,
    @SerializedName("manipulations") var manipulations: ArrayList<String> = arrayListOf(),
    @SerializedName("custom_properties") var customProperties: ArrayList<String> = arrayListOf(),
    @SerializedName("responsive_images") var responsiveImages: ArrayList<String> = arrayListOf(),
    @SerializedName("order_column") var orderColumn: String? = null,
    @SerializedName("created_at") var createdAt: String? = null,
    @SerializedName("updated_at") var updatedAt: String? = null,
    @SerializedName("full_url") var fullUrl: String? = null

)
package com.wxrk.model.dashbord

import android.os.Parcel
import android.os.Parcelable
import com.google.gson.annotations.SerializedName


data class Banners(

    @SerializedName("id") var id: Int? = null,
    @SerializedName("type") var type: String? = null,
    @SerializedName("name") var name: String? = null,
    @SerializedName("button_text") var buttonText: String? = null,
    @SerializedName("button_link") var buttonLink: String? = null,
    @SerializedName("attachment_type") var attachmentType: String? = null,
    @SerializedName("is_auto_play") var isAutoPlay: String? = null,
    @SerializedName("status") var status: String? = null,
    @SerializedName("updated_by") var updatedBy: String? = null,
    @SerializedName("created_at") var createdAt: String? = null,
    @SerializedName("updated_at") var updatedAt: String? = null,
    @SerializedName("image") var image: String? = null

) : Parcelable {
    constructor(parcel: Parcel) : this(
        parcel.readValue(Int::class.java.classLoader) as? Int,
        parcel.readString(),
        parcel.readString(),
        parcel.readString(),
        parcel.readString(),
        parcel.readString(),
        parcel.readString(),
        parcel.readString(),
        parcel.readString(),
        parcel.readString(),
        parcel.readString(),
        parcel.readString()
    ) {
    }

    override fun writeToParcel(parcel: Parcel, flags: Int) {
        parcel.writeValue(id)
        parcel.writeString(type)
        parcel.writeString(name)
        parcel.writeString(buttonText)
        parcel.writeString(buttonLink)
        parcel.writeString(attachmentType)
        parcel.writeString(isAutoPlay)
        parcel.writeString(status)
        parcel.writeString(updatedBy)
        parcel.writeString(createdAt)
        parcel.writeString(updatedAt)
        parcel.writeString(image)
    }

    override fun describeContents(): Int {
        return 0
    }

    companion object CREATOR : Parcelable.Creator<Banners> {
        override fun createFromParcel(parcel: Parcel): Banners {
            return Banners(parcel)
        }

        override fun newArray(size: Int): Array<Banners?> {
            return arrayOfNulls(size)
        }
    }
}
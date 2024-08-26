package com.wxrk.model.dashbord

import com.google.gson.annotations.SerializedName
import com.wxrk.ui.adapters.SponserAds_Adapter
import java.io.Serializable


data class Events(

    @SerializedName("id") var id: Int? = null,
    @SerializedName("event_type_id") var eventTypeId: String? = null,
    @SerializedName("name") var name: String? = null,
    @SerializedName("description") var description: String? = null,
    @SerializedName("organizer") var organizer: String? = null,
    @SerializedName("how_to_join") var howToJoin: String? = null,
    @SerializedName("country_id") var countryId: String? = null,
    @SerializedName("start_date_time") var startDateTime: String? = null,
    @SerializedName("end_date_time") var endDateTime: String? = null,
    @SerializedName("status") var status: String? = null,
    @SerializedName("updated_by") var updatedBy: String? = null,
    @SerializedName("created_at") var createdAt: String? = null,
    @SerializedName("updated_at") var updatedAt: String? = null,
    @SerializedName("thumbnail_image") var thumbnailImage: String? = null,
    @SerializedName("venue") var venue: String? = null,
    @SerializedName("total_members") var total_members: Int? = 0,
     @SerializedName("already_joined") var already_joined: Int? = 0,
    @SerializedName("company_name") var company_name: String? = null,
    @SerializedName("about_the_company") var about_the_company: String? = null,
    @SerializedName("company_logo") var company_logo: String? = null,
    @SerializedName("remaining_time") var remaining_time: String? = null,
    @SerializedName("highlights") var highlights: String? = null,
    @SerializedName("banner") var banner: ArrayList<Banner> = arrayListOf(),
    @SerializedName("sponser") var sponser: ArrayList<Sponser> = arrayListOf(),
    @SerializedName("event_type") var eventType: EventType? = EventType(),
    @SerializedName("country") var country: Country? = Country()

) : Serializable


data class Sponser(

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
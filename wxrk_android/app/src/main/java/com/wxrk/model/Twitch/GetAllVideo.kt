package com.wxrk.model.Twitch

import com.google.gson.annotations.SerializedName
import java.io.Serializable

data class GetAllVideo(
    @SerializedName("status") var status: Int? = null,
    @SerializedName("data") var data: Data1? = Data1()
)

data class Data1(

    @SerializedName("message") var message: String? = null,
    @SerializedName("data") var data: Data? = Data()

)

data class Data(

    @SerializedName("twitch-videos") var twitch_videos: ArrayList<TwitchData> = arrayListOf(),

    )

data class TwitchData(

    @SerializedName("id") var id: Int? = null,
    @SerializedName("twitch_id") var twitchId: String? = null,
    @SerializedName("stream_id") var streamId: String? = null,
    @SerializedName("user_id") var userId: String? = null,
    @SerializedName("user_login") var userLogin: String? = null,
    @SerializedName("user_name") var userName: String? = null,
    @SerializedName("title") var title: String? = null,
    @SerializedName("description") var description: String? = null,
    @SerializedName("url") var url: String? = null,
    @SerializedName("thumbnail_url") var thumbnailUrl: String? = null,
    @SerializedName("viewable") var viewable: String? = null,
    @SerializedName("view_count") var viewCount: String? = null,
    @SerializedName("language") var language: String? = null,
    @SerializedName("type") var type: String? = null,
    @SerializedName("duration") var duration: String? = null,
    @SerializedName("muted_segments") var mutedSegments: String? = null,
    @SerializedName("video_created_at") var videoCreatedAt: String? = null,
    @SerializedName("video_published_at") var videoPublishedAt: String? = null,
    @SerializedName("status") var status: String? = null,
    @SerializedName("created_at") var createdAt: String? = null,
    @SerializedName("updated_at") var updatedAt: String? = null

) : Serializable


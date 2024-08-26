package com.contactandroidapp.Network

import com.google.gson.JsonArray
import com.wxrk.model.Dashboarddata.WatchTimeres
import com.wxrk.model.ResAppLogs
import com.wxrk.model.Twitch.GetAllVideo
import com.wxrk.model.body.AppLogs
import com.wxrk.model.dashbord.ResDasbord
import com.wxrk.model.event.JoinEventBody
import com.wxrk.model.event.JoinEventRes
import com.wxrk.model.login.LoginBody
import com.wxrk.model.login.LoginRes
import com.wxrk.model.login.otp.MobileOtpRes
import com.wxrk.model.login.otp.SendOTPBody
import com.wxrk.model.login.otp.VerifyOtpBody
import com.wxrk.model.offers.OfferListRes
import com.wxrk.model.offers.PromoCodeData
import com.wxrk.model.offers.offercat.JoinOfferBody
import com.wxrk.model.offers.offercat.Offeridbody
import com.wxrk.model.offers.offercat.ResOfferCat
import com.wxrk.model.transection.BodyTransection
import com.wxrk.model.transection.IosWeekdataRes
import com.wxrk.model.transection.Weekres
import com.wxrk.model.transection.toptrac.Transectionres
import okhttp3.MultipartBody
import okhttp3.RequestBody
import org.json.JSONArray
import retrofit2.Response
import retrofit2.http.*

interface ApiService {

    @POST("api/v1/login")
    @JvmSuppressWildcards
    suspend fun login(@Body body: LoginBody): Response<LoginRes>

    @POST("api/v1/send-otp")
    @JvmSuppressWildcards
    suspend fun send_otp(@Body body: SendOTPBody): Response<MobileOtpRes>

    @POST("api/v1/verify-otp")
    @JvmSuppressWildcards
    suspend fun verify_otp(@Body body: VerifyOtpBody): Response<MobileOtpRes>

    @Multipart
    @POST("http://seoforworld.com/api/v1/file-upload.php?image")
    suspend fun profile(
        @Part("user_id") user_id: RequestBody,
        @Part("name") name: RequestBody,
        @Part("date_of_birth") date_of_birth: RequestBody,
        @Part image: MultipartBody.Part
    ): Response<MobileOtpRes>


    @FormUrlEncoded
    @POST("api/v1/profile")
    @JvmSuppressWildcards
    suspend fun profile_login(
        @Field("user_id") user_id: Int,
        @Field("name") name: String
    ): Response<MobileOtpRes>


//    @POST("api/v1/android/app-logs")
//    @JvmSuppressWildcards
//    suspend fun send_applogs(@Body body: List<AppLogs>): Response<ResAppLogs>

    @GET("api/v1/dashboard")
    suspend fun getDashboard(): Response<ResDasbord>

    @GET("api/v1/watch-time")
    suspend fun getWatchtime(): Response<WatchTimeres>

    @GET("api/v1/offer-categories")
    suspend fun getOfferCat(): Response<ResOfferCat>

    @GET("api/v1/offers")
    suspend fun getOfferList(@Query("offer_category_ids[]") offer_category_ids: List<Int>): Response<OfferListRes>

    @POST("api/v1/buy-offer")
    suspend fun setJoinOffer(@Body body: JoinOfferBody): Response<PromoCodeData>

    @POST("api/v1/join-event")
    suspend fun getJoinEvent(@Body body: JoinEventBody): Response<JoinEventRes>

    @GET("api/v1/events")
    suspend fun getEventList(): Response<ResDasbord>


    @GET("api/v1/top-transactions")
    suspend fun getTopTransection(): Response<Transectionres>

    //   @HTTP(method = "GET", path = "api/v1/transactions", hasBody = true)
    @GET("api/v1/transactions")
    suspend fun getAllTransections(
        @Query("from_date") from_date: String,
        @Query("to_date") to_date: String
    ): Response<Transectionres>

    @GET("api/v1/android-app-performance")
    suspend fun getWeekData(): Response<Weekres>

    @GET("api/v1/ios-app-performance")
    suspend fun getWeekDataIosAppPerformance(): Response<IosWeekdataRes>

    @GET("api/v1/twitch-videos")
    suspend fun get_twitchvideos(): Response<GetAllVideo>


}
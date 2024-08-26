package com.wxrk.model.offers

import android.os.Parcel
import android.os.Parcelable
import com.google.gson.annotations.SerializedName


data class PromoCodeData(
    @SerializedName("status") var status: Int? = null,
    @SerializedName("data") var data: PromoCodeRes? = PromoCodeRes(),
)


data class PromoCodeRes(
    @SerializedName("message") var message: String? = null,
    @SerializedName("promo_code") var promo_code: PromoCode? = PromoCode(),
    @SerializedName("offer") var offer: Offers? = Offers(),
    @SerializedName("order") var order: Order? = Order()
) : Parcelable {
    constructor(parcel: Parcel) : this(
        parcel.readString(),
        TODO("promo_code"),
        TODO("offer")
    ) {
    }

    override fun writeToParcel(parcel: Parcel, flags: Int) {
        parcel.writeString(message)
    }

    override fun describeContents(): Int {
        return 0
    }

    companion object CREATOR : Parcelable.Creator<PromoCodeRes> {
        override fun createFromParcel(parcel: Parcel): PromoCodeRes {
            return PromoCodeRes(parcel)
        }

        override fun newArray(size: Int): Array<PromoCodeRes?> {
            return arrayOfNulls(size)
        }
    }
}


data class PromoCode(

    @SerializedName("id") var id: Int? = null,
    @SerializedName("offer_id") var offerId: String? = null,
    @SerializedName("promo_code") var promoCode: String? = null,
    @SerializedName("redemption_status") var redemptionStatus: String? = null,
    @SerializedName("redemption_date") var redemptionDate: String? = null,
    @SerializedName("status") var status: String? = null,
    @SerializedName("updated_by") var updatedBy: String? = null

)


data class Order(

    @SerializedName("order_number") var orderNumber: String? = null,
    @SerializedName("offer_id") var offerId: Int? = null,
    @SerializedName("offer_name") var offerName: String? = null,
    @SerializedName("offer_price") var offerPrice: String? = null,
    @SerializedName("offer_price_in_wxrk") var offerPriceInWxrk: String? = null,
    @SerializedName("offer_promo_code") var offerPromoCode: String? = null,
    @SerializedName("promo_code_redemption_status") var promoCodeRedemptionStatus: String? = null,
    @SerializedName("promo_code_redemption_date") var promoCodeRedemptionDate: String? = null,
    @SerializedName("offer_type") var offerType: String? = null,
    @SerializedName("offer_category") var offerCategory: String? = null,
    @SerializedName("offer_premium_category") var offerPremiumCategory: String? = null,
    @SerializedName("time_to_redeem") var timeToRedeem: String? = null,
    @SerializedName("highlight_of_offer") var highlightOfOffer: String? = null,
    @SerializedName("details_of_offer") var detailsOfOffer: String? = null,
    @SerializedName("link") var link: String? = null,
    @SerializedName("user_id") var userId: Int? = null,
    @SerializedName("customer_name") var customerName: String? = null,
    @SerializedName("customer_mobile") var customerMobile: String? = null,
    @SerializedName("customer_email") var customerEmail: String? = null,
    @SerializedName("customer_country") var customerCountry: String? = null,
    @SerializedName("admin_id") var adminId: String? = null,
    @SerializedName("vendor_name") var vendorName: String? = null,
    @SerializedName("vendor_mobile") var vendorMobile: String? = null,
    @SerializedName("vendor_email") var vendorEmail: String? = null,
    @SerializedName("vendor_country") var vendorCountry: String? = null,
    @SerializedName("vendor_category") var vendorCategory: String? = null,
    @SerializedName("vendor_state") var vendorState: String? = null,
    @SerializedName("vendor_city") var vendorCity: String? = null,
    @SerializedName("vendor_address") var vendorAddress: String? = null,
    @SerializedName("vendor_postal_code") var vendorPostalCode: String? = null,
    @SerializedName("status") var status: String? = null,
    @SerializedName("updated_at") var updatedAt: String? = null,
    @SerializedName("created_at") var createdAt: String? = null,
    @SerializedName("id") var id: Int? = null,
    @SerializedName("remaining_hours") var remainingHours: String? = null,
    @SerializedName("end_time") var endTime: String? = null

)


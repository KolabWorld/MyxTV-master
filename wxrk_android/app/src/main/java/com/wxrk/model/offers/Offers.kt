package com.wxrk.model.offers

import com.google.gson.annotations.SerializedName


data class Offers(

    @SerializedName("id") var id: Int? = null,
    @SerializedName("price_view_id") var priceViewId: String? = null,
    @SerializedName("country_id") var countryId: String? = null,
    @SerializedName("offer_type_id") var offerTypeId: String? = null,
    @SerializedName("offer_category_id") var offerCategoryId: String? = null,
    @SerializedName("premium_category_id") var premiumCategoryId: String? = null,
    @SerializedName("offer_name") var offerName: String? = null,
    @SerializedName("offer_price") var offerPrice: String? = null,
    @SerializedName("offer_price_in_wxrk") var offerPriceInWxrk: String? = null,
    @SerializedName("offer_period") var offerPeriod: String? = null,
    @SerializedName("offer_listing_price") var offerListingPrice: String? = null,
    @SerializedName("offer_listing_value") var offerListingValue: String? = null,
    @SerializedName("premium_listing_period") var premiumListingPeriod: String? = null,
    @SerializedName("premium_listing_price") var premiumListingPrice: String? = null,
    @SerializedName("premium_listing_value") var premiumListingValue: String? = null,
    @SerializedName("total_value") var totalValue: String? = null,
    @SerializedName("start_date") var startDate: String? = null,
    @SerializedName("stock") var stock: String? = null,
    @SerializedName("low_stock") var lowStock: String? = null,
    @SerializedName("you_get") var youGet: String? = null,
    @SerializedName("time_to_redeem") var timeToRedeem: String? = null,
    @SerializedName("quantity_per_user") var quantityPerUser: String? = null,
    @SerializedName("shipping_cost") var shippingCost: String? = null,
    @SerializedName("highlight_of_offer") var highlightOfOffer: String? = null,
    @SerializedName("details_of_offer") var detailsOfOffer: String? = null,
    @SerializedName("company_name") var companyName: String? = null,
    @SerializedName("about_the_company") var aboutTheCompany: String? = null,
    @SerializedName("link") var link: String? = null,
    @SerializedName("offer_code_bg_color") var offerCodeBgColor: String? = null,
    @SerializedName("offer_code_text_color") var offerCodeTextColor: String? = null,
    @SerializedName("status") var status: String? = null,
    @SerializedName("updated_by") var updatedBy: String? = null,
    @SerializedName("created_at") var createdAt: String? = null,
    @SerializedName("updated_at") var updatedAt: String? = null,
    @SerializedName("company_logo") var companyLogo: String? = null,
    @SerializedName("thumbnail_image") var thumbnailImage: String? = null,
    @SerializedName("banner") var banner: ArrayList<Banner> = arrayListOf(),
    @SerializedName("offer_type") var offerType: OfferType? = OfferType(),
    @SerializedName("offer_category") var offerCategory: OfferCategory? = OfferCategory(),
    @SerializedName("premium_category") var premiumCategory: PremiumCategory? = PremiumCategory()

)
package com.wxrk.model.login.otp

import com.google.gson.annotations.SerializedName


data class User(

    @SerializedName("id") var id: Int? = null,
    @SerializedName("name") var name: String? = null,
    @SerializedName("user_name") var userName: String? = null,
    @SerializedName("has_password") var hasPassword: String? = null,
    @SerializedName("email") var email: String? = null,
    @SerializedName("is_email_verified") var isEmailVerified: String? = null,
    @SerializedName("mobile") var mobile: String? = null,
    @SerializedName("is_mobile_verified") var isMobileVerified: String? = null,
    @SerializedName("two_step_verification") var twoStepVerification: String? = null,
    @SerializedName("date_of_birth") var dateOfBirth: String? = null,
    @SerializedName("gender") var gender: String? = null,
    @SerializedName("marital_status") var maritalStatus: String? = null,
    @SerializedName("timezone") var timezone: String? = null,
    @SerializedName("is_new_user") var isNewUser: String? = null,
    @SerializedName("status") var status: String? = null,
    @SerializedName("updated_by") var updatedBy: String? = null,
    @SerializedName("created_at") var createdAt: String? = null,
    @SerializedName("updated_at") var updatedAt: String? = null,
    @SerializedName("profile_pic") var profile_pic: String? = null

)
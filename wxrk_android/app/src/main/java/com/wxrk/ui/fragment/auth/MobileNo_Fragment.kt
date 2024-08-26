package com.wxrk.ui.fragment.auth

import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import androidx.lifecycle.Lifecycle
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import com.ancient.country.view.fragment.CountryListBottomSheet
import com.contactandroidapp.Network.RetrofitBuilder
import com.wxrk.R
import com.wxrk.databinding.ActivityPhonenoAuthBinding
import com.wxrk.utils.Common
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.LoginViewModel

class MobileNo_Fragment : Fragment(R.layout.activity_phoneno_auth) {

    lateinit var bindeview: ActivityPhonenoAuthBinding
    private lateinit var viewModel: LoginViewModel

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
//        if (!this::bindeview.isInitialized) {
        bindeview = ActivityPhonenoAuthBinding.inflate(inflater, container, false)
        initview()
        initViewModel()
        observer()
//        }

        return bindeview.root
    }


    private fun initview() {
        bindeview.lifecycleOwner = this

        bindeview.rlSendcode.setOnClickListener {
            Prefs.getInstance(requireActivity()).countrycode =
                bindeview.tvCountrycode.text.toString()
            if (Common.validMail(bindeview.etEmail.text.toString())) {
                viewModel.send_otp(
                    bindeview.tvCountrycode.text.toString(),
                    bindeview.etMobileno.text.toString(),
                    bindeview.etEmail.text.toString()
                )

            }
        }
        bindeview.tvPrivacypolicy.setOnClickListener {
            startActivity(
                Intent(
                    Intent.ACTION_VIEW,
                    Uri.parse(RetrofitBuilder.BASE_URL + "privacy-policy")
                )
            )
        }

        bindeview.tvCountrycode.setOnClickListener {

            val ft = parentFragmentManager.beginTransaction()
            val countryListBottomSheet = CountryListBottomSheet()
            countryListBottomSheet.countrySelection = {
                bindeview.tvCountrycode.setText(it.dialCode)
                countryListBottomSheet.dismiss()
            }
            countryListBottomSheet.show(ft, "bottom_sheet_dialog")
        }
    }


    private fun initViewModel() {
        viewModel = ViewModelProvider(this).get(LoginViewModel::class.java)
    }

    private fun observer() {
        viewModel.itemotp.observe(viewLifecycleOwner, Observer {
            if (viewLifecycleOwner.lifecycle.currentState == Lifecycle.State.RESUMED) {

                if (it != null) {
                    if (it.status == 200) {
                        Prefs.getInstance(requireActivity()).mobile = it.data?.data?.user?.mobile

                        Common.logUnlimited("innnn", "innnn222")

                        parentFragment?.findNavController()
                            ?.navigate(R.id.mobileno_to_otpverification)

                    }
                } else {
                    Common.tooast(requireActivity(), "Somthing went wrong")

                }
            }
        })

        viewModel.loader.observe(viewLifecycleOwner, Observer {

            if (it) {
                bindeview.rlSendcode.visibility = View.GONE
                bindeview.progress.visibility = View.VISIBLE
            } else {
                bindeview.progress.visibility = View.GONE
                bindeview.rlSendcode.visibility = View.VISIBLE

            }

        }
        )


    }
}
package com.wxrk.ui.fragment.auth

import android.os.Bundle
import android.os.CountDownTimer
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.Navigation
import androidx.navigation.fragment.findNavController
import com.wxrk.BaseFragment
import com.wxrk.R
import com.wxrk.databinding.FragmentPhonenoVerificationBinding
import com.wxrk.utils.Common
import com.wxrk.utils.Common.Companion.logUnlimited
import com.wxrk.utils.Common.Companion.tooast
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.LoginViewModel

class MobileVerification_Fragment : BaseFragment(R.layout.fragment_phoneno_verification) {

    private lateinit var viewModel: LoginViewModel
    lateinit var bindeview: FragmentPhonenoVerificationBinding

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        bindeview = FragmentPhonenoVerificationBinding.inflate(inflater, container, false)
        initview()
        initViewModel()
        observer()
        logUnlimited("innnn", "innnn111")
        return bindeview.root
    }


    private fun initview() {
        bindeview.tvMobileno.setText(
            "${Prefs.getInstance(requireActivity()).countrycode} " + Prefs.getInstance(
                requireActivity()
            ).mobile
        )
        bindeview.rlVerify.setOnClickListener {

            viewModel.verify_otp(bindeview.etInclude.otp.toString())

        }
        resendcountdown()


        bindeview.tvPhonenoui.setOnClickListener {
//            findNavController().popBackStack(R.id.phoneno_fragment,false)
            requireActivity().onBackPressed()
//            Navigation.findNavController(bindeview.root).popBackStack() // You need this line.
//            tooast(requireActivity(),"Innnn")
        }




        bindeview.tvResend.setOnClickListener {
//            viewModel.send_otp(Prefs.getInstance(requireActivity()).countrycode,Prefs.getInstance(requireActivity()).mobile)
            bindeview.tvSendanothertext.show()
            resendcountdown()
        }
    }

    private fun initViewModel() {
        viewModel = ViewModelProvider(this).get(LoginViewModel::class.java)
    }

    private fun observer() {
        viewModel.itemotp.observe(requireActivity(), Observer {
            if (it != null) {
                if (it.status == 200) {

                    parentFragment?.findNavController()?.navigate(R.id.otpverification_to_name)

                }
            } else {
                Common.tooast(requireActivity(), "Wrong Otp")

            }

        })

        viewModel.loader.observe(requireActivity(), Observer {

            if (it) {
                bindeview.rlVerify.visibility = View.GONE
                bindeview.progress.visibility = View.VISIBLE
            } else {
                bindeview.progress.visibility = View.GONE
                bindeview.rlVerify.visibility = View.VISIBLE

            }

        }
        )
    }

    fun resendcountdown() {
        // time count down for 30 seconds,
        // with 1 second as countDown interval
        object : CountDownTimer(30000, 1000) {

            // Callback function, fired on regular interval
            override fun onTick(millisUntilFinished: Long) {
                bindeview.tvResend.setText("" + millisUntilFinished / 1000)
            }

            // Callback function, fired
            // when the time is up
            override fun onFinish() {
                bindeview.tvResend.setText("Resend")
                bindeview.tvSendanothertext.hide()
            }
        }.start()
    }
}
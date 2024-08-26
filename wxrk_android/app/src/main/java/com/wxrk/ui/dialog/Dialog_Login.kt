package com.wxrk.ui.dialog

import android.content.Intent
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import com.wxrk.MainActivity
import com.wxrk.R
import com.wxrk.databinding.BotomsheetLoginBinding
import com.wxrk.ui.dialog.roundbottomsheet.RoundedBottomSheetDialogFragment
import com.wxrk.utils.Common.Companion.logUnlimited
import com.wxrk.utils.Common.Companion.tooast
import com.wxrk.utils.Common.Companion.validMail
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.LoginViewModel

class Dialog_Login(var onnextstep: onNextStep) : RoundedBottomSheetDialogFragment() {

    private lateinit var viewModel: LoginViewModel

    lateinit var botomsheetLoginBinding: BotomsheetLoginBinding
    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {

        botomsheetLoginBinding = BotomsheetLoginBinding.inflate(inflater, container, false)
        initViewModel()
        initview()
        observer()
        return botomsheetLoginBinding.root
    }

    fun initview() {

        botomsheetLoginBinding.btConfirm.setOnClickListener {

            if (validMail(botomsheetLoginBinding.etEmail.text.toString())) {
                viewModel.Login(
                    botomsheetLoginBinding.etPass.text.toString(),
                    botomsheetLoginBinding.etEmail.text.toString()
                )
            } else {
                tooast(requireActivity(), "Please enter valid email")
            }


        }
    }

    private fun initViewModel() {
        botomsheetLoginBinding.lifecycleOwner = this
        viewModel = ViewModelProvider(requireActivity()).get(LoginViewModel::class.java)
    }

    private fun observer() {

        viewModel.itemlogin.observe(this, Observer {

            if (it != null) {
                if (it.data?.data?.isNewUser.equals("0")) {
                    requireActivity().finish()
                    Prefs.getInstance(requireActivity()).token = it.data?.accessToken
                    Prefs.getInstance(requireActivity()).userid = it.data?.data?.id
                    Prefs.getInstance(requireActivity()).mobile = it.data?.data?.mobile
                    Prefs.getInstance(requireActivity()).email = it.data?.data?.email
                    Prefs.getInstance(requireActivity()).dob = it.data?.data?.dateOfBirth
                    Prefs.getInstance(requireActivity()).userFirstName = it.data?.data?.name
                    Prefs.getInstance(requireActivity()).profileImage =
                        it.data?.data?.profileImageUrl
                    Prefs.getInstance(requireActivity()).isLogin = true
                    Prefs.getInstance(requireActivity()).lastSyncTime =
                        System.currentTimeMillis() * 1000
                    startActivity(Intent(requireActivity(), MainActivity::class.java))
                } else {
                    dismiss()
                    Prefs.getInstance(requireActivity()).dob = it.data?.data?.dateOfBirth
                    Prefs.getInstance(requireActivity()).mobile = it.data?.data?.mobile
                    Prefs.getInstance(requireActivity()).email = it.data?.data?.email
                    Prefs.getInstance(requireActivity()).userFirstName = it.data?.data?.name
                    Prefs.getInstance(requireActivity()).profileImage =
                        it.data?.data?.profileImageUrl
                    Prefs.getInstance(requireActivity()).userid = it.data?.data?.id
                    Prefs.getInstance(requireActivity()).token = it.data?.accessToken
                    onnextstep.onnextstepclick()
                }
            } else {
                tooast(requireActivity(), "Please enter valid credentials")
            }

        })
    }

    interface onNextStep {
        fun onnextstepclick()
    }

}

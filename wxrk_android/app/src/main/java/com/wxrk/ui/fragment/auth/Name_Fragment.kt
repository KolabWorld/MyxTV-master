package com.wxrk.ui.fragment.auth

import android.content.Intent
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import com.wxrk.R
import com.wxrk.databinding.ActivityNameBinding
import com.wxrk.ui.Intro_Activity
import com.wxrk.utils.Common
import com.wxrk.utils.Common.Companion.tooast
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.LoginViewModel

class Name_Fragment : Fragment(R.layout.activity_name) {
    lateinit var bindeview: ActivityNameBinding
    private lateinit var viewModel: LoginViewModel

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        bindeview = ActivityNameBinding.inflate(inflater, container, false)
        initview()
        initViewModel()
        observer()
        return bindeview.root
    }

    private fun initViewModel() {
        viewModel = ViewModelProvider(this).get(LoginViewModel::class.java)
    }

    private fun initview() {
        bindeview.rlNextstep.setOnClickListener {

            if (bindeview.etName.text.trim().toString().length > 0) {
                Prefs.getInstance(requireActivity()).userFirstName =
                    bindeview.etName.text.trim().toString()
                viewModel.updateprofile()
            } else {
                tooast(requireActivity(), "Please enter name")
            }
        }
    }

    private fun observer() {
        viewModel.itemotp.observe(requireActivity(), Observer {
            if (it != null) {
                if (it.status == 200) {
                    Prefs.getInstance(requireActivity()).dob = it.data?.data?.user?.dateOfBirth
                    Prefs.getInstance(requireActivity()).isLogin = true
                    Prefs.getInstance(requireActivity()).lastSyncTime =
                        System.currentTimeMillis() * 1000
                    startActivity(Intent(requireActivity(), Intro_Activity::class.java))
                    requireActivity().finish()
                }
            } else {
                Common.tooast(requireActivity(), "Somthing went wrong! Please Try Again")
            }
        })

        viewModel.loader.observe(requireActivity(), Observer {
            if (it) {
                bindeview.rlNextstep.visibility = View.GONE
                bindeview.progress.visibility = View.VISIBLE
            } else {
                bindeview.progress.visibility = View.GONE
                bindeview.rlNextstep.visibility = View.VISIBLE
            }
        }
        )
    }
}
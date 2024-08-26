package com.wxrk.ui.fragment.auth

import android.app.DatePickerDialog
import android.content.Intent
import android.os.Bundle
import android.view.LayoutInflater
import android.view.MotionEvent
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import com.wxrk.R
import com.wxrk.databinding.FragmentDobBinding
import com.wxrk.ui.Intro_Activity
import com.wxrk.ui.dialog.DatePicker
import com.wxrk.utils.Common
import com.wxrk.utils.Common.Companion.logUnlimited
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.LoginViewModel
import java.text.SimpleDateFormat
import java.util.*

class DOB_Fragment : Fragment(R.layout.fragment_dob), DatePickerDialog.OnDateSetListener {

    private lateinit var viewModel: LoginViewModel
    lateinit var bindeview: FragmentDobBinding

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        bindeview = FragmentDobBinding.inflate(inflater, container, false)
        initview()
        initViewModel()
        observer()
        return bindeview.root
    }

    private fun initview() {
        bindeview.rlFinish.setOnClickListener {
//            viewModel.updateprofile(bindeview.etDob.text.toString())
        }

        bindeview.etDob.setOnTouchListener(object : View.OnTouchListener {
            override fun onTouch(p0: View?, p1: MotionEvent?): Boolean {
                logUnlimited("test", "touch")
                if (p1?.getAction() == MotionEvent.ACTION_UP) {  //check the event
                    datepicker()
                }

                return true
            }

        })

    }

    fun datepicker() {
        var datepicker = DatePicker()
        datepicker.show(childFragmentManager, "show")
    }

    private fun initViewModel() {
        viewModel = ViewModelProvider(this).get(LoginViewModel::class.java)
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
                bindeview.rlFinish.visibility = View.GONE
                bindeview.progress.visibility = View.VISIBLE
            } else {
                bindeview.progress.visibility = View.GONE
                bindeview.rlFinish.visibility = View.VISIBLE

            }

        }
        )


    }

    override fun onDateSet(p0: android.widget.DatePicker?, p1: Int, p2: Int, p3: Int) {
        val mCalendar: Calendar = Calendar.getInstance()
        mCalendar.set(Calendar.YEAR, p1)
        mCalendar.set(Calendar.MONTH, p2)
        mCalendar.set(Calendar.DAY_OF_MONTH, p3)
        val df = SimpleDateFormat("yyyy-MM-dd", Locale.US)
        bindeview.etDob.setText(df.format(mCalendar.getTime()))
    }
}
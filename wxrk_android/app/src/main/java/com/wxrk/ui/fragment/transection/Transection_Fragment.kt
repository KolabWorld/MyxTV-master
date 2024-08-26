package com.wxrk.ui.fragment.transection

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import com.google.android.material.datepicker.MaterialDatePicker
import com.wxrk.BaseFragment
import com.wxrk.R
import com.wxrk.databinding.FragmentLedgerBinding
import com.wxrk.model.transection.BodyTransection
import com.wxrk.utils.Common
import com.wxrk.utils.Common.Companion.logUnlimited
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.TransectionViewModel
import java.util.*

class Transection_Fragment : BaseFragment(R.layout.fragment_ledger) {

    lateinit var binding: FragmentLedgerBinding
    lateinit var viewModel: TransectionViewModel
    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentLedgerBinding.inflate(inflater, container, false)

        initviewmodel()
        initview()
        initobserve()
        return binding.root
    }

    private fun initview() {
        binding.ivBack.setOnClickListener { findNavController().popBackStack() }

        binding.rvTransection.layoutManager = LinearLayoutManager(requireActivity())

        binding.llWallet.setOnClickListener {
            findNavController().navigate(R.id.home_to_walletfrag)
        }
        viewModel.getAllTraction(BodyTransection(Common.getDate(System.currentTimeMillis()),
            Common.getDate(System.currentTimeMillis())))
        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)

        binding.tvFromdate.setOnClickListener { shocalender() }
        binding.tvTodate.setOnClickListener { shocalender() }

        binding.tvFromdate.setText(Common.getDate(System.currentTimeMillis()))
        binding.tvTodate.setText(Common.getDate(System.currentTimeMillis()))
    }

    private fun initviewmodel() {
        viewModel = ViewModelProvider(requireActivity()).get(TransectionViewModel::class.java)

    }

    private fun initobserve() {
        viewModel.itemdataAlltransection.observe(viewLifecycleOwner, Observer {
            if (it != null) {
                binding.rvTransection.adapter =
                    it.data?.data?.let { it1 ->
                        Transection_Adapter(
                            requireActivity(),
                            it1?.transactions
                        )
                    }
                if(it.data?.data?.transactions?.size!!>0){
                    binding.rvTransection.show()
                    binding.tvemptyview.hide()
                }else{
                    binding.tvemptyview.show()
                    binding.rvTransection.hide()

                }
            } else {
                binding.tvemptyview.show()
                binding.rvTransection.hide()
                Common.tooast(requireActivity(), "Somthing went wrong! Please Try Again")
            }
        })
    }

    fun shocalender() {
        val builder = MaterialDatePicker.Builder.dateRangePicker()
        val now = Calendar.getInstance()
        builder.setSelection(androidx.core.util.Pair(now.timeInMillis, now.timeInMillis))
        val picker = builder.build()
        picker.show(activity?.supportFragmentManager!!, picker.toString())
        picker.addOnNegativeButtonClickListener { picker.dismiss() }
        picker.addOnPositiveButtonClickListener {
            binding.tvFromdate.setText(Common.getDate(it.first))
            binding.tvTodate.setText(Common.getDate(it.second))
            logUnlimited("date__", "${it.first} -  ${it.second}")
//            tooast(requireActivity(),"The selected date range is ${it.first} - ${it.second}")}
            viewModel.getAllTraction(
                BodyTransection(
                    Common.getDate(it.first),
                    Common.getDate(it.second)
                )
            )

        }
    }

}
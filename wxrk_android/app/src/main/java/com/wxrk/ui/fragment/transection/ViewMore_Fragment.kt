package com.wxrk.ui.fragment.transection

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import androidx.lifecycle.Lifecycle
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.wxrk.R
import com.wxrk.databinding.FragmentViewmoreBinding
import com.wxrk.model.transection.TodaysData
import com.wxrk.ui.adapters.AppViaData_Adapter
import com.wxrk.ui.adapters.Graph_Adapter
import com.wxrk.utils.Common
import com.wxrk.utils.Common.Companion.logUnlimited
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.TransectionViewModel
import kotlin.math.roundToInt

class ViewMore_Fragment : Fragment(R.layout.fragment_viewmore) {
    lateinit var binding: FragmentViewmoreBinding
    lateinit var viewModel: TransectionViewModel
    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentViewmoreBinding.inflate(inflater, container, false)

        initviewmodel()
        initview()
        initobserve()
        return binding.root
    }

    private fun initview() {
        binding.ivBack.setOnClickListener { findNavController().popBackStack() }
        binding.llWallet.setOnClickListener {
            findNavController().navigate(R.id.home_to_walletfrag)
        }
        binding.rvAppdata.layoutManager = LinearLayoutManager(requireActivity())
        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)

        binding.rvgraph.layoutManager =
            LinearLayoutManager(requireActivity(), RecyclerView.HORIZONTAL, false)

        binding.tvWeek.setOnClickListener {
            binding.tvWeek.setBackgroundResource(R.drawable.bg_selectedweek)
            binding.tvDay.setBackgroundResource(0)
            changeadapter(lastWeekData_list)
        }

        binding.tvDay.setOnClickListener {
            binding.tvDay.setBackgroundResource(R.drawable.bg_selectedweek)
            binding.tvWeek.setBackgroundResource(0)
            changeadapter(lastdayData_list)
        }

        viewModel.getWeekdatanew()
    }

    private fun initviewmodel() {
        viewModel = ViewModelProvider(requireActivity()).get(TransectionViewModel::class.java)

    }

    lateinit var lastWeekData_list: ArrayList<TodaysData>
    lateinit var lastdayData_list: ArrayList<TodaysData>
    var larger_value=0.0
    var hours=1
    private fun initobserve() {
//        viewModel.itemdataweek.observe(viewLifecycleOwner, Observer {
//            if (viewLifecycleOwner.lifecycle.currentState == Lifecycle.State.RESUMED) {
//
//                if (it != null) {
//                    binding.tvWeeklytime.setText(it.data?.data?.weeklyAverage)
//                    lastWeekData_list = it.data?.data?.lastWeekData!!
//                    lastdayData_list = it.data?.data?.todaysData!!
//                    binding.rvAppdata.adapter =
//                        AppViaData_Adapter(requireActivity(), lastWeekData_list)
//                    binding.rvgraph.adapter =
//                        Graph_Adapter(requireActivity(), it.data?.data?.dayWiseSummaryData!!)
//                } else {
//                    Common.tooast(requireActivity(), "Somthing went wrong! Please Try Again")
//                }
//            }
//        }
//        )

        viewModel.itemdataweekios.observe(viewLifecycleOwner, Observer {
            if (viewLifecycleOwner.lifecycle.currentState == Lifecycle.State.RESUMED) {
                if (it != null) {
                    for (i in 0..it.data?.data?.iosAppPerformace!!.size-1){
                       if (larger_value <it.data?.data?.iosAppPerformace!!.get(i).watchTime!!.toDouble()){
                           larger_value=it.data?.data?.iosAppPerformace!!.get(i).watchTime!!.toDouble()
                       }
                    }
                    larger_value= larger_value+3600

                    binding.rvAppdata.adapter =
                        AppViaData_Adapter(requireActivity(), it.data?.data?.iosAppPerformace!!)
                    binding.rvgraph.adapter =
                        Graph_Adapter(requireActivity(), it.data?.data?.iosAppPerformace!!,larger_value)
                    hours=(larger_value/3600).roundToInt()
                    binding.tvHours.setText("$hours hr")
                    logUnlimited("hour","${(larger_value/3600).roundToInt()}")
                } else {
                    Common.tooast(requireActivity(), "Somthing went wrong! Please Try Again")
                }
            }
        }
        )
    }

    fun changeadapter(lastdayData_: ArrayList<TodaysData>) {
//        binding.rvAppdata.adapter = AppViaData_Adapter(requireActivity(), lastdayData_)
    }
}
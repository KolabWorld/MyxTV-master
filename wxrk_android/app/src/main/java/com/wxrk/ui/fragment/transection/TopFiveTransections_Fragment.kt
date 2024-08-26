package com.wxrk.ui.fragment.transection

import android.content.Intent
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import com.wxrk.BaseFragment
import com.wxrk.R
import com.wxrk.databinding.FragmentWalletBinding
import com.wxrk.ui.Intro_Activity
import com.wxrk.utils.Common
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.TransectionViewModel

class TopFiveTransections_Fragment : BaseFragment(R.layout.fragment_wallet) {

    lateinit var binding: FragmentWalletBinding
    lateinit var viewModel: TransectionViewModel

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentWalletBinding.inflate(inflater, container, false)

        initviewmodel()
        initview()
        initobserve()
        return binding.root
    }

    private fun initview() {
        binding.ivBack.setOnClickListener { findNavController().popBackStack() }

        binding.rvTransection.layoutManager = LinearLayoutManager(requireActivity())

        binding.rlTransection.setOnClickListener {
            findNavController().navigate(R.id.wallet_to_transection)
        }
        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)

        binding.llHowtoearn.setOnClickListener {
            requireActivity().finish()
            startActivity(Intent(requireActivity(), Intro_Activity::class.java))
        }


        viewModel.getTopTraction()
    }

    private fun initviewmodel() {
        viewModel = ViewModelProvider(requireActivity()).get(TransectionViewModel::class.java)

    }

    private fun initobserve() {
        viewModel.itemdatatransection.observe(viewLifecycleOwner, Observer {
            if (it != null) {
                binding.rvTransection.adapter =
                    it.data?.data?.let { it1 ->
                        Transection_Adapter(
                            requireActivity(),
                            it1?.transactions
                        )
                    }

            } else {
                Common.tooast(requireActivity(), "Somthing went wrong! Please Try Again")
            }
        })
    }
}
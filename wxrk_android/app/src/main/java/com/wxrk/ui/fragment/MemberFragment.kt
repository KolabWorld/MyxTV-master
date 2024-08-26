package com.wxrk.ui.fragment

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import androidx.recyclerview.widget.LinearLayoutManager
import com.wxrk.R
import com.wxrk.databinding.FragmentMembersBinding
import com.wxrk.ui.adapters.*
import com.wxrk.utils.Prefs

class MemberFragment : Fragment(R.layout.fragment_members) {

    lateinit var binding: FragmentMembersBinding

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentMembersBinding.inflate(inflater, container, false)
        initview()
        return binding.root
    }


    private fun initview() {
        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)

        binding.rvCategory.layoutManager =
            LinearLayoutManager(requireActivity(), LinearLayoutManager.HORIZONTAL, false)
        binding.rvCategory.adapter = MemberCategory_Adapter(requireActivity())

        binding.rvOffers.layoutManager = LinearLayoutManager(requireActivity())
        binding.rvOffers.adapter = Member_Adapter(requireActivity())

    }
}
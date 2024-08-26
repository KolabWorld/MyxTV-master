package com.wxrk.ui.fragment.profile

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import com.bumptech.glide.Glide
import com.wxrk.R
import com.wxrk.databinding.FragmentProfileBinding
import com.wxrk.utils.Prefs

class ProfileFragment : Fragment(R.layout.fragment_profile) {

    lateinit var binding: FragmentProfileBinding

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentProfileBinding.inflate(inflater, container, false)
        initview()
        return binding.root
    }


    private fun initview() {
        Glide.with(requireActivity()).load(Prefs.getInstance(requireActivity()).profileImage)
            .placeholder(R.drawable.ic_x).into(binding.ivUser)
        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)
        binding.tvNameTx.setText(Prefs.getInstance(requireActivity()).userFirstName)
        binding.tvPhonenumberTx.setText(Prefs.getInstance(requireActivity()).mobile)
        binding.tvDobTx.setText(Prefs.getInstance(requireActivity()).email)
        binding.tvEditProfile.setOnClickListener {
            findNavController().navigate(R.id.profile_to_editprofile)
        }
        binding.ivBack.setOnClickListener {
            findNavController().popBackStack()
        }
        binding.llWallet.setOnClickListener {
            findNavController().navigate(R.id.home_to_walletfrag)
        }
    }
}
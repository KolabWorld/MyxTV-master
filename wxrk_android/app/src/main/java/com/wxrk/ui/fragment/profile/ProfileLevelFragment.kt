package com.wxrk.ui.fragment.profile

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import com.wxrk.R
import com.wxrk.databinding.*

class ProfileLevelFragment : Fragment(R.layout.fragment_event) {

    lateinit var binding: FragmentProfilelevelBinding

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentProfilelevelBinding.inflate(inflater, container, false)
        initview()
        return binding.root
    }


    private fun initview() {


    }
}
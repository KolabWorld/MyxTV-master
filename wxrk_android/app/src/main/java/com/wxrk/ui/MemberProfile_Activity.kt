package com.wxrk.ui

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import androidx.recyclerview.widget.LinearLayoutManager
import com.wxrk.MainActivity
import com.wxrk.R
import com.wxrk.databinding.ActivityMemberprofileBinding

class MemberProfile_Activity : AppCompatActivity() {

    lateinit var binding: ActivityMemberprofileBinding
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityMemberprofileBinding.inflate(layoutInflater)
        setContentView(binding.root)
        initViewModel()
        observeSplashLiveData()

    }

    private fun initViewModel() {
        binding.ivBack.setOnClickListener { finish() }


    }

    private fun observeSplashLiveData() {


    }
}
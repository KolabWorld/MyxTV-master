package com.wxrk.ui

import android.os.Bundle
import androidx.navigation.NavController
import androidx.navigation.fragment.findNavController
import com.wxrk.BaseActivity
import com.wxrk.R
import com.wxrk.databinding.ActivityLoginBinding

class LoginActivity : BaseActivity() {
    lateinit var binding: ActivityLoginBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityLoginBinding.inflate(layoutInflater)
        setContentView(binding.root)

        initview()
    }

    lateinit var navController: NavController
    private fun initview() {
        val navHost = supportFragmentManager.findFragmentById(R.id.login_nav_host_fragment)!!
        navController = navHost.findNavController()

    }

    override fun onBackPressed() {
        if (!navController.popBackStack()) {
            // Call finish() on your Activity
            finish()
        }
    }
}




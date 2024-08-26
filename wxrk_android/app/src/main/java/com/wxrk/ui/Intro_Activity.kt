package com.wxrk.ui

import android.content.Intent
import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.ViewModelProvider
import androidx.viewpager2.widget.ViewPager2.OnPageChangeCallback
import com.wxrk.MainActivity
import com.wxrk.databinding.ActivityIntroscreenBinding
import com.wxrk.ui.adapters.Intro_Adapter
import com.wxrk.viewmodels.ChooseLoginViewModel


class Intro_Activity : AppCompatActivity() {

    private lateinit var viewModel: ChooseLoginViewModel
    lateinit var bindeview: ActivityIntroscreenBinding
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        bindeview = ActivityIntroscreenBinding.inflate(layoutInflater)
        setContentView(bindeview.root)

        initview()
        initViewModel()
    }

    private fun initview() {
        bindeview.viewpager.adapter = Intro_Adapter(this)

        bindeview.viewpager.registerOnPageChangeCallback(object : OnPageChangeCallback() {
            // This method is triggered when there is any scrolling activity for the current page
            override fun onPageScrolled(
                position: Int,
                positionOffset: Float,
                positionOffsetPixels: Int
            ) {
                super.onPageScrolled(position, positionOffset, positionOffsetPixels)
            }

            // triggered when you select a new page
            override fun onPageSelected(position: Int) {
                super.onPageSelected(position)
            }

            // triggered when there is
            // scroll state will be changed
            override fun onPageScrollStateChanged(state: Int) {
                super.onPageScrollStateChanged(state)
            }
        })

    }

    private fun initViewModel() {
        viewModel = ViewModelProvider(this).get(ChooseLoginViewModel::class.java)
    }

    override fun onBackPressed() {
        finish()
        startActivity(Intent(this, MainActivity::class.java))
    }
}
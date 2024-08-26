package com.wxrk.ui

import android.Manifest
import android.content.Intent
import android.content.pm.PackageManager
import android.net.Uri
import android.os.Bundle
import android.view.animation.AnimationUtils
import androidx.appcompat.app.AppCompatActivity
import androidx.core.app.ActivityCompat
import androidx.core.content.ContextCompat
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import com.wxrk.MainActivity
import com.wxrk.R
import com.wxrk.databinding.ActivitySplashBinding
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.SplashViewModel


class SplashActivity : AppCompatActivity() {

    private lateinit var splashViewModel: SplashViewModel
    lateinit var binding: ActivitySplashBinding
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivitySplashBinding.inflate(layoutInflater)
        setContentView(binding.root)
        initViewModel()
        observeSplashLiveData()


        var animSlide = AnimationUtils.loadAnimation(
            getApplicationContext(),
            R.anim.bottom_to_top
        );
        binding.ivImageview.startAnimation(animSlide)

        var animSlide_new = AnimationUtils.loadAnimation(
            getApplicationContext(),
            R.anim.left_to_right
        );
        binding.rlTopview.startAnimation(animSlide_new)

        val uri: Uri =
            Uri.parse("android.resource://" + packageName + "/" + R.raw.videonew)
        binding.videoview.setVideoURI(uri)
        binding.videoview.start()
        binding.videoview.requestFocus()
        binding.videoview.setOnPreparedListener { mp ->
            mp.setLooping(true)

            if (checkPermissions().size == 0) {
                splashViewModel.initSplashScreen()
            } else {
                requestPermissions()
            }
        }

    }

    private fun initViewModel() {
        splashViewModel = ViewModelProvider(this).get(SplashViewModel::class.java)
    }

    private fun observeSplashLiveData() {
        val observer = Observer<Boolean> {

            if (Prefs.getInstance(this).isLogin) {
                val intent = Intent(this, MainActivity::class.java)
                startActivity(intent)
            } else {
                val intent = Intent(this, LoginActivity::class.java)
                startActivity(intent)
            }
            finish()
        }
        splashViewModel.liveData.observe(this, observer)
    }


    private fun checkPermissions(): List<String> {
        val permissions: MutableList<String> = ArrayList()
        if (ContextCompat.checkSelfPermission(
                applicationContext,
                Manifest.permission.WRITE_EXTERNAL_STORAGE
            ) != PackageManager.PERMISSION_GRANTED
        ) {
            permissions.add(Manifest.permission.WRITE_EXTERNAL_STORAGE)
        }
        if (ContextCompat.checkSelfPermission(
                applicationContext,
                Manifest.permission.READ_PHONE_STATE
            ) != PackageManager.PERMISSION_GRANTED
        ) {
            permissions.add(Manifest.permission.READ_PHONE_STATE)
        }
        return permissions
    }

    private fun requestPermissions() {
        val permissions = checkPermissions()
        if (permissions.size > 0) {
            ActivityCompat.requestPermissions(this, permissions.toTypedArray(), 0)
        }
    }

    override fun onRequestPermissionsResult(
        requestCode: Int,
        permissions: Array<String>,
        grantResults: IntArray
    ) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults)
        for (i in permissions.indices) {
            val permission = permissions[i]
            if (permission == Manifest.permission.WRITE_EXTERNAL_STORAGE && grantResults[i] == PackageManager.PERMISSION_GRANTED) {
                break
            }
        }
        splashViewModel.initSplashScreen()
    }

}
package com.wxrk.ui.fragment.twitch

import android.content.pm.ActivityInfo
import android.content.res.Configuration
import android.os.Bundle
import android.os.Handler
import android.os.Message
import android.util.Log
import android.view.LayoutInflater
import android.view.MotionEvent
import android.view.View
import android.view.ViewGroup
import android.webkit.WebChromeClient
import android.webkit.WebView
import android.webkit.WebViewClient
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import com.wxrk.BaseFragment
import com.wxrk.R
import com.wxrk.databinding.FragmentTwitchdetailBinding
import com.wxrk.model.Twitch.TwitchData
import com.wxrk.utils.Common.Companion.countviews
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.EventViewModel

class TwitchDetail_Fragment : BaseFragment(R.layout.fragment_twitchdetail), View.OnTouchListener,
    Handler.Callback {
    lateinit var binding: FragmentTwitchdetailBinding
    lateinit var item: TwitchData
    lateinit var viewModel: EventViewModel
    lateinit var client: WebViewClient
     var oriantation_=false
    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentTwitchdetailBinding.inflate(inflater, container, false)
        initViewModel()
        observers()
        initview()
        return binding.root
    }

    override fun onConfigurationChanged(newConfig: Configuration) {
        super.onConfigurationChanged(newConfig)
        // Checks the orientation of the screen
        if (newConfig.orientation == Configuration.ORIENTATION_LANDSCAPE) {
            oriantation_ = false
        } else if (newConfig.orientation == Configuration.ORIENTATION_PORTRAIT) {
            oriantation_ = true
        }
    }

    private fun initview() {
        binding.ivBack.setOnClickListener {
            if(oriantation_) {
                findNavController().popBackStack()
            }else{
                oriantation_=true
                requireActivity(). setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);
            }
        }
        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)
        binding.llWallet.setOnClickListener {
            findNavController().navigate(R.id.home_to_walletfrag)
        }
        binding.ivVideoExpend.hide()
        binding.ivVideoExpend.setOnClickListener {
           if (oriantation_){
               oriantation_=false
              requireActivity(). setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
           }else{
               oriantation_=true
               requireActivity(). setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);
           }
        }
        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)
        binding.tvTextdes.setText(item.title)
        binding.tvBrandName.setText(item.description)
        binding.tvExpire.setText(item.videoCreatedAt)
        binding.tvCount.setText("${countviews(item.viewCount!!.toLong())} view")
        callFunction()
    }

    private fun initViewModel() {
        binding.lifecycleOwner = this
        viewModel = ViewModelProvider(requireActivity()).get(EventViewModel::class.java)
    }

    private fun observers() {
        item = arguments?.get("item") as TwitchData
        loadwebview()
        viewModel.watchtimedata.observe(binding.lifecycleOwner!!, Observer {
            Prefs.getInstance(requireActivity()).balance =
                it.data?.data?.todayWxrkBalance
            binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)
        })
    }

    private val CLICK_ON_WEBVIEW = 1
    private val CLICK_ON_URL = 2
    val handler = Handler(this)
    fun loadwebview() {
        client = object : WebViewClient() {
            override fun shouldOverrideUrlLoading(view: WebView, url: String): Boolean {
                handler.sendEmptyMessage(CLICK_ON_URL)
                return false
            }
        }
        val url = "https://staging-wxrk.staqo.com/app-video/${item.twitchId}?user_id=${Prefs.getInstance(requireActivity()).userid}"
        Log.e("loadwebview:", "$url")
        val mWebView = binding.webview
        mWebView.webChromeClient = WebChromeClient()
        val webSettings = mWebView.settings
        webSettings.javaScriptEnabled = true
        webSettings.setLoadsImagesAutomatically(true)
        webSettings.setJavaScriptCanOpenWindowsAutomatically(true)
        webSettings.setMediaPlaybackRequiresUserGesture(false)
        webSettings.setDomStorageEnabled(false)
        webSettings.setAllowFileAccess(true)
        webSettings.useWideViewPort = true
        webSettings.loadWithOverviewMode = true
        val webChromeClient = WebChromeClient()
        mWebView.setWebChromeClient(webChromeClient)
        mWebView.setWebViewClient(WebViewClient())
        mWebView.setOnTouchListener(this);
        mWebView.setWebViewClient(client);
        mWebView.setWebViewClient(object : WebViewClient() {
            override fun onPageFinished(view: WebView?, weburl: String?) {
            }
        })
        mWebView.setWebChromeClient(object : WebChromeClient() {
            override fun onProgressChanged(view: WebView?, newProgress: Int) {
            }
        })
        mWebView.loadUrl(url)
    }

    override fun onTouch(p0: View?, p1: MotionEvent?): Boolean {
        if (p0!!.getId() == R.id.webview && p1!!.getAction() == MotionEvent.ACTION_DOWN) {
            handler.sendEmptyMessageDelayed(CLICK_ON_WEBVIEW, 500);
        }
        return false;
    }

    override fun handleMessage(msg: Message): Boolean {
        if (msg.what == CLICK_ON_URL) {
            handler.removeMessages(CLICK_ON_WEBVIEW);
            return true;
        }
        if (msg.what == CLICK_ON_WEBVIEW) {
            return true;
        }
        return false;
    }

    fun callFunction(){
        val handler = Handler()
        handler.postDelayed(object : Runnable {
            override fun run() {
                //Call your function here
                viewModel.getWatchtime()
                handler.postDelayed(this, 60000)//1 sec delay
            }
        }, 0)
    }

}
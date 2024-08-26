package com.wxrk.ui.fragment.event


import android.os.Bundle
import android.os.CountDownTimer
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import com.bumptech.glide.Glide
import com.wxrk.R
import com.wxrk.databinding.FragmentEventpromocodeBinding
import com.wxrk.model.dashbord.Events
import com.wxrk.utils.Common
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.OfferViewModel
import java.text.ParseException
import java.text.SimpleDateFormat
import java.util.*

class RedeemEvent_Fragment : Fragment(R.layout.fragment_eventpromocode) {

    lateinit var binding: FragmentEventpromocodeBinding
    lateinit var item: Events
    private lateinit var viewModel: OfferViewModel
    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentEventpromocodeBinding.inflate(inflater, container, false)
        initViewModel()
        observers()

        initview()
        return binding.root
    }


    private fun initview() {
        binding.ivBack.setOnClickListener {
            parentFragment?.findNavController()?.popBackStack()
        }
        binding.llWallet.setOnClickListener {

            findNavController().navigate(R.id.home_to_walletfrag)
        }

        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)


        binding.tvDate.setText(Common.convertEventdate("dd", item.startDateTime!!))
        binding.tvMonth.setText(Common.convertEventdate("MMMM", item.startDateTime!!))
        binding.tvEventname.setText("By ${item.company_name}")
        Glide.with(requireActivity()).load(item.thumbnailImage)
            .into(binding.ivBanner)
//        Log.e(TAG, "initview: ", )
        binding.tvremainig.setText(item.remaining_time)

        binding.tvTimeLocation.setText(
            Common.convertEventdate(
                "EEE, MMM dd",
                item.startDateTime!!
            ) + "\n" + item.venue
        )
        reverstimer()
    }

    private fun initViewModel() {
        binding.lifecycleOwner = this
        viewModel = ViewModelProvider(requireActivity()).get(OfferViewModel::class.java)
    }

    private fun observers() {

        item = arguments?.get("item") as Events
    }

    fun reverstimer(){
        var futureMinDate = Date()
        val sdf = SimpleDateFormat("yyyy-MM-dd HH:mm:ss", Locale.ENGLISH)
        try {
            futureMinDate = sdf.parse(item.endDateTime)
        } catch (e: ParseException) {
            e.printStackTrace()
        }

// Here futureMinDate.time Returns the number of milliseconds since January 1, 1970, 00:00:00 GM
// So we need to subtract the millis from current millis to get actual millis
        object : CountDownTimer(futureMinDate.time - System.currentTimeMillis(), 1000) {
            override fun onTick(millisUntilFinished: Long) {
                val sec = (millisUntilFinished / 1000) % 60
                val min = (millisUntilFinished / (1000 * 60)) % 60
                val hr = (millisUntilFinished / (1000 * 60 * 60)) % 24
                val day = ((millisUntilFinished / (1000 * 60 * 60)) / 24).toInt()
                val formattedTimeStr = if (day > 1) "$day days $hr : $min : $sec"
                else "${day}d: ${hr}h: ${min}m: ${sec}s"
                binding.tvremainig.setText(formattedTimeStr)
            }

            override fun onFinish() {
                binding.tvremainig.setText("00:00:00")
            }
        }.start()
    }


}
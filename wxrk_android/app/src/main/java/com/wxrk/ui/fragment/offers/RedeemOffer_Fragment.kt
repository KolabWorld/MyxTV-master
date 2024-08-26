package com.wxrk.ui.fragment.offers

import android.content.ClipData
import android.content.ClipboardManager
import android.content.Context
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.os.CountDownTimer
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import com.bumptech.glide.Glide
import com.wxrk.R
import com.wxrk.databinding.FragmentOfferpromocodeBinding
import com.wxrk.model.offers.PromoCodeRes
import com.wxrk.utils.Common
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.OfferViewModel
import java.text.ParseException
import java.text.SimpleDateFormat
import java.util.*

class RedeemOffer_Fragment : Fragment(R.layout.fragment_offerpromocode) {

    lateinit var binding: FragmentOfferpromocodeBinding
    lateinit var item: PromoCodeRes
    private lateinit var viewModel: OfferViewModel
    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentOfferpromocodeBinding.inflate(inflater, container, false)
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



        binding.tvTextdes.setText(item.offer?.detailsOfOffer)
        binding.tvName.setText(item.offer?.offerName)
        Glide.with(requireActivity()).load(item.offer?.thumbnailImage)
            .into(binding.ivOfferimg)
        binding.tvPromocode.setText(item.promo_code?.promoCode)

        binding.btRedeem.setOnClickListener {
            if (item.offer?.link != null)
                if (!item.offer?.link!!.startsWith("http://") && !item.offer?.link!!.startsWith("https://"))
                    startActivity(Intent(Intent.ACTION_VIEW, Uri.parse("http://" + item.offer?.link)))

        }
        binding.llCopy.setOnClickListener {
            binding.tvPromocode.text.toString().copyToClipboard(requireActivity())
        }
        binding.tvOfferpice.setText(item.offer?.offerPriceInWxrk)
        reverstimer()
    }

    private fun initViewModel() {
        binding.lifecycleOwner = this
        viewModel = ViewModelProvider(requireActivity()).get(OfferViewModel::class.java)
    }

    private fun observers() {

        item = arguments?.get("item") as PromoCodeRes
    }

    fun String.copyToClipboard(context: Context) {
        val clipBoard = context.getSystemService(Context.CLIPBOARD_SERVICE) as ClipboardManager
        val clipData = ClipData.newPlainText("label", this)
        clipBoard.setPrimaryClip(clipData)
        Toast.makeText(requireActivity(),"${binding.tvPromocode.text} Copy",Toast.LENGTH_LONG).show()
    }

    fun reverstimer(){
        Common.logUnlimited("timer", "inn")
        var str_time= item.order?.remainingHours
//        str_time=str_time.substring(0,2)
//         str_time=str_time.substring(3,5)
//         str_time=str_time.substring(6,8)
//        Common.logUnlimited("str_time", str_time)
//        return
        val additionalHour = str_time?.substring(0,2)?.toInt()
        val additionalMinute = str_time?.substring(3,5)?.toInt()
        val additionalSeconds = str_time?.substring(6,8)?.toInt()


        val sdf = SimpleDateFormat("yyyy:MM:dd:HH:mm", Locale.getDefault())
        val currentDateandTime = sdf.format(Date())

        var date: Date? = null
        try {
            date = sdf.parse(currentDateandTime)
        } catch (e: ParseException) {
            e.printStackTrace()
        }
        val calendar = Calendar.getInstance()
        calendar.time = date
        calendar.add(Calendar.HOUR, additionalHour!!)
        calendar.add(Calendar.MINUTE, additionalMinute!!)
        calendar.add(Calendar.SECOND, additionalSeconds!!)

        System.out.println("Desired Time here " + calendar.time)

// Here futureMinDate.time Returns the number of milliseconds since January 1, 1970, 00:00:00 GM
// So we need to subtract the millis from current millis to get actual millis
        object : CountDownTimer(calendar.timeInMillis - System.currentTimeMillis(), 1000) {
            override fun onTick(millisUntilFinished: Long) {
                val sec = (millisUntilFinished / 1000) % 60
                val min = (millisUntilFinished / (1000 * 60)) % 60
                val hr = (millisUntilFinished / (1000 * 60 * 60))
//                val hr = (millisUntilFinished / (1000 * 60 * 60)) % 24
//                val day = ((millisUntilFinished / (1000 * 60 * 60)) ).toInt()
//                 val day = ((millisUntilFinished / (1000 * 60 * 60)) / 24).toInt()
                val formattedTimeStr = "$hr:$min:$sec"
//                else "$hr : $min : $sec"
                Common.logUnlimited("timer", "$formattedTimeStr")
                binding.tvremainig.setText(formattedTimeStr)

//                tvFlashDealCountDownTime.text = formattedTimeStr
            }

            override fun onFinish() {
//                tvFlashDealCountDownTime.text = "Done!"
                Common.logUnlimited("timer", "finish")
                binding.tvremainig.setText("00:00:00")

            }
        }.start()
    }
}
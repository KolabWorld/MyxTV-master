package com.wxrk.ui.fragment.event

import android.os.Build
import android.os.Bundle
import android.os.CountDownTimer
import android.text.Html
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.core.os.bundleOf
import androidx.lifecycle.Lifecycle
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.GridLayoutManager
import com.google.android.material.tabs.TabLayoutMediator
import com.wxrk.BaseFragment
import com.wxrk.R
import com.wxrk.databinding.FragmentEventdetailBinding
import com.wxrk.model.dashbord.Events
import com.wxrk.model.event.JoinEventBody
import com.wxrk.ui.adapters.EventSponsor_Adapter
import com.wxrk.ui.adapters.Imageview_Adapter
import com.wxrk.utils.Common
import com.wxrk.utils.Common.Companion.logUnlimited
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.EventViewModel
import java.text.ParseException
import java.text.SimpleDateFormat
import java.util.*

class EventDetail_Fragment : BaseFragment(R.layout.fragment_eventdetail) {

    lateinit var binding: FragmentEventdetailBinding
    lateinit var item: Events
    lateinit var viewModel: EventViewModel

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentEventdetailBinding.inflate(inflater, container, false)
        initViewModel()
        observers()
        initview()
        return binding.root
    }


    private fun initview() {
        binding.ivBack.setOnClickListener {
            findNavController().popBackStack()
        }
        binding.tvDes.setText(item.about_the_company)

        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)

        binding.llWallet.setOnClickListener {
            findNavController().navigate(R.id.home_to_walletfrag)
        }

        binding.rvEventsponsor.layoutManager = GridLayoutManager(requireActivity(), 4)
//        binding.rvSignupmember.layoutManager = LinearLayoutManager(requireActivity())
        binding.rvEventsponsor.adapter = EventSponsor_Adapter(requireActivity(), item.sponser)
//        binding.rvSignupmember.adapter = SignupMember_Adapter(requireActivity())
        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)


        binding.viewpager.adapter = Imageview_Adapter(requireActivity(), item.banner)

        TabLayoutMediator(binding.tablay, binding.viewpager) { tab, position ->
            //Some implementation
        }.attach()

        binding.tvTextdes.setText(item.name)
        binding.tvBrandName.setText("By ${item.company_name}")
//        logUnlimited(
//            "ineventdetail",
//            "Highlight ${item.highlights} aboutcompany=${item.about_the_company}"
//        )
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.N) {
            binding.tvHighlight.setText(Html.fromHtml(item.highlights,Html.FROM_HTML_MODE_LEGACY))
        }else{
            binding.tvHighlight.setText(Html.fromHtml(item.highlights))
        }

        binding.tvExpire.setText(item.remaining_time)
        binding.tvSignupcount.setText("${item.total_members} signups")
        if (item.total_members!! > 0) {
            binding.tvTextbynow.setText("Join " + item.total_members + " MEMBERS")
        }
        binding.tvVenu.setText(item.venue)
        binding.tvAboutorg.setText("About " + item.company_name)
        binding.tvDate.setText(Common.convertEventdate("dd-MM-yyyy", item.startDateTime!!)+"\n"
                +Common.convertEventdate("hh:mm aa", item.startDateTime!!))
        binding.tvTime.setText(Common.convertEventdate("dd MM yyyy hh:mm a", item.endDateTime!!))
    binding.tvTime.setText(Common.convertEventdate("dd-MM-yyyy", item.endDateTime!!)+"\n"+
            Common.convertEventdate("hh:mm aa", item.endDateTime!!))

        binding.llJoin.setOnClickListener {
            viewModel.JoinEvent(
                JoinEventBody(
                    item.id!!,
                    Prefs.getInstance(requireActivity()).userid
                )
            )
        }
        binding.tvVisitwebsite.hide()

        reverstimer()
    }

    private fun initViewModel() {
        binding.lifecycleOwner = this
        viewModel = ViewModelProvider(requireActivity()).get(EventViewModel::class.java)
    }

    private fun observers() {

        item = arguments?.get("item") as Events

        viewModel.itemjoinres.observe(viewLifecycleOwner, Observer {
            if (viewLifecycleOwner.lifecycle.currentState == Lifecycle.State.RESUMED) {

                if (it.status != null) {
                    parentFragment?.findNavController()
                        ?.navigate(R.id.eventdetail_to_eventpromo, bundleOf("item" to item))
                    Common.tooast(requireActivity(),"Registered Successfully")

                }
            }

        })

        viewModel.errorres.observe(viewLifecycleOwner, Observer {
            if (viewLifecycleOwner.lifecycle.currentState == Lifecycle.State.RESUMED) {
                logUnlimited("response", "${it}")
                Common.tooast(requireActivity(),it!!.errors!!.message!!)
            }
        })
        viewModel.itemloader.observe(viewLifecycleOwner, Observer {

            if (it) {
                binding.llJoin.visibility = View.GONE
                binding.progress.visibility = View.VISIBLE
            } else {
                binding.llJoin.visibility = View.VISIBLE
                binding.progress.visibility = View.GONE

            }

        })

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
                binding.tvExpire.setText(formattedTimeStr)
            }

            override fun onFinish() {
                binding.tvExpire.setText("00:00:00")
            }
        }.start()
    }
}
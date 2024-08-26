package com.wxrk.ui.fragment

import android.content.Intent
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.core.os.bundleOf
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout
import com.bumptech.glide.Glide
import com.wxrk.BaseFragment
import com.wxrk.R
import com.wxrk.databinding.FragmentHomeBinding
import com.wxrk.model.dashbord.Banners
import com.wxrk.model.dashbord.Events
import com.wxrk.model.dashbord.Offers
import com.wxrk.ui.Intro_Activity
import com.wxrk.ui.adapters.*
import com.wxrk.ui.fragment.event.Event_Adapter
import com.wxrk.ui.fragment.offers.Offer_Adapter
import com.wxrk.utils.AppUtil
import com.wxrk.utils.Common
import com.wxrk.utils.Common.Companion.getlastsynch
import com.wxrk.utils.Common.Companion.tooast
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.HomeViewModel
import java.text.SimpleDateFormat
import java.util.*


class HomeFragment : BaseFragment(R.layout.fragment_home), Offer_Adapter.OnOfferClick,
    SponserAds_Adapter.OnSponserClick, Event_Adapter.onAdapterItemClick,
    SwipeRefreshLayout.OnRefreshListener {

    lateinit var binding: FragmentHomeBinding
    private lateinit var viewModel: HomeViewModel
    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentHomeBinding.inflate(inflater, container, false)
        initViewModel()
        initview()
        observers()

        return binding.root
    }

    private fun initViewModel() {
        binding.lifecycleOwner = this
        viewModel = ViewModelProvider(requireActivity()).get(HomeViewModel::class.java)
        binding.viewmodel = viewModel
    }


    private fun initview() {
        binding.swiprefresh.setOnRefreshListener(this)
        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)
        Glide.with(requireActivity()).load(Prefs.getInstance(requireActivity()).profileImage)
            .placeholder(R.drawable.ic_x).into(binding.ivUser)

        settting_adapters()

        binding.tvLastsynchtime.setText(getlastsynch(Prefs.getInstance(requireActivity()).lastSyncTime))


        binding.tvViewmore.setOnClickListener {
            findNavController().navigate(R.id.home_to_weekreport)
        }

         binding.tvwatchtoearn.setOnClickListener {
            findNavController().navigate(R.id.home_to_twitch)
        }

        binding.ivIntro.setOnClickListener {
            requireActivity().finish()
            startActivity(Intent(requireActivity(), Intro_Activity::class.java))
        }

        var textvalue = String.format(requireActivity().getString(R.string.total),
            AppUtil.formatMilliSeconds(Prefs.getInstance(requireActivity()).todaysUsage))
        binding.tvClock.setText(textvalue)

        binding.ivUser.setOnClickListener {
            findNavController().navigate(R.id.home_to_profile)
        }

        binding.llWallet.setOnClickListener {
            findNavController().navigate(R.id.home_to_walletfrag)
        }
        viewModel.callGetDashboard()
         viewModel.getWatchtime()
    }

    private fun settting_adapters() {
        binding.rvUpcomingevent.layoutManager =
            LinearLayoutManager(requireActivity(), LinearLayoutManager.HORIZONTAL, false)

        binding.rvToptimesaver.layoutManager =
            LinearLayoutManager(requireActivity(), LinearLayoutManager.HORIZONTAL, false)

        binding.rvPremium.layoutManager = LinearLayoutManager(requireActivity())
        binding.rvPremium.isNestedScrollingEnabled = false
        binding.rvSponserads.layoutManager = LinearLayoutManager(requireActivity())
    }

    private fun observers() {
        viewModel.watchtimedata.observe(binding.lifecycleOwner!!, Observer {
            Prefs.getInstance(requireActivity()).balance =
                it.data?.data?.todayWxrkBalance
            binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)
        })
        viewModel.dashbordData.observe(binding.lifecycleOwner!!, Observer {
            if (it != null) {

                Prefs.getInstance(requireActivity()).lastSyncTime =
                    it.data?.data?.dayWiseSummary?.updatedAt?.let { it1 -> convertdate(it1) }
                Prefs.getInstance(requireActivity()).todaysUsage =
                    ((it.data?.data?.dayWiseSummary?.watchTime?.toLong())?.times(
                        1000
                    ))

                var textvalue = String.format(
                    requireActivity().getString(R.string.total),
                    AppUtil.formatMilliSeconds(Prefs.getInstance(requireActivity()).todaysUsage)
                )
                binding.tvClock.setText(textvalue)
                binding.rvUpcomingevent.adapter =
                    it.data?.data?.events?.let { it1 ->
                        Event_Adapter(
                            requireActivity(),
                            it1,
                            this
                        )
                    }
                if (it.data?.data?.iosAppPerformace?.size!! > 0) {
                    binding.rvToptimesaver.adapter = it.data?.data?.iosAppPerformace?.let { it1 ->
                        TopTimeSaver_Adapter(
                            requireActivity(),
                            it1
                        )
                    }
                    binding.rvToptimesaver.show()
                    binding.tvLastsynchtime.show()
                    binding.tvlastsevendaytxt.show()
                } else {
                    binding.rvToptimesaver.hide()
                    binding.tvLastsynchtime.hide()
                    binding.tvlastsevendaytxt.hide()
                }
                binding.rvPremium.adapter =
                    it.data?.data?.offers?.let { it1 ->
                        Premium_Adapter(
                            requireActivity(),
                            it1,
                            this
                        )
                    }

                binding.rvSponserads.adapter =
                    it.data?.data?.banners?.let { it1 ->
                        SponserAds_Adapter(
                            requireActivity(), it1, this
                        )
                    }
                if (it.data?.data?.user?.status.equals("inactive")){
                    Common.tooast(requireActivity(),"Your account is inactive.Please contact admin.")
                    requireActivity().finish()

                }
                Prefs.getInstance(requireActivity()).profileImage= it.data?.data?.user?.profileImageUrl
//                Prefs.getInstance(requireActivity()).balance =
//                    it.data?.data?.dayWiseSummary?.wxrkBalance
//                binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)

            } else {
                tooast(requireActivity(), "Somthing went wrong! Please try again.")
            }
        })
    }

    fun convertdate(myDate: String): Long {
        val sdf = SimpleDateFormat("yyyy-MM-dd HH:mm:ss")
        val date: Date = sdf.parse(myDate)
        val millis: Long = date.getTime()
        return millis
    }

    override fun Onofferclickitem(item: Offers) {
        findNavController().navigate(R.id.offerlist_to_offerdetail, bundleOf("item" to item))
    }

    override fun OnClickAds(item: Banners) {
        findNavController().navigate(R.id.sponserlist_to_sponserads, bundleOf("item" to item))

    }

    override fun onadapteritemclick(item: Events) {
        findNavController().navigate(R.id.eventdetail_fragment, bundleOf("item" to item))

    }

    override fun onjoinnowclick(item: Events) {

    }

    override fun onRefresh() {
        binding.swiprefresh.isRefreshing = false
    }

}
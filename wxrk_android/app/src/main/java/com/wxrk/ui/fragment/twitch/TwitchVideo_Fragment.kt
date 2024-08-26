package com.wxrk.ui.fragment.twitch

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.core.os.bundleOf
import androidx.fragment.app.Fragment
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import com.wxrk.R
import com.wxrk.databinding.FragmentEventBinding
import com.wxrk.model.Twitch.TwitchData
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.EventViewModel

class TwitchVideo_Fragment : Fragment(R.layout.fragment_event), Twitch_Adapter.onAdapterItemClick {

    lateinit var binding: FragmentEventBinding
    private lateinit var viewModel: EventViewModel

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentEventBinding.inflate(inflater, container, false)
        if (isAdded) {
            initViewModel()
            initview()
            observers()
        }
        return binding.root
    }


    private fun initview() {
        binding.tvText.setText("VIDEOS")
        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)
        binding.rvEvents.layoutManager = LinearLayoutManager(requireActivity())
        viewModel.getallvideos()
        binding.llWallet.setOnClickListener {
            findNavController().navigate(R.id.home_to_walletfrag)
        }

    }

    private fun initViewModel() {
        binding.lifecycleOwner = this
        viewModel = ViewModelProvider(requireActivity()).get(EventViewModel::class.java)
    }

    private fun observers() {
        viewModel.twitch_list.observe(requireActivity(), Observer {
            binding.rvEvents.adapter = it.data?.data?.let { it1 ->
                Twitch_Adapter(requireActivity(), it1.twitch_videos, this)
            }
        })

        viewModel.watchtimedata.observe(binding.lifecycleOwner!!, Observer {
            Prefs.getInstance(requireActivity()).balance =
                it.data?.data?.todayWxrkBalance
            binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)
        })
    }

    override fun onadapteritemclick(item: TwitchData) {

        findNavController().navigate(R.id.twitchvideo_to_twitchdetail, bundleOf("item" to item))
    }

    override fun onResume() {
        super.onResume()
        viewModel.getWatchtime()

    }

}
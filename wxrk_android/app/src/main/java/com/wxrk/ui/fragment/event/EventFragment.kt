package com.wxrk.ui.fragment.event

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.core.os.bundleOf
import androidx.lifecycle.Lifecycle
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import com.wxrk.BaseFragment
import com.wxrk.R
import com.wxrk.databinding.FragmentEventBinding
import com.wxrk.model.dashbord.Events
import com.wxrk.model.event.JoinEventBody
import com.wxrk.utils.Common
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.EventViewModel

class EventFragment : BaseFragment(R.layout.fragment_event), Event_Adapter.onAdapterItemClick {

    lateinit var binding: FragmentEventBinding
    private lateinit var viewModel: EventViewModel

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentEventBinding.inflate(inflater, container, false)
        initViewModel()
        initview()
        observers()
        return binding.root
    }

    private fun initview() {
        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)
        binding.rvEvents.layoutManager = LinearLayoutManager(requireActivity())
        viewModel.geteventlist()
        binding.llWallet.setOnClickListener {
            findNavController().navigate(R.id.home_to_walletfrag)
        }
    }

    private fun initViewModel() {
        binding.lifecycleOwner = this
        viewModel = ViewModelProvider(requireActivity()).get(EventViewModel::class.java)
    }

    private fun observers() {
        viewModel.itemcategory.observe(requireActivity(), Observer {
            binding.rvEvents.adapter =
                Event_Adapter(requireActivity(), it.data?.data?.events!!, this)
            if (it.data?.data?.events!!.size>0) {
                binding.rvEvents.show()
                binding.tvemptyview.hide()
            }else{
                binding.rvEvents.hide()
                binding.tvemptyview.show()
            }
        })

        viewModel.itemjoinres.observe(viewLifecycleOwner, Observer {
            if (viewLifecycleOwner.lifecycle.currentState == Lifecycle.State.RESUMED) {

                if (it != null) {
                    parentFragment?.findNavController()
                        ?.navigate(R.id.eventdetail_to_eventpromo, bundleOf("item" to item_))
                } else {
                    Common.tooast(requireActivity(), "No promo code available")
                }
            }
        })
    }

    override fun onadapteritemclick(item: Events) {
        findNavController().navigate(R.id.eventdetail_fragment, bundleOf("item" to item))
    }

    lateinit var item_: Events
    override fun onjoinnowclick(item: Events) {
        item_ = item
        viewModel.JoinEvent(JoinEventBody(item.id!!, Prefs.getInstance(requireActivity()).userid))
    }
}
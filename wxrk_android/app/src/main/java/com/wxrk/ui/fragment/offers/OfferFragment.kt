package com.wxrk.ui.fragment.offers

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.core.os.bundleOf
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import com.wxrk.BaseFragment
import com.wxrk.R
import com.wxrk.databinding.FragmentShopBinding
import com.wxrk.model.dashbord.Offers
import com.wxrk.ui.adapters.*
import com.wxrk.utils.Common.Companion.tooast
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.OfferViewModel
import java.util.*

class OfferFragment : BaseFragment(R.layout.fragment_shop), OfferCategory_Adapter.CellClickListener,
    Offer_Adapter.OnOfferClick {

    lateinit var binding: FragmentShopBinding
    private lateinit var viewModel: OfferViewModel
    var idlist = ArrayList<Int>()
    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentShopBinding.inflate(inflater, container, false)
        initViewModel()
        initview()
        observers()
        return binding.root
    }

    private fun initview() {
        binding.rvCategory.layoutManager =
            LinearLayoutManager(requireActivity(), LinearLayoutManager.HORIZONTAL, false)
        binding.rvOffers.layoutManager = LinearLayoutManager(requireActivity())
        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)

        viewModel.getOfferCat()

        binding.llWallet.setOnClickListener {
            findNavController().navigate(R.id.home_to_walletfrag)
        }
    }

    private fun initViewModel() {
        binding.lifecycleOwner = this
        viewModel = ViewModelProvider(requireActivity()).get(OfferViewModel::class.java)
    }

    private fun observers() {
        viewModel.itemcategory.observe(requireActivity(), Observer {
            binding.rvCategory.adapter =
                OfferCategory_Adapter(requireActivity(), it.data?.data?.offer_categories!!, this)
        })
        viewModel.itemOfferlist.observe(requireActivity(), Observer {
            if (it != null) {
                binding.rvOffers.adapter =
                    it.data?.data?.data?.let { it1 -> Offer_Adapter(requireActivity(), it1, this) }

                if (it.data?.data?.data!!.size > 0) {
                    binding.rvOffers.show()
                    binding.tvemptyview.hide()
                } else {
                    binding.rvOffers.hide()
                    binding.tvemptyview.show()
                }
            } else {
                tooast(requireActivity(), "Somthing went wrong! Please try again.")
                binding.rvOffers.hide()
                binding.tvemptyview.show()
            }
        })

    }

    override fun onCellClickListener(id: Int, isselected: Boolean) {
        if (isselected) {
            idlist.add(id)

        } else {
            idlist.remove(id)
        }

        viewModel.getOfferList(idlist)
    }

    override fun Onofferclickitem(item: Offers) {
        findNavController().navigate(R.id.offerlist_to_offerdetail, bundleOf("item" to item))
    }

    override fun onResume() {
        super.onResume()
        viewModel.getOfferList(idlist)
    }


}
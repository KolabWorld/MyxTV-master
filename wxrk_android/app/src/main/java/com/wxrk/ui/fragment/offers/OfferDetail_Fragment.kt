package com.wxrk.ui.fragment.offers

import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.core.os.bundleOf
import androidx.lifecycle.Lifecycle
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import com.bumptech.glide.Glide
import com.google.android.material.tabs.TabLayoutMediator
import com.wxrk.BaseFragment
import com.wxrk.R
import com.wxrk.databinding.FragmentOfferdetailBinding
import com.wxrk.model.dashbord.Offers
import com.wxrk.ui.adapters.Imageview_Adapter
import com.wxrk.utils.Common.Companion.logUnlimited
import com.wxrk.utils.Common.Companion.tooast
import com.wxrk.utils.Prefs
import com.wxrk.viewmodels.OfferViewModel

class OfferDetail_Fragment : BaseFragment(R.layout.fragment_offerdetail) {

    lateinit var binding: FragmentOfferdetailBinding
    lateinit var offeritem: Offers
    private lateinit var viewModel: OfferViewModel
    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentOfferdetailBinding.inflate(inflater, container, false)
        initViewModel()
        observers()
        initview()
        return binding.root
    }

    private fun initview() {
        binding.ivBack.setOnClickListener { findNavController().popBackStack() }
        binding.llWallet.setOnClickListener {
            findNavController().navigate(R.id.home_to_walletfrag)
        }

        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)


        binding.viewpager.adapter = Imageview_Adapter(requireActivity(), offeritem.banner)

        TabLayoutMediator(binding.tablay, binding.viewpager) { tab, position ->
            //Some implementation
        }.attach()

        binding.tvBalance.setText(Prefs.getInstance(requireActivity()).balance)
        binding.tvPrice.setText(offeritem.offerPriceInWxrk)
        binding.tvOfferpirce.setText(offeritem.offerPriceInWxrk)
        binding.tvOffertital.setText(offeritem.offerName)
        binding.tvHighlight.setText(offeritem.highlightOfOffer)
        binding.tvExpire.setText(offeritem.remaining_days)

        binding.tvBrandName.setText("By ${offeritem.companyName}")
        binding.tvDayLeft.setText("${offeritem.stock} left")
        binding.tvDesCompany.setText("${offeritem.aboutTheCompany}")
        binding.tvAboutorg.setText("About ${offeritem.companyName}")
        Glide.with(requireActivity()).load(offeritem.companyLogo).into(binding.ivBrand)

        binding.rlbynow.setOnClickListener {
            offeritem.id?.let { it1 -> viewModel.JoinOffer(it1) }
        }

        logUnlimited("offerlink","${offeritem.link}")
        binding.tvVisitwebsite.setOnClickListener {
            if (offeritem.link != null) {
                if (!offeritem.link!!.startsWith("http://") && !offeritem.link!!.startsWith("https://")) {
                    startActivity(Intent(Intent.ACTION_VIEW, Uri.parse("http://" + offeritem.link)))
                }else{
                    startActivity(Intent(Intent.ACTION_VIEW, Uri.parse(offeritem.link)))
                }
            } else {

                binding.tvVisitwebsite.hide()
            }

        }

    }

    private fun observers() {
        offeritem = arguments?.get("item") as Offers

        viewModel.itempromocodedate.observe(viewLifecycleOwner, Observer {
            if (viewLifecycleOwner.lifecycle.currentState == Lifecycle.State.RESUMED) {
                logUnlimited("response", "${it.data?.message}")
                logUnlimited("response", "${it}")
                if (it.status != null) {
                    parentFragment?.findNavController()
                        ?.navigate(R.id.offerdetail_to_promocode, bundleOf("item" to it.data))
                    if (!it.data?.message.equals("you have already purchased this offer.")){
                        if (offeritem.stock?.toInt()!=0){
                            offeritem.stock= (offeritem.stock?.toInt()?.minus(1)).toString()
                        }
                        tooast(requireActivity(),"Redeem successfully")
                    }else{
                        tooast(requireActivity(),"You have already purchased this offer.")

                    }
                }
            }
        })

         viewModel.errorres.observe(viewLifecycleOwner, Observer {
            if (viewLifecycleOwner.lifecycle.currentState == Lifecycle.State.RESUMED) {
                logUnlimited("response", "${it}")
                tooast(requireActivity(),it!!.errors!!.message!!)
            }
        })

        viewModel.loader.observe(viewLifecycleOwner, Observer {

            if (it) {
                binding.rlBlocto.visibility = View.GONE
                binding.progress.visibility = View.VISIBLE
            } else {
                binding.rlBlocto.visibility = View.VISIBLE

                binding.progress.visibility = View.GONE
            }
        })
    }

    private fun initViewModel() {
        viewModel = ViewModelProvider(requireActivity()).get(OfferViewModel::class.java)
    }


}
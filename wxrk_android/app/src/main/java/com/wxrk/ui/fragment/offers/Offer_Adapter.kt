package com.wxrk.ui.fragment.offers

import android.content.Context
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.wxrk.R
import com.wxrk.databinding.ItemOffersBinding
import com.wxrk.model.dashbord.Offers


class Offer_Adapter(
    val contextCompat: Context, var offers: ArrayList<Offers>,
    var itemclick: OnOfferClick
) : RecyclerView.Adapter<Offer_Adapter.ViewHolder>() {
    class ViewHolder(var bind: ItemOffersBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemOffersBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_offers, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return offers.size
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        var item = offers.get(position)

        holder.bind.tvName.setText(item.offerName)
        holder.bind.tvOfferpice.setText(item.offerPriceInWxrk)
        holder.bind.tvDes.setText(item.detailsOfOffer)

        holder.itemView.setOnClickListener {
            itemclick.Onofferclickitem(item)
        }

        Glide.with(contextCompat).load(item.thumbnailImage).into(holder.bind.ivOfferimg)


        if (item.islowstock.equals("0")) {
            holder.bind.tvLowstockview.visibility = View.GONE
        }else{
            holder.bind.tvLowstockview.visibility = View.VISIBLE

        }

    }

    interface OnOfferClick {
        fun Onofferclickitem(item: Offers)
    }

}
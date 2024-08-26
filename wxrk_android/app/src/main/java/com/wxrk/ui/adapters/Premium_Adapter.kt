package com.wxrk.ui.adapters

import android.content.Context
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.wxrk.R
import com.wxrk.databinding.ItemPreminumBinding
import com.wxrk.model.dashbord.PremiumOffer
import com.wxrk.ui.fragment.offers.Offer_Adapter


class Premium_Adapter(
    val contextCompat: Context, var offers: ArrayList<PremiumOffer>,
    var itemclick: Offer_Adapter.OnOfferClick
) : RecyclerView.Adapter<Premium_Adapter.ViewHolder>() {
    class ViewHolder(var bind: ItemPreminumBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemPreminumBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_preminum, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return offers.size
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        var item = offers.get(position)

        holder.bind.tvTital.setText(item.name)

        if (item.offers.size > 0) {
            holder.bind.rvOffer.layoutManager = LinearLayoutManager(contextCompat)
            holder.bind.rvOffer.adapter = Offer_Adapter(contextCompat, item.offers, itemclick)
        } else {
            holder.bind.rvOffer.visibility = View.GONE
        }
    }


}
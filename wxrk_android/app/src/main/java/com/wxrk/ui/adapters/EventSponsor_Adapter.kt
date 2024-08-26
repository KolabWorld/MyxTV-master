package com.wxrk.ui.adapters

import android.content.Context
import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.wxrk.R
import com.wxrk.databinding.ItemEventsponsorBinding
import com.wxrk.model.dashbord.Sponser
import com.wxrk.utils.Prefs


class EventSponsor_Adapter(val contextCompat: Context, var sponser: ArrayList<Sponser>) :
    RecyclerView.Adapter<EventSponsor_Adapter.ViewHolder>() {
    class ViewHolder(var bind: ItemEventsponsorBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemEventsponsorBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_eventsponsor, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return sponser.size
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        Glide.with(contextCompat).load(sponser.get(position).fullUrl).placeholder(R.drawable.ic_x)
            .into(holder.bind.ivItem)


    }

}
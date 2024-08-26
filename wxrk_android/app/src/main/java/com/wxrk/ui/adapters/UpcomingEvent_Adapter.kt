package com.wxrk.ui.adapters

import android.content.Context
import android.content.Intent
import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.google.gson.Gson
import com.wxrk.R
import com.wxrk.databinding.ItemUpcomingeventsBinding
import com.wxrk.model.dashbord.Events
import com.wxrk.utils.Common.Companion.convertEventdate
import com.wxrk.utils.Common.Companion.logUnlimited


class UpcomingEvent_Adapter(val contextCompat: Context, var list: ArrayList<Events>) :
    RecyclerView.Adapter<UpcomingEvent_Adapter.ViewHolder>() {
    class ViewHolder(var bind: ItemUpcomingeventsBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemUpcomingeventsBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_upcomingevents, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return list.size
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        var item = list.get(position)
        holder.bind.tvEventname.setText(item.name)
        holder.bind.tvTimeLocation.setText(
            convertEventdate(
                "EEE, MMM dd",
                item.startDateTime!!
            ) + "\n" + item.country?.name
        )
        holder.bind.tvDate.setText(convertEventdate("dd", item.startDateTime!!))
        holder.bind.tvMonth.setText(convertEventdate("MMMM", item.startDateTime!!))

        if (item.banner.size > 0) {
            Glide.with(contextCompat).load(item.banner.get(0).fullUrl).into(holder.bind.ivBanner)
        }

        holder.itemView.setOnClickListener {
//            var intent=Intent(contextCompat, EventDetail_Activity::class.java)
//          var value=  Gson().toJson(item).toString()
//            logUnlimited("clickvalue",value)
//            intent.putExtra("data",value)
//            contextCompat.startActivity(intent)
        }
    }

}
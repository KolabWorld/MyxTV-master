package com.wxrk.ui.adapters

import  android.content.Context
import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.core.content.ContextCompat
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.wxrk.R
import com.wxrk.databinding.ItemToptimesaverBinding
import com.wxrk.model.dashbord.IosAppPerformace
import com.wxrk.utils.AppUtil
import com.wxrk.utils.Common

class TopTimeSaver_Adapter(val contextCompat: Context, var list: ArrayList<IosAppPerformace>) :
    RecyclerView.Adapter<TopTimeSaver_Adapter.ViewHolder>() {
    class ViewHolder(var bind: ItemToptimesaverBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemToptimesaverBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_toptimesaver, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return list.size
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        var item = list.get(position)
//        var seconds_ = item.todayUsageTime!!.toDouble() * 60000
//        holder.bind.tvTime.setText(
//            AppUtil.formatMilliSeconds(seconds_.toLong())
//        )
//
//
        if (item.timeSavedPercentage!!.toLong() >0) {
            holder.bind.tvPercentage.setTextColor(ContextCompat.getColor(contextCompat,R.color.green))
            holder.bind.tvPercentage.setCompoundDrawables(ContextCompat.getDrawable(contextCompat,R.drawable.ic_up_arrow_green),null,null,null)
            holder.bind.tvPercentage.setText(item.timeSavedPercentage + "%")
        }else{
            holder.bind.tvPercentage.setCompoundDrawables(ContextCompat.getDrawable(contextCompat,R.drawable.ic_down_red_arrow),null,null,null)
            holder.bind.tvPercentage.setTextColor(ContextCompat.getColor(contextCompat,R.color.red))
            holder.bind.tvPercentage.setText(item.timeSavedPercentage + "%")

        }
        var textvalue = String.format("%s", AppUtil.formatMilliSeconds( (item.watchTime?.toLong() ?: 0) *1000))
    holder.bind.tvTime.setText(textvalue)
    holder.bind.tvDate.setText(Common.convertEventdate("dd", item.updatedAt!!))
        holder.bind.tvMonth.setText(Common.convertEventdate("MMM", item.updatedAt!!))
    }

}
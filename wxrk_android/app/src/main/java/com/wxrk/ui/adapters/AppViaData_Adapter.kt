package com.wxrk.ui.adapters

import android.content.Context
import android.content.Intent
import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.wxrk.R
import com.wxrk.databinding.ItemAppviadataBinding
import com.wxrk.model.dashbord.IosAppPerformace
import com.wxrk.utils.AppUtil
import com.wxrk.utils.Common


class AppViaData_Adapter(val contextCompat: Context, var todaysData: ArrayList<IosAppPerformace>) :
    RecyclerView.Adapter<AppViaData_Adapter.ViewHolder>() {

    class ViewHolder(var bind: ItemAppviadataBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemAppviadataBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_appviadata, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return todaysData.size
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        var item = todaysData.get(position)
//        holder.bind.ivAppicon.setImageDrawable(
//            AppUtil.getPackageIcon(
//                contextCompat,
//                item.packageName
//            )
//        )
        var seconds_ = item.watchTime!!.toDouble() * 1000
        holder.bind.tvTime.setText(
            AppUtil.formatMilliSeconds(seconds_.toLong())
        )

        holder.bind.tvAppname.setText(
            Common.convertEventdate(
            "dd-MMM-yyyy",
            item.createdAt!!))
    }

}
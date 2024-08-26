package com.wxrk.ui.fragment.transection

import android.content.Context
import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.wxrk.R
import com.wxrk.databinding.ItemTransectionBinding
import com.wxrk.model.transection.toptrac.Transactions
import com.wxrk.utils.AppUtil


class Transection_Adapter(val contextCompat: Context, var transactions: ArrayList<Transactions>) :
    RecyclerView.Adapter<Transection_Adapter.ViewHolder>() {
    class ViewHolder(var bind: ItemTransectionBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemTransectionBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_transection, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return transactions.size
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        var item = transactions.get(position)
        if (item.type.equals("spent")) {
            holder.bind.ivArrow.setImageResource(R.drawable.ic_red_spend_arrow)
            holder.bind.tvHours.setText(item.offer?.offerName ?: "")
        } else {
            holder.bind.ivArrow.setImageResource(R.drawable.down_green_arrow)
            holder.bind.tvHours.setText(String.format("%s", AppUtil.formatMilliSeconds( (item.watchTime?.toLong() ?: 0) *1000)))
        }
        holder.bind.tvEarnedtxt.setText(item.type)
        holder.bind.tvEarn.setText(item.wxrkBalance)
        holder.bind.tvDate.setText(item.createdAt)
    }

}
package com.wxrk.ui.adapters

import android.content.Context
import android.content.Intent
import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.wxrk.R
import com.wxrk.databinding.ItemImageviewBinding
import com.wxrk.model.dashbord.Banner


class Imageview_Adapter(val contextCompat: Context, var banner: ArrayList<Banner>) :
    RecyclerView.Adapter<Imageview_Adapter.ViewHolder>() {
    class ViewHolder(var bind: ItemImageviewBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemImageviewBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_imageview, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return banner.size
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        var item = banner.get(position)
        holder.itemView.setOnClickListener {
//            contextCompat.startActivity(Intent(contextCompat,EventDetail_Activity::class.java))
        }

        if (item.fullUrl != null) {
            Glide.with(contextCompat).load(item.fullUrl).into(holder.bind.ivBanner)
        }

    }

}
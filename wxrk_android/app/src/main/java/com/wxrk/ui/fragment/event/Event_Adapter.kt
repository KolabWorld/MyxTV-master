package com.wxrk.ui.fragment.event

import android.content.Context
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.core.content.ContextCompat
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.wxrk.R
import com.wxrk.databinding.ItemEventBinding
import com.wxrk.model.dashbord.Events
import com.wxrk.utils.Common


class Event_Adapter(
    val contextCompat: Context,
    var list: ArrayList<Events>,
    var onadapteritemclick: onAdapterItemClick
) : RecyclerView.Adapter<Event_Adapter.ViewHolder>() {
    class ViewHolder(var bind: ItemEventBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemEventBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_event, parent, false
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
            Common.convertEventdate(
                "EEE, MMM dd",
                item.startDateTime!!
            ) + "\n" + item.venue
        )
        holder.bind.tvDate.setText(Common.convertEventdate("dd", item.startDateTime!!))
        holder.bind.tvMonth.setText(Common.convertEventdate("MMMM", item.startDateTime!!))

        if (item.already_joined==0){
            holder.bind.btJoinnow.visibility =View.VISIBLE
            holder.bind.btAlreadyjoin.visibility =View.GONE
            holder.bind.clLay.background=ContextCompat.getDrawable(contextCompat,R.drawable.bg_strick)
            holder.bind.clLay.setPadding(0,0,0,0)
        }else{
            holder.bind.btJoinnow.visibility =View.INVISIBLE
            holder.bind.clLay.background=ContextCompat.getDrawable(contextCompat,R.drawable.bg_strick_selected)
            holder.bind.btAlreadyjoin.visibility =View.VISIBLE

        }
        Glide.with(contextCompat).load(item.thumbnailImage).into(holder.bind.ivBanner)


        holder.itemView.setOnClickListener {
            onadapteritemclick.onadapteritemclick(list.get(position))
        }

        holder.bind.btJoinnow.setOnClickListener {
            onadapteritemclick.onjoinnowclick(list.get(position))
        }

    }

    interface onAdapterItemClick {

        fun onadapteritemclick(item: Events)
        fun onjoinnowclick(item: Events)
    }

}
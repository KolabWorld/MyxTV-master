package com.wxrk.ui.fragment.twitch

import android.content.Context
import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.wxrk.R
import com.wxrk.databinding.ItemEventBinding
import com.wxrk.databinding.ItemTwitchBinding
import com.wxrk.model.Twitch.GetAllVideo
import com.wxrk.model.Twitch.TwitchData
import com.wxrk.model.dashbord.Events
import com.wxrk.utils.Common
import com.wxrk.utils.Common.Companion.countviews


class Twitch_Adapter(
    val contextCompat: Context,
    var list: ArrayList<TwitchData>,
    var onadapteritemclick: onAdapterItemClick
) : RecyclerView.Adapter<Twitch_Adapter.ViewHolder>() {
    class ViewHolder(var bind: ItemTwitchBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemTwitchBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_twitch, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return list.size
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        var item = list.get(position)
        holder.bind.tvEventname.setText(item.title)
        holder.bind.tvViewcount.setText(countviews(item.viewCount!!.toLong()) + " viewers")
        holder.bind.tvTimeLocation.setText(item.userName)

        Glide.with(contextCompat).load(
            item.thumbnailUrl!!.replace("%{width}", "500")
                .replace("%{height}", "500")
        ).into(holder.bind.ivBanner)


        holder.itemView.setOnClickListener {
            onadapteritemclick.onadapteritemclick(list.get(position))
        }


    }

    interface onAdapterItemClick {

        fun onadapteritemclick(item: TwitchData)
    }

}
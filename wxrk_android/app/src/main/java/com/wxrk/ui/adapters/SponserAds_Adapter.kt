package com.wxrk.ui.adapters

import android.content.Context
import android.net.Uri
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.VideoView
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.wxrk.R
import com.wxrk.databinding.ItemSponserAdsBinding
import com.wxrk.model.dashbord.Banners


class SponserAds_Adapter(
    val contextCompat: Context, var banners: ArrayList<Banners>,
    var onsponserclick: OnSponserClick
) : RecyclerView.Adapter<SponserAds_Adapter.ViewHolder>() {
    class ViewHolder(var bind: ItemSponserAdsBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemSponserAdsBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_sponser_ads, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return banners.size
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        var item = banners.get(position)

        if (item.attachmentType.equals("image")) {
            holder.bind.ivSponser.visibility = View.VISIBLE
            holder.bind.videoview.visibility = View.INVISIBLE
            Glide.with(contextCompat).load(item.image).into(holder.bind.ivSponser)

        } else {
            holder.bind.ivSponser.visibility = View.INVISIBLE
            holder.bind.videoview.visibility = View.VISIBLE
            item.image?.let { playvideo(holder.bind.videoview, it) }
        }

        holder.itemView.setOnClickListener {

            onsponserclick.OnClickAds(item)
        }


    }

    fun playvideo(videoview: VideoView, videoUrl: String) {
        val uri: Uri = Uri.parse(videoUrl)

        videoview.setVideoURI(uri)
        videoview.start()
        videoview.requestFocus()
        videoview.setOnPreparedListener { mp ->
            mp.setLooping(true)
            mp.setVolume(0F, 0F)
        }
    }

    interface OnSponserClick {

        fun OnClickAds(item: Banners)
    }

}
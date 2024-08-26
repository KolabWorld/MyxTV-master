package com.wxrk.ui.adapters

import android.content.Context
import android.content.Intent
import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.wxrk.R
import com.wxrk.databinding.ItemWeekStreakBinding
import org.json.JSONException


class Weekstreak_Adapter(val contextCompat: Context) :
    RecyclerView.Adapter<Weekstreak_Adapter.ViewHolder>() {

    var days = arrayOf("M", "T", "W", "T", "F", "S", "S")

    class ViewHolder(var bind: ItemWeekStreakBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemWeekStreakBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_week_streak, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return days.size
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        holder.bind.tvDay.text = days[position]

    }

}
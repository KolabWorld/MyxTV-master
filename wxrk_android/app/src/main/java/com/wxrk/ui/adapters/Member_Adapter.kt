package com.wxrk.ui.adapters

import android.content.Context
import android.content.Intent
import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.wxrk.R
import com.wxrk.databinding.ItemMembersBinding
import com.wxrk.databinding.ItemOffercategoryBinding
import com.wxrk.databinding.ItemOffersBinding
import com.wxrk.ui.MemberProfile_Activity


class Member_Adapter(val contextCompat: Context) :
    RecyclerView.Adapter<Member_Adapter.ViewHolder>() {
    class ViewHolder(var bind: ItemMembersBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemMembersBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_members, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return 15
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {

        holder.itemView.setOnClickListener {

            contextCompat.startActivity(Intent(contextCompat, MemberProfile_Activity::class.java))
        }
    }

}
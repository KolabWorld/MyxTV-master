package com.wxrk.ui.adapters

import android.content.Context
import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.wxrk.R
import com.wxrk.databinding.ItemMembersBinding
import com.wxrk.databinding.ItemOffercategoryBinding
import com.wxrk.databinding.ItemOffersBinding
import com.wxrk.databinding.ItemSignupmemberBinding


class SignupMember_Adapter(val contextCompat: Context) :
    RecyclerView.Adapter<SignupMember_Adapter.ViewHolder>() {
    class ViewHolder(var bind: ItemSignupmemberBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemSignupmemberBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_signupmember, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return 5
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {

    }

}
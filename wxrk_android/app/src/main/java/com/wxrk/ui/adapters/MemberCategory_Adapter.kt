package com.wxrk.ui.adapters

import android.content.Context
import android.content.Intent
import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.core.content.ContextCompat
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.wxrk.R
import com.wxrk.databinding.ItemOffercategoryBinding


class MemberCategory_Adapter(val contextCompat: Context) :
    RecyclerView.Adapter<MemberCategory_Adapter.ViewHolder>() {
    class ViewHolder(var bind: ItemOffercategoryBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemOffercategoryBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_offercategory, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return 5
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        holder.bind.tvCat.setText("CHALLENGES")
        holder.itemView.setOnClickListener {
            holder.bind.tvCat.setTextColor(
                ContextCompat.getColor(
                    contextCompat,
                    R.color.cat_selected_color
                )
            )
            holder.bind.constraintlay.setBackgroundResource(R.drawable.bg_category_selected)
        }
    }

}
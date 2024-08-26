package com.wxrk.ui.adapters

import android.content.Context
import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.core.content.ContextCompat
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.wxrk.R
import com.wxrk.databinding.ItemOffercategoryBinding
import com.wxrk.model.offers.offercat.OfferCategories


class OfferCategory_Adapter(
    val contextCompat: Context, var offer_categories: ArrayList<OfferCategories>,
    var itemclick: CellClickListener
) : RecyclerView.Adapter<OfferCategory_Adapter.ViewHolder>() {
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
        return offer_categories.size
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        var item = offer_categories.get(position)

        holder.itemView.setOnClickListener {
            if (item.selected == true) {
                item.selected = false

            } else {
                item.selected = true
            }
            itemclick.onCellClickListener(item.id!!, item.selected!!)
            notifyItemChanged(position)
        }

        if (item.selected!!) {
            holder.bind.tvCat.setTextColor(
                ContextCompat.getColor(
                    contextCompat,
                    R.color.cat_selected_color
                )
            )
            holder.bind.constraintlay.setBackgroundResource(R.drawable.bg_category_selected)
        } else {
            holder.bind.tvCat.setTextColor(ContextCompat.getColor(contextCompat, R.color.white))
            holder.bind.constraintlay.setBackgroundResource(R.drawable.bg_category)
        }

        holder.bind.tvCat.setText(item.name)

    }

    interface CellClickListener {
        fun onCellClickListener(id: Int, isselected: Boolean)
    }
}
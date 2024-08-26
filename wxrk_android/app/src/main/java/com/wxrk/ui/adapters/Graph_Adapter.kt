package com.wxrk.ui.adapters

import android.content.Context
import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.wxrk.R
import com.wxrk.databinding.ItemGraphBinding
import com.wxrk.model.dashbord.IosAppPerformace
import com.wxrk.utils.Common
import kotlin.math.roundToInt

class Graph_Adapter(
    val contextCompat: Context,
    var dayWiseSummaryData: ArrayList<IosAppPerformace>,
    var larger_value: Double
) : RecyclerView.Adapter<Graph_Adapter.ViewHolder>() {
    class ViewHolder(var bind: ItemGraphBinding) : RecyclerView.ViewHolder(bind.root) {
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemGraphBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_graph, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return dayWiseSummaryData.size
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {

        holder.bind.tvday.setText(
            Common.convertEventdate(
                "EEEEE",
                dayWiseSummaryData.get(position).createdAt!!
            )
        )

//  864000=total seconds of one day
//  Calculation will be 100/86400*today watch time result will be %age of one day watch time

        if (dayWiseSummaryData.get(position).watchTime != null) {
//            var  calculationper= (100/86400).toLong()*dayWiseSummaryData.get(position).watchTime!!.toDouble()
            var  calculationper= (100*dayWiseSummaryData.get(position).watchTime!!.toDouble())/larger_value
            Common.logUnlimited("percentage", "${calculationper.roundToInt()} --- ${calculationper}" +
                    " -- ${dayWiseSummaryData.get(position).watchTime!!.toDouble()} -- $larger_value")
            holder.bind.idProgressbar.progress = calculationper.roundToInt()
        }
    }
}
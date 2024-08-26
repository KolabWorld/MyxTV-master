package com.wxrk.ui.adapters

import android.content.Context
import android.content.Intent
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.databinding.DataBindingUtil
import androidx.recyclerview.widget.RecyclerView
import com.wxrk.MainActivity
import com.wxrk.R
import com.wxrk.databinding.ItemIntroBinding
import com.wxrk.ui.Intro_Activity


class Intro_Adapter(val contextCompat: Context) : RecyclerView.Adapter<Intro_Adapter.ViewHolder>() {

    var tital_list = arrayOf(R.string.cxmmunity, R.string.WXRK, R.string.Reward)
    var des_list = arrayOf(R.string.intro1, R.string.intro2, R.string.intro3)
    var imagefront_list =
        arrayOf(R.drawable.intro_one_frontimg, R.drawable.intro_two, R.drawable.intro_three)

    class ViewHolder(var bind: ItemIntroBinding) : RecyclerView.ViewHolder(bind.root) {

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        var listItemContactsBinding: ItemIntroBinding
        val view = LayoutInflater.from(parent.context)
        listItemContactsBinding = DataBindingUtil.inflate(
            view,
            R.layout.item_intro, parent, false
        )
        return ViewHolder(listItemContactsBinding)
    }

    override fun getItemCount(): Int {
        return 3
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {

        holder.bind.tvSkip.setOnClickListener {
            (contextCompat as Intro_Activity).finish()
            contextCompat.startActivity(Intent(contextCompat, MainActivity::class.java))
        }

        holder.bind.tvTital.setText(tital_list[position])
        holder.bind.tvDes.setText(des_list[position])
        holder.bind.ivFrontimg.setImageResource(imagefront_list[position])

        if (position == 2) {
            holder.bind.tvSkip.setText(R.string.getstarted)
        } else {
            holder.bind.tvSkip.setText(R.string.skip)

        }

        if (position == 0) {
            holder.bind.view1.setBackgroundResource(R.drawable.circule_blueselected)
            holder.bind.view2.setBackgroundResource(R.drawable.circule_non_selected)
            holder.bind.view3.setBackgroundResource(R.drawable.circule_non_selected)
            holder.bind.rlLay.visibility = View.INVISIBLE

        } else if (position == 1) {
            holder.bind.view1.setBackgroundResource(R.drawable.circule_non_selected)
            holder.bind.view2.setBackgroundResource(R.drawable.circule_blueselected)
            holder.bind.view3.setBackgroundResource(R.drawable.circule_non_selected)
            holder.bind.rlLay.visibility = View.VISIBLE
        } else if (position == 2) {
            holder.bind.view1.setBackgroundResource(R.drawable.circule_non_selected)
            holder.bind.view2.setBackgroundResource(R.drawable.circule_non_selected)
            holder.bind.view3.setBackgroundResource(R.drawable.circule_blueselected)
            holder.bind.rlLay.visibility = View.INVISIBLE

        }


    }

}
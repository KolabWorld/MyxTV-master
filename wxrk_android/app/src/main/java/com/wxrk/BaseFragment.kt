package com.wxrk

import android.view.View
import androidx.fragment.app.Fragment

open class BaseFragment(layout: Int) : Fragment(layout) {


    fun View.show() {
        this.visibility = View.VISIBLE
    }

    fun View.hide() {
        this.visibility = View.GONE
    }
}
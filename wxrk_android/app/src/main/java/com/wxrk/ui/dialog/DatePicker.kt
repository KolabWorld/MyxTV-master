package com.wxrk.ui.dialog

import android.app.DatePickerDialog
import android.app.DatePickerDialog.OnDateSetListener
import android.app.Dialog
import android.os.Bundle
import androidx.annotation.Nullable
import androidx.fragment.app.DialogFragment
import java.util.*


class DatePicker : DialogFragment() {

    override fun onCreateDialog(@Nullable savedInstanceState: Bundle?): Dialog {
        val mCalendar: Calendar = Calendar.getInstance()
        val year: Int = mCalendar.get(Calendar.YEAR)
        val month: Int = mCalendar.get(Calendar.MONTH)
        val dayOfMonth: Int = mCalendar.get(Calendar.DAY_OF_MONTH)
        var datepicker = DatePickerDialog(
            requireActivity(),
            parentFragment as OnDateSetListener?,
            year,
            month,
            dayOfMonth
        )
        datepicker.datePicker.maxDate = System.currentTimeMillis()
        return datepicker
    }
}
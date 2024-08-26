package com.wxrk.utils

class AppUtil {


    companion object{
    fun formatMilliSeconds(milliSeconds: Long): String? {
        val second = milliSeconds / 1000L
        return if (second < 60) {
            if (second<10)
            String.format("00:00:0%s", second)
            else
            String.format("00:00:%s", second)
        } else if (second < 60 * 60) {
            val min=second / 60
            if (min<10) {
                String.format("00:0%s:%s", min, second % 60)
            }else{
                String.format("00:%s:%s", min, second % 60)
            }
        } else {
            String.format("%s:%s:%s", second / 3600, second % 3600 / 60, second % 3600 % 60)
        }
    }
    }
}
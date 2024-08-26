package com.wxrk.viewmodels

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import kotlinx.coroutines.delay
import kotlinx.coroutines.launch

class ChooseLoginViewModel(application: Application) : AndroidViewModel(application) {

    var liveData: MutableLiveData<Boolean> = MutableLiveData()


    private fun updateLiveData() {
        liveData.value = true
    }

}
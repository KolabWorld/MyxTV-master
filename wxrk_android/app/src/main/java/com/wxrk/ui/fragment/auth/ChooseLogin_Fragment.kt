package com.wxrk.ui.fragment.auth

import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.lifecycle.Lifecycle
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import com.wxrk.MainActivity
import com.wxrk.R
import com.wxrk.databinding.FragmentChooseloginBinding
import com.wxrk.ui.dialog.Dialog_Login
import com.wxrk.utils.Common
import com.wxrk.utils.Prefs
import com.wxrk.utils.toast
import com.wxrk.viewmodels.LoginViewModel
import io.outblock.fcl.Fcl
import io.outblock.fcl.models.FclResult
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch

class ChooseLogin_Fragment : Fragment(R.layout.fragment_chooselogin), Dialog_Login.onNextStep {

    private lateinit var viewModel: LoginViewModel
    lateinit var bindeview: FragmentChooseloginBinding

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {

        bindeview = FragmentChooseloginBinding.inflate(inflater, container, false)
        initview()
        initViewModel()
        observer()
        return bindeview.root
    }


    private fun initview() {
        bindeview.rlBlocto.setOnClickListener {
//            val myRoundedBottomSheet = Dialog_Login(this)
//            myRoundedBottomSheet.show(parentFragmentManager!!, myRoundedBottomSheet.tag)
            login_flow()
        }

    }

    private fun initViewModel() {
        viewModel = ViewModelProvider(this).get(LoginViewModel::class.java)
    }

    override fun onnextstepclick() {
        findNavController().navigate(R.id.chooslogin_to_offerdetail)

    }

//    fun login_vai_blockto() {
//
//        val requestAccountOnSuccess: (String) -> Unit = {
//            logUnlimited("login_vai", it.toString())
//            val address = "${it.substring(0, 6)}...${it.substring(it.length - 6, it.length)}"
////            binding.connectButton.text = address
////            viewModel.currentAddress = it
//        }
//
//        val requestAccountOnError: (BloctoSDKError) -> Unit = {
////            viewModel.showError(it)
//        }
//        BloctoSDK.ethereum.requestAccount(
//            context = requireActivity(),
//            onSuccess = requestAccountOnSuccess,
//            onError = requestAccountOnError
//        )
//
////        BloctoSDK.ethereum.signMessage(
////        context = requireActivity(),
////            fromAddress ="0x95C90F641ecF82C408d0a1389678B5D490d0Fc55",
////            signType= EvmSignType.TYPED_DATA_SIGN,
////            message="{\n" +
////                    "\t\"message\": \"test\"\n" +
////                    "}",
////        onSuccess = requestAccountOnSuccess,
////        onError = requestAccountOnError
////        )
//
//    }

    fun login_flow() {
        val provider = Fcl.providers.all()[1]
        CoroutineScope(Dispatchers.IO).launch {
            when (val result = Fcl.authenticate(provider)) {
                is FclResult.Success -> CoroutineScope(Dispatchers.Main).launch {
//                    Toast.makeText(requireActivity(), "Blocto Authe", Toast.LENGTH_SHORT)
//                        .show()
                    Log.d("TAG", "login_flow: ${result.value.data?.address!!}")
                    viewModel.Login("Test123!", result.value.data?.address!!)

                }
                is FclResult.Failure -> result.toast(requireActivity())
            }
        }
    }


    private fun observer() {

        viewModel.itemlogin.observe(requireActivity(), Observer {

            if (it != null) {
                if (it.data?.data?.isNewUser.equals("0")) {
                    requireActivity().finish()
                    Prefs.getInstance(requireActivity()).token = it.data?.accessToken
                    Prefs.getInstance(requireActivity()).userid = it.data?.data?.id
                    Prefs.getInstance(requireActivity()).mobile = it.data?.data?.mobile
                    Prefs.getInstance(requireActivity()).email = it.data?.data?.email
                    Prefs.getInstance(requireActivity()).dob = it.data?.data?.dateOfBirth
                    Prefs.getInstance(requireActivity()).userFirstName = it.data?.data?.name
                    Prefs.getInstance(requireActivity()).profileImage =
                        it.data?.data?.profileImageUrl
                    Prefs.getInstance(requireActivity()).isLogin = true
                    Prefs.getInstance(requireActivity()).lastSyncTime =
                        System.currentTimeMillis() * 1000
                    startActivity(Intent(requireActivity(), MainActivity::class.java))
                } else {
                    Prefs.getInstance(requireActivity()).dob = it.data?.data?.dateOfBirth
                    Prefs.getInstance(requireActivity()).mobile = it.data?.data?.mobile
                    Prefs.getInstance(requireActivity()).email = it.data?.data?.email
                    Prefs.getInstance(requireActivity()).userFirstName = it.data?.data?.name
                    Prefs.getInstance(requireActivity()).profileImage =
                        it.data?.data?.profileImageUrl
                    Prefs.getInstance(requireActivity()).userid = it.data?.data?.id
                    Prefs.getInstance(requireActivity()).token = it.data?.accessToken
                    onnextstepclick()
                }
            } })

            viewModel.errorres.observe(viewLifecycleOwner, Observer {
                if (viewLifecycleOwner.lifecycle.currentState == Lifecycle.State.RESUMED) {
                    Common.logUnlimited("response", "${it}")
                    Common.tooast(requireActivity(),it!!.errors!!.message!!)
                }
            })


    }

}
package com.wxrk.ui.fragment.profile

import android.app.Activity
import android.app.DatePickerDialog
import android.content.Context
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.core.net.toFile
import androidx.fragment.app.Fragment
import androidx.lifecycle.Lifecycle
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.fragment.findNavController
import com.android.volley.Response
import com.android.volley.toolbox.Volley
import com.bumptech.glide.Glide
import com.contactandroidapp.Network.RetrofitBuilder
import com.github.dhaval2404.imagepicker.ImagePicker
import com.wxrk.R
import com.wxrk.databinding.FragmentEditprofileBinding
import com.wxrk.utils.*
import com.wxrk.utils.Common.Companion.logUnlimited
import com.wxrk.viewmodels.EditProfileViewModel
import org.json.JSONObject
import java.io.IOException
import java.text.SimpleDateFormat
import java.util.*


class ProfileEditFragment : Fragment(R.layout.fragment_editprofile),
    DatePickerDialog.OnDateSetListener {

    lateinit var binding: FragmentEditprofileBinding
    lateinit var viewModel: EditProfileViewModel
    var uri: Uri? = null
    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentEditprofileBinding.inflate(inflater, container, false)
        initview()
        initviewmodel()
        observers()
        return binding.root
    }


    private fun initview() {
        binding.etName.setText(Prefs.getInstance(requireActivity()).userFirstName)
        binding.etPhonenumber.setText(Prefs.getInstance(requireActivity()).mobile)
        binding.etDob.setText(Prefs.getInstance(requireActivity()).email)
        Glide.with(requireActivity()).load(Prefs.getInstance(requireActivity()).profileImage)
            .placeholder(R.drawable.ic_x).into(binding.ivUser)

        binding.tvEditProfile.setOnClickListener {
            imagepicker()
        }
        binding.tvUpdateProfile.setOnClickListener {


            call_fun()

        }
        binding.ivBack.setOnClickListener {
            findNavController().popBackStack()
        }

    }

    fun initviewmodel() {

        viewModel = ViewModelProvider(requireActivity()).get(EditProfileViewModel::class.java)
    }


    private fun observers() {
        viewModel.itemotp.observe(viewLifecycleOwner, androidx.lifecycle.Observer {
            if (it != null) {

                if (viewLifecycleOwner.lifecycle.currentState == Lifecycle.State.RESUMED) {

                    if (it.status == 200) {
                        Prefs.getInstance(requireActivity()).dob = it.data?.data?.user?.dateOfBirth
                        Prefs.getInstance(requireActivity()).userFirstName =
                            it.data?.data?.user?.name
                        Prefs.getInstance(requireActivity()).profileImage =
                            it.data?.data?.user?.profile_pic
                        Prefs.getInstance(requireActivity()).dob = it.data?.data?.user?.dateOfBirth
                        logUnlimited("profileurl", it.data?.data?.user?.profile_pic.toString())
                        Common.tooast(requireActivity(), "Profile has been updated")

                    }
                }
            } else {
                Common.tooast(requireActivity(), "Somthing went wrong! Please Try Again")

            }

        })

        viewModel.loader.observe(viewLifecycleOwner, androidx.lifecycle.Observer {

            if (it) {
                binding.tvUpdateProfile.visibility = View.GONE
                binding.progress.visibility = View.VISIBLE
            } else {
                binding.progress.visibility = View.GONE
                binding.tvUpdateProfile.visibility = View.VISIBLE

            }

        }
        )


    }

//    fun datepicker() {
//        var datepicker = DatePicker()
//        datepicker.show(childFragmentManager, "show")
//    }


    override fun onDateSet(p0: android.widget.DatePicker?, p1: Int, p2: Int, p3: Int) {
        val mCalendar: Calendar = Calendar.getInstance()
        mCalendar.set(Calendar.YEAR, p1)
        mCalendar.set(Calendar.MONTH, p2)
        mCalendar.set(Calendar.DAY_OF_MONTH, p3)
        val df = SimpleDateFormat("yyyy-MM-dd", Locale.US)
        binding.etDob.setText(df.format(mCalendar.getTime()))
    }

    fun imagepicker() {
        ImagePicker.with(this)
            .crop()                    //Crop image(Optional), Check Customization for more option
            .compress(1024)            //Final image size will be less than 1 MB(Optional)
            .maxResultSize(
                1080,
                1080
            )    //Final image resolution will be less than 1080 x 1080(Optional)
            .start()
    }

    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (resultCode == Activity.RESULT_OK) {
            //Image Uri will not be null for RESULT_OK
            val uri1: Uri = data?.data!!
            uri = uri1
            // Use Uri object instead of File to avoid storage permissions
            binding.ivUser.setImageURI(uri1)
        } else if (resultCode == ImagePicker.RESULT_ERROR) {
            Toast.makeText(requireActivity(), ImagePicker.getError(data), Toast.LENGTH_SHORT).show()
        } else {
            Toast.makeText(requireActivity(), "Task Cancelled", Toast.LENGTH_SHORT).show()
        }
    }

    fun call_fun() {
        RetrofitBuilder.token = "Bearer " + Prefs.getInstance(requireActivity()).token

        binding.tvUpdateProfile.visibility = View.GONE
        binding.progress.visibility = View.VISIBLE


        val request = object : VolleyFileUploadRequest(Method.POST,
            "https://staging-wxrk.staqo.com/api/v1/profile",
            Response.Listener {
                val jsonstr = String(it.data)
                var json = JSONObject(jsonstr)

                logUnlimited("response", "${json}")
                if (json.getString("status").equals("200")) {
                    Prefs.getInstance(requireActivity()).dob =
                        json.getJSONObject("data").getJSONObject("data").getJSONObject("user")
                            .getString("date_of_birth")
                    Prefs.getInstance(requireActivity()).userFirstName =
                        json.getJSONObject("data").getJSONObject("data").getJSONObject("user")
                            .getString("name")
                    Prefs.getInstance(requireActivity()).profileImage =
                        json.getJSONObject("data").getJSONObject("data").getJSONObject("user")
                            .getString("profile_pic")
                    Common.tooast(requireActivity(), "Profile has been updated")
                    findNavController().popBackStack()
                }

                binding.progress.visibility = View.GONE
                binding.tvUpdateProfile.visibility = View.VISIBLE

                // finishSend(response, comment)
            },
            Response.ErrorListener {
//                commentNotSent()

                binding.progress.visibility = View.GONE
                binding.tvUpdateProfile.visibility = View.VISIBLE

            }
        ) {
            override fun getByteData(): MutableMap<String, FileDataPart> {
                val params = HashMap<String, FileDataPart>()
                if (uri != null) {
                    params["profile_pic"] = FileDataPart(
                        uri!!.toFile().name,
                        readBytes(requireActivity(), uri!!)!!,
                        "fffff"
                    )
                }
                return params
            }

            override fun getHeaders(): MutableMap<String, String> {
                val params = HashMap<String, String>()
                params.put("Authorization", "${RetrofitBuilder.token}")
                return params
            }

            override fun getParams(): MutableMap<String, String> {
                val params = HashMap<String, String>()
                params.put("user_id", Prefs.getInstance(requireActivity()).userid.toString())
                params.put("name", binding.etName.text.toString())
//                params.put("date_of_birth", binding.etDob.text.toString())
                return params
            }
        }

        var requestQueue = Volley.newRequestQueue(requireActivity())
        requestQueue.add(request)

    }

    @Throws(IOException::class)
    private fun readBytes(context: Context, uri: Uri): ByteArray? =
        context.contentResolver.openInputStream(uri)?.buffered()?.use { it.readBytes() }


}